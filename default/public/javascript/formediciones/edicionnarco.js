	function cerrarPop(event){
    var elemento= event.target;
    var id=elemento.attributes['data-id'].value;
    $(".quitar-"+id).click();
};

function eliminarDen(event){
    var elemento=event.currentTarget;
    var id=elemento.id;
    var url_base=$("meta[name='base_url']").attr("content");

    $.post(url_base+"narcoticos/eliminarNarcotico", {'idnar':id})
    .done(function(result){
      $('#row-'+id).remove();
    })
    .fail(function(err){
      console.log('malo '+err);
    });
}

$(document).ready(function() {

    hidepresentacion();
    $('.selectnarco').on('change', function(){ //para el formulario de narcoticos para el select de presentacion
		
        hidepresentacion();
         $('.selectpres').val('');
	});

    function hidepresentacion(){
        if($('.selectnarco').val()!=6){
            $('.selectpres').attr('disabled','true');
        }else{
            $('.selectpres').removeAttr('disabled');
        }
       
    }

    $('#form-narco').validator();//para aplicar la validacion de formularios
});
