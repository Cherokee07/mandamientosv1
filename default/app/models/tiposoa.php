<?php 
class Tiposoa extends ActiveRecord
{
	protected $database = 'catalogosgral';

  public function initialize(){
    $this->has_many('ordenes');
  }  
  
   public function listar(){
    return $this->find();
  } 

  public function gettiposoa($id){		
		$res = $this->find_first("conditions: id = ".$id);
		return $res->descripcion;
	}
   
}
?>
