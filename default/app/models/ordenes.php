<?php 
class Ordenes extends ActiveRecord
{
 
  public function initialize(){
    $this->database = 'ordenes';

    
	$this->has_many('indiciados');
	$this->has_many('ofendidos');
	$this->has_many('nomindis');
	$this->has_many('nomofens');
	$this->has_many('ofeindis');
	$this->belongs_to('juzgados');
	$this->belongs_to('localidades');
	$this->belongs_to('agencias');
	$this->belongs_to('tiposoa');
	}

		public function listaDelitos(){ //metodos para retornar los delitos ordenados por victima e imputado
	 $ofen=0;
	 $indi=0;
	 $arreglo = array();

        if (count($this->getOfeindis())>0){
            $ldelitos= Load::model('ofeindis')->find("ordenes_id = ".$this->id,"order: indiciados_id,ofendidos_id,delitos_id");
        }

        foreach ($ldelitos as $key) { // aqui se escoge a los imputados y victimas que no se repiten
            if($key->ofendidos_id !=$ofen || $key->indiciados_id !=$indi){
                array_push($arreglo,array('idel'=>$key->id,'ofendido'=>$key->getOfendidos(), 'indiciado'=>$key->getIndiciados()));
            }
            $ofen=$key->ofendidos_id;
            $indi=$key->indiciados_id;
        }

        for ($i=0; $i <count($arreglo) ; $i++) { // aqui voy metiendo un arreglo de delitos para cada uno
             $delitos=array();
            foreach ($ldelitos as $key) {
              if($key->ofendidos_id==$arreglo[$i]['ofendido']->id && $key->indiciados_id==$arreglo[$i]['indiciado']->id ){
                   array_push($delitos,array('delito'=>$key->getDelitos(),'iddeli'=>$key->id,'principal'=>$key->esprincipal)); 
              }
            }   
            $arreglo[$i]['delitos']=$delitos;   
        }
        return $arreglo;

	
	}
	
}
?>
