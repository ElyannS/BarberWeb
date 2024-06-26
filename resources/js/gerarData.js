$(document).ready(function() {
  var meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
  var diasSemana = ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"];

  function formatarData(data) {
      return diasSemana[data.getDay()] + ' ' + data.getDate() + ' de ' + meses[data.getMonth()] + ', ' + data.getFullYear();
  }

  var dataAtual = new Date(new Date().toLocaleString("en-US", { timeZone: "America/Sao_Paulo" }));
  dataAtual.setHours(0, 0, 0, 0); 
  var dataFormatada = dataAtual.toISOString().split('T')[0];
  $('#dataMarcada').val(dataFormatada) + 'T00:00';

  function gerarDatas() {
      var dataMarcada = $('#dataMarcada').val() + 'T00:00' || dataFormatada;
      var dataSelecionada = new Date(dataMarcada);
      dataSelecionada.setHours(0, 0, 0, 0);

      var inicioSemana = new Date(dataSelecionada);
      inicioSemana.setDate(dataSelecionada.getDate() - dataSelecionada.getDay());

      if (dataSelecionada.getDay() === 0 && dataSelecionada > dataAtual) {
          inicioSemana.setDate(inicioSemana.getDate() - 7);
      }

      $(".date_ext").empty();

      var meses = [];

      for (var i = 0; i < 7; i++) {
          var dia = inicioSemana.getDate();
          var mes = inicioSemana.getMonth();
          var diaFormatado = (dia < 10) ? '0' + dia : dia;
          var dataFormatada = inicioSemana.toISOString().split('T')[0];
          var classeDestaque = (dataSelecionada.toISOString().split('T')[0] === dataFormatada) ? 'highlight' : '';

          var divDia = $('<div class="day ' + classeDestaque + '">' + diaFormatado + '</div>');
          $(".date").text(formatarData(dataSelecionada));
          $(".date_ext").append(divDia);

          meses.push(mes);

          divDia.on('click', function () {
              $('.day').removeClass('highlight');
              $(this).addClass('highlight');
              var diaClicado = parseInt($(this).text(), 10);

              dataSelecionada.setDate(diaClicado);
              dataSelecionada.setHours(0, 0, 0, 0);

              var mesClicado = meses[$(this).index()];
              if (dataSelecionada.getMonth() !== mesClicado) {
                  dataSelecionada.setMonth(mesClicado, diaClicado);
                  inicioSemana = new Date(dataSelecionada);
                  inicioSemana.setDate(dataSelecionada.getDate() - dataSelecionada.getDay());
              }

              $('#dataMarcada').val(dataSelecionada.toISOString().split('T')[0]).trigger('change');
          });

          inicioSemana.setDate(inicioSemana.getDate() + 1);
      }
  }

  $('#prevButton').on('click', function () {
      retrocederSemana();
  });

  $('#nextButton').on('click', function () {
      avancarSemana();
  });

  function retrocederSemana() {
      var dataMarcada = $('#dataMarcada').val() + 'T00:00';
      var dataSelecionada = new Date(dataMarcada);
      dataSelecionada.setDate(dataSelecionada.getDate() - 7);

      $('#dataMarcada').val(dataSelecionada.toISOString().split('T')[0]).trigger('change');
  }

  function avancarSemana() {
      var dataMarcada = $('#dataMarcada').val() + 'T00:00';
      var dataSelecionada = new Date(dataMarcada);
      dataSelecionada.setDate(dataSelecionada.getDate() + 7);

      $('#dataMarcada').val(dataSelecionada.toISOString().split('T')[0]).trigger('change');
  }

  $('#dataMarcada').on('change', function () {
      gerarDatas();
  });

  gerarDatas();
});
 