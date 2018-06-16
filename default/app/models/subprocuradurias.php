<?php

/**
 * @author 
 * @copyright 2013
 */
class Subprocuradurias extends ActiveRecord{

	protected $database = 'catalogosgral';
    public function initialize(){
	   //$this->database = 'catalogosgral';	   
    }

	public function listar(){
		return $this->find("order: 2");
	}
}
?>