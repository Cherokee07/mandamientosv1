$(document).ready(function() {

	if($('#tabla_usuarios').length>0){
		$('#tabla_usuarios').DataTable( { //para que la tabla funcione y su lenguaje en español
	        "language": {
	            "lengthMenu": "Mostrar _MENU_ registros",
	            "zeroRecords": "No hay resultados",
	            "info": "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
	            "infoEmpty": "No hay registros disponibles",
	            "infoFiltered": "(Filtrando _MAX_  del total de registros)",
	            "search":         "Buscar: ",
			    "paginate": {
			        "first":      "Primero",
			        "last":       "Ultimo",
			        "next":       "Siguiente",
			        "previous":   "Anterior"
			    },
	        }
	    } );
	}
    
    $(function(){
      $('.form').validator();
    });

     if($(".select2d").length>0){
     	$(".select2d").select2({
		    language: "es"
		});
     }
    
     verificarLista();
    $('#listagen').on('change',function(){ // ocultar todo si tiene todos los permisos
      verificarLista();
    });


    verificarAcceso();
    $('#acceso').on('change',function(){//ocultar agencias si tiene todas las siglas
      verificarAcceso();
      comprobarvacio(); 
    });

    function verificarLista(){
    	if( $('#listagen').val()=="T"){
        $('.div-agencias').hide('fast');
      }else{
        $('.div-agencias').show('fast');
      }
    }

    function verificarAcceso(){
    	if( $('#acceso').val()!="S"){
        	$('.capcon').show('fast');
		}else{
			$('.capcon').hide('fast');
		}
    }

    $('#botontodo').on('click',function(){ // al intentar hacer el submit
    	comprobarvacio(); 
    });

   
    	
    
    comprobarvacio();
    function comprobarvacio(){// checa que por cada opcion elegida los campos requeridos se cumplan
    	$('.errores').empty();
    	if($('#acceso').val()!="S"){
 			$('.errores').append('<label class="text-maroon">*El usuario debe contar con mesas para visualizar y con grupo de agencias para recibir</label><br>');
    	}

    	if($('#acceso').val()=="A"){
    		$('.errores').append('<label class="text-red">El usuario debe contar con Agencias para su consulta y captura</label><br>');
    		
    	}

    	if($('#acceso').val()=="M"){
    		$('.errores').append('<label class="text-red">El usuario debe contar con mesas para su consulta</label><br>');
    	}

    	
    }

    
 $('[data-toggle="popover"]').popover();
    
   
  });

function cerrarPop(event){
    var elemento= event.target;
    var id=elemento.attributes['data-id'].value;
    var nom=elemento.attributes['data-name'].value;
    $(".quitar-"+nom+"-"+id).click();
};

function eliminar(event){
    var elemento=event.currentTarget;
    var id=elemento.id;
    var url_base=$("meta[name='base_url']").attr("content");
    var name=elemento.attributes['data-name'].value;
    var url="";
    switch(name){
    	case 'gpoa':
    		url="usersgpoagencias/eliminargrupo";
    		break;
    	case 'gpom':
    		url="usersgrupostipos/eliminargrupo";
    		break;
    	case 'm':
    		url="usersmesas/eliminarmesa";
    		break;
    	case 'a':
    		url="usersagencias/eliminaragencia";
    		break;
    	case 's':
    		url="usersubprocuradurias/eliminarsub";
    		break;
    	default:
    		url="";
    		break;
    }

    if(url!=""){
    	$.post(url_base+url, {'id':id})
	    .done(function(result){
	    	var boton= document.querySelector(".quitar-"+name+"-"+id)  	
	    	boton.setAttribute('data-widget',"remove");
	    	boton.click();
	    })
	    .fail(function(err){
	      console.log('malo '+err);
	    });
    }

    
}