<?php 
class Indiciados extends ActiveRecord
{
  protected $database = 'ordenes';
 
  public function initialize(){
	$this->has_many('delitos');
	$this->has_many('nomindis');
	$this->belongs_to('ordenes');
	$this->belongs_to('estadosoa');
	$this->belongs_to('motivosoa');
	$this->has_many('estatusindiciado');
	$this->has_many('medafiliacion');
  }  
  
 
 public function mostrar($ordenesid = 0){
	 $datos = $this->desplegar($ordenesid);
	 $datos[0] = 'Nombre Real';
	 return $datos;
 }  
  
  public function listar($ordenesid = 0){
	$sql = "Select i.id,i.ordenes_id,concat(ifnull(i.nombre,''),' ',ifnull(i.paterno,''),' ',ifnull(i.materno,'')' ',) as nombre from indiciados i ";
	$sql .="inner join ordenes g ON g.id = i.ordenes_id ".((Session::get('todas')=='S')?"":" AND g.subprocuradurias_id = ".Session::get('subprocuradurias_id')." ");
	$sql .="where i.ordenes_id = $ordenesid order by nombre,paterno,materno";
	$todos = $this->db->in_query($sql);
	$resultados = array();	
    foreach($todos AS $resultado) {
        $resultados[] = $this->dump_result($resultado);
    }
	return $resultados;
  }

      public function getindiciados($id){		
		$res = $this->find_first("conditions: id = ".$id);
		return $res->nombre;
  }  
  	public function getNombre(){
		    return $this->nombre.' '.$this->paterno.' '.$this->materno;
  }


 

}
?>