$(function(){
  $('#form-den').validator();
  var mostrar=false; // mostrar la lista de victimas para relacionar con parentesco
    $('#addParentesco').on('click', function(){
        if(mostrar){
            $('#parentescosdiv').hide('fast');
            mostrar=false;
        }else{
           $('#parentescosdiv').show('fast');
           mostrar=true; 
        }
    });
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

    $.post(url_base+"denunciantes/eliminarDenunciante", {'idden':id})
    .done(function(result){
      $('#row-'+id).remove();
    })
    .fail(function(err){
      console.log('malo '+err);
    });
  }
  