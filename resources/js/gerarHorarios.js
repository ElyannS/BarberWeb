$(document).ready(function() {
   $('.js-example-basic-single').select2();
  var currentPagePath = window.location.pathname;
  var specificPagePath = '/BarberWeb/admin/agendamentos';
    if (currentPagePath === specificPagePath) {
        function atualizarData(data, idBarbeiro) {
        $.ajax({
            url: '/BarberWeb/admin/gerar_horario',
            type: 'POST',
            data: {
                data: data,
                idBarbeiro: idBarbeiro
            },
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
                } else {
                    console.log('Horários não encontrados ou formato inválido.');
                }
            },
            error: function(xhr, status, error) {
                var mensagemErro = 'Ocorreu um erro na requisição: ' + error;
                alert(mensagemErro);
            }
        });
        }

        function atualizarHorariosMarcados(data, idBarbeiro) {
        $.ajax({
            url: '/BarberWeb/admin/atualizar_data',
            type: 'POST',
            data: {
                data: data,
                idBarbeiro: idBarbeiro
            },
            dataType: 'json',
                success: function(response) {
                var horarios = response.horarios;

                for (var i = 0; i < horarios.length; i++) {
                    var horario = horarios[i].horario;
                    var nomeAgendamento = horarios[i].nome;
                    var idAgendamento = horarios[i].idAgendamento;
                    var servico = horarios[i].servico;

                    var celula = $('#horario-' + horario.replace(':', '-').replace(' ', '-'));

                    if (nomeAgendamento) {
                        celula.addClass('marcado');
                        if (servico == 'Corte e barba') {
                            celula.addClass('marcado-corte-barba');
                        }
                    }

                    var linkAgendamento = $('<a></a>');
                    linkAgendamento.attr('href', 'agendamentos-edit/' + idAgendamento);
                    linkAgendamento.text(nomeAgendamento);

                    celula.append(linkAgendamento);
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
            var idBarbeiro = $('#idBarbeiro').val();
            atualizarData(data, idBarbeiro);
            setTimeout(function() {
                atualizarHorariosMarcados(data, idBarbeiro);
            }, 200); // Pequeno atraso de 0.2 segundos
        });

        $('#idBarbeiro').change(function() {
            var data = $('#dataMarcada').val();
            var idBarbeiro = $('#idBarbeiro').val();
            atualizarData(data, idBarbeiro);
            setTimeout(function() {
                atualizarHorariosMarcados(data, idBarbeiro);
            }, 200); // Pequeno atraso de 0.2 segundos
        });

        var dataInicial = $('#dataMarcada').val();
        var idBarbeiro = $('#idBarbeiro').val();
        atualizarData(dataInicial, idBarbeiro);
        setTimeout(function() {
            atualizarHorariosMarcados(dataInicial, idBarbeiro);
        }, 200); // Pequeno atraso de 0.2 segundos
    }
});
