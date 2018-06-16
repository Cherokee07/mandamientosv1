<?php
Load::models('juzgados');
Load::models('ordenes');
class IndexController extends AppController
{

	
	public function index(){

    $this->ordenes=Load::model('ordenes')->find();
    View::template('templatemenus');
    $orden= new Ordenes();
		}


  }