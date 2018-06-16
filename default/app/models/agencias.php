<?php 
class Agencias extends ActiveRecord
{
	protected $database = 'catalogosgral';

  public function initialize(){
    $this->has_many('ordenes');
  }  
  
  public function listar(){
    $sql = "SELECT id, concat(agencia,' [' , codagen , ']')  as agencia FROM agencias where vigente='S' ";
    return $this->find_all_by_sql($sql);
  } 

}
?>
