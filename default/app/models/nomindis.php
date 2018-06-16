<?php 
class Nomindis extends ActiveRecord
{
  /**
  *Retorna un array de objetos cuyos campos son los mismos de la tabla Marca
  *$page : es el número o indice de la página
  *$$ppage : es el número de filas o registro de la página
  **/
  public function initialize(){
	$this->belongs_to('ordenes');
	$this->belongs_to('indiciados');
  }  
   
  public function listar($ordenesid = 0){
	$sql = "Select i.id,i.ordenes_id,concat(ifnull(i.nombre,''),' ',ifnull(i.paterno,''),' ',ifnull(i.materno,'')) as nombre,indiciados_id from nomindis i ";
	$sql .="inner join ordenes g ON g.id = i.ordenes_id ".((Session::get('niveles_id')==1)?" ":" AND g.subprocuradurias_id = ".Session::get('subprocuradurias_id')." ");
	$sql .= "where i.ordenes_id = $ordenesid order by nombre,paterno,materno";
	$todos = $this->db->in_query($sql);
	$resultados = array();	
    foreach($todos AS $resultado) {
        $resultados[] = $this->dump_result($resultado);
    }
	return $resultados;
  }  
  
  
}
?>