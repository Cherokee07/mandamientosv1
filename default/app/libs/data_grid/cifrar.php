<?php

class Cifrar {
	 const CLAVE = '3st4tus';
	public static function todo($texto){
		$clave=self::CLAVE;
		$resultado='';
		for($i=0;$i<strlen($texto);$i++){

			$caracter=substr($texto, $i,1);
			$caracterClave=substr($clave, ($i%strlen($clave))-1,1);
			$caracter=chr(ord($caracter)+ord($caracterClave));
			$resultado.=$caracter;

		}

		return base64_encode($resultado);
	}
	public static function undo($texto){
		$clave=self::CLAVE;
		$resultado='';
		$texto=base64_decode($texto);
		for($i=0;$i<strlen($texto);$i++){

			$caracter=substr($texto, $i,1);
			$caracterClave=substr($clave, ($i%strlen($clave))-1,1);
			$caracter=chr(ord($caracter)-ord($caracterClave));
			$resultado.=$caracter;
		}

		return $resultado;
	}
}
