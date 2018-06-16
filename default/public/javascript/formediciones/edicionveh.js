$(document).ready(function() {
var url_base=$("meta[name='base_url']").attr("content");
$('#form-veh').validator();

llenarversiones();
$('.selectmarca').on('change',function(){
	llenarversiones();
});

function llenarversiones(){// funcion para llenar el select de versiones de vehiculos 
	$('#selectver').empty();
	var idam=$('#selectver').attr('data-id');
	var marca=$('.selectmarca').val();

	if(marca!=''){
		$('#selectver').removeAttr('disabled');
		$.post(url_base+"vervehiculos/listaVersion", {'idm':marca})
        .done(function(result){
        	if(JSON.parse(result).length>0){
	         $.each(JSON.parse(result), function(k, v) {
				var opcion=$('<option/>').val(v.idver).text(v.version).appendTo($('#selectver'));
				if(idam!=""){
				if(opcion.val()==idam){
					opcion.attr('selected', 'true'); //seleccionar el que ya tiene
				}
			}
			});
	     	}else{
	     		$('#selectver').attr('disabled','true');
	     	}
        })
        .fail(function(err){
          console.log('malo '+err);
        });

	}else{
		$('#selectver').attr('disabled','true');
	}

}
mostrarnombre();
$('#propietarios').on('change', function(){
	mostrarnombre();
});

	function mostrarnombre(){  //funcion para mostrar un input para escibir un nombre
		if($('#propietarios').val()==3){
			$('.divnombres').hide('fast');
			$('.nombre').show('fast');
		}else{
			llenarnombres();
		}
	}

function llenarnombres(){ // funcion para llenar el select de nombres de propietarios
	$('.divnombres').show('fast');
	$('.nombre').hide('fast');
	$('#selectnombres').removeAttr('disabled');
	var idam=$('#selectnombres').attr('data-persona');
	$('#selectnombres').empty();
	var idexp=$('#selectnombres').attr('data-id');
		if($('#propietarios').val()=='4'){
			var opcion=$('<option/>').val('0').text('DESCONOCIDO').appendTo($('#selectnombres'));
			if(idam!=""){
				if(opcion.val()==idam){
					opcion.attr('selected', 'true'); //seleccionar el que ya tiene
				}
			}
		}
		if($('#propietarios').val()=='1'){ // se llena de ofendidos si es 1
			$.post(url_base+"ofendidos/listaOfendidos",{'idexp':idexp})
	        .done(function(result){
	        	if((result).length>0){
		         $.each((result), function(k, v) {
					var opcion=$('<option/>').val(v.idofen).text(v.nombre).appendTo($('#selectnombres'));
					if(idam!=""){
		    			if(opcion.val()==idam){
		    				opcion.attr('selected', 'true'); //seleccionar el que ya tiene
		    			}
		    		}
				});
		     	}else{
		     		$('#selectnombres').attr('disabled','true');
		     	}
	        })
	        .fail(function(err){
	          console.log('malo '+err);
	        });
		}

		if($('#propietarios').val()=='2'){ // se llena de imputados si es 2
			$.post(url_base+"indiciados/listaImputados", {'idexp':idexp})
	        .done(function(result){
	        	if((result).length>0){
		         $.each((result), function(k, v) {
					var opcion=$('<option/>').val(v.idindi).text(v.nombre).appendTo($('#selectnombres'));
					if(idam!=""){
		    			if(opcion.val()==idam){
		    				opcion.attr('selected', 'true'); //seleccionar el que ya tiene
		    			}
		    		}
				});
		     	}else{
		     		$('#selectnombres').attr('disabled','true');
		     	}
	        })
	        .fail(function(err){
	          console.log('malo '+err);
	        });
		}
}


 var options = {  //llena el input con los nombres de localidades
    	url: function(frase){ return  url_base+"localidades/nombresLocalidades?frase="+frase+"&format=json"} ,
    	getValue: function(element) {
      		return  element.name;
    	},
    	list: {
      		match: {
        	enabled: true
      		},
      		maxNumberOfElements:20,
      		onClickEvent: function(){
      			$('#localidadid').siblings('.help-block').text('');
        		var id=$('#localidadname').getSelectedItemData().idloc;
        		$('#localidadid').val(id);
        		
      		},
      		onKeyEnterEvent: function(){
      			$('#localidadid').siblings('.help-block').text('');
      			var id=$('#localidadname').getSelectedItemData().idloc;
        		$('#localidadid').val(id);
      		},
    	}
  	};

	$("#localidadname").easyAutocomplete(options, 'appendTo', '.eventInsForm');

	$("#localidadname").blur(function(event) {//Al pasar las localidades verifica que no se quede vacio despues 
		if($("#localidadname").val()==""){		//de elegir uno con el easycomplete
			$('#localidadid').val('');
			
		}else{
			if ($('#localidadid').val()=='') {
				$('#localidadid').parent().addClass('has-error has-danger');
				$('#localidadid').siblings('.help-block').text('seleccione una localidad valida');
			}else{
				$('#localidadid').siblings('.help-block').text('');
			}
		}
	});

	$("#localidadname").keypress(function(){
        	$('#localidadid').val('');
			
		
	});

	$('.calendario').on('blur', function(){ // mascara de fecha
     var texto=$(this).val();
        if(texto!='' && texto.length<=8){
          var anio=texto.substring(4,8);
          var mes=texto.substring(2,4);
          var dia=texto.substring(0,2);

          var fecha=dia+'-'+mes+'-'+anio;

          $(this).val(fecha);
        }

  });
    

});

function cerrarPop(event){
    var elemento= event.target;
    var id=elemento.attributes['data-id'].value;
    $(".quitar-"+id).click();
};

function eliminarV(event){
    var elemento=event.currentTarget;
    var id=elemento.id;
    var url_base=$("meta[name='base_url']").attr("content");

    $.post(url_base+"vehiculos/eliminarVehiculo", {'idv':id})
    .done(function(result){
      $('#row-'+id).remove();
    })
    .fail(function(err){
      console.log('malo '+err);
    });
}
