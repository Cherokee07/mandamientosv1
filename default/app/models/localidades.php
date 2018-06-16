<?php 
class Localidades extends ActiveRecord
{
	protected $database = 'catalogosgral';

  public function initialize(){
    $this->has_many('ordenes');
	$this->belongs_to('municipios');
  }  
   
	public function listar(){		
		return $this->find(); 
	}
}
?>
