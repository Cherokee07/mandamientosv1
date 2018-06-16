$(function(){
	var url_base=$("meta[name='base_url']").attr("content");
	$.datetimepicker.setLocale('es'); //lenguaje español para los calendarios
    
    $('.calendario').datetimepicker({ //configuracion de los calendarios
    	format:'d-m-Y',
    	timepicker:false,	
      
    });

    $('.reloj').datetimepicker({ // configuracion del reloj
		format:'H:i',
		datepicker:false,
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

    

     $('[data-toggle="popover"]').popover();
     $('[data-toggle="tooltip"]').tooltip(); 
    

    $('#botonfinal').on('click', function(){ // funcion para mostrar el modal 
        $('#myModal').modal('show');
        var idexp=$('#botonfinal').attr('data-id');
    	url=url_base+"expedientestemp/validarCampos/" + idexp; 
     	$("#div_campos").load(url);
    });

    $('#guardarexp').on('click',function(){
        var url=url_base; 
        $(location).attr('href',url);
    });

    $('.selectpicker').selectpicker({ //slect con buscador
        style: 'btn-flat selectpic',
    });

    

    pintarRequeridos();
    function pintarRequeridos(){  // funcion para marcar los campos requeridos
        $(".requerido").each(function(){
            if($(this).val()==''){
                $(this).css('border-color','#fb0b42');
            }
        });
    }

     $(".requerido").on('blur', function(){ // funcion para quitar la marca a los campos requeridos
        if($(this).val()!=''){
                $(this).css('border-color','#d2d6de');
            }
     });

     if ( $(".radio").length > 0 ) {
         pintarCheck();
    }

    function pintarCheck(){  //marcar el borde del check selecccinado
        $(".radio").each(function(){
           $(this).css('border','none');
        });
      var elemento=$('input:radio[name=opciones]:checked');
      var dive=elemento[0].parentNode.parentNode.parentNode;
      dive.style.border='solid';
      dive.style.borderColor='#2fa1b3';
    }

    $('.radio').on('change', function(){
         pintarCheck();
         if($(".inputsub").length > 0){ // compruebo si ya existe un input con el nombre de "inputsub"
             $('.inputsub').remove(); // si existe se elimina
          }
         if($(this).hasClass('radiosubm')){ // si el check que se selecciono es de submujeres
          var idsub=$(this).children().children().children('.subm').val(); // saco su value para agregarselo a un nuevo input
          $(this).append('<input type="hidden" value="'+idsub+'" name="submujeres" class="inputsub">');
          
         }
    });

  

    //setTimeout(function() {
    //    $(".info .flash").fadeOut(1500);
    //},2000);



});



function justNumbers(e){ //metodo para que el input solo acepte numeros 
	    var keynum = window.event ? window.event.keyCode : e.which;
	    if ((keynum == 8) || (keynum == 46))
	    return true;
	     
	    return /\d/.test(String.fromCharCode(keynum));
}


