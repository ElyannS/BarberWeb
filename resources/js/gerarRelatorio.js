$(document).ready(function(){

        var currentPagePath = window.location.pathname;

    // Definir o caminho da página específica
    var specificPagePath = '/BarberWeb-1/admin/caixa-relatorio';

    // Verificar se a página atual é a página específica
    if (currentPagePath === specificPagePath) {
        function atualizarData(data1, data2) {
            $.ajax({
                url: '/BarberWeb-1/admin/gerar_relatorio',
                type: 'POST',
                data: { data1: data1, data2: data2 },
                dataType: 'json',
                success: function(response) {
                    var relatorio = response.relatorio;
                    $('h1#valorTotal').empty();
                    if (relatorio == null){
                        $('h1#valorTotal').append('<p> Sem dados para mostrar!</p>');
                    } else{
                        $('h1#valorTotal').append(relatorio);
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