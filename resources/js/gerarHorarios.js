$(document).ready(function(){
    function atualizarData(data) {
        $.ajax({
            url: '/BarberWeb-1/admin/gerar_horario',
            type: 'POST',
            data: { data: data },
            dataType: 'json',
            success: function(response) {
                var horarios = response.horarios;
                $('#tabelaHorarios').empty();

                var tabela = $('<table></table>').addClass('horarios-table');
                var corpoTabela = $('<tbody></tbody>');

                if (horarios.length > 0 && horarios[0].turno1 && horarios[0].turno2) {
                    var turno1 = horarios[0].turno1;
                    var turno2 = horarios[0].turno2;

                    if (turno1 === 'FECHADO' && turno2 === 'FECHADO') {
                        var text = "<p>Nenhum horário disponível!</p>";
                        $('#aviso').empty(); 
                        $('#aviso').append(text);
                        $('#aviso').addClass('mostrar');
                        setTimeout(function() {
                            $('#aviso').removeClass('mostrar');
                            $('#aviso').empty(); 
                        }, 5000);
                    } else {

                        if (horarios.length > 0 && horarios[0].turno1) {
                            var turno1 = horarios[0].turno1.trim();
                            if (turno1 === 'FECHADO') {
                                turno1 = []; 
                            } else {
                                turno1 = turno1.split(', '); 
                            }
                        
                            turno1.forEach(function(horario) {
                                var idHorario = 'horario-' + horario.replace(':', '-');
        
                                var linha = $('<tr></tr>');
                               
                                var cabecalho = $('<th></th>').addClass('tr').text(horario);
                                linha.append(cabecalho);
                              
                                var celula = $('<td></td>');
                                var divHorario = $('<div></div>').addClass('td selectTd').attr('id', idHorario);
                                celula.append(divHorario);
                                linha.append(celula);
        
                                corpoTabela.append(linha);
                            });
                        }
                        
                        if (horarios.length > 0 && horarios[0].turno2) {
                            var turno2 = horarios[0].turno2.trim();
                            if (turno2 === 'FECHADO') {
                                turno2 = []; 
                            } else {
                                turno2 = turno2.split(', '); 
                            }
                            
                            turno2.forEach(function(horario) {
                                var idHorario = 'horario-' + horario.replace(':', '-');
        
                                var linha = $('<tr></tr>');
        
                                var cabecalho = $('<th></th>').addClass('tr').text(horario);
                                linha.append(cabecalho);
        
                                var celula = $('<td></td>');
                                var divHorario = $('<div></div>').addClass('td').attr('id', idHorario);
                                celula.append(divHorario);
                                linha.append(celula);
        
                                corpoTabela.append(linha);
                            });
                        }
                        tabela.append(corpoTabela);
                        $('#tabelaHorarios').append(tabela);
                    }
                } else{
                    console.log('Horários não encontrados ou formato inválido.');
                }
            }, 
            error: function(xhr, status, error) {
                var mensagemErro = 'Ocorreu um erro na requisição: ' + error;
                alert(mensagemErro);
            }
        });
    }
   
    $('#dataMarcada').change(function() {
        var data = $('#dataMarcada').val();
        atualizarData(data);
    });
    
    var dataInicial = $('#dataMarcada').val(); 
    atualizarData(dataInicial);
});