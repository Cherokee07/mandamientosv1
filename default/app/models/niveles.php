<?php 
class Niveles extends ActiveRecord
{
	protected $database = 'catalogosgral';
 
  public function initialize(){
    $this->has_many('usuarios'); 
  }  
  
  public function paginarid($id=0, $ppage=10)
  {
    return $this->paginate("conditions: id = ".$id, "order: 2 ASC","page: 1","per_page: $ppage");
  }  
  
  public function paginar($page, $condicion="", $ppage=10)
  {
    return $this->paginate("conditions: nivel like '%".$condicion."%'", "order: 2 ASC","page: $page","per_page: $ppage");
  }
  
  public function listar(){
    return $this->find("order: 2 asc");
  } 
 
  public function obtenLista($condiciones="1=1"){
    return $this->find("conditions: ".(empty($condiciones)?'1=1':$condiciones),"order: 3 asc, 4 asc, 2 asc");
  }  
}
?>
