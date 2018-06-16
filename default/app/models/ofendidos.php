<?php 
class Ofendidos extends ActiveRecord
{

  protected $database = 'ordenes';

  public function initialize(){
	$this->has_many('delitos');
	$this->has_many('nomofens');
	$this->belongs_to('ordenes');
	$this->belongs_to('nacionalidades');
  }  
  
  public function mostrar($ordenesid = 0){
	$datos = $this->desplegar($ordenesid);
	$datos[0] = 'Nombre Real';
	return $datos;
  }  

  public function listar($ordenesid = 0){
	$sql = "Select o.id,o.ordenes_id,concat(ifnull(o.nombre,''),' ',ifnull(o.paterno,''),' ',ifnull(o.materno,'')) as nombre from ofendidos o ";
	$sql .= "inner join ordenes g ON g.id = o.ordenes_id ".((Session::get('todas')=='S')?"":" AND g.subprocuradurias_id = ".Session::get('subprocuradurias_id')." ");
	$sql .= "where o.ordenes_id = $ordenesid order by nombre,paterno,materno";
	$todos = $this->db->in_query($sql);
	$resultados = array();	
    foreach($todos AS $resultado) {
        $resultados[] = $this->dump_result($resultado);
    }
	return $resultados;
  }  
  
  public function desplegar($ordenesid = 0){
	$sql = "Select o.id,o.ordenes_id,concat(ifnull(o.nombre,''),' ',ifnull(o.paterno,''),' ',ifnull(o.materno,'')) as nombre from ofendidos o ";
	$sql .="inner join ordenes g ON g.id = o.ordenes_id ".((Session::get('todas')=='S')?"":" AND g.subprocuradurias_id = ".Session::get('subprocuradurias_id')." ");
	$sql .="where o.ordenes_id = $ordenesid order by nombre,paterno,materno";
	$todos = $this->db->in_query($sql);
	$resultados = array();	
    foreach($todos as $resultado) {
        $resultados[$resultado['id']] = $resultado['nombre'];
    }
	return $resultados;
  }
  
  public function listaOrdenes($nombre='',$paterno='',$materno='',$alias='',$observa=''){	
	$nombre = utf8_decode($nombre);
	$paterno = utf8_decode($paterno);
	$materno = utf8_decode($materno);
	$alias = utf8_decode($alias);
	$observa = utf8_decode($observa);
	$sql = "SELECT DISTINCT g.id,concat(g.exppenal,'/',g.anipenal,'/',juzgados_id,'/',t.clave,'/',g.ocasion) as expediente,'REAL' as tipo,";
	$sql .= "ifnull(o.nombre,'') as nombre, ifnull(o.paterno,'') as paterno, ifnull(o.materno,'') as materno,";
	$sql .= "CASE o.autoridad WHEN 'S' THEN 'AUTORIDAD' ELSE '' END as autoridad,";
	$sql .= "CASE o.occiso WHEN 'S' THEN 'OCCISO' WHEN 'N' THEN 'VIVO' ELSE '' END as occiso,";
	$sql .= "o.edad,o.sexo,o.sobren, o.observaciones ";
	$sql .= "FROM ofendidos o INNER JOIN ordenes g ON g.id = o.ordenes_id ";
	$sql .= ((Session::get('todas')=='S')?" ":" AND g.subprocuradurias_id = ".Session::get('subprocuradurias_id')." ");
	$sql .= "LEFT JOIN ".$this->catalogos.".tiposoa t ON t.id = g.tiposoa_id ";
	$sql .= "WHERE ifnull(o.nombre,'') like '%".$nombre."%' and ifnull(o.paterno,'') like '%".$paterno."%' ";
 	$sql .= "and ifnull(o.materno,'') like '%".$materno."%' and ifnull(o.sobren,'') like '%".$alias."%' and ifnull(o.observaciones,'') like '%".$observa."%' ";
	if (!((($alias !='') || ($observa!='')) && (($nombre=='') && ($paterno=='') && ($materno=='')))){
		$sql .= " UNION ";
		$sql .= "SELECT DISTINCT g.id,concat(g.exppenal,'/',g.anipenal,'/',juzgados_id,'/',t.clave,'/',g.ocasion) as expediente,'FICT.' as tipo,";
		$sql .= "ifnull(n.nombre,'') as nombre, ifnull(n.paterno,'') as paterno, ifnull(n.materno,'') as materno,";
		$sql .= "CASE o.autoridad WHEN 'S' THEN 'AUTORIDAD' ELSE '' END as autoridad,";
		$sql .= "CASE o.occiso WHEN 'S' THEN 'OCCISO' WHEN 'N' THEN 'VIVO' ELSE '' END as occiso,";	
		$sql .= "o.edad,o.sexo,'' as sobren,o.observaciones ";
		$sql .= "FROM nomofens n INNER JOIN ofendidos o ON o.id = n.ofendidos_id INNER JOIN ordenes g ON g.id = n.ordenes_id ";
		$sql .= ((Session::get('todas')=='S')?" ":" AND g.subprocuradurias_id = ".Session::get('subprocuradurias_id')." ");
		$sql .= "LEFT JOIN ".$this->catalogos.".tiposoa t ON t.id = g.tiposoa_id ";
		$sql .= "WHERE ifnull(n.nombre,'') like '%".$nombre."%' and ifnull(n.paterno,'') like '%".$paterno."%' ";
		$sql .= "and ifnull(n.materno,'') like '%".$materno."%' and ifnull(o.sobren,'') like '%".$alias."%' and ifnull(o.observaciones,'') like '%".$observa."%' ";
	}
	return $this->find_all_by_sql($sql); 
  }
  
  public $before_validation_on_create="aux_before_val_create"; 
  public function aux_before_val_create(){ 		
		$this->cvecaptu = Session::get('login');  
  }

  public function getofendidos($id){		
		$res = $this->find_first("conditions: id = ".$id);
		return $res->nombre;
  }  

  public function getNombre(){
		    return $this->nombre.' '.$this->paterno.' '.$this->materno;
  } 
}
?>