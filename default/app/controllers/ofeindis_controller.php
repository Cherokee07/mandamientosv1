<?php

Load::models('ofeindis','nomindis','ordenes', 'delitos', 'indiciados', 'ofendidos');


class OfeindisController extends AppController 
{



   public function formcreate($id){

    View::template('template2');
    $ord= new Ordenes();
    $ide=Cifrar::undo($id);
    $orde=$ord->find($ide);
      if($orde!=null){
        $this->ordenes=$orde;
        $this->idexpcifrado=$id;

        if( isset($this->parameters[1])){// cuando viene de otra parte que no es la creacion
        $iddel=Cifrar::undo($this->parameters[1]);
        $this->delitounico=Load::model('ofeindistemp')->find($iddel);
        }        
      }
      else {
        Redirect::to('principal/nodisponible');
      }
   }

   public function crearDelitoTemp(){
      View::select(null);
      if (Input::hasPost("indiciados","ofendidos","delitotemp")){
        $datos=Input::post("delitotemp");
        $idexp=$datos['ordenes'];
        $delitoid=$datos['delito'];
      }

      $indiciados=Input::post('indiciados');
      $ofendidos=Input::post('ofendidos');
      foreach ($indiciados as $indiciado){
        foreach ($ofendidos as $ofendido) {
          if (!(Load::model('ofeindis')->exists("ordenes_id = ".$idexp." and delitos_id = $delitoid and indiciados_id = $indiciado and ofendidos_id = $ofendido"))) {
            $ofeindis= new Ofeindis();
            $ofeindis->ordenes_id=$idexp;
            $ofeindis->indiciados_id=$indiciado;
            $ofeindis->ofendidos_id=$ofendido;
            $ofeindis->delitos_id=$delitoid;
            $ofeindis->edosdelioa_id=1;
            $ofeindis->grave=$datos['grave'];
            $ofeindis->tentativa=$datos['tentativa'];
            $ofeindis->culposo=$datos['culposo'];
            $ofeindis->oficioso='N';
            $ofeindis->particularidades=mb_strtoupper($datos['particularidades'],'utf-8');
            $ofeindis->delestadis_id=$datos['delestadis'];
            $ofeindis->tentativaestadis=$datos['tentativaestadis'];
            $ofeindis->culposoestadis=$datos['culposoestadis'];
            $ofeindis->moddelitos_id=$datos['moddelitos'];
            $ofeindis->violentoestadis=$datos['violentoestadis'];


            if ($ofeindis->save()) {
                Flash::valid('<div class="alert alert-success" role="alert">
                <strong>Exito!</strong> El delito ha sido registrado
              </div>');
                Redirect::toAction("formcreate/".Cifrar::todo($idexp));  

            }
          }
        }
      }
   }


}
?>