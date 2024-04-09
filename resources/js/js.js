$(document).ready(function(){
  $('#selectHora1').on('change', function() {
    if ($(this).val() === 'FECHADO') {
        $('#selectHora2').val('FECHADO');
    }
  });
  $('#selectHora2').on('change', function() {
    if ($(this).val() === 'FECHADO') {
        $('#selectHora1').val('FECHADO');
    }
  });
  $('#selectHora3').on('change', function() {
    if ($(this).val() === 'FECHADO') {
        $('#selectHora4').val('FECHADO');
    }
  });
  $('#selectHora4').on('change', function() {
    if ($(this).val() === 'FECHADO') {
        $('#selectHora3').val('FECHADO');
    }
  });

  $('#selectHora2').on('change', function() {
    var value2 = $('#selectHora2').val();
    var value1 = $('#selectHora1').val();
    
    if (value2 < value1) {
      var text = "<p>Selecione um horário válido!</p>";
      $('#aviso').empty(); 
      $('#aviso').append(text);
      $('#aviso').addClass('mostrar');

      setTimeout(function() {
        $('#aviso').removeClass('mostrar');
      }, 5000);
    } else {
      var text = "<p>Horário válido!</p>";
      $('#avisoSucesso').empty(); 
      $('#avisoSucesso').append(text);
      $('#avisoSucesso').addClass('mostrarSucesso');

      setTimeout(function() {
        $('#avisoSucesso').removeClass('mostrarSucesso');
      }, 5000);
    }
  });
  
  $('#selectHora4').on('change', function() {
    var value2 = $('#selectHora4').val();
    var value1 = $('#selectHora3').val();
    
    if (value2 < value1) {
      var text = "<p>Selecione um horário válido!</p>";
      $('#aviso').empty(); 
      $('#aviso').append(text);
      $('#aviso').addClass('mostrar');

      setTimeout(function() {
        $('#aviso').removeClass('mostrar');
      }, 5000);
    } else {
      var text = "<p>Horário válido!</p>";
      $('#avisoSucesso').empty(); 
      $('#avisoSucesso').append(text);
      $('#avisoSucesso').addClass('mostrarSucesso');

      setTimeout(function() {
        $('#avisoSucesso').removeClass('mostrarSucesso');
      }, 5000);
    }
  });
  
  
  $('tr td .td').on('click' , function() {
    var dataInput = $('#dataMarcada').val();
  
    var horarioId = $(this).attr('id');
    
    var horario = horarioId.split('-')[1] + ':' + horarioId.split('-')[2];

    var celula = $('#' + horarioId);


    $('body.admin .container-popup').toggleClass('active');
    $('body.admin .conteudo').toggleClass('back');
    
  });
  $('.close').on('click' , function() {
    $('body.admin .container-popup').toggleClass('active');
    $('body.admin .conteudo').toggleClass('back');
  });
  if ($('form.form_ajax').length) {
    if (!jQuery().ajaxForm)
      return;
    $('form.form_ajax').on("submit", function(e) {
      e.preventDefault();
      var form = $(this);
      var alerta = form.children('.alerta');
      form.ajaxSubmit({
        dataType:'json'
        ,success: function(response) {
          if (response.msg){
            alerta.html(response.msg);
          }
          if (response.status != '0') {
            alerta.addClass('sucesso');
          } else {
            alerta.addClass('erro');
          }
          if (response.redirecionar_pagina){
            window.location = response.redirecionar_pagina;
          }
          if (response.resetar_form){
            form[0].reset();
          }
          setTimeout(
            function(){ 
              alerta.html("");
              alerta.removeClass('sucesso');
              alerta.removeClass('erro');
            }, 
          4000);
        }
      });
      return false;
    });
  }




  $('input[name="excluir_imagem_principal"]').on('click' , function() {

    if($(this).is(':checked')){

        $('input[name="imagem_principal"]').attr('required', 'required');
    } else{
      $('input[name="imagem_principal"]').attr('required', false);
    }
  });


  $('input[name="excluir_foto_usuario"]').on('click' , function() {

    if($(this).is(':checked')){

        $('input[name="foto_usuario"]').attr('required', 'required');
    } else{
      $('input[name="foto_usuario"]').attr('required', false);
    }
  });
  $('input[name="excluir_logo_site"]').on('click' , function() {

    if($(this).is(':checked')){

        $('input[name="logo_site"]').attr('required', 'required');
    } else{
      $('input[name="logo_site"]').attr('required', false);
    }
  });

});


