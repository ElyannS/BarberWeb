<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Despesa;
use App\Model\Caixa;
use App\Model\Usuario;
use App\Model\Configuracao;

final class DespesaController {
    public function despesa (
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        $servicos = new Despesa();
        $emailUser = $_SESSION['usuario_logado']['email'];
        $usuario = new Usuario();
        $usuarioInfo = $usuario->selectUsuario('*', ['email' => $emailUser]);
        $idBarbeiro = $usuarioInfo[0]['id'];

        if(isset($_GET['pesquisa']) && $_GET['pesquisa'] !== ''){
            $lista = $servicos->selectCaixaPesquisa($_GET['pesquisa'], $idBarbeiro);
            $paginaAtual = 1;
            $proximaPagina = false;
            $paginaAnterior = false;
            
        } else{
            $limit = 7;
            $paginaAtual = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($paginaAtual * $limit) - $limit;
            
            $sqlDatasDistintas = "SELECT MAX(id) as id FROM despesas GROUP BY data ORDER BY data DESC LIMIT {$offset}, {$limit}";
            $datasDistintas = $servicos->querySelect($sqlDatasDistintas);
            
            $sqlCount = "SELECT COUNT(DISTINCT data) as total FROM despesas";
            $resultCount = $servicos->querySelect($sqlCount);
            $totalRegistros = $resultCount[0]['total'];
            $totalPaginas = ceil($totalRegistros / $limit);
            
            if (count($datasDistintas) > 0) {
                $proximaPagina = ($paginaAtual < $totalPaginas) ? URL_BASE."admin/despesas?page=".($paginaAtual + 1) : false;
                $paginaAnterior = ($paginaAtual > 1) ? URL_BASE."admin/despesas?page=".($paginaAtual - 1) : false;
              
                $ids = implode(',', array_column($datasDistintas, 'id'));
                $sqlLista = "SELECT * FROM despesas WHERE id IN ({$ids}) AND despesas.id_barbeiro = {$idBarbeiro} ORDER BY data DESC";
                $lista = $servicos->querySelect($sqlLista);
            } else {
                $lista = [];
                $proximaPagina = false;
                $paginaAnterior = false;
            }  
        }

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'despesa',
            'lista' => $lista,
            'paginaAtual' => $paginaAtual,
            'proximaPagina' => $proximaPagina,
            'paginaAnterior' => $paginaAnterior,
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/despesa");
        return $renderer->render($response, "despesa.php", $data);
    } 
    
   
    public function despesa_create(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'despesa',
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/despesa");
        return $renderer->render($response, "create.php", $data);
    }
    public function despesa_relatorio(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'despesa',
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/despesa");
        return $renderer->render($response, "relatorio.php", $data);
    }

