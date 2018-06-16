$(function(){
	var url_base=$("meta[name='base_url']").attr("content");
	$.datetimepicker.setLocale('es'); //lenguaje español para los calendarios
    
  $('.calendario').datetimepicker({ //configuracion de los calendarios
  	format:'Y-m-d',
  	timepicker:false,	
  });

  $('.btnreport').on('click',function(){ // funcion para cargar la tabla uno en la vista
  	var valor=$('#exptipos_id').val();
    var fechai=$('#fechaini').val();
    var fechaf=$('#fechafin').val();
    var fechas=$('#fechas').val();
    var sub=$('#area').val();

    $.post(url_base+"reportes/reporteUno/"+valor, {'fechaini':fechai,'fechafin':fechaf,'fechas':fechas,'area':sub,'exptipos_id':valor})
    .done(function(result){
      $("#div-tabla").html(result);
    })
    .fail(function(err){
      console.log('malo '+err);
    });
  });

  
  $('.btnmostrar').on('click',function(){ // funcion para cargar la tabla uno en la vista
    var valor=$('#exptipos_id').val();
    var fechai=$('#fechaini').val();
    var fechaf=$('#fechafin').val();
    var fechas=$('#fechas').val();
    var sub=$('#area').val();

    var subs= '0';
    var del='1,8,10051';
    var ten="'S','N'";
    var cul="'S','N'";
    var vio="'S','N'";
    var mod="'1','2','3','4','5'";
    var sex="'F'";

    $.post(url_base+"reportes/reporteDosVista/0/0/"+subs+"/"+del+"/"+ten+"/"+cul+"/"+vio+"/"+mod+"/"+sex+"/"+valor, 
      {'fechaini':fechai,'fechafin':fechaf,'fechas':fechas,'area':sub,'exptipos_id':valor})
    .done(function(result){
      $("#div-tabla").html(result);
    })
    .fail(function(err){
      console.log('malo '+err);
    });
  });


  $(document).on("click", ".linkreport", function(){ // funcion para cargar el reporte dos en una nueva ventana
        var valor=$('#exptipos_id').val();
        var fechai=$('#fechaini').val();
        var fechaf=$('#fechafin').val();
        var fechas=$('#fechas').val();
        var sub=$('#area').val();

        var subs= $(this).data('sub');
        var del=$(this).data('del');
        var ten=$(this).data('ten');
        var cul=$(this).data('cul');
        var vio=$(this).data('vio');
        var mod=$(this).data('mod');
        var sex=$(this).data('sex');

        $.post(url_base+"reportes/reporteDosVista/1/0/"+subs+"/"+del+"/"+ten+"/"+cul+"/"+vio+"/"+mod+"/"+sex+"/"+valor, 
          {'fechaini':fechai,'fechafin':fechaf,'fechas':fechas,'area':sub, 'exptipos_id':valor})
        .done(function(result){
          var pagina= window.open();
          pagina.document.write(result);
        })
      .fail(function(err){
        console.log('malo '+err);
      });
  });


  $(document).on("click", ".linkreportReg", function(){ // funcion para cargar el reporte dos en una nueva ventana
        var valor=$('#exptipos_id').val();
        var fechai=$('#fechaini').val();
        var fechaf=$('#fechafin').val();
        var fechas=$('#fechas').val();
        

        var subs= $(this).data('sub');
        var del=$(this).data('del');
        var ten=$(this).data('ten');
        var cul=$(this).data('cul');
        var vio=$(this).data('vio');
        var mod=$(this).data('mod');
        var sex=$(this).data('sex');

        $.post(url_base+"reportes/reporteDosVista/1/1/"+subs+"/"+del+"/"+ten+"/"+cul+"/"+vio+"/"+mod+"/"+sex+"/"+valor, 
          {'fechaini':fechai,'fechafin':fechaf,'fechas':fechas,'exptipos_id':valor})
        .done(function(result){
          var pagina= window.open();
          pagina.document.write(result);
        })
      .fail(function(err){
        console.log('malo '+err);
      });
  });
  

  $('.btnreporteregiones').on('click',function(){ // funcion para cargar la tabla uno en la vista
    var valor=$('#exptipos_id').val();
    var fechai=$('#fechaini').val();
    var fechaf=$('#fechafin').val();
    var fechas=$('#fechas').val();
    var sub=$('#area').val();

    $.post(url_base+"reportes/reporteRegiones/"+valor, {'fechaini':fechai,'fechafin':fechaf,'fechas':fechas,'area':sub})
    .done(function(result){
      $("#div-tabla").html(result);
    })
    .fail(function(err){
      console.log('malo '+err);
    });
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


