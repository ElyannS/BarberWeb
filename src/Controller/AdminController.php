<?php

namespace App\Controller;

use App\Model\Usuario;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Configuracao;

final class AdminController
{
    function __construct() {
        if (!isset($_SESSION)) {
            session_start();
        }
    }
    public function login(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $data['informacoes'] = array(
            'nome_logo' => $nome_logo_site
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN);
        return $renderer->render($response, "admin_login.php", $data);
    }
    public function verificar_login(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $email = $request->getParsedBody()['email'];
        $senha = $request->getParsedBody()['senha'];

        $usuario = new Usuario();

        $resultado = $usuario->selectUsuario('*', array('email' => $email));

        if(!$resultado) {
            $js['status'] = 0;
            $js['msg'] = "Usuário ou senha inválidos";
            echo json_encode($js);
            exit();
        }

        if (password_verify($senha, $resultado[0]['senha'])) {

            $_SESSION['usuario_logado'] = $resultado[0];

            $js['status'] = 1;
            $js['msg'] = "Usuário logado com sucesso";
            $js['redirecionar_pagina'] = URL_BASE.'dashboard';
            echo json_encode($js);
            exit();
        } else{
            $js['status'] = 0;
            $js['msg'] = "Usuário ou senha inválidos";
            echo json_encode($js);
            exit();
        }
  
    }
    public function logout(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $_SESSION['usuario_logado'] = NULL;
        unset( $_SESSION['usuario_logado']);
        header("Location: ".URL_BASE."admin-login");
		exit();
    } 
    public function dashboard(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];
        
        $data['informacoes'] = array(
            'menu_active' => 'dashboard',
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN);
        return $renderer->render($response, "dashboard.php", $data);
    } 
    public function perfil(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'perfil',
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN);
        return $renderer->render($response, "perfil.php", $data);
    } 
    public function site(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $configuracoes = $config->selectConfiguracao('*', array('1' => 1));
        $info = array();

        foreach ($configuracoes as $c) {

            $info[$c['nome']] = $c['valor'];
            
        }
        $usuario = $_SESSION['usuario_logado'];
        $data['informacoes'] = array(
            'menu_active' => 'site',
            'nome_logo' => $nome_logo_site,
            'info' => $info,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN);
        return $renderer->render($response, "site.php", $data);
    } 
    public function site_update(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $nome_site = $request->getParsedBody()['nome_site'];
        
        $nome_logo_site = "";
        $logo_atualizar = false;

        if(isset($request->getParsedBody()['excluir_logo_site_nome'])){
            $excluir_logo_site = $request->getParsedBody()['excluir_logo_site_nome'];
        } else{
            $excluir_logo_site = false;
        }
        
        if(isset($_FILES['logo_site'])){

            if($request->getUploadedFiles()['logo_site']) {
                $logo_site = $request->getUploadedFiles()['logo_site'];
            } else {
                $logo_site = false;
            }
    
            if($logo_site) {
                $logo_atualizar = true;
                    if ($logo_site->getError() === UPLOAD_ERR_OK) {
                        $extensao = pathinfo($logo_site->getClientFilename(), PATHINFO_EXTENSION);
        
                        $nome_foto = md5(uniqid(rand(), true)).pathinfo($logo_site->getClientFilename(), PATHINFO_FILENAME).".".$extensao;
        
                        $nome_logo_site = "resources/imagens/" . $nome_foto;

                        unlink($excluir_logo_site);

                        $logo_site->moveTo($nome_logo_site);

                    }
            }
        }
  
        $config = new Configuracao();

        if ($nome_site !== "") {
            $campos = array(
                'nome' => 'nome_site',
                'valor' => $nome_site
            );
            $config->updateConfiguracao($campos, array('nome' => 'nome_site'));
        }
   
        
        if ($logo_atualizar) {
            $campos = array(
                'nome' => 'logo_site',
                'valor' => $nome_logo_site
            );
            $config->updateConfiguracao($campos, array('nome' => 'logo_site'));
        }
        
        $js['status'] = 1;
        $js['msg'] = 'Informações atualizadas com sucesso.';
        $js['redirecionar_pagina'] = URL_BASE."admin/site";
        echo json_encode($js);
        exit();
    }
    public function perfil_update(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $request->getParsedBody()['id'];
        $nome = $request->getParsedBody()['nome'];
        $email = $request->getParsedBody()['email'];
        $comissao = $request->getParsedBody()['comissao'];
        $senha = $request->getParsedBody()['senha'];
        $confirmar_senha = $request->getParsedBody()['confirmar_senha'];
        $nome_imagem_atual = $request->getParsedBody()['nome_imagem_atual'];
        

        $alterar_senha = false;

       
        if($senha !== '') {
            if( $senha !== $confirmar_senha){
                $js['status'] = 0;
                $js['msg'] = 'As senhas não são iguais.';
                echo json_encode($js);
                exit();
            }
            $alterar_senha = true;
        }

        
        $nome_foto_usuario = "";
        $imagem_atualizar = false;
        
        if(isset($_FILES['foto_usuario'])){

            if($request->getUploadedFiles()['foto_usuario']) {
                $foto_usuario = $request->getUploadedFiles()['foto_usuario'];
            } else {
                $foto_usuario = false;
            }
    
            if($foto_usuario) {
                
            $imagem_atualizar = true;
                if ($foto_usuario->getError() === UPLOAD_ERR_OK) {
                    unlink($nome_imagem_atual);

                    $extensao = pathinfo($foto_usuario->getClientFilename(), PATHINFO_EXTENSION);
    
                    $nome_foto = md5(uniqid(rand(), true)).pathinfo($foto_usuario->getClientFilename(), PATHINFO_FILENAME).".".$extensao;
    
                    $nome_foto_usuario = "resources/imagens/usuario/" . $nome_foto;

                    
                    $foto_usuario->moveTo($nome_foto_usuario);

                    
                }
            }
        }
        $campos = array(
            'nome' => $nome,
            'email' => $email,
            'data_cadastro' => date('Y-m-d'),
            'comissao' => $comissao
        );
        if($imagem_atualizar) {
            $campos['foto_usuario'] = $nome_foto_usuario;
        }
        if($alterar_senha) {
            $campos['senha'] = password_hash($senha, PASSWORD_DEFAULT, ["const"=>12]);
        }
       
        $usuario = new Usuario();

        $usuario->updateUsuario($campos, array('id' => $id));

        $resultado = $usuario->selectUsuario('*', array('email' => $email));

        $_SESSION['usuario_logado'] = $resultado[0];

        $js['status'] = 1;
        $js['msg'] = 'Usuário atualizado com sucesso.';
        $js['redirecionar_pagina'] = URL_BASE."admin/perfil";
        echo json_encode($js);
        exit();
    }
}