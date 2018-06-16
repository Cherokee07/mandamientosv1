$(document).ready(function() {
    var url_base=$("meta[name='base_url']").attr("content"); // conseguimos el PUBLIC_PATH

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
        		var idmun=$('#localidadname').getSelectedItemData().idmun;
        		$('#localidadid').attr('data-id',idmun);
        		$('#localidadid').val(id);
        		llenarAgencias(idmun);
      		},
      		onKeyEnterEvent: function(){
      			$('#localidadid').siblings('.help-block').text('');
      			var id=$('#localidadname').getSelectedItemData().idloc;
        		var idmun=$('#localidadname').getSelectedItemData().idmun;
        		$('#localidadid').attr('data-id',idmun);
        		$('#localidadid').val(id);
        		llenarAgencias(idmun);
      		},
    	}
  	};

	$("#localidadname").easyAutocomplete(options, 'appendTo', '.eventInsForm');

	$("#localidadname").blur(function(event) {//Al pasar las localidades verifica que no se quede vacio despues 
		if($("#localidadname").val()==""){		//de elegir uno con el easycomplete
			$('#localidadid').attr('data-id','');
        	$('#localidadid').val('');
			$('.agenciasmun').empty();
			$('#localidadid').siblings('.help-block').text('');
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
			$('#localidadid').attr('data-id','');
        	$('#localidadid').val('');
			$('.agenciasmun').empty();
		
	});



	$('.selectipo').on('change',function(event) { // funcion para llenar las mesas de acuerdo al tipo
		$('#selectmesa').empty();
		var idt= $('.selectipo').val();
		var idm=$('#selectmesa').attr('data-id');
		llenarSelect(idt,idm);
	});
	verificarMesa();
	verificarAgencia();
	function verificarMesa(){// funciona para que se llene el select de mesa al cargar la pagina
		if($('.selectipo').val()!=0){
			var idt= $('.selectipo').val();
			var idm=$('#selectmesa').attr('data-id');
			llenarSelect(idt,idm);
		}
	}

	function verificarAgencia(){// funciona para que se llene el select de agencia al cargar la pagina
		if($('#localidadid').val()!=0){
			var idl= $('#localidadid').attr('data-id');
			llenarAgencias(idl);
		}
	}

	function llenarSelect(id,idm){ //funcion para llenar el select de mesas 
		$.get(url_base+'mesas/getMesasTipo',{idtipo:id}).done(function(result){
			
			if(JSON.parse(result).length > 0){ //comprobar si el arreglo viene vacio o no para deshabilitarlo
				$('#selectmesa').removeAttr('disabled');
				$.each(JSON.parse(result), function(k, v) {
	        		var opcion=$('<option/>').val(v.idmesa).text(v.mesa).appendTo($('#selectmesa'));
	        		if(idm!=""){
	        			if(opcion.val()==idm){
	        				opcion.attr('selected', 'true'); //seleccionar el que ya tiene
	        			}
	        		}
	      		});  
	      	}else{
	      		$('#selectmesa').attr('disabled', 'disabled');
	      	}
		}).fail(function(err){
			
		}); 
	}

	function llenarAgencias(idL){ //funcion para llenar las agencias mun
		$('.agenciasmun').empty();
		var idam=$('.agenciasmun').attr('data-id');
		$.get(url_base+'amunicipales/getAgenciasMun',{idmun:idL}).done(function(result){
			/*var opcion1=$('<option/>').text("NO APLICA").appendTo($('.agenciasmun'));*/
			$.each(JSON.parse(result), function(k, v) {
				var opcion=$('<option/>').val(v.idagen).text(v.agencia).appendTo($('.agenciasmun'));
				if(idam!=""){
        			if(opcion.val()==idam){
        				opcion.attr('selected', 'true'); //seleccionar el que ya tiene
        			}
        		}
			}); 
		}).fail(function(err){
			alert('error');
		});    
	}
	var options1 = {  //llena el input con los nombres de localidades en el formulario 
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
      			$('#idlocalextra').siblings('.help-block').text('');
        		var id=$('#localidadextra').getSelectedItemData().idloc;
        		$('#idlocalextra').val(id);
      		},
      		onKeyEnterEvent: function(){
      			$('#idlocalextra').siblings('.help-block').text('');
      			var id=$('#localidadextra').getSelectedItemData().idloc;
        		$('#idlocalextra').val(id);
        		
      		},
    	}
  	};

	$("#localidadextra").easyAutocomplete(options1, 'appendTo', '.eventInsForm');

	$("#localidadextra").blur(function(event) {//Al pasar las localidades extras verifica que no se quede vacio despues 
		if($("#localidadextra").val()==""){		//de elegir uno con el easycomplete
        	$('#idlocalextra').val('');
			$('#idlocalextra').siblings('.help-block').text('');
		}else{
			if ($('#idlocalextra').val()=='') {
				$('#idlocalextra').parent().addClass('has-error has-danger');
				$('#idlocalextra').siblings('.help-block').text('seleccione una localidad valida');
			}else{
				$('#idlocalextra').siblings('.help-block').text('');
			}
		}
	});

	$(".localidadextra").keypress(function(){
        $('#idlocalextra').val('');
	});


	$('#form-exp').validator();//para aplicar la validacion de formularios


	$('.selectnarco').on('change', function(){ //para el formulario de narcoticos para el select de presentacion
		if($('.selectnarco').val()!=6){

			$('.selectpres').attr('disabled','true');
		}else{
			$('.selectpres').removeAttr('disabled');
		}
		$('.selectpres').val('');
	});

});