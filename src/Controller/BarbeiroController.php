<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Usuario;
use App\Model\Configuracao;


final class BarbeiroController
{
    function __construct()
    {
        Usuario::verificarLogin();
    }
    public function barbeiros(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) { 
        $barbeiros = new Usuario();

        if(isset($_GET['pesquisa']) && $_GET['pesquisa'] !== ''){
            $lista = $barbeiros->selectUsuariosPesquisa($_GET['pesquisa']);
            $paginaAtual = 1;
            $proximaPagina = false;
            $paginaAnterior = false;
            
        } else{
            $limit = 10;
            $paginaAtual = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($paginaAtual*$limit) - $limit;

            $qntTotal = count($barbeiros->selectUsuario('*' , array('1'=>'1')));

            $proximaPagina = ($qntTotal > ($paginaAtual*$limit)) ? URL_BASE."admin/barbeiros?page=".($paginaAtual+1) : false;

            $paginaAnterior = ($paginaAtual > 1) ? URL_BASE."admin/barbeiros?page=".($paginaAtual-1) : false;

            $lista = $barbeiros->selectUsuariosPage($limit, $offset);
        }
      
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'barbeiros',
            'lista' => $lista,
            'paginaAtual' => $paginaAtual,
            'proximaPagina' => $proximaPagina,
            'paginaAnterior' => $paginaAnterior,
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/barbeiro");
        return $renderer->render($response, "barbeiros.php", $data);
    }
    public function barbeiros_create(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
       
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $data['informacoes'] = array(
            'menu_active' => 'barbeiros',
            'nome_logo' => $nome_logo_site
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/barbeiro");
        return $renderer->render($response, "create.php", $data);
    }
    public function barbeiros_edit(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $args['id'];

        $usuarioSession = $_SESSION['usuario_logado']['id'];

        $barbeiros = new Usuario();

        $resultado = $barbeiros->selectUsuario('*', array('id' => $id))[0];

        $usuario = new Usuario();

        $resultadoUsuario = $usuario->selectUsuario('*', array('id' => $usuarioSession))[0];

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');
        $data['informacoes'] = array(
            'menu_active' => 'barbeiros',
            'barbeiro' => $resultado,
            'usuario' => $resultadoUsuario,
            'nome_logo' => $nome_logo_site
        );

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/barbeiro");
        return $renderer->render($response, "edit.php", $data);
    }


    public function barbeiros_insert(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        
        $nome = $request->getParsedBody()['nome'];
        $email = $request->getParsedBody()['email'];
        $status = $request->getParsedBody()['ativo'];
        $type = $request->getParsedBody()['gestor'];
        $password = $request->getParsedBody()['password'];

        $nome_imagem_principal = "";

        if($request->getUploadedFiles()['imagem_principal']) {
            $imagem_principal = $request->getUploadedFiles()['imagem_principal'];
        } else {
            $imagem_principal = false;
        }

        if($imagem_principal) {
            if ($imagem_principal->getError() === UPLOAD_ERR_OK) {
                $extensao = pathinfo($imagem_principal->getClientFilename(), PATHINFO_EXTENSION);

                $nome_imagem = md5(uniqid(rand(), true)).pathinfo($imagem_principal->getClientFilename(), PATHINFO_FILENAME).".".$extensao;

                $nome_imagem_principal = "resources/imagens/usuario/" . $nome_imagem;

                $imagem_principal->moveTo($nome_imagem_principal);
            }
        }
       
        if($type === '1'){
            $gestor = 1;
        } else{
            $gestor = 2;
        }
        $campos = array(
            'nome' => $nome,
            'email' => $email,
            'foto_usuario' => $nome_imagem_principal,
            'status' => $status,
            'type' => $gestor,
        );
        $campos['senha'] = password_hash($password, PASSWORD_DEFAULT, ["const"=>12]);
        
        $barbeiros = new Usuario();
        
        $barbeiros->insertUsuario($campos);

        header('Location: '.URL_BASE.'admin/barbeiros');
        exit();
    }

    public function barbeiros_update(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $request->getParsedBody()['id'];
        $nome = $request->getParsedBody()['nome'];
        $email = $request->getParsedBody()['email'];
        $status = $request->getParsedBody()['ativo'];
        $type = $request->getParsedBody()['gestor'];

        $nome_imagem_atual = $request->getParsedBody()['nome_imagem_atual'];

        $imagem_atualizar = false;

        if($request->getUploadedFiles()['foto_usuario']->getClientFilename() !== '') {
            $imagem_atualizar = true;
            $nome_imagem_principal = "";

            //Usuario quer atualizar a imagem principal
            if($request->getUploadedFiles()['foto_usuario']) {
                $imagem_principal = $request->getUploadedFiles()['foto_usuario'];
            } else {
                $imagem_principal = false;
            }
    
            if($imagem_principal) {
                if ($imagem_principal->getError() === UPLOAD_ERR_OK) {
                    unlink($nome_imagem_atual); // deleta as imagens do diretorio

                    $extensao = pathinfo($imagem_principal->getClientFilename(), PATHINFO_EXTENSION);
    
                    $nome_imagem = md5(uniqid(rand(), true)).pathinfo($imagem_principal->getClientFilename(), PATHINFO_FILENAME).".".$extensao;
    
                    $nome_imagem_principal = "resources/imagens/usuario/" . $nome_imagem;

                    $imagem_principal->moveTo($nome_imagem_principal);
                   


                }
            }
        }
        if($type === '1'){
            $gestor = 1;
        } else{
            $gestor = 2;
        }

        $campos = array(
            'nome' => $nome,
            'status' => $status,
            'email' => $email,
            'type' => $gestor,
        );
        if($imagem_atualizar) {
            $campos['foto_usuario'] = $nome_imagem_principal;
        }
        $barbeiros = new Usuario();
        
        $barbeiros->updateUsuario($campos, array('id' => $id));


        header('Location: '.URL_BASE.'admin/barbeiros');
        exit();
    }


    public function barbeiros_delete(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
       $id = $request->getParsedBody()['id'];

       $barbeiros = new Usuario;

       $resultado = $barbeiros->selectBarbeiro('*', array('id' => $id))[0];

       unlink($resultado['imagem_principal']);

       $barbeiros->deleteBarbeiro('id', $id);

       header('Location: '.URL_BASE.'admin/barbeiros');
       exit();
    }

}