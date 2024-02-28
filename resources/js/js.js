$(document).ready(function(){

  $('table tr td div.td').click(function() {
    // Ação a ser executada quando a div é clicada
    alert('Div clicada!');
});
  $('tr td .td').on('click' , function() {

    var valorInput = $('table tr td div.td input[name="input-valor"]').val();
            
    // Exibir o valor do input
    alert('Valor do input com name="valor-input": ' + valorInput);
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


