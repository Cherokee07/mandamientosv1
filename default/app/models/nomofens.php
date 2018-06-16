<?php 
class Nomofens extends ActiveRecord
{
  /**
  *Retorna un array de objetos cuyos campos son los mismos de la tabla Marca
  *$page : es el número o indice de la página
  *$$ppage : es el número de filas o registro de la página
  **/
  public function initialize(){
	$this->belongs_to('ordenes');
	$this->belongs_to('ofendidos');
  }  

}

?>