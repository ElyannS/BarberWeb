<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Video;
use App\Model\Usuario;
use App\Model\Configuracao;


final class VideoController
{
    function __construct()
    {
        Usuario::verificarLogin();
    }
    public function videos(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $videos = new Video();

        if(isset($_GET['pesquisa']) && $_GET['pesquisa'] !== ''){
            $lista = $videos->selectVideosPesquisa($_GET['pesquisa']);
            $paginaAtual = 1;
            $proximaPagina = false;
            $paginaAnterior = false;
            
        } else{
            $limit = 10;
            $paginaAtual = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($paginaAtual*$limit) - $limit;

            $qntTotal = count($videos->selectVideo('*' , array('1'=>'1')));

            $proximaPagina = ($qntTotal > ($paginaAtual*$limit)) ? URL_BASE."admin/videos?page=".($paginaAtual+1) : false;

            $paginaAnterior = ($paginaAtual > 1) ? URL_BASE."admin/videos?page=".($paginaAtual-1) : false;

            $lista = $videos->selectVideosPage($limit, $offset);
        }
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $data['informacoes'] = array(
            'menu_active' => 'videos',
            'lista' => $lista,
            'paginaAtual' => $paginaAtual,
            'proximaPagina' => $proximaPagina,
            'paginaAnterior' => $paginaAnterior,
            'nome_logo' => $nome_logo_site
        );

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/video");
        return $renderer->render($response, "videos.php", $data);
    }
    public function videos_create(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $data['informacoes'] = array(
            'menu_active' => 'videos',
            'nome_logo' => $nome_logo_site
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/video");
        return $renderer->render($response, "create.php", $data);
    }
    public function videos_edit(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $args['id'];

        $videos = new video();

        $resultado = $videos->selectVideo('*', array('id' => $id))[0];

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $data['informacoes'] = array(
            'menu_active' => 'videos',
            'video' => $resultado,
            'nome_logo' => $nome_logo_site
        );

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/video");
        return $renderer->render($response, "edit.php", $data);
    }


    public function videos_insert(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $titulo = $request->getParsedBody()['titulo'];
        $data = $request->getParsedBody()['data'];
        $link_video = $request->getParsedBody()['link_video'];
        $status = $request->getParsedBody()['ativo'];

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

                $nome_imagem_principal = "resources/imagens/videos/" . $nome;

                $imagem_principal->moveTo($nome_imagem_principal);
            }
        }

        $campos = array(
            'titulo' => $titulo,
            'link_video' => $link_video,
            'imagem_principal' => $nome_imagem_principal,
            'data_cadastro' => $data,
            'status' => $status
        );
        
        $videos = new Video();
        
        $videos->insertVideo($campos);

        header('Location: '.URL_BASE.'admin/videos');
        exit();
    }

    public function videos_update(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $request->getParsedBody()['id'];
        $titulo = $request->getParsedBody()['titulo'];
        $data = $request->getParsedBody()['data'];
        $link_video = $request->getParsedBody()['link_video'];
        $status = $request->getParsedBody()['ativo'];
        

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
    
                    $nome_imagem_principal = "resources/imagens/videos/" . $nome;
    
                    $imagem_principal->moveTo($nome_imagem_principal);

                    unlink($nome_imagem_atual); // deleta as imagens do diretorio
                }
            }
        }

        $campos = array(
            'id' => $id,
            'titulo' => $titulo,
            'link_video' => $link_video,
            'data_cadastro' => $data,
            'status' => $status
        );
        if($imagem_atualizar) {
            $campos['imagem_principal'] = $nome_imagem_principal;
        }
        
        $videos = new Video();
        
        $videos->updateVideo($campos, array('id' => $id));


        header('Location: '.URL_BASE.'admin/videos');
        exit();
    }


    public function videos_delete(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
       $id = $request->getParsedBody()['id'];

       $videos = new Video();

       $resultado = $videos->selectVideo('*', array('id' => $id))[0];

       unlink($resultado['imagem_principal']);

       $videos->deleteVideo('id', $id);

       header('Location: '.URL_BASE.'admin/videos');
       exit();
    }

}