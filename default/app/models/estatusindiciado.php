<?php 
class Estatusindiciado extends ActiveRecord
{
  protected $database = 'ordenes';

   public function initialize(){
	$this->belongs_to('indiciados');
  $this->belongs_to('estadosoa');
  $this->belongs_to('motivosoa');
}
  /**
  *Retorna un array de objetos cuyos campos son los mismos de la tabla Marca
  *$page : es el número o indice de la página
  *$$ppage : es el número de filas o registro de la página
  **/
  
  public function listar(){
    return $this->find("order: 2");
  } 
}
?>
