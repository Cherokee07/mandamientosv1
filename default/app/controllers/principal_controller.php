<?php


Load::models('usuarios','bitacora');
Load::lib('mi_captcha');

class PrincipalController extends AppController
{

    public function login(){
    	View::template(null);
        $usuarios = new Usuarios();
		$this->titulo = "SISTEMA DE EXPEDIENTES";
		$this->subtitulo = "CAPTURA DE EXPEDIENTES";
		Session::set('expe_grande','"shadowbox;width=1260;height=720;"');
		Session::set('expe_mediano','"shadowbox;width=1212;height=720;"');
		Session::set('expe_chico','"shadowbox;width=540;height=420;"');	

		if (Input::hasPost('login') && Input::hasPost('clave')){
			
			$conecta = new Bitacora();
			$conecta->login = Input::post('login');
			$conecta->usuarios_id = -1;
			$conecta->movimiento = utf8_encode('Conexión');
			$conecta->fecha = date('Y-m-d');
			$conecta->hora = date('H:i:s');
			$conecta->descripcion = $_SERVER['HTTP_USER_AGENT'];
			$conecta->tipo = -1;			
			$conecta->ip = Load::model('extras')->obtenerIp();
			$conecta->observaciones='No se conecto';
			$conecta->save();
			if ((Session::get('expe_intentos')<7) ){
				if($usuarios->iniciarSesion()) {	
					if(Session::get('activo')=='S'){//Verifico si el usuario esta activo
					 		//Session::set('expe_intentos',0);						
							Session::set('expe_pags',$conecta->id);
	                        Flash::info('<div class="alert alert-info" role="alert">
	  						<strong>Bienvenido '.Session::get('nombre').'!</strong>
							</div>');
							$conecta->usuarios_id = Session::get('id');
							$conecta->observaciones = 'Si se conecto';	
							$conecta->tipo = 1;						
							$conecta->save();

							$user = Load::model('usuarios')->find_first("conditions: id = ".Session::get('id'));
							Router::redirect('index');
					}else{
					 	$auth = Auth2::factory('model');
	                    $auth->logout();
	                    unset($_SESSION['KUMBIA_SESSION'][APP_PATH]);
	                    Flash::error("<div class='alert alert-error alert-dismissible'>
	                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>X</button>
	                        <h4><i class='icon fa  fa-times'></i>Error</h4>
	                        ¡ La cuenta de usuario no se encuentra activa !.
	                    </div>");

					} 
							
	            } 
				else {
                    Flash::error('<div class="alert alert-danger" role="alert">
  					<strong>Error!</strong>El nombre de usuario y/o la '.utf8_encode('contraseña').' son incorrectos 
					</div>');
                	}
			}
			else {
                Flash::error('<div class="alert alert-danger" role="alert">
  					<strong>Error!</strong>El captcha es incorrecto
					</div>');
            }
		}
		elseif(Usuarios::isValid()){
			Router::redirect('index');
		}
	}
	
	public function index(){
		Router::redirect("principal/login");
	}    
	
	public function letras(){
		View::template(null);
	}

	
    public function nodisponible(){
    	view::template('templatemenus');
    }

        public function salir() {
		$dat = Session::get('expe_pags');
        $usuarios = new Usuarios();
        if($usuarios->cerrarSesion()) {
			if (@$conect->id){
				$conect->fin = date('Y-m-d H:i:s');
				$conect->save();
			}			
            Flash::valid(utf8_encode("La sesión ha sido cerrada correctamente."));			
        }
        Router::redirect("principal/login");
    }

	
}

?>