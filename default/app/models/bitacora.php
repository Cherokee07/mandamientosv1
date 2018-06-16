<?php

/**
 * @author 
 * @copyright 2013
 */
class Bitacora extends ActiveRecord{
	protected $database = 'ordenes';


//metodo utilizado para registrar para cualquier movimiento que implique cambios registros y cambios importantes 

	public function registrarBitacora($movimiento, $descripcion, $expediente){
		$bitacora = new bitacora();
		$bitacora->movimiento = $movimiento;
		$bitacora->fecha = date('Y-m-d');
		$bitacora->hora = date('H:i:s');
		$bitacora->login = Session::get('login');
		$bitacora->usuarios_id = Session::get('id');
		$bitacora->subprocuradurias_id = Session::get('subprocuradurias_id');
		$bitacora->descripcion = $descripcion;
		$bitacora->expediente = $expediente!=""?$expediente->id:'';
		$bitacora->tipo = 50;
		$bitacora->ip = Load::model('extras')->obtenerIp();
		$bitacora->sistemas_id=2;
		$bitacora->save();
	}
}

?>