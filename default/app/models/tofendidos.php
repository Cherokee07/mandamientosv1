<?php

/**
 * @author 
 * @copyright 2013
 */
class Tofendidos extends ActiveRecord{
    public function initialize(){
	   $this->database = 'catlegajos';
    }

	public function listar(){
		return $this->find();
	}
}

?>