<?php
class Userpermisos extends ActiveRecord{
	protected $database = 'temporales';
    
    public function initialize(){
    	$this->belongs_to('usuarios');
    	$this->belongs_to('permisos');
    }
}