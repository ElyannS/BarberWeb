<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Venda;
use App\Model\Usuario;
use App\Model\Configuracao;
use App\Model\Produto;

final class VendaController 
{
    public function venda (
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        $servicos = new Venda();
    

        if(isset($_GET['pesquisa']) && $_GET['pesquisa'] !== ''){
            $lista = $servicos->selectVendaPesquisa($_GET['pesquisa']);
            $paginaAtual = 1;
            $proximaPagina = false;
            $paginaAnterior = false;
            
        } else{
            $limit = 7;
            $paginaAtual = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($paginaAtual * $limit) - $limit;
            
            $sqlDatasDistintas = "SELECT MAX(id) as id FROM vendas GROUP BY data ORDER BY data DESC LIMIT {$offset}, {$limit}";
            $datasDistintas = $servicos->querySelect($sqlDatasDistintas);
            
            $sqlCount = "SELECT COUNT(DISTINCT data) as total FROM vendas";
            $resultCount = $servicos->querySelect($sqlCount);
            $totalRegistros = $resultCount[0]['total'];
            $totalPaginas = ceil($totalRegistros / $limit);
            
            if (count($datasDistintas) > 0) {
                $proximaPagina = ($paginaAtual < $totalPaginas) ? URL_BASE."admin/venda?page=".($paginaAtual + 1) : false;
                $paginaAnterior = ($paginaAtual > 1) ? URL_BASE."admin/venda?page=".($paginaAtual - 1) : false;
              
                $ids = implode(',', array_column($datasDistintas, 'id'));
                $sqlLista = "SELECT * FROM vendas WHERE id IN ({$ids}) ORDER BY data DESC";
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
            'menu_active' => 'venda',
            'lista' => $lista,
            'paginaAtual' => $paginaAtual,
            'proximaPagina' => $proximaPagina,
            'paginaAnterior' => $paginaAnterior,
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/venda");
        return $renderer->render($response, "venda.php", $data);
    } 
    
   
    public function venda_create(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $produto = new Produto();
        $result = $produto->selectProduto('*', array('1'=>'1'));
        $resultID = $produto->selectProduto('*', array('id'=>2));
      

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'venda',
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario,
            'produto' => $result,
            'IDpro' => $resultID,
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/venda");
        return $renderer->render($response, "create.php", $data);
    }
    public function venda_relatorio(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'venda',
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/venda");
        return $renderer->render($response, "relatorio.php", $data);
    }

    public function venda_edit(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();

        $id = $args['id'];

        $caixa = new Venda();

        $resultado = $caixa->selectVenda('*', array('id' => $id))[0];

        $produto = new Produto();
        $result = $produto->selectProduto('*', array('1'=>'1'));
        
        $usuario = $_SESSION['usuario_logado'];

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $data['informacoes'] = array(
            'menu_active' => 'venda',
            'lista' => $resultado,
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario,
            'produto' => $result
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/venda");
        return $renderer->render($response, "edit.php", $data);
    }
    public function venda_edit_data(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();

        $dataUrl = $args['id'];


        $caixa = new Venda();
        $resultado = $caixa->selectPorData($dataUrl);

        $produto = new Produto();
        $result = $produto->selectProduto('*', array('1'=>'1'));


        
        $valorTotal = 0;
       
        foreach ($resultado as $registro) {
            // Soma os valores das colunas 'dinheiro', 'pix' e 'cartao'
            $valorTotal += $registro['dinheiro'];
        }
        
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'venda',
            'lista' => $resultado,
            'nome_logo' => $nome_logo_site,
            'dataUrl' => $dataUrl,
            'valorDoDia' => $valorTotal,
            'usuario' => $usuario,
            'produto' => $result
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/venda");
        return $renderer->render($response, "edit2.php", $data);
    }
    public function venda_insert(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $nome_cliente = $request->getParsedBody()['nome_cliente'] ?? null;
        $data = date('Y-m-d', strtotime($request->getParsedBody()['data'])) ?? null;
        $dinheiro = $request->getParsedBody()['dinheiro'] ?? null;
        $id_produto = $request->getParsedBody()['id_produto'] ?? null;
        $quantidade = $request->getParsedBody()['quantidade'] ?? null;
       
        $produto = new Produto();
        $result = $produto->selectProduto('*', array('id'=>$id_produto));

        $updateEstoque = $result[0]['estoque'] - $quantidade;
        $Estoque = array(
            'estoque' => $updateEstoque
        );
        $produto = new Produto();
        $produto->updateProduto($Estoque, array('id' => $id_produto));


        $camposPreenchidos = array(
            'data' => $data,
            'nome_cliente' => $nome_cliente,
            'id_produto' => $id_produto,
            'quantidade' => $quantidade,
            'dinheiro' => $dinheiro
        );
       
        
        $caixa = new Venda();
        $caixa->insertVenda($camposPreenchidos);

        header('Location: '.URL_BASE.'admin/venda-edit-data/'.$data);
        exit();
      
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
                                             
                    $caixa = new Venda();
                    Usuario::verificarLogin();
                    $emailUser = $_SESSION['usuario_logado']['email'];
                    $usuario = new Usuario();
                    $usuarioInfo = $usuario->selectUsuario('*', ['email' => $emailUser]);
                    $idBarbeiro = $usuarioInfo[0]['id'];
                    $comissao = $usuarioInfo[0]['comissao'];

                    $sql = "SELECT COUNT(*) AS total_caixa FROM caixa WHERE data = '$data1' AND caixa.id_barbeiro = '$idBarbeiro'";
                    $resultado = $caixa->querySelect($sql);
                    
                    $totalCaixa = $resultado[0]['total_caixa'];
                
                    
                   
            
                    $caixa = new Venda();
                    $resultado1 = $caixa->selectPorData($data1, $idBarbeiro);

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
                    
                    $valorComissao = $valorTotal * $comissao / 100;

                    $responseData = ['relatorio' => $valorTotal, 'atendimento' => $totalCaixa, 'comissao' => $valorComissao, 
                    'dinheiro' => $valorTotalDinheiro, 'pix' => $valorTotalPix, 'cartao' => $valorTotalCartao];
                    $response = $response->withHeader('Content-Type', 'application/json');
                    $response->getBody()->write(json_encode($responseData));
                    return $response;
                } else{
                    $caixa = new Venda();
                    Usuario::verificarLogin();
                    $emailUser = $_SESSION['usuario_logado']['email'];
                    $usuario = new Usuario();
                    $usuarioInfo = $usuario->selectUsuario('*', ['email' => $emailUser]);
                    $idBarbeiro = $usuarioInfo[0]['id'];
                    $comissao = $usuarioInfo[0]['comissao'];

                    $sql = "SELECT COUNT(*) AS total_caixa FROM caixa WHERE data BETWEEN '{$data1}' AND '{$data2}' AND caixa.id_barbeiro = '{$idBarbeiro}'";
                    $resultado = $caixa->querySelect($sql);
                    
                    $totalCaixa = $resultado[0]['total_caixa'];


                    $caixa = new Venda();

                    $dataInicioW = date('Y-m-d', strtotime($data1));
                    $dataFimW = date('Y-m-d', strtotime($data2));
                    
                    $sql = "SELECT SUM(dinheiro) + SUM(pix) + SUM(cartao) as valorTotal FROM caixa WHERE data BETWEEN '{$data1}' AND '{$data2}' AND caixa.id_barbeiro = '{$idBarbeiro}'";
                    $resultado1 = $caixa->querySelect($sql);
                    
                    $relatorio = $resultado1[0]['valorTotal'];
                    $valorComissao = $relatorio * $comissao / 100;

                    $sql = "SELECT * FROM caixa WHERE data BETWEEN '{$data1}' AND '{$data2}' AND caixa.id_barbeiro = '{$idBarbeiro}'";
                    $caixaDPC = $caixa->querySelect($sql);
                    
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

                $responseData = ['relatorio' => $relatorio,  'atendimento' => $totalCaixa , 'comissao' => $valorComissao, 'dinheiro' => $valorTotalDinheiro, 'pix' => $valorTotalPix, 'cartao' => $valorTotalCartao];
                $response = $response->withHeader('Content-Type', 'application/json');
                $response->getBody()->write(json_encode($responseData));
                return $response;
            }
        }
    }

//UPDATE venda

    public function venda_update(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $request->getParsedBody()['id'];
        $nome_cliente = $request->getParsedBody()['nome_cliente'];
        $data = $request->getParsedBody()['data'];
        $dinheiro = $request->getParsedBody()['dinheiro'];
        $quantidade = $request->getParsedBody()['quantidade'];
        $id_produto = $request->getParsedBody()['id_produto'];
       
        $produto = new Produto();
        $result = $produto->selectProduto('*', array('id'=>$id_produto));

        $updateEstoque = $result[0]['estoque'] - $quantidade;
        $Estoque = array(
            'estoque' => $updateEstoque
        );
        $produto = new Produto();
        $produto->updateProduto($Estoque, array('id' => $id_produto));


        $campos = array_filter(array(
            'nome_cliente' => $nome_cliente,
            'data' => $data
        ));

        $caixa = new Venda();
        $caixa->updateVenda($campos, array('id' => $id));
        

        $campos = array_filter(array(
            'id_produto' => $id_produto,
        ));
        $caixa = new Venda();
        $caixa->updateVenda($campos, array('id' => $id));


        $campos = array_filter(array(
            'dinheiro' => $dinheiro
        ));
        $caixa = new Venda();
        $caixa->updateVenda($campos, array('id' => $id));


        $campos = array_filter(array(
            'quantidade' => $quantidade
        ));
        $caixa = new Venda();
        $caixa->updateVenda($campos, array('id' => $id));


        header('Location: '.URL_BASE.'admin/venda-edit-data/'.$data);
        exit();
    }

    public function venda_delete(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $data = $request->getParsedBody()['data'];
       $id = $request->getParsedBody()['id'];

       $caixa = new Venda();

       $caixa->deleteVenda('id', $id);

       header('Location: '.URL_BASE.'admin/venda');
       exit();

    }
    public function venda_total_delete(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $data = $request->getParsedBody()['data'];
  

       $caixa = new Venda();

       $caixa->deleteVenda('data', $data);

       header('Location: '.URL_BASE.'admin/venda');
       exit();

    }

} 