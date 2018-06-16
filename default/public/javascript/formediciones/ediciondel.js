$(document).ready(function() {
  $('#form-del').validator();//para aplicar la validacion de formularios

  var url_base=$("meta[name='base_url']").attr("content"); // conseguimos el PUBLIC_PATH

    var options = {  //llena el input con los nombres de delitos
    	url: function(frase){ return  url_base+"delitos/nombresDelitos?frase="+frase+"&format=json"} ,
    	getValue: function(element) {
      		return  element.name;
    	},
    	list: {
      		match: {
        	enabled: true
      		},
      		maxNumberOfElements:20,
      		onClickEvent: function(){
             $('.botondel').removeAttr('disabled');
             $('#delitoid').siblings('.help-block').text('');
        		var id=$('#delitoname').getSelectedItemData().iddel;
            $('#delitoid').val(id);
        		elementoadicional(id);
      		},
      		onKeyEnterEvent: function(){
            $('.botondel').removeAttr('disabled');
             $('#delitoid').siblings('.help-block').text('');
      			var id=$('#delitoname').getSelectedItemData().iddel;
        		$('#delitoid').val(id);
            elementoadicional(id);
      		},
    	}
  	};

	 $("#delitoname").easyAutocomplete(options, 'appendTo', '.eventInsForm');
     $('.easy-autocomplete').css('width', '100%');
    
    $("#delitoname").blur(function(event) {//Al pasar el input de delitos verifica que no se quede vacio despues 
        if($("#delitoname").val()==""){    //de elegir uno con el easycomplete
            $('#delitoid').val(0);
            $('#div_elementos').hide('fast');
             $('#div_elementos').empty();
        }else{
          if ($('#delitoid').val()=='0') {
            $('#delitoid').parent().addClass('has-error has-danger');
            $('#delitoid').siblings('.help-block').text('seleccione un delito valido');
            $('.botondel').attr('disabled','true');
          }else{
            $('#delitoid').siblings('.help-block').text('');
          }
        }

    });

    $("#delitoname").keypress(function(){
      $('#delitoid').val(0);
      $('#div_elementos').hide('fast');
      $('#div_elementos').empty();
  });


    function elementoadicional(id){ //para inserttar el form con el nuevo rubro dependiendo del delito
      var datos_id=id;
      url=url_base+"ofeindis/elementos/" + datos_id;
      $('#div_elementos').show('fast');
      $("#div_elementos").load(url);

    }

    mostrarrestoform(); //  mostrar el resto del formulario despues de elegir victima e imputado
    $('#indiciados').on('blur',function(){
        mostrarrestoform();
    });
    $('#ofendidos').on('blur',function(){
        mostrarrestoform();
    });
    $('#ofendidos').on('change',function(){
        mostrarrestoform();
    });
    $('#indiciados').on('change',function(){
        mostrarrestoform();
    });

    function mostrarrestoform(){
      if($('#indiciados').val()!=null && $('#ofendidos').val()!=null ){
        $('#restoform').show('fast');
        $('.botones').show('fast');
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

function cerrarPop(event){ //funcion para cerrar el pop que se activa al querer eliminar
    var elemento= event.target;
    var id=elemento.attributes['data-id'].value;
    $(".quitar-"+id).click();
};

function eliminarTodo(event){ //eliminar todo los delitos
    var url_base=$("meta[name='base_url']").attr("content");
    var elemento=event.currentTarget;
    var idexp=elemento.id;
    var idofen=elemento.attributes['data-ofen'].value;
    var idindi=elemento.attributes['data-indi'].value;
    var del=elemento.attributes['data-del'].value;

    $.post(url_base+"ofeindis/eliminarTodo", {'idexp':idexp, 'ofen':idofen, 'indi':idindi})
    .done(function(result){
      $('#row-'+del).remove();
     
    })
    .fail(function(err){
      console.log('malo '+err);
    });
} 



function eliminarUno(event){ //eliminar un imputado y quitar de la tabla
    var elemento=event.currentTarget;
    var id=elemento.id;
    var url_base=$("meta[name='base_url']").attr("content");

    $.post(url_base+"ofeindis/eliminarUno", {'iddel':id})
    .done(function(result){
      //$('#lis-'+id).remove();
      window.location.reload();
    })
    .fail(function(err){
      console.log('malo '+err);
    });
};

function cerrarPopN(event){ //funcion para cerrar el pop de los delitos
    var elemento= event.target;
    var id=elemento.attributes['data-id'].value;
    $(".eliminar-"+id).click();
};

 