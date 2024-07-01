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

                    $.each(horarios, function(barbeiro, horariosArray) {
                        const barbeiroHtml = `
                            <div class="item">
                                <div class="nomeBarbeiro">
                                    <img src="<?=URL_BASE.$_SESSION['usuario_logado']['foto_usuario']?>"> <!-- Ajuste a URL da imagem conforme necessário -->
                                    <p>${barbeiro}</p>
                                </div>
                                <div class="horariosBarbeiros">
                                    ${horariosArray.map(horario => `<span>${horario}</span>`).join('')}
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

            var parts = tempoInput.split(';');
            var tempoServico = parts[0];

            mostrarHorarios(data, tempoServico);
        });
    }
    
});