    public function despesa_edit(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();

        $id = $args['id'];

        $despesa = new Despesa();

        $resultado = $despesa->selectDespesa('*', array('id' => $id))[0];


        $usuario = $_SESSION['usuario_logado'];

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $data['informacoes'] = array(
            'menu_active' => 'despesa',
            'lista' => $resultado,
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/despesa");
        return $renderer->render($response, "edit.php", $data);
    }
    public function despesa_edit_data(
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

        $despesa = new Despesa();
        $resultado = $despesa->selectPorData($dataUrl, $idBarbeiro);


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

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'despesa',
            'lista' => $resultado,
            'nome_logo' => $nome_logo_site,
            'dataUrl' => $dataUrl,
            'valorDoDia' => $valorTotal,
            'valorDinheiro' => $valorTotalDinheiro,
            'valorPix' => $valorTotalPix,
            'valorCartao' => $valorTotalCartao,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/despesa");
        return $renderer->render($response, "edit2.php", $data);
    }
    public function despesa_insert(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $nome_despesa = $request->getParsedBody()['nome_despesa'] ?? null;
        $data = $request->getParsedBody()['data'] ?? null;
        $dinheiro = $request->getParsedBody()['dinheiro'] ?? null;
        $pix = $request->getParsedBody()['pix'] ?? null;
        $cartao = $request->getParsedBody()['cartao'] ?? null;
    
        // Verifica e faz trim somente se a variável não for nula
        $nome_despesa = ($nome_despesa !== null) ? trim($nome_despesa) : null;
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
        if ($nome_despesa !== null || $data !== null || $dinheiro !== null || $pix !== null || $cartao !== null) {
            $camposPreenchidos = array_filter(array(
                'nome_despesa' => $nome_despesa,
                'data' => $data,
                'dinheiro' => $dinheiro,
                'pix' => $pix,
                'cartao' => $cartao,
                'id_barbeiro' => $idBarbeiro
            ));
            
            $despesa = new Despesa();
            $despesa->insertDespesa($camposPreenchidos);
    
            header('Location: '.URL_BASE.'admin/despesa-edit-data/'.$data);
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
                                             
                    $despesa = new Despesa();
                    Usuario::verificarLogin();
                    $emailUser = $_SESSION['usuario_logado']['email'];
                    $usuario = new Usuario();
                    $usuarioInfo = $usuario->selectUsuario('*', ['email' => $emailUser]);
                    $idBarbeiro = $usuarioInfo[0]['id'];
                    $comissao = $usuarioInfo[0]['comissao'];

                    $sql = "SELECT COUNT(*) AS total_caixa FROM despesas WHERE data = '$data1' AND despesas.id_barbeiro = '$idBarbeiro'";
                    $resultado = $despesa->querySelect($sql);
                    
                    $totalCaixa = $resultado[0]['total_caixa'];
                
                    
                   
            
                    $despesa = new Despesa();
                    $resultado1 = $despesa->selectPorData($data1, $idBarbeiro);

                    $valorTotal = '0';

                    $valorTotalDinheiro = 0;
                    $valorTotalPix = 0;
                    $valorTotalCartao = 0;
                    $valorTotal = 0;
                    foreach ($resultado1 as $registro) {
                        $valorTotalDinheiro += $registro['dinheiro'];
                    }
                    foreach ($resultado1 as $registro) {
                        $valorTotalPix += $registro['pix'];
                    }
                    foreach ($resultado1 as $registro) {
                        $valorTotalCartao += $registro['cartao'];
                    }

                    foreach ($resultado1 as $registro) {
                        $valorTotal += $registro['dinheiro'] + $registro['pix'] + $registro['cartao'];
                    }
                    

                    $caixa = new Caixa();
                    $consultaCaixa = $caixa->selectPorData($data1, $idBarbeiro);

                    $valorCaixa = 0;
                    $saldo = 0;
                    foreach ($consultaCaixa as $registro) {
                        $valorCaixa += $registro['dinheiro'] + $registro['pix'] + $registro['cartao'];
                    }
                    $resultCaixa = $valorCaixa * $comissao / 100;
                    $saldo = $resultCaixa - $valorTotal;

                    $responseData = ['relatorio' => $valorTotal, 'atendimento' => $totalCaixa,'dinheiro' => $valorTotalDinheiro, 'pix' => $valorTotalPix, 'cartao' => $valorTotalCartao, 'saldo' => $saldo];
                    $response = $response->withHeader('Content-Type', 'application/json');
                    $response->getBody()->write(json_encode($responseData));
                    return $response;
                } else{
                    $despesa = new Despesa();
                    Usuario::verificarLogin();
                    $emailUser = $_SESSION['usuario_logado']['email'];
                    $usuario = new Usuario();
                    $usuarioInfo = $usuario->selectUsuario('*', ['email' => $emailUser]);
                    $idBarbeiro = $usuarioInfo[0]['id'];
                    $comissao = $usuarioInfo[0]['comissao'];

                    $sql = "SELECT COUNT(*) AS total_caixa FROM despesas WHERE data BETWEEN '{$data1}' AND '{$data2}' AND despesas.id_barbeiro = '{$idBarbeiro}'";
                    $resultado = $despesa->querySelect($sql);
                    
                    $totalCaixa = $resultado[0]['total_caixa'];


                    $despesa = new Despesa();

                    $dataInicioW = date('Y-m-d', strtotime($data1));
                    $dataFimW = date('Y-m-d', strtotime($data2));
                    
                    $sql = "SELECT SUM(dinheiro) + SUM(pix) + SUM(cartao) as valorTotal FROM despesas WHERE data BETWEEN '{$data1}' AND '{$data2}' AND despesas.id_barbeiro = '{$idBarbeiro}'";
                    $resultado1 = $despesa->querySelect($sql);
                    
                    $relatorio = $resultado1[0]['valorTotal'];
                  
                    $sql = "SELECT * FROM despesas WHERE data BETWEEN '{$data1}' AND '{$data2}' AND despesas.id_barbeiro = '{$idBarbeiro}'";
                    $caixaDPC = $despesa->querySelect($sql);
                    
                    $valorTotalDinheiro = 0;
                    $valorTotalPix = 0;
                    $valorTotalCartao = 0;
                    $valorTotal = 0;
                    foreach ($caixaDPC as $registro) {
                        $valorTotalDinheiro += $registro['dinheiro'];
                    }
                    foreach ($caixaDPC as $registro) {
                        $valorTotalPix += $registro['pix'];
                    }
                    foreach ($caixaDPC as $registro) {
                        $valorTotalCartao += $registro['cartao'];
                    }
                }

                $valorCaixa = 0;
                $saldo = 0;
                
                $caixa = new Caixa();
                $sql = "SELECT SUM(dinheiro) + SUM(pix) + SUM(cartao) as valorTotal FROM caixa WHERE data BETWEEN '{$data1}' AND '{$data2}' AND caixa.id_barbeiro = '{$idBarbeiro}'";
                $consultaCaixa = $caixa->querySelect($sql);

                $valorCaixa = $consultaCaixa[0]['valorTotal'];

                $resultCaixa = $valorCaixa * $comissao / 100;
                $saldo = $resultCaixa - $relatorio;


                $responseData = ['relatorio' => $relatorio,  'atendimento' => $totalCaixa , 'dinheiro' => $valorTotalDinheiro, 'pix' => $valorTotalPix, 'cartao' => $valorTotalCartao, 'saldo' => $saldo];
                $response = $response->withHeader('Content-Type', 'application/json');
                $response->getBody()->write(json_encode($responseData));
                return $response;
            }
        }
    }

