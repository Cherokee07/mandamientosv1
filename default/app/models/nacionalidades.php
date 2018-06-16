<?php

/**
 * @author 
 * @copyright 2013
 */
class Nacionalidades extends ActiveRecord{
    protected $database = 'catalogosgral';
	
	public function initialize(){
	   $this->has_many('ofendidos');
	   $this->has_many('indiciados');
    }    	

	public function listar(){
		return $this->find();
	}
}

?>