<?php 

class Extras {
  /**
  *Retorna un array de objetos cuyos campos son los mismos de la tabla Marca
  *$page : es el número o indice de la página
  *$$ppage : es el número de filas o registro de la página
  **/
	public function obtenerIp() {
		$ip = ""; 
		if(isset($_SERVER)) { 
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
				$ip=$_SERVER['HTTP_CLIENT_IP']; 
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip=$_SERVER['HTTP_X_FORWARDED_FOR']; 
			} else { $ip=$_SERVER['REMOTE_ADDR']; 
			}
		} else {
			if ( getenv( 'HTTP_CLIENT_IP' ) ) { 
				$ip = getenv( 'HTTP_CLIENT_IP' ); 
			} elseif ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) { 
				$ip = getenv( 'HTTP_X_FORWARDED_FOR' ); 
			} else { $ip = getenv( 'REMOTE_ADDR' ); 
			}
		}
		// En algunos casos muy raros la ip es devuelta repetida dos veces separada por coma 
		if(strstr($ip,',')) { 
			$ip = array_shift(explode(',',$ip)); 
		} 
		return $ip; 
	} 
}
?>