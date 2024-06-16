$(document).ready(function(){

    var currentPagePath = window.location.pathname;
    var specificPagePath = '/BarberWeb/admin/caixa-relatorio';
 
    if (currentPagePath === specificPagePath) {
        function atualizarData(data1, data2) {
            $.ajax({
                url: '/BarberWeb/admin/gerar_relatorio',
                type: 'POST',
                data: { data1: data1, data2: data2 },
                dataType: 'json',
                success: function(response) {
                    var relatorio = response.relatorio;
                   
                    var atendimentos = response.atendimento;

                    var comissao = response.comissao;
           
                    var dinheiroR = response.dinheiro;
                    var pixR = response.pix;
                    var cartaoR = response.cartao;

                    $('h1#valorTotal').empty();
                    $('#relato').empty();
                    $('#comissao').empty();
                    $('#dinheiroR').empty();
                    $('#pixR').empty();
                    $('#cartaoR').empty();


                    if (relatorio == null){
                        $('h1#valorTotal').append('<p>Sem dados para mostrar!</p>');
                    } else{
                        $('#relato').append('<p>Voce fez <small id="#atendimentos">' + atendimentos + ' atendimentos</small> no perído.</p>')
                        $('h1#valorTotal').append('Valor total período: R$ ' + relatorio);
                        $('#comissao').append('Comissão Barbeiro: R$ ' + comissao);
                        $('#dinheiroR').append('Valor total do Dinheiro: R$ ' + dinheiroR);
                        $('#pixR').append('Valor total do Pix: R$ ' + pixR);
                        $('#cartaoR').append('Valor total do Cartão: R$ ' + cartaoR);
    
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