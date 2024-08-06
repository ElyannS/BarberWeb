<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Usuario;
use App\Model\Configuracao;
use App\Model\Produto;

final class ProdutoController 
{
     
    public function produtos(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        $produtos = new Produto();
        $resultadoProduto = $produtos->selectProduto('*' , array('1'=>'1'));
        
        $totalLucroEstoque = 0;
        $totalValorEstoque = 0;
        
        foreach ($resultadoProduto as $registro) {
            // Cálculo do lucro total do estoque
            $lucroPorProduto = $registro['lucro'] * $registro['estoque'];
            $totalLucroEstoque += $lucroPorProduto;
        
            // Cálculo do valor total do estoque com base no valor de venda
            $valorVendaPorProduto = $registro['vlrVenda'] * $registro['estoque'];
            $totalValorEstoque += $valorVendaPorProduto;
        }
        
        if(isset($_GET['pesquisa']) && $_GET['pesquisa'] !== ''){
            $lista = $produtos->selectProdutosPesquisa($_GET['pesquisa']);
            $paginaAtual = 1;
            $proximaPagina = false;
            $paginaAnterior = false;
            
        } else{
            $limit = 10;
            $paginaAtual = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($paginaAtual*$limit) - $limit;

            $qntTotal = count($produtos->selectProduto('*' , array('1'=>'1')));

            $proximaPagina = ($qntTotal > ($paginaAtual*$limit)) ? URL_BASE."admin/produtos?page=".($paginaAtual+1) : false;

            $paginaAnterior = ($paginaAtual > 1) ? URL_BASE."admin/produtos?page=".($paginaAtual-1) : false;

            $lista = $produtos->selectProdutosPage($limit, $offset);
        }

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');
        
        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'produtos',
            'lista' => $lista,
            'paginaAtual' => $paginaAtual,
            'proximaPagina' => $proximaPagina,
            'paginaAnterior' => $paginaAnterior,
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario,
            'lucro' => $totalLucroEstoque,
            'valorEstoque' => $totalValorEstoque
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/produtos");
        return $renderer->render($response, "produtos.php", $data);
    }
    public function produtos_create(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        $produtos = new Produto();

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'produtos',
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/produtos");
        return $renderer->render($response, "create.php", $data);
    }
    public function produtos_edit(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        $produtos = new Produto();

        $id = $args['id'];


        $resultado = $produtos->selectProduto('*', array('id' => $id))[0];

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'produtos',
            'produtos' => $resultado,
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/produtos");
        return $renderer->render($response, "edit.php", $data);
    }
    public function produtos_insert(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $parsedBody = $request->getParsedBody();
        $descr = $parsedBody['descricao'] ?? '';
        $barras = $parsedBody['barras'] ?? '';
        $vlrCusto = isset($parsedBody['vlrCusto']) ? $parsedBody['vlrCusto'] : 0.0;
        $vlrVenda = isset($parsedBody['vlrVenda']) ? $parsedBody['vlrVenda'] : 0.0;
        $estoque = isset($parsedBody['estoque']) ? $parsedBody['estoque'] : 0;
        $lucro = $vlrVenda - $vlrCusto;
    
        $campos = array(
            'descricao' => $descr,
            'barras' => $barras,
            'vlrCusto' => $vlrCusto,
            'vlrVenda' => $vlrVenda,
            'estoque' => $estoque,
            'lucro' => $lucro
        );
        
        $produtos = new Produto();
        $produtos->insertProduto($campos);
    
        header('Location: '.URL_BASE.'admin/produtos');
        exit();
    }
    


//UPDATE SERVIÇOS

public function produtos_update(
    ServerRequestInterface $request, 
    ResponseInterface $response,
    $args
) {
    $parsedBody = $request->getParsedBody();
    $id = $parsedBody['id'] ?? null;
    $descr = $parsedBody['descricao'] ?? '';
    $barras = $parsedBody['barras'] ?? '';
    $vlrCusto = isset($parsedBody['vlrCusto']) ? $parsedBody['vlrCusto'] : 0.0;
    $vlrVenda = isset($parsedBody['vlrVenda']) ? $parsedBody['vlrVenda'] : 0.0;
    $estoque = isset($parsedBody['estoque']) ? $parsedBody['estoque'] : 0;
    $lucro = $vlrVenda - $vlrCusto;
  
    $campos = array(
        'descricao' => $descr,
        'barras' => $barras,
        'vlrCusto' => $vlrCusto,
        'vlrVenda' => $vlrVenda,
        'estoque' => $estoque,
        'lucro' => $lucro
    );
    

    $produtos = new Produto();
    $produtos->updateProduto($campos, array('id' => $id));
    
    header('Location: '.URL_BASE.'admin/produtos');
    exit();
}


    public function produtos_delete(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
       $id = $request->getParsedBody()['id'];

       $produtos = new Produto();

       $produtos->deleteProduto('id', $id);

       header('Location: '.URL_BASE.'admin/produtos');
       exit();
    }

} 