<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Caixa;
use App\Model\Usuario;
use App\Model\Configuracao;

final class CaixaController 
{
    public function caixa (
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        $servicos = new Caixa();
        $emailUser = $_SESSION['usuario_logado']['email'];
        $usuario = new Usuario();
        $usuarioInfo = $usuario->selectUsuario('*', ['email' => $emailUser]);
        $idBarbeiro = $usuarioInfo[0]['id'];


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
                $sqlLista = "SELECT * FROM caixa WHERE id IN ({$ids}) AND caixa.id_barbeiro = {$idBarbeiro}";
                $lista = $servicos->querySelect($sqlLista);
            } else{
                $lista = [];
            }
           
        }
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'caixa',
            'lista' => $lista,
            'paginaAtual' => $paginaAtual,
            'proximaPagina' => $proximaPagina,
            'paginaAnterior' => $paginaAnterior,
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/caixa");
        return $renderer->render($response, "caixa.php", $data);
    } 
    
   
    public function caixa_create(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'caixa',
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/caixa");
        return $renderer->render($response, "create.php", $data);
    }
    public function caixa_relatorio(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'caixa',
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/caixa");
        return $renderer->render($response, "relatorio.php", $data);
    }

    public function caixa_edit(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();

        $id = $args['id'];

        $caixa = new Caixa();

        $resultado = $caixa->selectCaixa('*', array('id' => $id))[0];


        $usuario = $_SESSION['usuario_logado'];

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $data['informacoes'] = array(
            'menu_active' => 'caixa',
            'lista' => $resultado,
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/caixa");
        return $renderer->render($response, "edit.php", $data);
    }
    public function caixa_edit_data(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();

        $dataUrl = $args['id'];
        
        $emailUser = $_SESSION['usuario_logado']['email'];
        $usuario = new Usuario();
        $usuarioInfo = $usuario->selectUsuario('*', ['email' => $emailUser]);
        $idBarbeiro = $usuarioInfo[0]['id'];
        $comissao = $usuarioInfo[0]['comissao'];

        $caixa = new Caixa();
        $resultado = $caixa->selectPorData($dataUrl, $idBarbeiro);


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
        
        $valorComissao = $valorTotal * $comissao / 100;
        
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'caixa',
            'lista' => $resultado,
            'nome_logo' => $nome_logo_site,
            'dataUrl' => $dataUrl,
            'valorDoDia' => $valorTotal,
            'valorDinheiro' => $valorTotalDinheiro,
            'valorPix' => $valorTotalPix,
            'valorCartao' => $valorTotalCartao,
            'valorComissao' => $valorComissao,
            'usuario' => $usuario
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
    
        Usuario::verificarLogin();
        $emailUser = $_SESSION['usuario_logado']['email'];
        $usuario = new Usuario();
        $usuarioInfo = $usuario->selectUsuario('*', ['email' => $emailUser]);
        $idBarbeiro = $usuarioInfo[0]['id'];

        // Verifica se pelo menos um dos valores não é nulo antes de inserir no banco de dados
        if ($nome_cliente !== null || $data !== null || $dinheiro !== null || $pix !== null || $cartao !== null) {
            $camposPreenchidos = array_filter(array(
                'nome_cliente' => $nome_cliente,
                'data' => $data,
                'dinheiro' => $dinheiro,
                'pix' => $pix,
                'cartao' => $cartao,
                'id_barbeiro' => $idBarbeiro
            ));
            
            $caixa = new Caixa();
            $caixa->insertCaixa($camposPreenchidos);
    
            header('Location: '.URL_BASE.'admin/caixa-edit-data/'.$data);
            exit();
        } else {
            echo "Nenhum dos valores informados. Nada a ser inserido.";
        }
    }
    
    public function gerar_relatorio(
        ServerRequestInterface $request, 
        ResponseInterface $response
        )
    {
        $data1 = '';
        $data2 = '';
        $relatorio = [];

        if ($request->getMethod() === 'POST') {
            $params = $request->getParsedBody();
            if (isset($params['data1']) && isset($params['data2'])) {
                $data1 = $params['data1'];
                $data2 = $params['data2'];
                
                if($data1 === $data2){
                                             
                    $caixa = new Caixa();
                    Usuario::verificarLogin();
                    $emailUser = $_SESSION['usuario_logado']['email'];
                    $usuario = new Usuario();
                    $usuarioInfo = $usuario->selectUsuario('*', ['email' => $emailUser]);
                    $idBarbeiro = $usuarioInfo[0]['id'];
                    $comissao = $usuarioInfo[0]['comissao'];

                    $sql = "SELECT COUNT(*) AS total_caixa FROM caixa WHERE data = '$data1' AND caixa.id_barbeiro = '$idBarbeiro'";
                    $resultado = $caixa->querySelect($sql);
                    
                    $totalCaixa = $resultado[0]['total_caixa'];
                
                    
                   
            
                    $caixa = new Caixa();
                    $resultado1 = $caixa->selectPorData($data1, $idBarbeiro);

                    $valorTotal = '0';

                    foreach ($resultado1 as $registro) {
                        $valorTotal += $registro['dinheiro'] + $registro['pix'] + $registro['cartao'];
                    }
                    
                    $valorComissao = $valorTotal * $comissao / 100;

                    $responseData = ['relatorio' => $valorTotal, 'atendimento' => $totalCaixa, 'comissao' => $valorComissao];
                    $response = $response->withHeader('Content-Type', 'application/json');
                    $response->getBody()->write(json_encode($responseData));
                    return $response;
                } else{
                    $caixa = new Caixa();
                    Usuario::verificarLogin();
                    $emailUser = $_SESSION['usuario_logado']['email'];
                    $usuario = new Usuario();
                    $usuarioInfo = $usuario->selectUsuario('*', ['email' => $emailUser]);
                    $idBarbeiro = $usuarioInfo[0]['id'];
                    $comissao = $usuarioInfo[0]['comissao'];

                    $sql = "SELECT COUNT(*) AS total_caixa FROM caixa WHERE data BETWEEN '{$data1}' AND '{$data2}' AND caixa.id_barbeiro = '{$idBarbeiro}'";
                    $resultado = $caixa->querySelect($sql);
                    
                    $totalCaixa = $resultado[0]['total_caixa'];


                    $caixa = new Caixa();

                    $dataInicioW = date('Y-m-d', strtotime($data1));
                    $dataFimW = date('Y-m-d', strtotime($data2));
                    
                    $sql = "SELECT SUM(dinheiro) + SUM(pix) + SUM(cartao) as valorTotal FROM caixa WHERE data BETWEEN '{$data1}' AND '{$data2}' AND caixa.id_barbeiro = '{$idBarbeiro}'";
                    $resultado1 = $caixa->querySelect($sql);
                    
                    $relatorio = $resultado1[0]['valorTotal'];
                    $valorComissao = $relatorio * $comissao / 100;
                }

                $responseData = ['relatorio' => $relatorio,  'atendimento' => $totalCaixa , 'comissao' => $valorComissao];
                $response = $response->withHeader('Content-Type', 'application/json');
                $response->getBody()->write(json_encode($responseData));
                return $response;
            }
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
       
        $campos = array_filter(array(
            'nome_cliente' => $nome_cliente,
            'data' => $data
        ));

        $caixa = new Caixa();
        $caixa->updateCaixa($campos, array('id' => $id));
        

        $campos = array_filter(array(
            'cartao' => $cartao,
        ));
        $caixa = new Caixa();
        $caixa->updateCaixa($campos, array('id' => $id));


        $campos = array_filter(array(
            'dinheiro' => $dinheiro
        ));
        $caixa = new Caixa();
        $caixa->updateCaixa($campos, array('id' => $id));


        $campos = array_filter(array(
            'pix' => $pix
        ));
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