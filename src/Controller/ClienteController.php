<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Usuario;
use App\Model\Cliente;
use App\Model\Configuracao;


final class ClienteController
{
    function __construct()
    {
        Usuario::verificarLogin();
    }
    public function clientes(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) { 
        $clientes = new Cliente();

        if(isset($_GET['pesquisa']) && $_GET['pesquisa'] !== ''){
            $lista = $clientes->selectClientesPesquisa($_GET['pesquisa']);
            $paginaAtual = 1;
            $proximaPagina = false;
            $paginaAnterior = false;
            
        } else{
            $limit = 10;
            $paginaAtual = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($paginaAtual*$limit) - $limit;

            $qntTotal = count($clientes->selectCliente('*' , array('1'=>'1')));

            $proximaPagina = ($qntTotal > ($paginaAtual*$limit)) ? URL_BASE."admin/clientes?page=".($paginaAtual+1) : false;

            $paginaAnterior = ($paginaAtual > 1) ? URL_BASE."admin/clientes?page=".($paginaAtual-1) : false;

            $lista = $clientes->selectClientesPage($limit, $offset);
        }
      
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'clientes',
            'lista' => $lista,
            'paginaAtual' => $paginaAtual,
            'proximaPagina' => $proximaPagina,
            'paginaAnterior' => $paginaAnterior,
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/cliente");
        return $renderer->render($response, "clientes.php", $data);
    }
    public function clientes_create(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
       
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'clientes',
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/cliente");
        return $renderer->render($response, "create.php", $data);
    }
    public function clientes_edit(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $args['id'];


        $clientes = new Cliente();

        $resultadoUsuario = $clientes->selectCliente('*', array('id' => $id))[0];

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'clientes',
            'cliente' => $resultadoUsuario,
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/cliente");
        return $renderer->render($response, "edit.php", $data);
    }


    public function clientes_insert(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $nome = $request->getParsedBody()['nome'];
        $email = $request->getParsedBody()['email'];
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
       
        
        $campos = array(
            'nome' => $nome,
            'email' => $email,
            'foto_cliente' => $nome_imagem_principal
        );
        $campos['senha'] = password_hash($password, PASSWORD_DEFAULT, ["const"=>12]);
        
        $clientes = new Cliente();
        
        $clientes->insertCliente($campos);

        header('Location: '.URL_BASE.'admin/clientes');
        exit();
    }

    public function clientes_update(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $request->getParsedBody()['id'];
        $nome = $request->getParsedBody()['nome'];
        $email = $request->getParsedBody()['email'];
        $password = $request->getParsedBody()['password'];


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
       

        $campos = array(
            'nome' => $nome,
            'email' => $email,
            'foto_cliente' => $nome_imagem_principal
        );
        $campos['senha'] = password_hash($password, PASSWORD_DEFAULT, ["const"=>12]);
        
        if($imagem_atualizar) {
            $campos['foto_cliente'] = $nome_imagem_principal;
        }
        $clientes = new Cliente();
        
        $clientes->updateCliente($campos, array('id' => $id));


        header('Location: '.URL_BASE.'admin/clientes');
        exit();
    }


    public function clientes_delete(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
       $id = $request->getParsedBody()['id'];

       $clientes = new Cliente;

       $resultado = $clientes->selectCliente('*', array('id' => $id))[0];

       unlink($resultado['imagem_principal']);

       $clientes->deleteCliente('id', $id);

       header('Location: '.URL_BASE.'admin/clientes');
       exit();
    }

}