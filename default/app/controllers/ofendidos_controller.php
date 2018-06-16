<?php

Load::models('ofendidos');
Load::models('ordenes');

class OfendidosController extends AppController
{
	
    public function formcreate($id){
        View::template('template2');
        $ord= new Ordenes();
        $ide=Cifrar::undo($id);
        $orden=$ord->find($ide);

        if($orden!=null){
            $this->orden=$orden;
            $this->idexpcifrado=$id;

            if (isset ($this->parameters[1])){
                $id=Cifrar::undo($this->parameters[1]);
                $ofe=Load::model('ofendidos')->find($id);
                $this->ofendidos=$ofe; 
                Flash::valid('<div class="alert alert-success" role="alert">
                    <strong>Exito!</strong> Orden agregada Correctamente
                    </div>');  
            }
        }else{
            Redirect::to('principal/nodisponible/');
            Flash::valid('<div class="alert alert-success" role="alert">
                    <strong>Exito!</strong> No hagas mamadas
                    </div>');  
        }

    }


	public function crearOfendidoTemp(){
    
    View::select(null);
    $ofendido=new Ofendidos();
    if(Input::hasPost('ofendidos')){
		$datos=Input::post('ofendidos');
        $idexp=$datos['ordenes'];
        $expediente= Load::model('ordenes')->find($idexp);      
        $ofendido->ordenes_id=$idexp;
        $ofendido->nombre=mb_strtoupper($datos['nombre'],'utf-8');
        $ofendido->paterno=mb_strtoupper($datos['paterno'],'utf-8');
        $ofendido->materno=mb_strtoupper($datos['materno'],'utf-8');
        $ofendido->sobren=mb_strtoupper($datos['sobren'],'utf-8');
        $ofendido->sexo=mb_strtoupper($datos['sexo'],'utf-8');
        $ofendido->edad=$datos['edad'];
        $ofendido->occiso=mb_strtoupper($datos['occiso'],'utf-8');
        $ofendido->autoridad=mb_strtoupper($datos['autoridad'],'utf-8');
        $ofendido->observaciones=mb_strtoupper($datos['observaciones'],'utf-8');
       // $ofendido->num=$datos['num'];
        $ofendido->fechanacimiento=$datos['fechanacimiento'];
        $ofendido->nacionalidades_id=$datos['nacionalidad'];
      // $ofendido->lugarnac=$datos['lugarnac'];
        $ofendido->lugarres=$datos['lugarres'];
        $ofendido->domicilio=$datos['domicilio'];
        $ofendido->ocupacion=$datos['ocupacion'];
        $ofendido->escolaridades_id=$datos['escolaridad'];
        $ofendido->getnicos_id=$datos['grupoet'];
        $ofendido->dialectos_id=$datos['dialecto'];
        $ofendido->serviciomilitar=$datos['serviciomilitar'];
        $ofendido->rfc=$datos['rfc'];
        $ofendido->menor=$datos['menor'];
        $ofendido->clasedades_id=$datos['rangoedad'];
        $ofendido->nomres=$datos['nomres'];
        $ofendido->apatres=$datos['apatres'];
        $ofendido->amatres=$datos['amatres'];
        $ofendido->moral=$datos['moral'];
        $ofendido->tofendidos_id=$datos['tipofen'];
        $ofendido->giros_id=$datos['giro'];
        $ofendido->discapacidades_id=$datos['discapacidad'];
        $ofendido->certificadodef=$datos['certificadodef'];
        $ofendido->causamuerte=$datos['causamuerte'];
        $ofendido->fhomicidios_id['fhomicidios'];
        $ofendido->objusuado_id['objusuado'];
        $ident=$datos['lugarnac'];
        if($ident!=null){
          if($ident==33){
            $ofendido->lnacimiento=mb_strtoupper($datos['pais'],'utf-8');
            }else{
              $entidad=Load::model('entidades')->find($ident);
              $ofendido->lnacimiento=$entidad->entidad;
          } 
        }



	    if(!$ofendido->save()){ 
			Flash::error('<div class="alert alert-danger" role="alert">
  					<strong>Error!</strong> La orden no pudo ser creado
					</div>'.$idexp); 
		}else{ 
			Flash::valid('<div class="alert alert-success" role="alert">
  					<strong>Exito!</strong> Orden agregada Correctamente
					</div>'.$idexp);					
            Redirect::toAction("formcreate/".Cifrar::todo($idexp));

        }
      
      }			
    }  

  }
    