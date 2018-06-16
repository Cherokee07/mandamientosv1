$(document).ready(function() {
  $('#form-inv').validator();//para aplicar la validacion de formularios

  

 
});

function cerrarPop(event){ //funcion para cerrar el pop que se activa al querer eliminar
    var elemento= event.target;
    var id=elemento.attributes['data-id'].value;
    $(".quitar-"+id).click();
};

function eliminar(event){ //eliminar todo los delitos
    var url_base=$("meta[name='base_url']").attr("content");
    var elemento=event.currentTarget;
    var id=elemento.id;
   
    $.post(url_base+"involucrados/eliminarInvolucrado", {'idinv':id,})
    .done(function(result){
      $('#row-'+id).remove();
     
    })
    .fail(function(err){
      console.log('malo '+err);
    });
} 




 