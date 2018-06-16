<?php 
class Motivosoa extends ActiveRecord
{
  protected $database = 'catalogosgral';
  
  public function initialize(){
  $this->has_many('indiciados');
  }  


  
 // public function listar($edosid = 0){
   // return $this->find("conditions: estadosoa_id = ".$edosid,"order: 2 asc");
  //}
  public function listar2(){
    return $this->find("order: 2 asc");
  }  
     
}
?>