//UPDATE DESPESAS

    public function despesa_update(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $request->getParsedBody()['id'];
        $nome_despesa = $request->getParsedBody()['nome_despesa'];
        $data = $request->getParsedBody()['data'];
        $dinheiro = $request->getParsedBody()['dinheiro'];
        $pix = $request->getParsedBody()['pix'];
        $cartao = $request->getParsedBody()['cartao'];
       
        $campos = array_filter(array(
            'nome_despesa' => $nome_despesa,
            'data' => $data
        ));

        $despesa = new Despesa();
        $despesa->updateDespesa($campos, array('id' => $id));
        

        $campos = array_filter(array(
            'cartao' => $cartao,
        ));
        $despesa = new Despesa();
        $despesa->updateDespesa($campos, array('id' => $id));


        $campos = array_filter(array(
            'dinheiro' => $dinheiro
        ));
        $despesa = new Despesa();
        $despesa->updateDespesa($campos, array('id' => $id));


        $campos = array_filter(array(
            'pix' => $pix
        ));
        $despesa = new Despesa();
        $despesa->updateDespesa($campos, array('id' => $id));


        header('Location: '.URL_BASE.'admin/despesa-edit-data/'.$data);
        exit();
    }

    public function despesa_delete(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $data = $request->getParsedBody()['data'];
       $id = $request->getParsedBody()['id'];

       $despesa = new Despesa();

       $despesa->deleteDespesa('id', $id);

       header('Location: '.URL_BASE.'admin/despesa');
       exit();

    }
    public function despesa_total_delete(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $data = $request->getParsedBody()['data'];
  

       $despesa = new Despesa();

       $despesa->deleteDespesa('data', $data);

       header('Location: '.URL_BASE.'admin/despesa');
       exit();

    }

} 