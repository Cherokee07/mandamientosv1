<?php

/**
 * @author 
 * @copyright 2013
 */

class Usuarios extends ActiveRecord{

  protected $database = 'catalogosgral';
  
    public function initialize(){

     $this->belongs_to('subprocuradurias');
     $this->belongs_to('niveles');
     
    }    
  
   
    public static function isValid() {
        $auth = Auth2::factory('model');
        return $auth->isValid();
    }



    public function getNombre(){
      return $this->titulo."".$this->nombre." ".$this->paterno." ".$this->materno;
    }

   /* public function getPermisonly($idp){
       $sql="";
       $sql.="SELECT * FROM userpermisos";
       $sql.=" where usuarios_id=$this->id and permisos_id=$idp";
       $resultado=Load::model('userpermisos')->find_by_sql($sql);

       if($resultado->id){
         return $resultado;
       }else{
         return false;
       }
    }*/


    
  

   public function iniciarSesion() {
        //Verifico si tiene una sesión válida con una ip
        if(self::isValid()) {
            return true;
        } else {           
            //Verifico si se ha autentificado
            if(Input::hasPost('login') && Input::hasPost('clave')) {                                 
                  $usuario = Input::post('login'); //Filtro el usuario
                  $clave = Input::post('clave'); //Filtro la contraseña                  
                  $auth = Auth2::factory('model');  //Creo el objeto de Auth2 con el uso de validacion mediante modelos
                  $auth->setLogin('login'); //Defino cual es el campo del nombre de usuario
                  $auth->setPass('clave');//Defino cual es el campo del nombre de la contraseña
                  $auth->setCheckSession(true);//Se utiliza para que no inicie sesión en otro navegador (no me funciona :S)
                  $auth->setModel('usuarios'); //Indico cual es el modelo respectivo para que consulte en la base de datos
                  $auth->setAlgos('sha1');
                  $auth->setFields(array('id', 'nombre', 'paterno','materno','login','titulo', 'niveles_id','activo','subprocuradurias_id')); //Estos campos se almacenan en sesión automáticamente
                  return ($auth->identify($usuario,$clave) && $auth->isValid());
              }
        }
        return false;
    }

      public function cerrarSesion() {
        //Verifico si tiene sesión
        if(!self::isValid()) {
            Flash::error("No has iniciado sesión o ha caducado. <br /> Por favor identifícate nuevamente.");
            return false;
        } else {
            $auth = Auth2::factory('model');
            $auth->logout();
            //Elimino todas las variables de sesión de la app
            unset($_SESSION['KUMBIA_SESSION'][APP_PATH]);
            return true;
        }       
    }
      public function listar(){   
    $sql = "SELECT id, CONCAT(IFNULL(nombre,''),' ',IFNULL(paterno,''),' ',IFNULL(materno,'')) AS nombre FROM usuarios WHERE activo='S' ";    
    return $this->find_all_by_sql($sql);
  }

  public function obtener_usuarios($nombre) {
    if ($nombre != '') {
        $nombre = stripcslashes($nombre);
    $sql = "SELECT CONCAT(IFNULL(u.nombre,''),' ',IFNULL(u.estatus,''),' ',IFNULL(n.nivel,''),' *-',u.id) as nombre ";
    $sql .= "FROM users u, niveles n WHERE n.id = u.niveles_id AND ";
    $sql .= "CONCAT(IFNULL(u.nombre,''),' ',IFNULL(u.estatus,''),' ',IFNULL(n.nivel,''),' *-',u.id) LIKE '%".$nombre."%'";
    $res = $this->find_all_by_sql($sql);
        if ($res) {
            foreach ($res as $dato) {
                $datos[] = $dato->nombre;
            }
            return $datos;
        }
    }
    return array('NO SE ENCONTRO*-0');
  }  
  

  public function existe($id){
    $id = ((is_numeric(@$id))?$id:0);
    $art = "";
    $num = 1;
    $sql = "SELECT SUM(num) as num FROM (";
    foreach(Load::model('periodos')->find() as $periodo){
      $temp = Session::get('siuv_title').$periodo->periodo;
      $sql .= $art."(SELECT count(1) as num FROM ".$temp.".vehiculos WHERE usuarios_id = ".$id.")";
      $art = " UNION ";
      $sql .= $art."(SELECT count(1) as num FROM ".$temp.".clientes WHERE usuarios_id = ".$id.")";
      $sql .= $art."(SELECT count(1) as num FROM ".$temp.".contaminantes WHERE usuarios_id = ".$id.")";
      $sql .= $art."(SELECT count(1) as num FROM ".$temp.".fisicomecanicas WHERE usuarios_id = ".$id.")";
      $num++;
    }
    $sql .= ") T";
    $res = $this->find_by_sql($sql);
    return ($res->num>0);
  }

    public function getExistente($data) {
      $sql="SELECT u.* from usuarios as u WHERE login ='$data'";
      $user= $this->find_by_sql($sql);
      if($user->id){
          return true;    
      }else{
          return false;    
      }
          
  }

  

  
  

    

  
  

  

    public $before_create="aux_before_create"; 
    public $before_save="aux_before_save";
    public function aux_before_create(){ 
      if($this->exists("login='".$this->login."'")){ 
         Flash::error('<div class="alert alert-danger" role="alert"><strong>Error!</strong> El nombre de usuario  '.$this->login.' ya fue registrado, verifique! </div>');
        return 'cancel'; 
      }
    }
  


  public function aux_before_save(){ 
    $existe1 = $existe2 = false;
    if (!$this->id){
      $existe1 = $this->exists("login='".$this->login."'");
    }
    else{
      $existe1 = $this->exists("login='".$this->login."' AND id != ".$this->id);
    }
    if ($existe1){
      Flash::error('<div class="alert alert-danger" role="alert"><strong>Error!</strong> El nombre de usuario  '.$this->login.' ya fue registrado, verifique! </div>');
      return 'cancel'; 
    }
  }

    



}

?>