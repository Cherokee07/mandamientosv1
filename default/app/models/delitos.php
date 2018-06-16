<?php 
class Delitos extends ActiveRecord
{
	protected $database = 'catalogosgral';
 
  public function initialize(){

  $this->has_many('ordenes');
  $this->has_many('ofeindis');
  
  
  }

  public function listar(){ 
    return $this->find("order: 2");
  } 

   public function listardelito(){
   	$sql = "SELECT id, concat (a.codigo ,' - ',a.delito,' *- ',a.id ) AS delito FROM catlegajos.delitos a  WHERE a.id!=99999 ";
   	return $this->find_all_by_sql($sql);
   } 

}
?>  


