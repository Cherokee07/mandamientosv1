<?php 
class Ofeindis extends ActiveRecord
{
  protected $database = 'ordenes';
  /**
  *Retorna un array de objetos cuyos campos son los mismos de la tabla Marca
  *$page : es el número o indice de la página
  *$$ppage : es el número de filas o registro de la página
  **/
  public function initialize(){
	//$this->belongs_to('delitos');
	$this->belongs_to('ofendidos');
	$this->belongs_to('indiciados');
	$this->belongs_to('ordenes');
	$this->belongs_to('edosdelioa');
  $this->belongs_to('delitos');
  }  
}


?>