$(document).ready(function() {
	var url_base=$("meta[name='base_url']").attr("content");
	$('#form-bien').validator();

	mostrarnombre();
	$('#propietarios').on('change', function(){
		mostrarnombre();
	});

	function mostrarnombre(){  //funcion para mostrar un input para escibir un nombre
		if($('#propietarios').val()==4){
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
		if($('#propietarios').val()=='3'){
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

function eliminarB(event){
    var elemento=event.currentTarget;
    var id=elemento.id;
    var url_base=$("meta[name='base_url']").attr("content");

    $.post(url_base+"bienesasegurados/eliminarbien", {'idbien':id})
    .done(function(result){
      $('#row-'+id).remove();
    })
    .fail(function(err){
      console.log('malo '+err);
    });
}