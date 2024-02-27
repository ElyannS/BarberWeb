<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Caixa;
use App\Model\Usuario;
use App\Model\Configuracao;

final class ServicoController 
{
    
    // CAIXA 


    public function caixa(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        $servicos = new Caixa();

        if(isset($_GET['pesquisa']) && $_GET['pesquisa'] !== ''){
            $lista = $servicos->selectCaixaPesquisa($_GET['pesquisa']);
            $paginaAtual = 1;
            $proximaPagina = false;
            $paginaAnterior = false;
            
        } else{
            $limit = 10;
            $paginaAtual = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($paginaAtual * $limit) - $limit;

            // Obtenha as datas distintas agrupando por data e selecionando a transação mais recente
            $sqlDatasDistintas = "SELECT MAX(id) as id FROM caixa GROUP BY data ORDER BY data DESC LIMIT {$offset}, {$limit}";
            $datasDistintas = $servicos->querySelect($sqlDatasDistintas);

            $qntTotal = count($datasDistintas);

            if($qntTotal > 0){
                $proximaPagina = ($qntTotal > ($paginaAtual * $limit)) ? URL_BASE."admin/caixa?page=".($paginaAtual + 1) : false;
                $paginaAnterior = ($paginaAtual > 1) ? URL_BASE."admin/caixa?page=".($paginaAtual - 1) : false;
    
                // Agora, obtenha as transações para a página atual usando os IDs obtidos anteriormente
                $ids = implode(',', array_column($datasDistintas, 'id'));
                $sqlLista = "SELECT * FROM caixa WHERE id IN ({$ids})";
                $lista = $servicos->querySelect($sqlLista);
            } else{
                $lista = [];
            }
           
        }
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $caixa = new Caixa();

        $caixa = new Caixa();

        // Data de uma semana atrás
        $dataInicioW = date('Y-m-d', strtotime('-1 week'));
        $dataFimW = date('Y-m-d');
        
        $sql = "SELECT SUM(dinheiro) + SUM(pix) + SUM(cartao) as valorTotal FROM caixa WHERE data BETWEEN '{$dataInicioW}' AND '{$dataFimW}'";
        $resultado = $caixa->querySelect($sql);
        
        $valorTotalSemana = $resultado[0]['valorTotal'];
        
        $caixa = new Caixa();

        // Data de um mês atrás
        $dataInicioM = date('Y-m-d', strtotime('-1 month'));
        $dataFimM = date('Y-m-d');

        $sql = "SELECT SUM(dinheiro) + SUM(pix) + SUM(cartao) as valorTotal FROM caixa WHERE data BETWEEN '{$dataInicioM}' AND '{$dataFimM}'";
        $resultado = $caixa->querySelect($sql);

        $valorTotalMes = $resultado[0]['valorTotal'];

      
        $caixa = new Caixa();

        // Data de um ano atrás
        $dataInicioA = date('Y-m-d', strtotime('-1 year'));
        $dataFimA = date('Y-m-d');
        
        $sql = "SELECT SUM(dinheiro) + SUM(pix) + SUM(cartao) as valorTotal FROM caixa WHERE data BETWEEN '{$dataInicioA}' AND '{$dataFimA}'";
        $resultado = $caixa->querySelect($sql);
        
        $valorTotalAno = $resultado[0]['valorTotal'];
        
        $data['informacoes'] = array(
            'menu_active' => 'caixa',
            'lista' => $lista,
            'paginaAtual' => $paginaAtual,
            'proximaPagina' => $proximaPagina,
            'paginaAnterior' => $paginaAnterior,
            'nome_logo' => $nome_logo_site,
            'resultadoSemana' => $valorTotalSemana,
            'resultadoMes' => $valorTotalMes,
            'resultadoAno' => $valorTotalAno
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/caixa");
        return $renderer->render($response, "caixa.php", $data);
    } 
    
   
    public function caixa_create(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $caixa = new Caixa();
        $consultaCaixa = $caixa->selectCaixa('*', array(1 => '1'));

        $data['informacoes'] = array(
            'menu_active' => 'caixa',
            'nome_logo' => $nome_logo_site,
            'lista' => $consultaCaixa,
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/caixa");
        return $renderer->render($response, "create.php", $data);
    }

    public function caixa_edit(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $args['id'];

        $caixa = new Caixa();

        $resultado = $caixa->selectCaixa('*', array('id' => $id))[0];



        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');
        $data['informacoes'] = array(
            'menu_active' => 'caixa',
            'lista' => $resultado,
            'nome_logo' => $nome_logo_site
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/caixa");
        return $renderer->render($response, "edit.php", $data);
    }
    public function caixa_edit_data(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $dataUrl = $args['id'];

        $caixa = new Caixa();
        $resultado = $caixa->selectPorData($dataUrl);


        $valorTotalDinheiro = 0;
        $valorTotalPix = 0;
        $valorTotalCartao = 0;
        $valorTotal = 0;
        foreach ($resultado as $registro) {
            $valorTotalDinheiro += $registro['dinheiro'];
        }
        foreach ($resultado as $registro) {
            $valorTotalPix += $registro['pix'];
        }
        foreach ($resultado as $registro) {
            $valorTotalCartao += $registro['cartao'];
        }
        foreach ($resultado as $registro) {
            // Soma os valores das colunas 'dinheiro', 'pix' e 'cartao'
            $valorTotal += $registro['dinheiro'] + $registro['pix'] + $registro['cartao'];
        }
        
        
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');
        $data['informacoes'] = array(
            'menu_active' => 'caixa',
            'lista' => $resultado,
            'nome_logo' => $nome_logo_site,
            'dataUrl' => $dataUrl,
            'valorDoDia' => $valorTotal,
            'valorDinheiro' => $valorTotalDinheiro,
            'valorPix' => $valorTotalPix,
            'valorCartao' => $valorTotalCartao,
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/caixa");
        return $renderer->render($response, "edit2.php", $data);
    }
    public function caixa_insert(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $nome_cliente = $request->getParsedBody()['nome_cliente'] ?? null;
        $data = $request->getParsedBody()['data'] ?? null;
        $dinheiro = $request->getParsedBody()['dinheiro'] ?? null;
        $pix = $request->getParsedBody()['pix'] ?? null;
        $cartao = $request->getParsedBody()['cartao'] ?? null;
    
        // Verifica e faz trim somente se a variável não for nula
        $nome_cliente = ($nome_cliente !== null) ? trim($nome_cliente) : null;
        $data = ($data !== null) ? trim($data) : null;
        $dinheiro = ($dinheiro !== null) ? trim($dinheiro) : null;
        $pix = ($pix !== null) ? trim($pix) : null;
        $cartao = ($cartao !== null) ? trim($cartao) : null;
    
        // Verifica se pelo menos um dos valores não é nulo antes de inserir no banco de dados
        if ($nome_cliente !== null || $data !== null || $dinheiro !== null || $pix !== null || $cartao !== null) {
            $camposPreenchidos = array_filter(array(
                'nome_cliente' => $nome_cliente,
                'data' => $data,
                'dinheiro' => $dinheiro,
                'pix' => $pix,
                'cartao' => $cartao,
            ));
            
            $caixa = new Caixa();
            $caixa->insertCaixa($camposPreenchidos);
    
            header('Location: '.URL_BASE.'admin/caixa-edit-data/'.$data);
            exit();
        } else {
            echo "Nenhum dos valores informados. Nada a ser inserido.";
        }
    }
    



//UPDATE CAIXA

    public function caixa_update(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $request->getParsedBody()['id'];
        $nome_cliente = $request->getParsedBody()['nome_cliente'];
        $data = $request->getParsedBody()['data'];
        $dinheiro = $request->getParsedBody()['dinheiro'];
        $pix = $request->getParsedBody()['pix'];
        $cartao = $request->getParsedBody()['cartao'];
       
       
       

        
        
        $campos = array(
            'nome_cliente' => $nome_cliente,
            'data' => $data,
            'dinheiro' => $dinheiro,
            'pix' => $pix,
            'cartao' => $cartao,
        );
        
        $caixa = new Caixa();
        $caixa->updateCaixa($campos, array('id' => $id));
        
        header('Location: '.URL_BASE.'admin/caixa-edit-data/'.$data);
        exit();
    }

    public function caixa_delete(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $data = $request->getParsedBody()['data'];
       $id = $request->getParsedBody()['id'];

       $caixa = new Caixa();

       $caixa->deleteCaixa('id', $id);

       header('Location: '.URL_BASE.'admin/caixa');
       exit();

    }
    public function caixa_total_delete(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $data = $request->getParsedBody()['data'];
  

       $caixa = new Caixa();

       $caixa->deleteCaixa('data', $data);

       header('Location: '.URL_BASE.'admin/caixa');
       exit();

    }

} 