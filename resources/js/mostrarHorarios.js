$(document).ready(function(){

    var currentPagePath = window.location.pathname;
    var specificPagePath = '/BarberWeb/admin/agenda-cliente';

    if (currentPagePath === specificPagePath) {
        function mostrarHorarios(data, tempoServico, idServico) {
            $.ajax({
                url: '/BarberWeb/admin/mostrar_horarios',
                type: 'POST',
                data: {
                data: data,
                tempoServico: tempoServico,
                idServico: idServico
                },
                dataType: 'json',
                success: function(response) {
                    const horarios = response.horarios;
                    
                    $('.itensHorarios').empty();
                    $.each(horarios, function(barbeiro, dadosBarbeiro) {
                        const barbeiroHtml = `
                            <div class="item">
                                <div class="nomeBarbeiro">
                                    <img src="http://exclusivebarbershop.com.br/${dadosBarbeiro.foto_usuario}">
                                    <p>${barbeiro}</p>
                                </div>
                                <div class="horariosBarbeiros" id="pegaDados">
                                    ${dadosBarbeiro.horarios.map(horario => `<span class="span" value="${barbeiro},${dadosBarbeiro.idBarbeiro},${dadosBarbeiro.idServico},${dadosBarbeiro.data},${dadosBarbeiro.nomeServico},${horario}">${horario}</span>`).join('')}
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
            $('#valueIn').val('CHANGE');

            var dataAtual = new Date(new Date().toLocaleString("en-US", { timeZone: "America/Sao_Paulo" }));
            dataAtual.setHours(0, 0, 0, 0); 
            var dataFormatada = dataAtual.toISOString().split('T')[0];

            if( data < dataFormatada){
                var text = "<p>Selecione uma data válida!</p>";
                $('.alertaAviso').empty(); 
                $('.alertaAviso').append(text);
                $('.alertaAviso').addClass('mostrar');
                setTimeout(function() {
                    $('.alertaAviso').removeClass('mostrar');
                    $('.alertaAviso').empty(); 
                }, 5000);
            } else{
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
                    var idServico = parts[1];
                    
                    mostrarHorarios(data, tempoServico, idServico);
                }
            }
        });
        
        
            $('#servicoCliente').change(function(){
                var input =  $('#valueIn').val();
                if(input == 'CHANGE'){
                    var data = $('#dataCliente').val();
                    var tempoInput = $('#servicoCliente').val();
        
        
                    var dataAtual = new Date(new Date().toLocaleString("en-US", { timeZone: "America/Sao_Paulo" }));
                    dataAtual.setHours(0, 0, 0, 0); 
                    var dataFormatada = dataAtual.toISOString().split('T')[0];
        
                    if( data < dataFormatada){
                        var text = "<p>Selecione uma data válida!</p>";
                        $('.alertaAviso').empty(); 
                        $('.alertaAviso').append(text);
                        $('.alertaAviso').addClass('mostrar');
                        setTimeout(function() {
                            $('.alertaAviso').removeClass('mostrar');
                            $('.alertaAviso').empty(); 
                        }, 5000);
                    } else{
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
                            var idServico = parts[1];
                    
                            mostrarHorarios(data, tempoServico, idServico);
                        }
                    }
                }
            });
        
        
        $(document).on('click', '#pegaDados span', function() {
            const value = $(this).attr('value');
            $('.clienteAgenda').css('position', 'fixed');
            $('body.admin .index').toggleClass('activeAgenda');
           
 
            const [barbeiro, idBarbeiro, idServico, data, nomeServico, horario] = value.split(',');
   
            $('#nomeBarber').val(barbeiro);
            $('#idBaber').val(idBarbeiro);
            $('#nomeSevico').val(nomeServico);
            $('#idServ').val(idServico);
            $('#dataAgen').val(data);
            $('#agendData').val(data);
            $('#horarioAgen').val(horario);
            $('#horarioA').val(horario);



        });
        
        $('.closeAgenda').on('click' , function() {
            $('body.admin .index').toggleClass('activeAgenda');
            $('.agenda').css('position', 'initial');
        });
    }
    
});

    

