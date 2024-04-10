$(document).ready(function(){
    function atualizarData(data) {
        $.ajax({
            url: '/BarberWeb-1/admin/gerar_horario',
            type: 'POST',
            data: { data: data },
            dataType: 'json',
            success: function(response) {
                var horarios = response.horarios;
                var diaSemana = new Date(data).getDay(); // Obtém o dia da semana (0 = Domingo, 1 = Segunda, ..., 6 = Sábado)

                // Limpa a tabela antes de atualizar os horários
                $('#tabelaHorarios').empty();

                // Criação dinâmica da estrutura da tabela
                var tabela = $('<table></table>').addClass('horarios-table');
                var corpoTabela = $('<tbody></tbody>');

                // Percorre os horários para criar as linhas da tabela
                for (var i = 0; i < horarios.length; i++) {
                    var horario = horarios[i].horario;
                    var idHorario = 'horario-' + horario.replace(':', '-'); // ID único para cada célula de horário

                    // Criação da linha da tabela para o horário atual
                    var linha = $('<tr></tr>');

                    // Cabeçalho com o horário
                    var cabecalho = $('<th></th>').addClass('tr').text(horario);
                    linha.append(cabecalho);

                    // Célula contendo uma div com o ID específico para o horário
                    var celula = $('<td></td>');
                    var divHorario = $('<div></div>').addClass('td').attr('id', idHorario);
                    celula.append(divHorario);
                    linha.append(celula);
  
                    corpoTabela.append(linha);
                }  

                // Adiciona o corpo da tabela ao elemento HTML
                tabela.append(corpoTabela);
                $('#tabelaHorarios').append(tabela);
            }, 
            error: function(xhr, status, error) {
                // Tratamento de erro da requisição AJAX
                var mensagemErro = 'Ocorreu um erro na requisição: ' + error;
                alert(mensagemErro);
            }
        });
    }

    // Evento de mudança na data selecionada
    $('#dataMarcada').change(function() {
        var data = $('#dataMarcada').val();
        atualizarData(data);
    });
});