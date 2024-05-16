$(document).ready(function(){
  $('#gestor').on('click', function(){
    if($('#gestor').val() === '1'){
      $('#gestor').val('2');
    } else{
      $('#gestor').val('1');
    }
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




  $('#dinheiro').change(function() {
   
    if ($(this).is(':checked')) {
        
        $('.dinheiro').css('display', 'block');
    } else {
        $('.dinheiro').css('display', 'none');
    }
  });

  $('#pix').change(function() {
   
    if ($(this).is(':checked')) {
        
        $('.pix').css('display', 'block');
    } else {
        $('.pix').css('display', 'none');
    }
  });

  $('#cartao').change(function() {
   
    if ($(this).is(':checked')) {
        
        $('.cartao').css('display', 'block');
    } else {
        $('.cartao').css('display', 'none');
    }
  });
  
  $('#tabelaHorarios').on('click', '.td', function() {
    var idHorarioClicado = $(this).attr('id');
    var dataInput = $('#dataMarcada').val();
  
    var valorSelecionado = idHorarioClicado.split('-')[1] + ':' + idHorarioClicado.split('-')[2];

    $('#data1').val(dataInput);
    $('#data').val(dataInput);
    $('#data').attr('disabled', 'disabled');

    var selectElement = $('#horariosDisponiveis');

   
    if (selectElement.find('option[value="' + valorSelecionado + '"]').length === 0) {
        var novaOpcao = $('<option></option>').attr('value', valorSelecionado).text(valorSelecionado);
        selectElement.append(novaOpcao);
    }
    
    selectElement.val(valorSelecionado);
                
    $('body.admin .container-popup').toggleClass('active');
    $('body.admin .conteudo').toggleClass('back');
  });

  $('#btn-agendar').on('click' , function(){
      $('.agenda-top .form').toggleClass('active');
      $('body.admin .conteudo').addClass('back');
  });


  $('.close').on('click' , function() {
    $('body.admin .container-popup').toggleClass('active');
    $('body.admin .conteudo').toggleClass('back');
  });

  $('.close-form').on('click' , function() {
    $('.agenda-top .form').toggleClass('active');
    $('body.admin .container-popup').toggleClass('active');
    $('body.admin .conteudo').toggleClass('back')
    var selectElement = $('#horariosDisponiveis');
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
  


  var currentPagePath = window.location.pathname;
  var specificPagePath = '/BarberWeb-1/admin/agendamentos';

  if (currentPagePath === specificPagePath) {

      function atualizarHorariosMarcados(data) {
          $.ajax({
            url: '/BarberWeb-1/admin/atualizar_data',
            type: 'POST',
            data: {
              data: data,
            },
            dataType: 'json',
            success: function(response) {
              var horarios = response.horarios;
              if (horarios === 'fechada' ) {
                for (var i = 0; i < horarios.length; i++) {
                    var td = $('.td')
                    td.empty();
                    td.addClass('fechada')             
                    td.removeClass('marcado');
                    td.removeClass('marcado-corte-barba');
                }
              } else {
                //Percorra os horários
                for (var i = 0; i < horarios.length; i++) {
                  var horario = horarios[i].horario;
                  var nomeAgendamento = horarios[i].nome;
                  var idAgendamento = horarios[i].idAgendamento; // Assumindo que o ID do agendamento está disponível no array
                  var servico = horarios[i].servico;
      
                  // Encontre a célula correspondente ao horário
                  var celula = $('#horario-' + horario.replace(':', '-').replace(' ', '-'));
                 
                  var ultimoHorario = horarios[horarios.length - 1].horario;
                  if (ultimoHorario === '16:00') {
                      var celula1 = $('#horario-16-30');
                      var celula2 = $('#horario-17-00');
                      var celula3 = $('#horario-17-30');
                      var celula4 = $('#horario-18-00');
                      var celula5 = $('#horario-18-30');
                      var celula6 = $('#horario-19-00');
                      var celula7 = $('#horario-19-30');
                      celula1.addClass('fechada');
                      celula2.addClass('fechada');
                      celula3.addClass('fechada');
                      celula4.addClass('fechada');
                      celula5.addClass('fechada');
                      celula6.addClass('fechada');
                      celula7.addClass('fechada');
      
                      celula1.empty();
                      celula2.empty();
                      celula3.empty();
                      celula4.empty();
                      celula5.empty();
                      celula6.empty();
                      celula7.empty();
      
                      celula1.removeClass('marcado-corte-barba');
                      celula2.removeClass('marcado-corte-barba');
                      celula3.removeClass('marcado-corte-barba');
                      celula4.removeClass('marcado-corte-barba');
                      celula5.removeClass('marcado-corte-barba');
                      celula6.removeClass('marcado-corte-barba');
                      celula7.removeClass('marcado-corte-barba');
                  } else{
                    var celula6 = $('#horario-08-00');
                    celula6.empty();
                    celula6.addClass('fechada');            
                  }
                  celula.removeClass('fechada');
              
                
                  if (nomeAgendamento) {
                    celula.addClass('marcado');      
                    if(servico == 'Corte e barba') {
                      celula.addClass('marcado-corte-barba');
                      celula.removeClass('marcado');
                      
                    }else{
                      celula.empty();
                      celula.removeClass('marcado-corte-barba');
                
                    }
                  } else {
                    celula.empty();
                    celula.removeClass('marcado');
                    celula.removeClass('marcado-corte-barba');
                  }
      
                  // Criar o elemento <a> (link) dentro da célula
                  var linkAgendamento = $('<a></a>');
                  linkAgendamento.attr('href', 'agendamentos-edit/' + idAgendamento); // Adicione o ID do agendamento ao href
                  linkAgendamento.text(nomeAgendamento);
      
                  // Limpe o conteúdo da célula antes de adicionar o link
                  celula.empty();
                  
                  // Adicionar o link do agendamento à célula
                  celula.append(linkAgendamento);
                }
              } 
            },
            
            error: function(xhr, status, error) {
              if (xhr.responseText) {
                try {
                  var response = JSON.parse(xhr.responseText);
                  if (response.hasOwnProperty('error')) {
                    alert('Erro: ' + response.error);
                  } else {
                    alert('Ocorreu um erro na requisição.');
                  }
                } catch (e) {
                 
                  alert('Ocorreu um erro na requisição: ' + error);
                }
              } else {
              
                alert('Ocorreu um erro na requisição: ' + error);
               
              }
            }
          });
        }
        
        $('#dataMarcada').change(function() {
          var data = $('#dataMarcada').val();
        
          atualizarHorariosMarcados(data);
        });
      }
 
  

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
            alerta.addClass('sucesso');
            $('#aviso').addClass('mostrar'); 
            $('#avisoSucesso').addClass('mostrarSucesso');
          } else {
            alerta.addClass('erro');
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
              alerta.removeClass('sucesso');
              alerta.removeClass('erro');

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


  