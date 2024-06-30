$(document).ready(function(){

    var currentPagePath = window.location.pathname;
    var specificPagePath = '/BarberWeb/admin/agenda-cliente';

    if (currentPagePath === specificPagePath) {
        function mostrarHorarios(data, tempoServico) {
            $.ajax({
                url: '/BarberWeb/admin/mostrar_horarios',
                type: 'POST',
                data: {
                data: data,
                tempoServico: tempoServico
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
                        if(servico == 'Corte e barba') {
                        celula.addClass('marcado-corte-barba');
                        }
                    } 
        
                    
                    var linkAgendamento = $('<a></a>');
                    linkAgendamento.attr('href', 'agendamentos-edit/' + idAgendamento); 
                    linkAgendamento.text(nomeAgendamento);
        
                    
                    celula.empty();
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

        $('#mostrarHorarios').on('click', function(){
            var data = $('#dataCliente').val();
            var tempoInput = $('#servicoCliente').val();

            var parts = tempoInput.split(';');
            var tempoServico = parts[0];

            mostrarHorarios(data, tempoServico);
        });
    }
    
});