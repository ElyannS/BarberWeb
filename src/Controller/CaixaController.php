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
            $offset = ($paginaAtual*$limit) - $limit;

            $qntTotal = count($servicos->selectCaixa('*' , array('1'=>'1')));

            $proximaPagina = ($qntTotal > ($paginaAtual*$limit)) ? URL_BASE."admin/caixa?page=".($paginaAtual+1) : false;

            $paginaAnterior = ($paginaAtual > 1) ? URL_BASE."admin/caixa?page=".($paginaAtual-1) : false;

            $lista = $servicos->selectCaixaPage($limit, $offset);
        }
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');
        $data['informacoes'] = array(
            'menu_active' => 'servicos',
            'lista' => $lista,
            'paginaAtual' => $paginaAtual,
            'proximaPagina' => $proximaPagina,
            'paginaAnterior' => $paginaAnterior,
            'nome_logo' => $nome_logo_site
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/caixa");
        return $renderer->render($response, "caixa.php", $data);
    }
    public function caixa_create(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        
        $data['informacoes'] = array(
            'menu_active' => 'caixa',
    
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

        $servicos = new Caixa();

        $resultado = $servicos->selectCaixa('*', array('id' => $id))[0];

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');
        $data['informacoes'] = array(
            'menu_active' => 'servicos',
            'servico' => $resultado,
            'nome_logo' => $nome_logo_site
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/caixa");
        return $renderer->render($response, "edit.php", $data);
    }
    public function caixa_insert(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $titulo = $request->getParsedBody()['titulo'];
        $data = $request->getParsedBody()['data'];
        $descricao = $request->getParsedBody()['descricao'];
        $tempo_servico = $request->getParsedBody()['tempo_servico'];

        $nome_imagem_principal = "";

        if($request->getUploadedFiles()['imagem_principal']) {
            $imagem_principal = $request->getUploadedFiles()['imagem_principal'];
        } else {
            $imagem_principal = false;
        }

        if($imagem_principal) {
            if ($imagem_principal->getError() === UPLOAD_ERR_OK) {
                $extensao = pathinfo($imagem_principal->getClientFilename(), PATHINFO_EXTENSION);

                $nome = md5(uniqid(rand(), true)).pathinfo($imagem_principal->getClientFilename(), PATHINFO_FILENAME).".".$extensao;

                $nome_imagem_principal = "resources/imagens/" . $nome;

                $imagem_principal->moveTo($nome_imagem_principal);
            }
        }

        $campos = array(
            'titulo' => $titulo,
            'url_amigavel' => $this->gerarUrlAmigavel($titulo),
            'descricao' => $descricao,
            'imagem_principal' => $nome_imagem_principal,
            'data_cadastro' => $data,
            'tempo_servico' => $tempo_servico
        );
        
        $servicos = new Caixa();
        
        $servicos->insertServico($campos);

        $id_servico = $servicos->getUltimoServico()['id'];


        header('Location: '.URL_BASE.'admin/caixa');
        exit();
    }


//UPDATE SERVIÇOS

    public function caixa_update(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $request->getParsedBody()['id'];
        $titulo = $request->getParsedBody()['titulo'];
        $data = $request->getParsedBody()['data'];
        $descricao = $request->getParsedBody()['descricao'];
        $tempo_servico = $request->getParsedBody()['tempo_servico'];
        

        $nome_imagem_atual = $request->getParsedBody()['nome_imagem_atual'];

        $imagem_atualizar = false;

        if($request->getUploadedFiles()['imagem_principal']->getClientFilename() !== '') {
            $imagem_atualizar = true;
            $nome_imagem_principal = "";

            //Usuario quer atualizar a imagem principal
            if($request->getUploadedFiles()['imagem_principal']) {
                $imagem_principal = $request->getUploadedFiles()['imagem_principal'];
            } else {
                $imagem_principal = false;
            }
    
            if($imagem_principal) {
                if ($imagem_principal->getError() === UPLOAD_ERR_OK) {
                    $extensao = pathinfo($imagem_principal->getClientFilename(), PATHINFO_EXTENSION);
    
                    $nome = md5(uniqid(rand(), true)).pathinfo($imagem_principal->getClientFilename(), PATHINFO_FILENAME).".".$extensao;
    
                    $nome_imagem_principal = "resources/imagens/" . $nome;
    
                    $imagem_principal->moveTo($nome_imagem_principal);

                    unlink($nome_imagem_atual); // deleta as imagens do diretorio
                }
            }
        }

        $campos = array(
            'id' => $id,
            'titulo' => $titulo,
            'url_amigavel' => $this->gerarUrlAmigavel($titulo),
            'descricao' => $descricao,
            'data_cadastro' => $data,
            'tempo_servico' => $tempo_servico
            
        );
        if($imagem_atualizar) {
            $campos['imagem_principal'] = $nome_imagem_principal;
        }
        
        $servicos = new Caixa();
        
        $servicos->updateServico($campos, array('id' => $id));
        
        header('Location: '.URL_BASE.'admin/caixa');
        exit();
    }

    public function caixa_delete(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
       $id = $request->getParsedBody()['id'];

       $servicos = new Caixa();

       $resultado = $servicos->selectServico('*', array('id' => $id))[0];

       unlink($resultado['imagem_principal']);

       $servicos->deleteServico('id', $id);

       header('Location: '.URL_BASE.'admin/caixa');
       exit();
    }
} 