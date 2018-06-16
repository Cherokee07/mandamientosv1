<?php 
class Estadosoa extends ActiveRecord
{
	protected $database = 'catalogosgral';
 
  public function initialize(){
	$this->has_many('indiciados');
  }  

  
  
  
  public function listar(){
    return $this->find("order: 2 asc");
  }  
  
  public function obtenLista($condiciones="1=1"){
    return $this->find("conditions: ".$condiciones,"order: 2 asc");
  }     
}
?>
