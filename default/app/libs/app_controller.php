<?php
/**
 * @see Controller nuevo controller
 */
require_once CORE_PATH . 'kumbia/controller.php';

/**
 * Controlador principal que heredan los controladores
 *
 * Todas las controladores heredan de esta clase en un nivel superior
 * por lo tanto los metodos aqui definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 */
Load::model("usuarios");
class AppController extends Controller
{
    public $acl; //variable objeto ACL
    public $userRol = ""; 

    final protected function initialize()
    {       
        if(Usuarios::isValid()){
        //instanciamos a la clase MyAcl , y le indicamos el ini a utlizar
         $acl = new MyAcl('privilegios');  //si no se especifica el archivo a usar, por defecto busca en privilegios.ini
         $modulo = $this->module_name; //obtenermos el modulo actual
         $controlador = $this->controller_name; //obtenemos el controlador actual
         $accion = $this->action_name; //y obtenemos la accion actual
 
         // en el ejemplo se obtiene el privilegio del usuario actual a traves de la libreria Auth
         // pero se puede aplicar algun otro método para obtener el privilegio del usuario actual
         $privilegio = 'visitante';
         switch(Session::get('niveles_id')){
            case 1: $privilegio = 'administrador'; break;
            case 2: $privilegio = 'capturistas'; break;
            case 3: $privilegio = 'consultas'; break;
            case 4: $privilegio = 'amparos'; break;
            default: $privilegio = 'visitante'; break;
         }
         if (!$acl->check($privilegio, $modulo, $controlador, $accion)) { //verificamos si tiene ó no privilegios
 
             // si no posee los privilegios necesarios le enviamos un mensaje indicandoselo
             Flash::error("No posees suficientes PRIVILEGIOS para acceder a: {$modulo}/{$controlador}/{$accion}");
 
             //no dejamos que entre al contenido de la url si no tiene permisos
             View::select(NULL);
             return false;
         }
        }
        elseif($this->controller_name != 'principal'){
            Router::redirect('principal');
        }
    }

    final protected function finalize()
    {
        
    }
    
    protected function before_filter(){
    }
}