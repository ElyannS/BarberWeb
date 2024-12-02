$(document).ready(function(){

    var currentPagePath = window.location.pathname;
    var specificPagePath = '/BarberWeb/admin/despesa-relatorio';
 
    if (currentPagePath === specificPagePath) {
        function atualizarData(data1, data2) {
            $.ajax({
                url: '/BarberWeb/admin/gerar_relatorio_despesa',
                type: 'POST',
                data: { data1: data1, data2: data2 },
                dataType: 'json',
                success: function(response) {
                    var relatorio = response.relatorio;
                   
                    var atendimentos = response.atendimento;

           
                    var dinheiroR = response.dinheiro;
                    var pixR = response.pix;
                    var cartaoR = response.cartao;
                    var saldo = response.saldo;

                    $('h1#valorTotal').empty();
                    $('#relato').empty();
                    $('#dinheiroR').empty();
                    $('#pixR').empty();
                    $('#cartaoR').empty();
                    $('#saldo').empty();


                    if (relatorio == null){
                        $('h1#valorTotal').append('<p>Sem dados para mostrar!</p>');
                    } else{
                        $('#relato').append('<p>Voce teve <small id="#atendimentos">' + atendimentos + ' despesas</small> no perído.</p>')
                        $('h1#valorTotal').append('Valor total período: R$ ' + relatorio);
                        $('#dinheiroR').append('Valor total do Dinheiro: R$ ' + dinheiroR);
                        $('#pixR').append('Valor total do Pix: R$ ' + pixR);
                        $('#cartaoR').append('Valor total do Cartão: R$ ' + cartaoR);
                        $('#saldo').append('Saldo: R$ ' + saldo);
                      
                    }
                 
                },  
                error: function(xhr, status, error) {
                    var mensagemErro = 'Ocorreu um erro na requisição: ' + error;
                    alert(mensagemErro);
                }
            });
        } 
    
        $('#campoDataDespesa').change(function() {
            var data1 = $('#campoDataDespesa1').val();
            var data2 = $('#campoDataDespesa').val();
            atualizarData(data1, data2 );
        });
        
        var dataInicial = $('#campoDataDespesa1').val(); 
        atualizarData(dataInicial, dataInicial);
    }
});