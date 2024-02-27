<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Recomendacao;
use App\Model\Usuario;
use App\Model\Configuracao;

final class RecomendacoesController
{
    function __construct()
    {
        Usuario::verificarLogin();
    }
    public function recomendacoes(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $recomendacoes = new Recomendacao();

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        if(isset($_GET['pesquisa']) && $_GET['pesquisa'] !== ''){
            $lista = $recomendacoes->selectRecomendacoesPesquisa($_GET['pesquisa']);
            $paginaAtual = 1;
            $proximaPagina = false;
            $paginaAnterior = false;
            
        } else{
            $limit = 10;
            $paginaAtual = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($paginaAtual*$limit) - $limit;

            $qntTotal = count($recomendacoes->selectRecomendacao('*' , array('1'=>'1')));

            $proximaPagina = ($qntTotal > ($paginaAtual*$limit)) ? URL_BASE."admin/recomendacoes?page=".($paginaAtual+1) : false;

            $paginaAnterior = ($paginaAtual > 1) ? URL_BASE."admin/recomendacoes?page=".($paginaAtual-1) : false;

            $lista = $recomendacoes->selectRecomendacoesPage($limit, $offset);
        }

        $data['informacoes'] = array(
            'menu_active' => 'recomendacoes',
            'lista' => $lista,
            'paginaAtual' => $paginaAtual,
            'proximaPagina' => $proximaPagina,
            'paginaAnterior' => $paginaAnterior,
            'nome_logo' => $nome_logo_site
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/recomendacao");
        return $renderer->render($response, "recomendacoes.php", $data);
    }
    public function recomendacoes_create(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $data['informacoes'] = array(
            'menu_active' => 'recomendacoes',
            'nome_logo' => $nome_logo_site
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/recomendacao");
        return $renderer->render($response, "create.php", $data);
    }
    public function recomendacoes_edit(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $args['id'];

        $recomendacoes = new Recomendacao();

        $resultado = $recomendacoes->selectRecomendacao('*', array('id' => $id))[0];

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $data['informacoes'] = array(
            'menu_active' => 'recomendacoes',
            'recomendacao' => $resultado,
            'nome_logo' => $nome_logo_site
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/recomendacao");
        return $renderer->render($response, "edit.php", $data);
    }


    public function recomendacoes_insert(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $nome = $request->getParsedBody()['nome'];
        $profissao = $request->getParsedBody()['profissao'];
        $avaliacao = $request->getParsedBody()['avaliacao'];
        $data = $request->getParsedBody()['data'];
        $descricao = $request->getParsedBody()['descricao'];
        $status = $request->getParsedBody()['ativo'];

        $nome_foto_cliente = "";

        if($request->getUploadedFiles()['foto_cliente']) {
            $foto_cliente = $request->getUploadedFiles()['foto_cliente'];
        } else {
            $foto_cliente = false;
        }

        if($foto_cliente) {
            if ($foto_cliente->getError() === UPLOAD_ERR_OK) {
                $extensao = pathinfo($foto_cliente->getClientFilename(), PATHINFO_EXTENSION);

                $nome_imagem = md5(uniqid(rand(), true)).pathinfo($foto_cliente->getClientFilename(), PATHINFO_FILENAME).".".$extensao;

                $nome_foto_cliente = "resources/imagens/cliente/" . $nome_imagem;

                $foto_cliente->moveTo($nome_foto_cliente);
            }
        }

        $campos = array(
            'nome' => $nome,
            'profissao' => $profissao,
            'descricao' => $descricao,
            'avaliacao' => $avaliacao,
            'foto_cliente' => $nome_foto_cliente,
            'data_cadastro' => $data,
            'status' => $status
        );
        
        $recomendacoes = new Recomendacao();
        
        $recomendacoes->insertRecomendacao($campos);

       
        header('Location: '.URL_BASE.'admin/recomendacoes');
        exit();
    } 


    public function recomendacoes_update(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $request->getParsedBody()['id'];
        $nome = $request->getParsedBody()['nome'];
        $profissao = $request->getParsedBody()['profissao'];
        $avaliacao = $request->getParsedBody()['avaliacao'];
        $data = $request->getParsedBody()['data'];
        $descricao = $request->getParsedBody()['descricao'];
        $status = $request->getParsedBody()['ativo'];

        $nome_imagem_atual = $request->getParsedBody()['nome_imagem_atual'];

        $imagem_atualizar = false;

        if($request->getUploadedFiles()['imagem_principal']->getClientFilename() !== '') {
            $imagem_atualizar = true;
            $nome_foto_cliente = "";

            //Usuario quer atualizar a imagem principal
            if($request->getUploadedFiles()['imagem_principal']) {
                $foto_cliente = $request->getUploadedFiles()['imagem_principal'];
            } else {
                $foto_cliente = false;
            }
    
            if($foto_cliente) {
                if ($foto_cliente->getError() === UPLOAD_ERR_OK) {
                    $extensao = pathinfo($foto_cliente->getClientFilename(), PATHINFO_EXTENSION);
    
                    $nome_imagem = md5(uniqid(rand(), true)).pathinfo($foto_cliente->getClientFilename(), PATHINFO_FILENAME).".".$extensao;
    
                    $nome_foto_cliente = "resources/imagens/cliente/" . $nome_imagem;
    
                    $foto_cliente->moveTo($nome_foto_cliente);

                    unlink($nome_imagem_atual); // deleta as imagens do diretorio
                }
            }
        }

        $campos = array(
            'id' => $id,
            'nome' => $nome,
            'profissao' => $profissao,
            'descricao' => $descricao,
            'avaliacao' => $avaliacao,
            'data_cadastro' => $data,
            'status' => $status
        );
        if($imagem_atualizar) {
            $campos['foto_cliente'] = $nome_foto_cliente;
        }
        
        $recomendacoes = new Recomendacao();
        
        $recomendacoes->updateRecomendacao($campos, array('id' => $id));

        header('Location: '.URL_BASE.'admin/recomendacoes');
        exit();
    }


    public function recomendacoes_delete(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
       $id = $request->getParsedBody()['id'];

       $recomendacoes = new Recomendacao();

       $resultado = $recomendacoes->selectRecomendacao('*', array('id' => $id))[0];

       unlink($resultado['foto_cliente']);

       $recomendacoes->deleteRecomendacao('id', $id);

       header('Location: '.URL_BASE.'admin/recomendacoes');
       exit();
    }

}