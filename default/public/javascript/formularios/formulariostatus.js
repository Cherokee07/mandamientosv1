$(document).ready(function() {
    var url_base=$("meta[name='base_url']").attr("content"); // conseguimos el PUBLIC_PATH


    $('.selectgen').on('change',function(event) { // funcion para llenar el primer nivel
		$('#botonenviar').hide();// esconde el boton d enviar
		$('#selectespe1').empty(); //vacia el select por si existian ya option
		var idt= $('.selectgen').val(); // guarda el valor seleccionado
		llenarSelect2(idt,'getespecificos1','#selectespe1');
    	$('.selectnivel1').show('fast'); // muestra solo el select inferior
    	$('.selectnivel2').hide('fast');// esconde todos los demas en caso de que se  mostraron
    	$('.selectnivel3').hide('fast');
    	$('.selectnivel4').hide('fast');
    	$('.selectnivel5').hide('fast');
    	$('.selectnivel6').hide('fast');
        $('#labelerror').hide('fast'); // esconde el error en caso de ser mostrado
		$('#nivel').val('0'); // le asigna un valor al imputr oculto correspondiente al nivel

	});


	$('#selectespe1').on('change',function(event) { // funcion para llenar el 2 nivel
		$('#botonenviar').hide();
		$('#selectespe2').empty();
    	var idt= $('#selectespe1').val();
    	llenarSelect2(idt,'getespecificos2','#selectespe2');
    	$('.selectnivel2').hide('fast');  	
    	$('.selectnivel3').hide('fast');
    	$('.selectnivel4').hide('fast');
    	$('.selectnivel5').hide('fast');
    	$('.selectnivel6').hide('fast');
        $('#labelerror').hide('fast');
		$('#nivel').val('1');

	});

	$('#selectespe2').on('change',function(event) { // funcion para llenar el 3 nivel
		$('#botonenviar').hide();
		$('#selectespe3').empty();
    	var idt= $('#selectespe2').val();
        llenarSelect2(idt,'getespecificos3','#selectespe3');
        $('.selectnivel3').hide('fast');  
    	$('.selectnivel4').hide('fast');
    	$('.selectnivel5').hide('fast');
    	$('.selectnivel6').hide('fast');
		$('#labelerror').hide('fast');
		$('#nivel').val('2');

	});

	$('#selectespe3').on('change',function(event) { // funcion para llenar el 4 nivel
		$('#botonenviar').hide();
		$('#selectespe4').empty();
    	var idt= $('#selectespe3').val();
    	llenarSelect2(idt,'getespecificos4','#selectespe4');
        $('.selectnivel4').hide('fast');
    	$('.selectnivel5').hide('fast');
    	$('.selectnivel6').hide('fast');
		$('#labelerror').hide('fast');
		$('#nivel').val('3');
	
	});
	$('#selectespe4').on('change',function(event) { // funcion para llenar el 5 nivel
    	$('#botonenviar').hide();
    	$('#selectespe5').empty();
    	var idt= $('#selectespe4').val();
    	llenarSelect2(idt,'getespecificos5','#selectespe5');
    	$('.selectnivel5').hide('fast');
    	$('.selectnivel6').hide('fast');
		$('#nivel').val('4');
		$('#labelerror').hide('fast');
	
		
	});
	$('#selectespe5').on('change',function(event) { // funcion para llenar el 6 nivel
    	$('#botonenviar').hide();
    	$('#selectespe6').empty();
		var idt= $('#selectespe5').val();
		llenarSelect2(idt,'getespecificos6','#selectespe6');
		$('.selectnivel6').hide('fast');
		$('#nivel').val('5');
		$('#labelerror').hide('fast');
		
	});
	$('#selectespe6').on('change',function(event) { // funcion para llenar el 6 nivel
		$('#nivel').val('6');
		$('#labelerror').hide('fast');
		$('#botonenviar').show();
	});

    function llenarSelect2(id,metodo,elemento){ //funcion para llenar el select de mesas 
		$.get(url_base+'estgenerales/'+metodo,{idtipo:id}).done(function(result){	
			if(result.length > 0){ //comprobar si el arreglo viene vacio o no para deshabilitarlo
				$(elemento).removeAttr('disabled');
				var opcion1=$('<option/>').val('').text('SELECCIONE').appendTo($(elemento));
				$.each(result, function(k, v) {
	        		var opcion=$('<option/>').val(v.idestado).text(v.estado).appendTo($(elemento));
	      		}); 
	      		$(elemento).parent().show(); 
	      		$('#labelerror').show('fast');
	      	}else{
	      		$(elemento).attr('disabled', 'disabled');
	      		$('#botonenviar').show();
	      	}
		}).fail(function(err){
			
		}); 
	}


	$('#form-status').validator();

	

});
	
function cerrarPop(event){
    var elemento= event.target;
    var id=elemento.attributes['data-id'].value;
    $(".quitar-"+id).click();
};

function eliminar(event){
    var elemento=event.currentTarget;
    var id=elemento.id;
    var url_base=$("meta[name='base_url']").attr("content");

    $.post(url_base+"expedientes/eliminarestado", {'idstatus':id})
    .done(function(result){
      $('#row-'+id).remove();
    })
    .fail(function(err){
      console.log('malo '+err);
    });
}