<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Servico;
use App\Model\Usuario;
use App\Model\Configuracao;

final class ServicoController 
{
     
    public function servicos(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        $servicos = new Servico();

        if(isset($_GET['pesquisa']) && $_GET['pesquisa'] !== ''){
            $lista = $servicos->selectServicosPesquisa($_GET['pesquisa']);
            $paginaAtual = 1;
            $proximaPagina = false;
            $paginaAnterior = false;
            
        } else{
            $limit = 10;
            $paginaAtual = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($paginaAtual*$limit) - $limit;

            $qntTotal = count($servicos->selectServico('*' , array('1'=>'1')));

            $proximaPagina = ($qntTotal > ($paginaAtual*$limit)) ? URL_BASE."admin/servicos?page=".($paginaAtual+1) : false;

            $paginaAnterior = ($paginaAtual > 1) ? URL_BASE."admin/servicos?page=".($paginaAtual-1) : false;

            $lista = $servicos->selectServicosPage($limit, $offset);
        }

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');
        
        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'servicos',
            'lista' => $lista,
            'paginaAtual' => $paginaAtual,
            'proximaPagina' => $proximaPagina,
            'paginaAnterior' => $paginaAnterior,
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/servico");
        return $renderer->render($response, "servicos.php", $data);
    }
    public function servicos_create(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        $servicos = new Servico();

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'servicos',
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/servico");
        return $renderer->render($response, "create.php", $data);
    }
    public function servicos_edit(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        $servicos = new Servico();

        $id = $args['id'];

        $servicos = new Servico();

        $resultado = $servicos->selectServico('*', array('id' => $id))[0];

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'servicos',
            'servico' => $resultado,
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/servico");
        return $renderer->render($response, "edit.php", $data);
    }
    public function servicos_insert(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $parsedBody = $request->getParsedBody();
    
        $titulo = $parsedBody['titulo'] ?? '';
        $data = $parsedBody['data'] ?? '';
        $valor = isset($parsedBody['valor']) ? $parsedBody['valor'] : 0.0;
        $tempo_servico = $parsedBody['tempo_servico'] ?? '';
    
        $nome_imagem_principal = "";
    
        if ($request->getUploadedFiles() && isset($request->getUploadedFiles()['imagem_principal'])) {
            $imagem_principal = $request->getUploadedFiles()['imagem_principal'];
        } else {
            $imagem_principal = false;
        }
    
        if ($imagem_principal) {
            if ($imagem_principal->getError() === UPLOAD_ERR_OK) {
                $extensao = pathinfo($imagem_principal->getClientFilename(), PATHINFO_EXTENSION);
                $nome = md5(uniqid(rand(), true)).".".$extensao;
                $nome_imagem_principal = "resources/imagens/" . $nome;
                $imagem_principal->moveTo($nome_imagem_principal);
            }
        }
    
        $campos = array(
            'titulo' => $titulo,
            'imagem_principal' => $nome_imagem_principal,
            'data_cadastro' => $data,
            'tempo_servico' => $tempo_servico,
            'valor' => $valor
        );
        
        $servicos = new Servico();
        $servicos->insertServico($campos);
    
        header('Location: '.URL_BASE.'admin/servicos');
        exit();
    }
    


//UPDATE SERVIÇOS

public function servicos_update(
    ServerRequestInterface $request, 
    ResponseInterface $response,
    $args
) {
    $parsedBody = $request->getParsedBody();
    
    $id = $parsedBody['id'] ?? null;
    $titulo = $parsedBody['titulo'] ?? '';
    $data = $parsedBody['data'] ?? '';
    $valor = $parsedBody['valor'] ?? 0.0;
    $tempo_servico = $parsedBody['tempo_servico'] ?? '';
    $nome_imagem_atual = $parsedBody['nome_imagem_atual'] ?? '';

    $imagem_atualizar = false;
    $nome_imagem_principal = $nome_imagem_atual;

    if ($request->getUploadedFiles() && isset($request->getUploadedFiles()['imagem_principal']) && $request->getUploadedFiles()['imagem_principal']->getClientFilename() !== '') {
        $imagem_atualizar = true;
        
        // Usuario quer atualizar a imagem principal
        $imagem_principal = $request->getUploadedFiles()['imagem_principal'];

        if ($imagem_principal->getError() === UPLOAD_ERR_OK) {
            $extensao = pathinfo($imagem_principal->getClientFilename(), PATHINFO_EXTENSION);
            $nome = md5(uniqid(rand(), true)).".".$extensao;
            $nome_imagem_principal = "resources/imagens/" . $nome;

            // Deleta a imagem antiga do diretório, se existir
            if (file_exists($nome_imagem_atual)) {
                unlink($nome_imagem_atual);
            }

            // Move a nova imagem para o diretório correto
            $imagem_principal->moveTo($nome_imagem_principal);
        }
    }

    $campos = array(
        'titulo' => $titulo,
        'data_cadastro' => $data,
        'valor' => $valor,
        'tempo_servico' => $tempo_servico
    );
    
    if ($imagem_atualizar) {
        $campos['imagem_principal'] = $nome_imagem_principal;
    }

    $servicos = new Servico();
    $servicos->updateServico($campos, array('id' => $id));
    
    header('Location: '.URL_BASE.'admin/servicos');
    exit();
}


    public function servicos_delete(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
       $id = $request->getParsedBody()['id'];

       $servicos = new Servico();

       $resultado = $servicos->selectServico('*', array('id' => $id))[0];

       unlink($resultado['imagem_principal']);

       $servicos->deleteServico('id', $id);

       header('Location: '.URL_BASE.'admin/servicos');
       exit();
    }

    
} 