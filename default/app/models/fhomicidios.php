<?php 
class Fhomicidios extends ActiveRecord
{
	protected $database = 'catlegajos';
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
