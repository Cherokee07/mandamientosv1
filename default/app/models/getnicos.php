<?php

/**
 * @author 
 * @copyright 2013
 */
class Getnicos extends ActiveRecord{
    protected $database = 'catlegajos';

	public function listar(){
		return $this->find();
	}
}

?>