$(document).ready(function(){
  $('#gestor').on('click', function(){
    if($('#gestor').val() === '1'){
      $('#gestor').val('2');
    } else{
      $('#gestor').val('1');
    }
  });




  $('.itemAgend').on('click', '#CancelarHorario', function() {
      var cancel = $(this).val();
      $('#btn' + cancel).css('display', 'none');
      $('#Cancel' + cancel).css('display', 'flex');
});

$('.itemAgend').on('click', '#confirmarCancelar', function() {
    var cancel = $(this).val();
    $('#btn' + cancel).css('display', 'flex');
    $('#Cancel' + cancel).css('display', 'none');   
});
  var dataAtual = new Date();
  var ano = dataAtual.getFullYear();
  var mes = ('0' + (dataAtual.getMonth() + 1)).slice(-2); 
  var dia = ('0' + dataAtual.getDate()).slice(-2); 
  var dataFormatada = ano + '-' + mes + '-' + dia;
  $('#campoData1').val(dataFormatada);

  $('#dinheiro-edit').on('change', function() {
    var value1 = $('#dinheiro-edit').val();
  
    
    if (value1 === '0') {
      var text = "<p>Selecione um valor válido!  ex: 0.00</p>";
      $('#aviso').empty(); 
      $('#aviso').append(text);
      $('#aviso').addClass('mostrar');

      setTimeout(function() {
        $('#aviso').removeClass('mostrar');
      }, 5000);
    } 
  });
  $('#pix-edit').on('change', function() {
    var value1 = $('#pix-edit').val();
  
    
    if (value1 === '0') {
      var text = "<p>Selecione um valor válido!  ex: 0.00</p>";
      $('#aviso').empty(); 
      $('#aviso').append(text);
      $('#aviso').addClass('mostrar');

      setTimeout(function() {
        $('#aviso').removeClass('mostrar');
      }, 5000);
    } 
  }); $('#cartao-edit').on('change', function() {
    var value1 = $('#cartao-edit').val();
  
    
    if (value1 === '0') {
      var text = "<p>Selecione um valor válido!  ex: 0.00</p>";
      $('#aviso').empty(); 
      $('#aviso').append(text);
      $('#aviso').addClass('mostrar');

      setTimeout(function() {
        $('#aviso').removeClass('mostrar');
      }, 5000);
    } 
  });


  $('#tabelaHorarios').on('click', '.td', function() {
    var idHorarioClicado = $(this).attr('id');
    var dataInput = $('#dataMarcada').val();
  
    var valorSelecionado = idHorarioClicado.split('-')[1] + ':' + idHorarioClicado.split('-')[2];

    $('#data1').val(dataInput);
    $('#data').val(dataInput);
    $('#data').attr('disabled', 'disabled');

    $('#data2').val(dataInput);
    $('#data01').val(dataInput);
    $('#data01').attr('disabled', 'disabled');


    var selectElement = $('#horariosDisponiveis');
   
    if (selectElement.find('option[value="' + valorSelecionado + '"]').length === 0) {
        var novaOpcao = $('<option></option>').attr('value', valorSelecionado).text(valorSelecionado);
        selectElement.append(novaOpcao);
    }
    
    selectElement.val(valorSelecionado);


    var selectElements = $('#horariosDisponivel');
   
    if (selectElements.find('option[value="' + valorSelecionado + '"]').length === 0) {
        var novaOpcao = $('<option></option>').attr('value', valorSelecionado).text(valorSelecionado);
        selectElements.append(novaOpcao);
    }
    
    selectElements.val(valorSelecionado);
    
    var idBarber = $('#idBarbeiro').val();
    $('#selectBarbeiro').val(idBarber);
                 
    var idBarbeiro = $('#idBarbeiro').val();
    $('#selectBarbeiro1').val(idBarbeiro);

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
      var aviso = $('#aviso');
  
      form.ajaxSubmit({
        dataType:'json'
        ,success: function(response) {
          if (response.msg){
            alerta.html(response.msg);
            aviso.html(response.msg);
          }
          if (response.status != '0') {
            alerta.addClass('sucesso alert alert-success');
            $('#aviso').addClass('mostrar'); 
            $('#avisoSucesso').addClass('mostrarSucesso');
          } else {
            alerta.addClass('erro alert alert-danger');
            aviso.removeClass('sucesso').addClass('erro');
            $('#aviso').addClass('mostrar'); 
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
              alerta.removeClass('sucesso alert alert-success');
              alerta.removeClass('erro alert alert-danger');

              aviso.html("");
              aviso.removeClass('sucesso erro');
              $('#aviso').removeClass('mostrar');
              $('#avisoSucesso').removeClass('mostrarSucesso');
            }, 
          4000);
        }
      });
      return false;
    });
  }
  $('#btn-agendar').on('click' , function(){
      $('.agenda-top .formA').toggleClass('active');
      $('body.admin .conteudo').addClass('back');
  });
  $('#btn-bloquear').on('click' , function(){
    $('.agenda-top .formB').toggleClass('activeBloquear');
    $('body.admin .conteudo').addClass('back');
  });

  $('.close').on('click' , function() {
    $('body.admin .container-popup').toggleClass('active');
    $('body.admin .conteudo').toggleClass('back');
  });
  $('.close-formA').on('click' , function() {
    $('.agenda-top .formA').toggleClass('active');
    $('body.admin .container-popup').toggleClass('active');
    $('body.admin .conteudo').toggleClass('back')
    var selectElement = $('#horariosDisponiveis');
    selectElement.empty();
  });

  $('.close-formB').on('click' , function() {
    $('.agenda-top .formB').toggleClass('activeBloquear');
    $('body.admin .container-popup').toggleClass('active');
    $('body.admin .conteudo').toggleClass('back')
    var selectElement = $('#horariosDisponivel');
    selectElement.empty();
  });
 


  $('#selectHora1').on('change', function() {
    if ($(this).val() === 'FECHADO') {
        $('#selectHora2').val('FECHADO');
    }
  });
  $('#selectHora  2').on('change', function() {
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


$('.banners .itens').slick({
  autoplay: true,
  autoplaySpeed: 5000,
  infinite: true,
  prevArrow:  '<button class="slick-prev"><i class="fa-solid fa-chevron-left"></.</button>',
  nextArrow:  '<button class="slick-next"><i class="fa-solid fa-chevron-right"></.</button>'
})
$('.servicos.slider .itens').slick({
  infinite: true,
  slidesToShow: 3,
  slidesToScroll: 1,
  arrows: false,
  dots: true,
  autoplay: true,
  autoplaySpeed: 3000,
  responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
  
    ]
});