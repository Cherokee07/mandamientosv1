<?php

Load::models('juzgados');
Load::models('ordenes');
Load::models('niveles');

class OrdenesController extends AppController
{

    public $limit_params = FALSE;

    public function formCreacion($n)
    {
        View::template('template2');
        $orden=new Ordenes();

        if($n=='ini'){
            $orden->feccaptu=date('Y-m-d');
            $orden->subprocuradurias_id= Session::get('subprocuradurias_id');
            $ident=Session::get('niveles_id');
            if($ident!=null){
                  $niveles=Load::model('niveles')->find($ident);
                  $orden->cvecaptu=$niveles->nivel;
            }
           if($orden->save()){
                $this->orden=$orden;
                $this->idexpcifrado=Cifrar::todo($orden->id);

            }else{
                Flash::error('sucedio un error');
            }
           }elseif( isset($this->parameters[0])){// cuando viene de otra parte que no es la creacion
            $id=Cifrar::undo($this->parameters[0]);
            $exp=Load::model('ordenes')->find($id);
                            Flash::valid('<div class="alert alert-info" role="alert">
                    <strong>Exito!!!</strong> han sido guardados
                    </div>');
            if($exp!=null){
                $this->orden=$exp; 
                $this->idexpcifrado=Cifrar::todo($exp->id);
            }else{
                Redirect::to('principal/nodisponible/');
            }

        }
        
    }

	
	public function crearOrdenTemporal($id){
    View::select(null);
	$ord= new Ordenes();
    if(Input::hasPost('ordenes')){
       $ide=Cifrar::undo($id);
       $orden=$ord->find($ide);
       if($orden!=null){
	    $datos=Input::post('ordenes');
        $orden->exppenal=$datos['exppenal'];
        $orden->anipenal=$datos['anipenal'];
        $orden->juzgados_id=$datos['juzgados'];
        $orden->tiposoa_id=$datos['tiposoa'];
        $orden->numaver=mb_strtoupper($datos['averiguacion'], 'utf-8');
        $orden->aniagen=$datos['aniagen'];
        $orden->turno=$datos['turno'];
        $orden->feclib=$datos['feclib'];
        $orden->fecrec=$datos['fecrec'];
        $orden->agencias_id=$datos['agencias_id'];
        $orden->ofirec=mb_strtoupper($datos['ofirec'], 'utf-8');
        $orden->fecentpj=$datos['fecentpj'];
        $orden->dirijido=$datos['dirijido'];
        $orden->ofientpj=mb_strtoupper($datos['ofientpj'], 'utf-8');
        $orden->cvecaptu= Session::get('niveles_id'); //Aqui tenemos que mostrar el tipo de usuario, que capturo no su id 
        $orden->feccaptu=date("Y-m-d"); //Aqui tenemos que agregar, la fecha con la que estamos capturando
        $orden->ordenfisico=$datos['ordenfisico'];
        $orden->ocasion=mb_strtoupper($datos['ocasion'], 'utf-8');
        $orden->localidades_id=$datos['localidades'];
        $orden->sintesis=mb_strtoupper($datos['sintesis'], 'utf-8');
        $orden->notas=mb_strtoupper($datos['notas'], 'utf-8');
        $orden->subprocuradurias_id = Session::get('subprocuradurias_id');

        if (Input::hasPost('files')){
        $imagen=Input::post('files');
        $date = fopen ($imagen, 'rb');
        $size = filesize ($imagen);
        $contenido = fread ($fd, $size);
        fclose($fd);
        $orden->imagen=base64_decode($contenido);
        }


	    if(!$orden->save()){ 
			Flash::error('<div class="alert alert-danger" role="alert">
  					<strong>Error!</strong> La orden no pudo ser creada correctamente
					</div>'); 
		}else{
            $this->orden=$orden;
            $this->idexpcifrado=Cifrar::todo($orden->id); 
			Flash::valid('<div class="alert alert-success" role="alert">
  					<strong>Exito!</strong> Orden agregada Correctamente
					</div>');					
            Redirect::toAction("formCreacion/".Cifrar::todo($orden->id));

            

  

		      }
         }
    }			
}


public function eliminarTemporal($id){
        View::template(null);
        View::select(null);

        $cuentaerrores = 0;
        $Expetemptransac = new ordenes();
        $Expetemptransac->begin();

        $exp=Load::model('ordenes')->find($id);     
        if($exp->inicios_id>1){
            $otro=$exp->getNumexpedientestemp(); //le envia el numexpediente si tiene
            if(count($otro)>0){
                if(!$otro[0]->delete()){
                    Flash::error('error eliminacion numexpediente');
                    $cuentaerrores++;
                }
            }   
        }
      
      
        $ofendidos= $exp->getOfendidostemp();
        foreach ($ofendidos as $key) {
            $nombres= $key->getNomofenstemp();
                foreach ($nombres as $nom) {
                    if(!$nom->delete()){
                        Flash::error('error eliminacion nomofens');
                        $cuentaerrores++;
                    }
                }
            if(!$key->delete()){
                Flash::error('error eliminacion ofendido');
                $cuentaerrores++;
            }
            if($exp->submujeres_id==3 || $exp->submujeres_id==4 || $exp->sadais_id==13){
                $det=$key->getDetofendidostemp();
                if(count($det)>0){
                    if(!$det[0]->delete()){
                        Flash::error('error eliminacion detofendido');
                        $cuentaerrores++;
                    }
                }   
            }   
                        
         
        }           
        $indiciados=$exp->getIndiciadostemp();
        foreach ($indiciados as $key) {
            $nombres= $key->getNomindistemp();  // se guarda el nombre ficticio
            foreach ($nombres as $nom) {
                if(!$nom->delete()){
                    Flash::error('error eliminacion nomindiciado');
                    $cuentaerrores++;
                }
            }
            if(!$key->delete()){
                Flash::error('error eliminacion indiciado');
                $cuentaerrores++;
            }
        }

        $delitos= $exp->getOfeindistemp();
        foreach ($delitos as $key) {  
            if(!$key->delete()){
                Flash::error('error eliminacion ofeindis');
                $cuentaerrores++;
            }
        }
      

     
        
        if ($cuentaerrores<1) {
            if($exp->delete()){
                $Expetemptransac->commit();
                $bitacora=Load::model('bitacora')->registrarBitacora('ELIMINACIÓN','Se 
                elimino el expediente temporal '.$exp->getNombre().' junto con todos sus elementos al pasarlo a la tabla real', $exp);
                return true;
            }else{
                $Expetemptransac->rollback();
                $bitacora=Load::model('bitacora')->registrarBitacora('ELIMINACIÓN_ERROR','Se 
                intento eliminar el expediente temporal '.$exp->getNombre().' junto con todos sus elementos al intentar guardar en la tabla real pero termino en error y se revirtieron los cambios', $exp);
                Flash::error('error eliminacion expediente');
                return false;
            }
        }else{
            Flash::error('Por los errores ocurridos no se finalizo el proceso correctamente, verifique los datos y repita el proceso, si el problema persiste comuniquese con el administrador del sistema');
            $Expetemptransac->rollback();
            $bitacora=Load::model('bitacora')->registrarBitacora('ELIMINACIÓN_ERROR','Se 
                intento eliminar el expediente temporal '.$exp->getNombre().' junto con todos sus elementos pero en la eliminacion de algunos de sus elementos relacionados ocurrieron errores por lo tanto se revirtieron los cambios', $exp);
            return false;
        }
        
    }


//   public function getMunicipios()
//    {
//        //No es necesario el template
//        View::template(null);
//        //Carga la variable $region_id en la vista
//        $this->distritos_id = Input::post('distritos_id');
//    }

//    public function getLocalidades()
//    {
//        //No es necesario el template
//        View::template(null);
//        //Carga la variable $comuna_id en la vista
//        $this->municipios_id = Input::post('municipios_id');
//    }

   

}

