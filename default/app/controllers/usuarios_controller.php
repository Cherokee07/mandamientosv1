<?php

View::template('sbadmin');
Load::models('usuarios');
Load::models('subprocuradurias');
Load::models('niveles');


 class UsuariosController extends AppController
{

    public function crear(){
    	View::template('templatemenus');

$this->usuarios=Load::model('usuarios')->find();
	

      if(Input::hasPost('usuarios')){
		$datos=Input::post('usuarios');
		$usuario= new Usuarios();
		//$usuario->id=$datos['id'];
		$usuario->login=Input::post('login');
		$usuario->clave=sha1($datos['clave']);
		$usuario->repite=sha1($datos['repite']);
		$usuario->titulo=mb_strtoupper($datos['titulo'],'utf-8');
		$usuario->nombre=mb_strtoupper($datos['nombre'],'utf-8');
		$usuario->paterno=mb_strtoupper($datos['paterno'],'utf-8');
		$usuario->materno=mb_strtoupper($datos['materno'],'utf-8');
		$usuario->activo=$datos['activo'];
		$usuario->niveles_id=$datos['niveles_id'];
		$usuario->subprocuradurias_id=$datos['subprocuradurias_id'];
		$usuario->areas_id=$datos['areas_id'];
		$usuario->jefes_id=$datos['jefe'];
		$usuario->todas=$datos['todas'];
		$usuario->consultas=$datos['consultas'];
		$usuario->captura=$datos['captura'];
		$usuario->reportes=$datos['reportes'];
        

        
	    if(!$usuario->save()){ 
			Flash::error('<div class="alert alert-danger" role="alert">
  					<strong>Error!</strong> el usuario no fue creado
					</div>'); 
		}else{ 
			Flash::valid('<div class="alert alert-success" role="alert">
  					<strong>Exito!</strong> Usuario agregado Correctamente
					</div>');					
			Input::delete();
		}
       //var_dump(usuario);
       
       //exit();
      
    }


	}
	public function editar($id=null){ // metodo para editar un usuario (actualizado F)
		View::template('templatemenus');
		$idusu=Cifrar::undo($id);
		$user=Load::model('usuarios')->find($idusu);
		$this->usuario=$user;
	
		if(Input::hasPost('usuarios')){
		$datos=Input::post('usuarios');
		$user->login=Input::post('login');
		$user->clave=sha1($datos['clave']);
		$user->repite=sha1($datos['repite']);
		$user->titulo=mb_strtoupper($datos['titulo'],'utf-8');
		$user->nombre=mb_strtoupper($datos['nombre'],'utf-8');
		$user->paterno=mb_strtoupper($datos['paterno'],'utf-8');
		$user->materno=mb_strtoupper($datos['materno'],'utf-8');
		$user->activo=$datos['activo'];
		$user->niveles_id=$datos['niveles_id'];
		$user->subprocuradurias_id=$datos['subprocuradurias_id'];
		$user->areas_id=$datos['areas_id'];
		$user->jefes_id=$datos['jefe'];
		$user->todas=$datos['todas'];
		$user->consultas=$datos['consultas'];
		$user->captura=$datos['captura'];
		$user->reportes=$datos['reportes'];
		    if(!$user->update()){ 
				Flash::error('<div class="alert alert-danger" role="alert">
	  					<strong>Error!</strong> El usuario no pudo ser creado
						</div>'); 
			}else{ 
				Flash::valid('<div class="alert alert-success" role="alert">
	  					<strong>Exito!</strong> Usuario actualizado Correctamente
						</div>');					
				Input::delete();
				$bitacora=Load::model('bitacora')->registrarBitacora('ACTUALIZO USUARIO','Se actualizo la información del usuario '.$user->getNombre(),'');
			}
    	}
	}

	public function cambiarclave($id = null){ // metodo para cambiar la contraseña
		$idusu=Cifrar::undo($id);
		if($idusu==Session::get('id')){// comprueba que sea el mismo usuario y no otro
			View::template('templatemenus');
			$user=Load::model('usuarios')->find($idusu);
			$this->usuario=$user;
			if(Input::hasPost('datos')){ 
				$valores= Input::post('datos'); 
				$user->clave = sha1($valores['clave']);
				$user->repite = sha1($valores['repite']);
				if(!$user->update()){ 
					Flash::error('Falló Operación'); 
				}else{ 
					Flash::valid('<div class="alert alert-success" role="alert">
	  					<strong>Exito!</strong> Password actualizado correctamente
						</div>');					
				$bitacora=Load::model('bitacora')->registrarBitacora('CAMBIO CONTRASEÑA','Se cambio la contraseña del usuario '.$user->getNombre(),'');	
				}	  
			}
		}else{
			Redirect::to('principal/nodisponible/');
		}	
	}
	

		public function resetear($id=null){ // funcion para resetear la contraseña de un usuario 
		View::template('templatemenus');
		$idusu=Cifrar::undo($id);
		$usuario=Load::model('usuarios')->find($idusu);
		$usuario->clave =sha1('clave123'); 
		$usuario->repite = sha1('clave123');
		if ($usuario->update()){
			Flash::valid('<div class="alert alert-success" role="alert">
  					<strong>Exito!</strong> Password reseteado  Correctamente
					</div>');					
			$bitacora=Load::model('bitacora')->registrarBitacora('RESETEO DE CONTRASEÑA','Se reseteo la contraseña del usuario '.$usuario->getNombre(),'');			
		}
		else{				
			Flash::error('Falló Operación'); 
		}
		Redirect::toAction("crear");
	}

	public function getExistente() {  // comprueba que el nombre de login no se repita     
        View::select(NULL);
        View::template(NULL);
        $usuarios = new Usuarios();
        $dato = Input::get('login');
        if ($usuarios->getExistente($dato)) {
            echo("existe");
            header("HTTP/1.0 400 Ya existe este usuario");
        }       
    }

  }
	
   
   


