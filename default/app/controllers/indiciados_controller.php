<?php

Load::models('indiciados');
Load::models('ordenes');
Load::models('estatusindiciado');
Load::models('medafiliacion');


class IndiciadosController extends AppController 
{
  public $limit_params = FALSE;

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
          $indiciado=Load::model('indiciados')->find($id);
          $this->indiciado=$indiciado; 

           Flash::valid('<div class="alert alert-success" role="alert">
                    <strong>Exito!</strong> Acabaste de entrar en el form create
                    </div>');  
            }
      }else{
            Redirect::to('principal/nodisponible/');
            Flash::valid('<div class="alert alert-success" role="alert">
                    <strong>Exito!</strong> No hagas mamadas
                    </div>');  
    }

  }

   public function crearIndiciadoTemp(){

        View::select(null);
        if (Input::hasPost('indiciado')){ //Lo busca para modificar
            $ido=Input::post('indiciado');
            $indiciado=Load::model('indiciados')->find($ido);
        }else{
            $indiciado = new Indiciados();
            $filiacion = new Medafiliacion();
        }
        if(Input::hasPost('indiciados')){
        $datos=Input::post('indiciados');
        $idexp=$datos['ordenes'];
        $expediente = Load::model('ordenes')->find($idexp);
        $indiciado->ordenes_id=$idexp;
        $indiciado->nombre=mb_strtoupper($datos['nombre'],'utf-8');
      $indiciado->paterno=mb_strtoupper($datos['paterno'],'utf-8');
      $indiciado->materno=mb_strtoupper($datos['materno'],'utf-8');
        $indiciado->sobren=$datos['sobren'];
        $indiciado->sexo=$datos['sexo'];
        $indiciado->autoridad=$datos['autoridad'];
        $indiciado->estadosoa_id=$datos['estadosoa_id'];
        $indiciado->motivosoa_id=$datos['motivosoa_id'];
        $indiciado->fecedo=$datos['fecedo'];
      $indiciado->observaciones=mb_strtoupper($datos['observaciones'], 'utf-8');
        $indiciado->edad=$datos['edad'];
        $indiciado->fechanacimiento=$datos['fechanacimiento'];
        $indiciado->fecha_cambio=$datos['fechacambio'];
        $indiciado->nacionalidades_id=$datos['nacionalidad'];
        $indiciado->domicilio=$datos['domicilio'];
        $indiciado->ocupacion=$datos['ocupacion'];
        $indiciado->escolaridades_id=$datos['escolaridad'];
        $indiciado->getnicos_id=$datos['grupoet'];
        $indiciado->dialectos_id=$datos['dialectos_id'];
        $indiciado->serviciomilitar=$datos['serviciomilitar'];
        $indiciado->rfc=$datos['rfc'];
        $indiciado->menor=$datos['menor'];
        $indiciado->responsable_nombre=$datos['nomres'];
        $indiciado->responsable_paterno=$datos['apatres'];
        $indiciado->responsable_materno=$datos['amatres'];
        $indiciado->moral=$datos['moral'];
        $indiciado->lugarres=$datos['lugarres'];
        $ident=$datos['lugarnac'];
        if($ident!=null){
            if($ident==33){
                 $indiciado->lnacimiento=mb_strtoupper($datos['pais'],'utf-8');
                }else{
                $entidad=Load::model('entidades')->find($ident);
                 $indiciado->lnacimiento=$entidad->entidad;
                } 
            }
            $indiciado->entidades_id=$ident;
        }
      if (Input::hasPost('indiciado')) {
            if ($indiciado->update()) {// lo actualiza si viene el id de ofendido
                Flash::valid('<div class="alert alert-info" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Exito!</strong> Los datos del imputado han sido actualizados
                </div>');
            }
        }else{
            if($indiciado->save()){ 
                Flash::valid('<div class="alert alert-success" role="alert">
                    <strong>Exito!</strong> Imputado agregado Correctamente!!
                    </div>'.$indiciado->id);
                $filiacion->indiciados_id=$indiciado->id;
                    if($filiacion->save()){
                        Flash::valid('<div class="alert alert-success" role="alert">
                        <strong>Exito!</strong> Imputado agregado Correctamente!!
                        </div>'.$filiacion->id);
                    }                    
            }            
        }
    Redirect::toAction("formcreate/".Cifrar::todo($idexp));

    }


    public function formStatus($id){
    View::template('template2');
    $ord= new Ordenes();
    $ide=Cifrar::undo($id);
    $orden=$ord->find($ide);
    if ($orden!=null){
        $this->orden=$orden;
        $this->idexpcifrado=$id;
    
        if(isset($this->parameters[1])){
            $id=Cifrar::undo($this->parameters[1]);
            $ofe=Load::model('indiciados')->find($id);
            $this->indiciado=$ofe;
        }

    }
    else {
        Redirect::to('principal/nodisponible');
    }

    }

    public function crearStatus(){
    View::select(null);
    if (Input::hasPost('idindiciado')) {
        $ido=Input::post('idindiciado');
        $indiciado=Load::model('indiciados')->find($ido);
        $estatusindiciado=new estatusindiciado();
    }
    if (Input::hasPost('indiciados')){
        $datos=Input::post('indiciados');
        $idexp=$datos['ordenes'];
        $expediente = Load::model('ordenes')->find($idexp);
        $indiciado->ordenes_id=$idexp;
        $indiciado->estadosoa_id=$datos['estadosoa_id'];
        $indiciado->motivosoa_id=$datos['motivosoa_id'];
        $indiciado->fecedo=$datos['fecedo'];
        $indiciado->fecha_cambio=$datos['fechacambio'];
        $indiciado->observaciones=mb_strtoupper($datos['observaciones'], 'utf-8');
        $estatusindiciado->ordenes_id=$idexp;
        $estatusindiciado->indiciados_id=$ido;
        $estatusindiciado->estadosoa_id=$datos['estadosoa_id'];
        $estatusindiciado->motivosoa_id=$datos['motivosoa_id'];
        $estatusindiciado->fecedo=$datos['fecedo'];
        $estatusindiciado->fechacambio=$datos['fechacambio'];
        $estatusindiciado->observaciones=mb_strtoupper($datos['observaciones'], 'utf-8');        

        }
        if (Input::hasPost('idindiciado')){
            if ($indiciado->update()){
                Flash::valid('<div class="alert alert-info" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Exito!</strong> Los datos del imputado han sido actualizados
                </div>');
            }
            if ($estatusindiciado->save()){
                    Flash::valid('<div class="alert alert-success" role="alert">
                    <strong>Exito!</strong> Orden agregada Correctamente!!
                    </div>'.$idexp);   
            }
        }

    Redirect::toAction("formcreate/".Cifrar::todo($idexp));
    }


    public function formfiliacion($id,$idd,$iddd){
            View::template('template2');
            $ord = new Ordenes();
            $ide = Cifrar::undo($id);
            $orden = $ord->find($ide);

            if ($orden!=null){
                $this->orden=$orden;
                $this->idexpcifrado=$id;

                $indi = new Indiciados();
                $ide = Cifrar::undo($idd);
                $indiciado = $indi->find($ide);

                if ($indiciado!=null){
                    $this->indiciado=$indiciado;
                    $this->idexpcifrado=$id;

                        $med = new Medafiliacion();
                        $ide = Cifrar::undo($iddd);
                        $mafiliacion = $med->find($ide);

                        if($mafiliacion!=null){
                        $this->mafiliacion = $mafiliacion;
                        $this->idexpcifrado=$id;
                        Flash::valid('<div class="alert alert-success" role="alert">
                        <strong>Exito!</strong> Este es un mensaje del form create
                        </div>');  
                    }

                }
            }

                else{
                        Redirect::to('principal/nodisponible/');
                        Flash::valid('<div class="alert alert-success" role="alert">
                        <strong>Exito!</strong> No hagas mamadas
                        </div>');  
                        }
                

    }


    public function crearAfiliacion(){
            View::select(null);
            if(Input::hasPost('idafiliacion')){
                $ido=Input::post('idafiliacion');
                $mafiliacion=Load::model('medafiliacion')->find($ido);
            }

            if (Input::hasPost('mafiliacion')){
                $datos=Input::post('mafiliacion');      
                $mafiliacion->indiciados_id=$datos['indiciado_id'];
                $mafiliacion->bocamisuras_id=$datos['bocacomisuras'];
                $mafiliacion->bocatamano_id=$datos['bocatamano'];
                $mafiliacion->cabellocalvicie_id=$datos['cabellocalvicie'];
                $mafiliacion->cabellocantidad_id=$datos['cabellocantidad'];
                $mafiliacion->cabellocolor_id=$datos['cabellocolor'];
                $mafiliacion->cabelloforma_id=$datos['cabelloforma'];
                $mafiliacion->cabelloimplantacion_id=$datos['cabelloimplantacion'];
                $mafiliacion->cara_id=$datos['cara'];
                $mafiliacion->cejasdireccion_id=$datos['cejasdireccion'];
                $mafiliacion->cejasforma_id=$datos['cejasforma'];
                $mafiliacion->cejasimplantacion_id=$datos['cejasimplantacion'];
                $mafiliacion->cejastamano_id=$datos['cejastamano'];
                $mafiliacion->colorpiel_id=$datos['colorpiel'];
                $mafiliacion->complexion_id=$datos['complexion'];
                $mafiliacion->frentealtura_id=$datos['frentealtura'];
                $mafiliacion->frenteancho_id=$datos['frenteancho'];
                $mafiliacion->frenteinclinacion_id=$datos['frenteinclinacion'];
                $mafiliacion->labiosalturanasolabial_id=$datos['labiosalturanasolabial'];
                $mafiliacion->labiosespesor_id=$datos['labiosespesor'];
                $mafiliacion->labiosprominencia_id=$datos['labiosprominencia'];
                $mafiliacion->mentonforma_id=$datos['mentonforma'];
                $mafiliacion->mentoninclinacion_id=$datos['mentoninclinacion'];
                $mafiliacion->mentontipo_id=$datos['mentontipo'];
                $mafiliacion->narizaltura_id=$datos['narizaltura'];
                $mafiliacion->narizancho_id=$datos['narizancho'];
                $mafiliacion->narizbase_id=$datos['narizbase'];
                $mafiliacion->narizdorso_id=$datos['narizdorso'];
                $mafiliacion->narizraiz_id=$datos['narizraiz'];
                $mafiliacion->ojoscolor_id=$datos['ojoscolor'];
                $mafiliacion->ojosforma_id=$datos['ojosforma'];
                $mafiliacion->ojostamano_id=$datos['ojostamano'];
                $mafiliacion->orejabordeforma_id=$datos['orejabordeforma'];
                $mafiliacion->orejahelixadherencia_id=$datos['orejahelixadherencia'];
                $mafiliacion->orejahelixoriginal_id=$datos['orejahelixoriginal'];
                $mafiliacion->orejahelixposterior_id=$datos['orejahelixposterior'];
                $mafiliacion->orejahelixsuperior_id=$datos['orejahelixsuperior'];
                $mafiliacion->orejalobuloadherencia_id=$datos['orejahelixadherencia'];
                $mafiliacion->orejalobulocontorno_id=$datos['orejalobulocontorno'];
                $mafiliacion->orejalobulodimension_id=$datos['orejalobulodimension'];
                $mafiliacion->orejalobuloparticularidad_id=$datos['orejalobuloparticularidad'];
                $mafiliacion->sangrefactorrh_id=$datos['sangrefactorrh'];
                $mafiliacion->sangretipo_id=$datos['sangretipo'];
              //  $mafiliacion->observaciones=$datos['observaciones'];
            }
                if (Input::hasPost('mafiliacion')) {
            if ($mafiliacion->update()) {// lo actualiza si viene el id de ofendido
                Flash::valid('<div class="alert alert-info" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Exito!</strong> La media afiliacion ah sido modificada!
                </div>');
                }
        }
    }
}   


