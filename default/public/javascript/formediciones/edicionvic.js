$(function(){
    var url_base=$("meta[name='base_url']").attr("content");
    $('#form-vic').validator();

    $('#tipovictima').on('change', function(event) { //para mostrar el resto del formulario o no
        if($('#tipovictima').val()==2){
            $('#form-nuevo').hide('fast');
            $('#nameofen').val('Q.Q.R.S.P');
            $('#apatofen').val('');
            $('#amatofen').val('');
            $('#nameofen').attr('readonly', 'true');
            $('#apatofen').attr('readonly', 'true');
            $('#amatofen').attr('readonly', 'true');
            $(".obligatorio" ).each(function(){
                $(this).removeAttr('required');
            });
        }else{
            $('#form-nuevo').show('fast');
            $('#nameofen').val('');
            $('#nameofen').removeAttr('readonly');
            $('#apatofen').removeAttr('readonly');
            $('#amatofen').removeAttr('readonly');
            $(".obligatorio" ).each(function(){
                $(this).attr('required','true');
            });
        }
    });

    $('#selectmenor').on('change',function(event) {//para mostrar el resto de rubros de si es menor
        mostrarmenor();
    });

    function mostrarmenor(){
       if($('#selectmenor').val()==1){
            $('.form-menor').show('fast');
            $('.selectrango').attr('required','true');
        }else{
             $('.form-menor').hide('fast');
             $('.selectrango').removeAttr('required');
        } 

    }

    mostrarmenor();
    mostrarocciso();
    $('#selectocciso').on('change',function(event) {//para mostrar el resto de rubros de si es occiso
        mostrarocciso();
    });

    function mostrarocciso(){
        if($('#selectocciso').val()==1){
            $('.form-occiso').show('fast');
            $('.certificado').attr('required','true');
            $('.causam').attr('required','true');
            $('.selecthomi').attr('required','true');
        }else{
            $('.form-occiso').hide('fast');
            $('.selecthomi').removeAttr('required');
            $('.causam').removeAttr('required');
            $('.certificado').removeAttr('required');
        }
    }

    
    mostrarotraorg();            // para mostrar el input de otra organizacion
    $('.catorg').on('change',function(){
        mostrarotraorg();
    });
    function mostrarotraorg(){
        if($('.catorg').val()==30){
            $('#otraorg').show('fast');
        }else{
            $('#otraorg').hide('fast');
        }
    }

    $('.add-name').on('click', function(event) { //mostrar el formulario  para agregar un nombre ficticio
        var li = event.target;
        var idofen= li.getAttribute('data-vic');
        var texto=$('.nombre-'+idofen).text();
        $('#victima').val(idofen);
        $('.name-ofen').text('');
        $('.name-ofen').text(texto);
        $('#namefic').val('');
        $('#apatfic').val('');
        $('#amatfic').val('');
        $('#inputedit').val('');
        $('#form-ficticio').show('fast');
    });

    $('.cancel-fic').on('click',function(event) { //ocultar el form de nombre ficticio
         $('#form-ficticio').hide('fast');
    });

    $('.editname').on('click', function(event) {//mostrar el formulario  para editar un nombre ficticio
        var item = event.target;
        var idofen= item.getAttribute('data-id');
        var idnom=item.getAttribute('data-name');
        var texto=$('.nombre-'+idofen).text();
        $('#victima').val(idofen);
        $('.name-ofen').text('');
        $('.name-ofen').text(texto);
        $('#inputedit').val(idnom);
        $('#form-ficticio').show('fast');

        $.get(url_base+"nomofens/getNombreFicticio", {idname:idnom})
        .done(function(result){
          $('#namefic').val(result[0].name);
          $('#apatfic').val(result[0].pat);
          $('#amatfic').val(result[0].mat);
          $('#form-ficticio').show('fast');
        })
        .fail(function(err){
          console.log('malo '+err);
        });

    });


    $('.selectentidad').on('change',function(){ // funcion para mostrar un nuevo campo si es extranjero
         var item = event.target.parentNode;
        if($('.selectentidad').val()=='33'){
            item.classList.remove('col-md-6');
            item.classList.add('col-md-3');
            $('.pais').show('fast');
        }else{
            item.classList.remove('col-md-3');
            item.classList.add('col-md-6');
            $('.pais').hide('fast');
        }
    });
    verExtrangero();
    function verExtrangero(){
        if($('#ofendidoreal_lugarnac').val()=='33'){
            var item=$('.selectentidad').parent();
           item.removeClass('col-md-6');
           item.addClass('col-md-3');
            $('.pais').show('fast');
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

    habilitarDrogas();
    $('#adiccion').on('change', function(){
        habilitarDrogas();
    });

    function habilitarDrogas(){
        if($('#adiccion').val()=="N"){
            $('#drogas').tagsinput('removeAll');
            $('#drogas').attr('disabled','true');
        }else{
            $('#drogas').removeAttr('disabled');
        }
    }

    habilitarDrogasres();
    $('#adiccionres').on('change', function(){
        habilitarDrogasres();
    });

    function habilitarDrogasres(){
        if($('#adiccionres').val()=="N"){
            $('#drogasres').tagsinput('removeAll');
            $('#drogasres').attr('disabled','true');
        }else{
            $('#drogasres').removeAttr('disabled');
        }
    }

    $("#drogas, #drogasres").tagsinput({
          trimValue: true
    });


});

function cerrarPop(event){ //funcion para cerrar el pop que se activa al querer eliminar
    var elemento= event.target;
    var id=elemento.attributes['data-id'].value;
    $(".quitar-"+id).click();
};

function eliminarDen(event){ //eliminar una victima y quitar de la tabla
    var elemento=event.currentTarget;
    var id=elemento.id;
    var url_base=$("meta[name='base_url']").attr("content");

    $.post(url_base+"ofendidos/eliminarOfendido", {'idofen':id})
    .done(function(result){
      //$('#row-'+id).remove();
      window.location.reload(); 
    })
    .fail(function(err){
      console.log('malo '+err);
    });
};

function cerrarPopN(event){ //funcion para cerrar el pop que se activa al querer eliminar
    var elemento= event.target;
    var id=elemento.attributes['data-id'].value;
    $(".eliminar-"+id).click();
};

function eliminarName(event){ //eliminar una victima y quitar de la tabla
    var elemento=event.currentTarget;
    var id=elemento.id;
    var url_base=$("meta[name='base_url']").attr("content");

    $.post(url_base+"nomofens/eliminarNombre", {'idname':id})
    .done(function(result){
      $('#lis-'+id).remove();
     
    })
    .fail(function(err){
      console.log('malo '+err);
    });
}  
  