$(document).ready(function(){

    var currentPagePath = window.location.pathname;
    var specificPagePath = '/BarberWeb-1/admin/caixa-relatorio';

    if (currentPagePath === specificPagePath) {
        function atualizarData(data1, data2) {
            $.ajax({
                url: '/BarberWeb-1/admin/gerar_relatorio',
                type: 'POST',
                data: { data1: data1, data2: data2 },
                dataType: 'json',
                success: function(response) {
                    var relatorio = response.relatorio;
                   
                    var atendimentos = response.atendimento;

                    $('h1#valorTotal').empty();
                    $('#relato').empty();
                    if (relatorio == null){
                        $('h1#valorTotal').append('<p>Sem dados para mostrar!</p>');
                    } else{
                        $('#relato').append('<p>Voce fez <small id="#atendimentos">' + atendimentos + ' atendimentos</small> no perído.</p>')
                        $('h1#valorTotal').append('R$ ' + relatorio);
                    }
                
                },  
                error: function(xhr, status, error) {
                    var mensagemErro = 'Ocorreu um erro na requisição: ' + error;
                    alert(mensagemErro);
                }
            });
        }
    
        $('#campoData').change(function() {
            var data1 = $('#campoData1').val();
            var data2 = $('#campoData').val();
            atualizarData(data1, data2 );
        });
        
        var dataInicial = $('#campoData1').val(); 
        atualizarData(dataInicial, dataInicial);
    }
});