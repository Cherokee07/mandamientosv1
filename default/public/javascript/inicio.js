$(function(){
     $('[data-toggle="popover"]').popover();

     
});

function cerrarPop(event){
    var elemento= event.target;
    var id=elemento.attributes['data-id'].value;
    $(".quitar-"+id).click();
};

function eliminarDen(event){
    var elemento=event.currentTarget;
    var id=elemento.id;
    var url_base=$("meta[name='base_url']").attr("content");

    $.post(url_base+"expedientestemp/eliminarTemporal/"+id)
    .done(function(result){
      $('#row-'+id).remove();
    })
    .fail(function(err){
      console.log('malo '+err);
    });
}
