<?php 
class medafiliacion extends ActiveRecord
{
  protected $database = 'ordenes';


  	public function initialize(){
	   $this->belongs_to('indiciados');
    }    	
  
  public function listar(){
    return $this->find("order: 2");
  } 
}
?>

