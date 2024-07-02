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
                    const horarios = response.horarios;
                    $('.itensHorarios').empty();
                    $.each(horarios, function(barbeiro, dadosBarbeiro) {
                        const barbeiroHtml = `
                            <div class="item">
                                <div class="nomeBarbeiro">
                                    <img src="http://localhost/BarberWeb/${dadosBarbeiro.foto_usuario}">
                                    <p>${barbeiro}</p>
                                </div>
                                <div class="horariosBarbeiros" data-id="${dadosBarbeiro.id}">
                                ${dadosBarbeiro.horarios.map(horario => `<span>${horario}</span>`).join('')}
                            </div>
                            </div>
                        `;
                
                        $('.itensHorarios').append(barbeiroHtml);
                    });
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
            
            if( tempoInput === 'sel'){
                var text = "<p>Selecione um serviço!</p>";
                $('.alertaAviso').empty(); 
                $('.alertaAviso').append(text);
                $('.alertaAviso').addClass('mostrar');
                setTimeout(function() {
                    $('.alertaAviso').removeClass('mostrar');
                    $('.alertaAviso').empty(); 
                }, 5000);
            } else{
                var parts = tempoInput.split(';');
                var tempoServico = parts[0];
        
                mostrarHorarios(data, tempoServico);
            }
        });
    }
    
});