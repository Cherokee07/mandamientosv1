<?php

/**
 * @author 
 * @copyright 2013
 */
class Giros extends ActiveRecord{
    protected $database = 'catlegajos';


  public function initialize(){
	$this->has_many('ofendidos');
  }  

	public function listar(){		
		return $this->find(); 
	}
}

?>