<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Usuario;
use App\Model\Cliente;
use App\Model\Configuracao;
use App\Model\Agendamento;
use App\Model\Servico;
use App\Model\HorarioBarbeiro;


final class ClienteController
{
    function __construct() {
        if (!isset($_SESSION)) {
            session_set_cookie_params(604800);
            session_start();
        }
    }
    public function login_cliente(
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
        return $renderer->render($response, "login_cliente.php", $data);
    }
    public function verificar_login_cliente(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $email = $request->getParsedBody()['email'];
        $senha = $request->getParsedBody()['senha'];

        $usuario = new Cliente();

        $resultado = $usuario->selectCliente('*', array('email' => $email));

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
            $js['redirecionar_pagina'] = URL_BASE.'dashboard-cliente';
            echo json_encode($js);
            exit();
        } else{
            $js['status'] = 0;
            $js['msg'] = "Usuário ou senha inválidos";
            echo json_encode($js);
            exit();
        }
  
    }
    public function logout_cliente(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $_SESSION['usuario_logado'] = NULL;
        unset( $_SESSION['usuario_logado']);
        header("Location: ".URL_BASE."login-cliente");
		exit();
    }
    public function receber_email(
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
        return $renderer->render($response, "gerar_token.php", $data);
    }
    public function gerar_token(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
       
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $request->getParsedBody()['email'];
            
            $token = bin2hex(random_bytes(32));

            $config = new Configuracao();
            $nomeBarbearia = $config->getConfig('nome_site');
          
            $clientes = new Cliente();
            $consultaClientes  = $clientes->selectCliente('*', array('email' => $email));
            $emailExiste = !empty($consultaClientes);
            if (!empty($consultaClientes) && is_array($consultaClientes)) {
                $nomeCliente = $consultaClientes[0]['nome'];
            } else {
                $nomeCliente = null;
            }

            if ($emailExiste) {
                $tokenExiste = $consultaClientes[0]['token'];
                if (!empty($tokenExiste)) {
                    $js['status'] = 0;
                    $js['msg'] = "Email já enviado!";
                    echo json_encode($js);
                    exit();
                }
                $campos = array(
                    'token' => $token,
                );
              
                
                $clientes = new Cliente();
                
                $clientes->updateCliente($campos, array('email' => $email));
                if($clientes){
                    $msgHtml = "
                        <!DOCTYPE html>
                        <html lang='pt-BR'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <title>Redefinir senha</title>
                            <style>
                                body {
                                    font-family: Arial, sans-serif;
                                    background-color: #f4f4f4;
                                    margin: 0;
                                    padding: 0;
                                }
                                .container {
                                    width: 100%;
                                    max-width: 600px;
                                    margin: 0 auto;
                                    background-color: #ffffff;
                                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                                    padding: 20px;
                                    box-sizing: border-box;
                                }
                                .header {
                                    background-color: #4CAF50;
                                    color: white;
                                    padding: 20px;
                                    text-align: center;
                                }
                                .content {
                                    padding: 20px;
                                    text-align: center;
                                }
                                .button {
                                    display: inline-block;
                                    background-color: #4CAF50;
                                    color: white;
                                    padding: 15px 25px;
                                    text-decoration: none;
                                    border-radius: 5px;
                                    margin-top: 20px;
                                }
                                .footer {
                                    margin-top: 20px;
                                    text-align: center;
                                    color: #777;
                                }
                                .footer a {
                                    color: #4CAF50;
                                    text-decoration: none;
                                }
                            </style>
                        </head>
                        <body>
                            <div class='container'>
                                <div class='header'>
                                    <h1>Redefinição de senha</h1>
                                </div>
                                <div class='content'>
                                    <p>Olá!</p>
                                    <p>Seu link para redefinir sua senha esta disponível abaixo!</p>
                                
                                    <a href='https://exclusivebarbershop.com.br/redefinir-senha?$token'  class='button'>Redefinir senha</a>
                                    <p>Se você tiver alguma dúvida, por favor, entre em contato conosco.</p>
                                </div>
                                <div class='footer'>
                                    <p>Atenciosamente,<br>A Equipe $nomeBarbearia</p>
                                    <p><a href='https://exclusivebarbershop.com.br/login-cliente'>acessar agenda</a></p>
                                </div>
                            </div>
                        </body>
                        </html>
                    ";
                

                    $destino = $email;
                    $assunto_email = "Redefinir senha!";
                    $this->enviarEmailApi($destino, $assunto_email, $msgHtml, $nomeBarbearia, $nomeCliente);
            
                    if($results['enviarEmailApi'] = 'success'){
                        $js['status'] = 1;
                        $js['msg'] = "E-mail enviado!";
                        $js['resetar_form'] = true;
                        echo json_encode($js);
                        exit();
                    }
                }
            } else{
                $js['status'] = 0;
                $js['msg'] = "E-mail não encontrado!";
                echo json_encode($js);
                exit();
            }
        }
     
    }
    public function redefinir_senha(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');
        $clientes = new Cliente();

        $data['informacoes'] = array(
            'nome_logo' => $nome_logo_site,
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN);
        return $renderer->render($response, "senha_nova.php", $data);
    }
    public function redefinir_senha_nova(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
       
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $token = $request->getParsedBody()['token'];
            $senha = $request->getParsedBody()['senha'];
            $confirmar_senha = $request->getParsedBody()['confirmar_senha'];
           
            if( $senha !== $confirmar_senha){
                $js['status'] = 0;
                $js['msg'] = 'As senhas não são iguais.';
                echo json_encode($js);
                exit();
            }
            $config = new Configuracao();
            $nomeBarbearia = $config->getConfig('nome_site');
          
           
            $clientes = new Cliente();
            $consultaClientes = $clientes->selectCliente('*', array('token' => $token));

            if (isset($consultaClientes[0]['email'])) {
                $email = $consultaClientes[0]['email'];
                $nomeCliente = $consultaClientes[0]['nome'];
                $campos = array(
                    'token' => '',
                    'senha' => password_hash($senha, PASSWORD_DEFAULT, ["cost" => 12])
                );
                
                $clientes->updateCliente($campos, array('email' => $email));
                if($clientes){
                    $msgHtml = "
                        <!DOCTYPE html>
                    <html lang='pt-BR'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title>Redefinir senha</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f4f4f4;
                                margin: 0;
                                padding: 0;
                            }
                            .container {
                                width: 100%;
                                max-width: 600px;
                                margin: 0 auto;
                                background-color: #ffffff;
                                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                                padding: 20px;
                                box-sizing: border-box;
                            }
                            .header {
                                background-color: #4CAF50;
                                color: white;
                                padding: 20px;
                                text-align: center;
                            }
                            .content {
                                padding: 20px;
                                text-align: center;
                            }
                            .button {
                                display: inline-block;
                                background-color: #4CAF50;
                                color: white;
                                padding: 15px 25px;
                                text-decoration: none;
                                border-radius: 5px;
                                margin-top: 20px;
                            }
                            .footer {
                                margin-top: 20px;
                                text-align: center;
                                color: #777;
                            }
                            .footer a {
                                color: #4CAF50;
                                text-decoration: none;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <h1>Redefinição de senha</h1>
                            </div>
                            <div class='content'>
                                <p>Olá, $nomeCliente</p>
                                <p>Sua senha foi redefinida com sucesso!</p>
                               
                                <p>Se você tiver alguma dúvida, por favor, entre em contato conosco.</p>
                            </div>
                            <div class='footer'>
                                <p>Atenciosamente,<br>A Equipe $nomeBarbearia</p>
                                <p><a href='https://exclusivebarbershop.com.br/login-cliente'>acessar agenda</a></p>
                            </div>
                        </div>
                    </body>
                    </html>

                    ";
                

                    $destino = $email;
                    $assunto_email = "Senha redefinida!";

                    $this->enviarEmailApi($destino, $assunto_email, $msgHtml, $nomeBarbearia, $nomeCliente);
            
                    if($results['enviarEmailApi'] = 'success'){
                        $js['status'] = 1;
                        $js['msg'] = "Senha redefinida!";
                        $js['resetar_form'] = true;
                        echo json_encode($js);
                        exit();
                    }
                }
            } else {
                $js['status'] = 0;
                $js['msg'] = "senha já redefinida!";
                echo json_encode($js);
                exit();
            }
        }
    }
    public function dashboard_cliente(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Cliente::verificarLoginCliente();

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];
        
        $data['informacoes'] = array(
            'menu_active' => 'dashboard',
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN);
        return $renderer->render($response, "dashboard_cliente.php", $data);
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

        $quantTotal = count($clientes->selectCliente('*' , array('1'=>'1')));
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
            'usuario' => $usuario,
            'qtdCliente' => $quantTotal
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
    public function register_cliente(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
       
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

       

        $data['informacoes'] = array(
            'menu_active' => 'clientes',
            'nome_logo' => $nome_logo_site,
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN);
        return $renderer->render($response, "register.php", $data);
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
        $telefone = $request->getParsedBody()['telefone'];

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

                $nome_imagem_principal = "resources/imagens/cliente/" . $nome_imagem;

                $imagem_principal->moveTo($nome_imagem_principal);
            }
        }
       
        
        $campos = array(
            'nome' => $nome,
            'email' => $email,
            'telefone' => $telefone,
            'foto_usuario' => $nome_imagem_principal
        );
        $campos['senha'] = password_hash($password, PASSWORD_DEFAULT, ["const"=>12]);
        
        $clientes = new Cliente();
        
        $clientes->insertCliente($campos);

        header('Location: '.URL_BASE.'admin/clientes');
        exit();
    }

    // INSERT CLIENTE CADASTRO

    public function clientes_insert_cadastro(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $first_name = $request->getParsedBody()['first_name'];
        $last_name = $request->getParsedBody()['last_name'];
        $email = $request->getParsedBody()['email'];
        $telefone = $request->getParsedBody()['telefone'];
        $senha = $request->getParsedBody()['senha'];
        $confirmar_senha = $request->getParsedBody()['confirmar_senha'];
      
        $config = new Configuracao();
        $nomeBarbearia = $config->getConfig('nome_site');

        if($senha !== $confirmar_senha){
            $js['status'] = 0;
            $js['msg'] = 'As senhas não são iguais.';
            echo json_encode($js);
            exit();
        }
        if(strlen($senha) < 4) {
            $js['status'] = 0;
            $js['msg'] = 'A senha deve conter no mínimo 4 caracteres.';
            echo json_encode($js);
            exit();
        }
        
        $clientes = new Cliente();
        $result = $clientes->selectCliente('*', array('email' => $email));

        if (!empty($result) && is_array($result)) {
            $conferirEmail = count($result[0]);
        } else {
            $conferirEmail = 0;
        }
       
        if($conferirEmail > 0){
            $js['status'] = 0;
            $js['msg'] = 'Email já cadastrado!';
            echo json_encode($js);
            exit();
        } 
      
          
        $campos = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'telefone' => $telefone,
            'foto_usuario' => 'resources/imagens/cliente/usuariopadrao.png',
            'type' => 3,
            'email' => $email
        );

        if($senha === $confirmar_senha){
            $campos['senha'] = password_hash($senha, PASSWORD_DEFAULT, ["const"=>12]);
        }
        
        $clientes = new Cliente();
        $clientes->insertCliente($campos);

        if($clientes){
            // Corpo E-mail
            $msgHtml = "
                <!DOCTYPE html>
                <html lang='pt-BR'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Confirmação de Cadastro</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f4f4f4;
                            margin: 0;
                            padding: 0;
                        }
                        .container {
                            width: 100%;
                            max-width: 600px;
                            margin: 0 auto;
                            background-color: #ffffff;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                            padding: 20px;
                            box-sizing: border-box;
                        }
                        .header {
                            background-color: #4CAF50;
                            color: white;
                            padding: 20px;
                            text-align: center;
                        }
                        .content {
                            padding: 20px;
                            text-align: center;
                        }
                        .button {
                            display: inline-block;
                            background-color: #4CAF50;
                            color: white;
                            padding: 15px 25px;
                            text-decoration: none;
                            border-radius: 5px;
                            margin-top: 20px;
                        }
                        .footer {
                            margin-top: 20px;
                            text-align: center;
                            color: #777;
                        }
                        .footer a {
                            color: #4CAF50;
                            text-decoration: none;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h1>Bem-vindo!</h1>
                        </div>
                        <div class='content'>
                            <p>Olá, $first_name</p>
                            <p>Obrigado por se cadastrar em nossa barbearia. Para acessar a agenda, por favor, clique no botão abaixo:</p>
                             <a href='https://exclusivebarbershop.com.br/login-cliente' class='button'>Acessar</a>
                        </div>
                        <div class='footer'>
                            <p>Para qualquer dúvida entre em contato com o estabelecimento.</p>
                            <p>Atenciosamente,<br>A Equipe $nomeBarbearia</p>
                            <!-- <p><a href='#'>Visite nosso site</a></p> -->
                        </div>
                    </div>
                </body>
                </html>
            ";
            

            $destino = $email;
            $assunto_email = "Agradecemos seu cadastro ".$first_name."!";

          
            $this->enviarEmailApi($destino, $assunto_email, $msgHtml, $nomeBarbearia, $first_name);
            
            if($results['enviarEmailApi'] = 'success'){
                $js['status'] = 1;
                $js['msg'] = 'Cadastro realizado com sucesso!';
                $js['redirecionar_pagina'] = URL_BASE."login-cliente";
                echo json_encode($js);
                exit();
            } else {
                $js['status'] = 0;
                $js['msg'] = 'Erro ao enviar o Formulário. Tente novamente!';
                $js['resetar_form'] = true;
                echo json_encode($js);
                exit();
            }
        } else {
            $js['status'] = 0;
                $js['msg'] = 'Erro ao enviar o cadastro. Tente novamente!';
                $js['resetar_form'] = true;
                echo json_encode($js);
                exit();
        }
    }


    public function clientes_update(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $request->getParsedBody()['id'];
        $first_name = $request->getParsedBody()['first_name'];
        $last_name = $request->getParsedBody()['last_name'];
        $email = $request->getParsedBody()['email'];
        $telefone = $request->getParsedBody()['telefone']; 
        $senha = $request->getParsedBody()['senha'];
        $confirmar_senha = $request->getParsedBody()['confirmar_senha'];
      

        if($senha !== $confirmar_senha){
            $js['status'] = 0;
            $js['msg'] = 'As senhas não são iguais.';
            echo json_encode($js);
            exit();
        }
        if(strlen($senha) < 4) {
            $js['status'] = 0;
            $js['msg'] = 'A senha deve conter no mínimo 4 caracteres.';
            echo json_encode($js);
            exit();
        }
        $nome_imagem_atual = $request->getParsedBody()['nome_imagem_atual'];

        $imagem_atualizar = false;

        if (isset($uploadedFiles['foto_usuario']) && $uploadedFiles['foto_usuario']->getClientFilename() !== '') {
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
    
                    $nome_imagem_principal = "resources/imagens/cliente/" . $nome_imagem;

                    $imagem_principal->moveTo($nome_imagem_principal);
                   
                    unlink($nome_imagem_atual);

                }
            }
        }
       

        $campos = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'telefone' => $telefone,
        );
        if($senha === $confirmar_senha){
            $campos['senha'] = password_hash($senha, PASSWORD_DEFAULT, ["const"=>12]);
        }
        
        if($imagem_atualizar) {
            $campos['foto_usuario'] = $nome_imagem_principal;
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




    // AGENDAMENTO PELO CLIENTE

    public function agenda_cliente(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Cliente::verificarLoginCliente();

        $agendamentos = new Agendamento();
        $consultaAgendamentos  = $agendamentos->selectAgendamento('*', array('*'));

        $barbeiros = new Usuario();
        $resultado = $barbeiros->selectUsuario('*', array('*'));

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');
        $config = new Configuracao();
        $dataLibera = $config->getConfig('dataLibera');

        $servicos = new Servico();
        $consultaServicos  = $servicos->selectServico('*', array('*'));

        $clientes = new Cliente();
        $consultaClientes  = $clientes->selectCliente('*', array('*'));
        
        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'agendamentos',
            'agendamento' => $consultaAgendamentos,
            'barbeiro' => $resultado,
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario,
            'servico' => $consultaServicos,
            'cliente' => $consultaClientes,
            'dataLibera' => $dataLibera
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/agenda");
        return $renderer->render($response, "agenda_cliente.php", $data);
    }

    public function minha_agenda(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Cliente::verificarLoginCliente();
        $emailUser = $_SESSION['usuario_logado']['email'];
        $usuario = new Cliente();
        $usuarioInfo = $usuario->selectCliente('*', ['email' => $emailUser]);
        $idCliente = $usuarioInfo[0]['id'];

        $agendamentos = new Agendamento();
        $consultaAgendamentos  = $agendamentos->selectAgendamentoCliente($idCliente);
        

        $data_atual = date("Y-m-d H:i:s");

        $agendamentos_futuros = [];
        $agendamentos_passados = [];

        foreach ($consultaAgendamentos as $agendamento) {
            if (strtotime($agendamento['data_agendamento']) >= strtotime($data_atual)) {
                $agendamentos_futuros[] = $agendamento;
            } else {
                $agendamentos_passados[] = $agendamento;
            }
        }

        
        $agendamentos_futuros = array_reverse($agendamentos_futuros);
        $agendamentos_passados = array_reverse($agendamentos_passados);
        

        
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');
        

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'minha_agenda',
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario,
            'agendamentos_futuros' => $agendamentos_futuros,
            'agendamentos_passados' => $agendamentos_passados,
           
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/agenda");
        return $renderer->render($response, "minha_agenda.php", $data);
    }
   
    public function mostrar_horarios(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $data = '';
        $tempoServico = '';
        $idServico = '';
        $nomeServico = ''; 
    
        $horarios = [];
        
        if ($request->getMethod() === 'POST') {
            $params = $request->getParsedBody();
            if (isset($params['data']) && isset($params['tempoServico']) && isset($params['idServico'])) {
                $data = $params['data'];
                $tempoServico = $params['tempoServico'];
                $idServico = $params['idServico'];
    
                
                $servico = new Servico();
                $resultado = $servico->selectServico('*', array('id' => $idServico));
                if (!empty($resultado)) {
                    $nomeServico = $resultado[0]['titulo'];
                }
    
                $diaSemana = date('w', strtotime($data));
                $diasSemana = [
                    'Domingo',
                    'Segunda',
                    'Terça',
                    'Quarta',
                    'Quinta',
                    'Sexta',
                    'Sabado'
                ];
    
                $usuario = new Usuario();
                $barbeiros = $usuario->selectUsuario('*', array('*'));
    
                $agendamentos = new Agendamento();
                $horariosPorBarbeiro = [];
    
                foreach ($barbeiros as $barbeiro) {
                    $horariosPorBarbeiro[$barbeiro['nome']] = [
                        'foto_usuario' => $barbeiro['foto_usuario'],
                        'horarios' => [],
                        'idBarbeiro' => $barbeiro['id'],
                        'idServico' => $idServico,
                        'nomeServico' => $nomeServico,
                        'data' => $data
                    ];
    
                    $ConsultaHorarios = new HorarioBarbeiro();
                    if (isset($diasSemana[$diaSemana])) {
                        $turnos = $ConsultaHorarios->selectHorarioSemanaBarbeiro($diasSemana[$diaSemana], $barbeiro['id']);
                        
                        $turno1 = isset($turnos[0]['turno1']) ? $turnos[0]['turno1'] : '';
                        $turno2 = isset($turnos[0]['turno2']) ? $turnos[0]['turno2'] : '';
    
                        $horariosTrabalho = [];
                        if ($turno1 !== "FECHADO" && !empty($turno1)) {
                            $arrayTurno1 = array_map('trim', explode(",", $turno1));
                            foreach ($arrayTurno1 as $horario) {
                                $horariosTrabalho[] = $horario;
                            }
                            $ultimoHorarioTurno1 = end($arrayTurno1);
                        }
    
                        if ($turno2 !== "FECHADO" && !empty($turno2)) {
                            $arrayTurno2 = array_map('trim', explode(",", $turno2));
                            foreach ($arrayTurno2 as $horario) {
                                $horariosTrabalho[] = $horario;
                            }
                            $ultimoHorarioTurno2 = end($arrayTurno2);
                        }
                    }
    
                    $consultaAgendamentos = $agendamentos->selectAgendamentoData($data, $barbeiro['id']);
    
                    $horariosIndisponiveis = [];
                    foreach ($consultaAgendamentos as $agendamento) {
                        $horariosIndisponiveis[] = date('H:i', strtotime($agendamento['data_agendamento']));
                        $horarioAtual = $agendamento['servico_id'];
    
                        if ($horarioAtual == 2) {
                            $proximoHorario = date('H:i', strtotime($agendamento['data_agendamento']) + 1800);
                            $horariosIndisponiveis[] = $proximoHorario;
                        }
                    }
    
                    foreach ($horariosTrabalho as $index => $horario) {
                        if (in_array($horario, $horariosIndisponiveis)) {
                            continue;
                        }
    
                        if ($tempoServico == 30) {
                            $proximoHorario = date('H:i', strtotime($horario));
                            if (!in_array($proximoHorario, $horariosIndisponiveis)) {
                                $hora = date('H:i');
                                if ($data == date('Y-m-d')) {
                                    if ($horario > $hora) {
                                        $horariosPorBarbeiro[$barbeiro['nome']]['horarios'][] = $horario;
                                    }
                                } else {
                                    $horariosPorBarbeiro[$barbeiro['nome']]['horarios'][] = $horario;
                                }
                            }
                        } elseif ($tempoServico == 60) {
                            $proximoHorario = date('H:i', strtotime($horario));
                            $horarioFinal = date('H:i', strtotime($horario) + 1800);
    
                            // Verifica se é o último horário de cada turno
                            $isLastSlotOfTurno1 = isset($ultimoHorarioTurno1) && $horario === $ultimoHorarioTurno1;
                            $isLastSlotOfTurno2 = isset($ultimoHorarioTurno2) && $horario === $ultimoHorarioTurno2;
    
                            if (!$isLastSlotOfTurno1 && !$isLastSlotOfTurno2 && 
                                !in_array($proximoHorario, $horariosIndisponiveis) && 
                                !in_array($horarioFinal, $horariosIndisponiveis)) {
                                $horarioOcupado = false;
                                foreach ($horariosIndisponiveis as $horarioIndisponivel) {
                                    if ($horarioIndisponivel == $horario || $horarioIndisponivel == $proximoHorario) {
                                        $horarioOcupado = true;
                                        break;
                                    }
                                }
                                $hora = date('H:i');
                                if (!$horarioOcupado) {
                                    if ($data == date('Y-m-d')) {
                                        if ($horario > $hora) {
                                            $horariosPorBarbeiro[$barbeiro['nome']]['horarios'][] = $horario;
                                        }
                                    } else {
                                        $horariosPorBarbeiro[$barbeiro['nome']]['horarios'][] = $horario;
                                    }
                                }
                            }
                        }
                    }
                }
    
                $horarios = $horariosPorBarbeiro;
            

            }
        }
    
        $responseData = ['horarios' => $horarios];
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode($responseData));
        return $response;
    }
    
    
    public function insert_agendamento_cliente(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        try {
            // Verifica o login do cliente
            Cliente::verificarLoginCliente();
    
            // Obtém o email do usuário logado
            $emailUser = $_SESSION['usuario_logado']['email'];
    
            // Obtém informações do cliente logado
            $usuario = new Cliente();
            $usuarioInfo = $usuario->selectCliente('*', ['email' => $emailUser]);
            if (empty($usuarioInfo) || !is_array($usuarioInfo)) {
                throw new Exception("Erro ao obter informações do cliente.");
            }
            $idCliente = $usuarioInfo[0]['id'];
            $nomeCliente = $usuarioInfo[0]['first_name'] . ' ' . $usuarioInfo[0]['last_name'];
            $emailCliente = $usuarioInfo[0]['email'];
    
            // Obtém o nome da barbearia
            $config = new Configuracao();
            $nomeBarbearia = $config->getConfig('nome_site');
    
            // Processa os dados recebidos do formulário
            $data = date('Y-m-d', strtotime($request->getParsedBody()['dataAgen']));
            $hora = date('H:i', strtotime($request->getParsedBody()['horarioAgenda']));
            $observacao = $request->getParsedBody()['observacao'];
            $idBarbeiro = $request->getParsedBody()['idBarbeiro'];
            $idServico = $request->getParsedBody()['idServico'];
            $datetime = $data . ' ' . $hora;
    
            // Obtém informações do serviço
            $servicos = new Servico();
            $infoServico = $servicos->selectServico('titulo', ['id' => $idServico]);
            if (empty($infoServico) || !is_array($infoServico)) {
                throw new Exception("Erro ao obter informações do serviço.");
            }
            $nomeServico = $infoServico[0]['titulo'];
    
            // Obtém informações do barbeiro
            $usuarios = new Usuario();
            $infoBarbeiro = $usuarios->selectUsuario('*', ['id' => $idBarbeiro]);
            if (empty($infoBarbeiro) || !is_array($infoBarbeiro)) {
                throw new Exception("Erro ao obter informações do barbeiro.");
            }
            $nomeBarbeiro = $infoBarbeiro[0]['nome'];
            $emailBarbeiro = $infoBarbeiro[0]['email'];
    
            // Verifica se o horário já está agendado
            $agendamentos_verificar = new Agendamento();
            $numero_agendamentos = count($agendamentos_verificar->selectAgendamentoVerificar($datetime, $idBarbeiro));
            if ($numero_agendamentos > 0) {
                $js['status'] = 0;
                $js['msg'] = "Horário indisponível!";
                echo json_encode($js);
                exit();
            }
    
            // Insere o novo agendamento
            $campos = [
                'id_cliente' => $idCliente,
                'data_agendamento' => $datetime,
                'servico_id' => $idServico,
                'barbeiro_id' => $idBarbeiro,
                'descricao' => $observacao
            ];
            $agendamentos = new Agendamento();
            $agendamentos->insertAgendamento($campos);
    
          
           
            $this->enviarEmailConfirmacao($nomeCliente, $emailCliente, $nomeServico, $data, $hora, $nomeBarbeiro, $nomeBarbearia);
            $this->enviarEmailNotificacaoBarbeiro($emailBarbeiro, $nomeServico, $data, $hora, $nomeCliente, $nomeBarbearia, $observacao, $nomeBarbeiro);
            
            $js['status'] = 1;
            $js['msg'] = 'Agendado com sucesso!';
            $js['redirecionar_pagina'] = URL_BASE."admin/minha-agenda";
            echo json_encode($js);
            exit();
    
        } catch (Exception $e) {
            $js['status'] = 0;
            $js['msg'] = 'Erro ao agendar Horário. Tente novamente!';
            echo json_encode($js);
            exit();
        }
    }
    
    
    private function enviarEmailConfirmacao($nomeCliente, $emailCliente, $nomeServico, $data, $hora, $nomeBarbeiro, $nomeBarbearia) {
        $assunto = "Confirmação de Agendamento!";
        $mensagem = "
        <!DOCTYPE html>
        <html lang='pt-BR'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Agendamento Concluído</title>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                .container { width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); padding: 20px; box-sizing: border-box; }
                .header { background-color: #4CAF50; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; text-align: center; }
                .footer { margin-top: 20px; text-align: center; color: #777; }
                .footer a { color: #4CAF50; text-decoration: none; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Agendamento Concluído</h1>
                </div>
                <div class='content'>
                    <p>Olá, $nomeCliente</p>
                    <p>Seu agendamento foi concluído com sucesso!</p>
                    <p>Aqui estão os detalhes do seu agendamento:</p>
                    <p><strong>Data:</strong> $data</p>
                    <p><strong>Horário:</strong> $hora</p>
                    <p><strong>Serviço:</strong> $nomeServico</p>
                    <p><strong>Barbeiro:</strong> $nomeBarbeiro</p>
                    <p>Se você tiver alguma dúvida, por favor, entre em contato conosco.</p>
                </div>
                <div class='footer'>
                    <p>Atenciosamente,<br>A Equipe $nomeBarbearia</p>
                    <p><a href='https://exclusivebarbershop.com.br/minha-agenda'>Confira seu agendamento</a></p>
                </div>
            </div>
        </body>
        </html>
        ";
        $this->enviarEmailApi($emailCliente, $assunto, $mensagem, $nomeBarbearia, $nomeCliente);
    }
    
    private function enviarEmailNotificacaoBarbeiro($emailBarbeiro, $nomeServico, $data, $hora, $nomeCliente, $nomeBarbearia,$observacao,$nomeBarbeiro) {
        $assunto = "Novo Agendamento!";
        $mensagem = "
        <!DOCTYPE html>
        <html lang='pt-BR'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Novo Agendamento</title>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                .container { width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); padding: 20px; box-sizing: border-box; }
                .header { background-color: #4CAF50; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; text-align: center; }
                .footer { margin-top: 20px; text-align: center; color: #777; }
                .footer a { color: #4CAF50; text-decoration: none; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Novo Agendamento!</h1>
                </div>
                <div class='content'>
                    <p>Olá, $nomeBarbeiro</p>
                    <p>Você tem um novo agendamento!</p>
                    <p>Aqui estão os detalhes do agendamento:</p>
                    <p><strong>Data:</strong> $data</p>
                    <p><strong>Horário:</strong> $hora</p>
                    <p><strong>Serviço:</strong> $nomeServico</p>
                    <p><strong>Observação:</strong> $observacao</p>
                    <p><strong>Cliente:</strong> $nomeCliente</p>
                </div>
                <div class='footer'>
                    <p>Atenciosamente,<br>A Equipe $nomeBarbearia</p>
                    <p><a href='https://exclusivebarbershop.com.br/admin-login'>Confira o agendamento</a></p>
                </div>
            </div>
        </body>
        </html>
        ";
        $this->enviarEmailApi($emailBarbeiro, $assunto, $mensagem, $nomeBarbearia, $nomeBarbeiro);
   
    }


    private function enviarEmailConfirmacaoCancelamento($nomeCliente, $emailCliente, $nomeServico, $data, $hora, $nomeBarbeiro, $nomeBarbearia) {
        $assunto = "Confirmação de Cancelamento!";
        $mensagem = "
        <!DOCTYPE html>
        <html lang='pt-BR'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Agendamento Cancelado</title>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                .container { width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); padding: 20px; box-sizing: border-box; }
                .header { background-color: #4CAF50; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; text-align: center; }
                .footer { margin-top: 20px; text-align: center; color: #777; }
                .footer a { color: #4CAF50; text-decoration: none; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Agendamento Cancelado</h1>
                </div>
                <div class='content'>
                    <p>Olá, $nomeCliente</p>
                    <p>Seu agendamento foi cancelado com sucesso!</p>
                    <p>Aqui estão os detalhes do seu agendamento:</p>
                    <p><strong>Data:</strong> $data</p>
                    <p><strong>Horário:</strong> $hora</p>
                    <p><strong>Serviço:</strong> $nomeServico</p>
                    <p><strong>Barbeiro:</strong> $nomeBarbeiro</p>
                    <p>Se você tiver alguma dúvida, por favor, entre em contato conosco.</p>
                </div>
                <div class='footer'>
                    <p>Atenciosamente,<br>A Equipe $nomeBarbearia</p>
                    <p><a href='https://exclusivebarbershop.com.br/minha-agenda'>Confira sua Agenda</a></p>
                </div>
            </div>
        </body>
        </html>
        ";
        $this->enviarEmailApi($emailCliente, $assunto, $mensagem, $nomeBarbearia, $nomeCliente);
    }


    private function enviarEmailNotificacaoBarbeiroCancelamento($emailBarbeiro, $nomeServico, $data, $hora, $nomeCliente, $nomeBarbearia,$nomeBarbeiro) {
        $assunto = "Cancelamento de Agendamento!";
        $mensagem = "
        <!DOCTYPE html>
        <html lang='pt-BR'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Cancelamento de Agendamento</title>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                .container { width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); padding: 20px; box-sizing: border-box; }
                .header { background-color: #4CAF50; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; text-align: center; }
                .footer { margin-top: 20px; text-align: center; color: #777; }
                .footer a { color: #4CAF50; text-decoration: none; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Cancelamento de Agendamento!</h1>
                </div>
                <div class='content'>
                    <p>Olá, $nomeBarbeiro</p>
                    <p>Cancelamento de agendamento!</p>
                    <p>Aqui estão os detalhes do agendamento:</p>
                    <p><strong>Data:</strong> $data</p>
                    <p><strong>Horário:</strong> $hora</p>
                    <p><strong>Serviço:</strong> $nomeServico</p>
                    <p><strong>Cliente:</strong> $nomeCliente</p>
                </div>
                <div class='footer'>
                    <p>Atenciosamente,<br>A Equipe $nomeBarbearia</p>
                    <p><a href='https://exclusivebarbershop.com.br/admin-login'>Confira sua Agenda</a></p>
                </div>
            </div>
        </body>
        </html>
        ";
        $this->enviarEmailApi($emailBarbeiro, $assunto, $mensagem, $nomeBarbearia, $nomeBarbeiro);
   
    }

    
    private function enviarEmailApi($emailDestino, $assunto, $mensagem, $nomeBarbearia, $nomeDestino)
    {
        // URL da API do MailerSend
        $url = "https://api.mailersend.com/v1/email";
    
        // Token de autenticação
        $apiToken = 'mlsn.15f340984ea67fbe3308f63e28b0e7c20027e1f9bc091887faabac50cea00404';
    
        // Dados do e-mail
        $dados = [
            "from" => [
                "email" => "info@exclusivebarbershop.com.br",
                "name" => $nomeBarbearia
            ],
            "to" => [
                [
                    "email" => $emailDestino,
                    "name" => $nomeDestino
                ]
            ],
            "subject" => $assunto,
            "text" => strip_tags($mensagem), // Conteúdo em texto puro
            "html" => $mensagem // Conteúdo HTML
        ];
    
        // Inicializa a sessão cURL
        $ch = curl_init($url);
    
        // Configurações do cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiToken
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
    
        // Executa a requisição e captura a resposta
        $resposta = curl_exec($ch);
    
        // Verifica erros
        if (curl_errno($ch)) {
            error_log('Erro ao enviar e-mail: ' . curl_error($ch));
            curl_close($ch);
            return false; // Indica falha no envio
        }
    
        // Fecha a sessão cURL
        curl_close($ch);
    
        // Decodifica a resposta para verificar sucesso
        $respostaDecoded = json_decode($resposta, true);
    
        if (isset($respostaDecoded['error'])) {
            error_log('Erro ao enviar e-mail: ' . $respostaDecoded['error']);
            return false; // Indica falha no envio
        }
    
        return true; // Indica sucesso no envio
    }
    

   
    public function perfil_cliente(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Cliente::verificarLoginCliente();
        
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'perfil',
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN);
        return $renderer->render($response, "perfil_cliente.php", $data);
    } 

    public function perfil_updateCliente(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $request->getParsedBody()['id'];
        $first_name = $request->getParsedBody()['first_name'];
        $last_name = $request->getParsedBody()['last_name'];
        $email = $request->getParsedBody()['email'];
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
                    if($nome_foto_usuario == 'usuariopadrao.png'){
                        unlink($nome_imagem_atual);
                    }

                    $extensao = pathinfo($foto_usuario->getClientFilename(), PATHINFO_EXTENSION);
    
                    $nome_foto = md5(uniqid(rand(), true)).pathinfo($foto_usuario->getClientFilename(), PATHINFO_FILENAME).".".$extensao;
    
                    $nome_foto_usuario = "resources/imagens/usuario/" . $nome_foto;

                    
                    $foto_usuario->moveTo($nome_foto_usuario);

                    
                }
            }
        }
        $campos = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
        );
        if($imagem_atualizar) {
            $campos['foto_usuario'] = $nome_foto_usuario;
        }
        if($alterar_senha) {
            $campos['senha'] = password_hash($senha, PASSWORD_DEFAULT, ["const"=>12]);
        }
       
        $cliente = new Cliente();

        $cliente->updatecliente($campos, array('id' => $id));

        $resultado = $cliente->selectcliente('*', array('email' => $email));

        $_SESSION['usuario_logado'] = $resultado[0];

        $js['status'] = 1;
        $js['msg'] = 'Usuário atualizado com sucesso.';
        $js['redirecionar_pagina'] = URL_BASE."admin/perfil-cliente";
        echo json_encode($js);
        exit();
    }

    public function agendacliente_delete(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
       $id = $request->getParsedBody()['id'];

       $config = new Configuracao();
       $nomeBarbearia = $config->getConfig('nome_site');

       Cliente::verificarLoginCliente();
    
       // Obtém o email do usuário logado
       $emailUser = $_SESSION['usuario_logado']['email'];

       $usuario = new Cliente();
        $usuarioInfo = $usuario->selectCliente('*', ['email' => $emailUser]);
        if (empty($usuarioInfo) || !is_array($usuarioInfo)) {
            throw new Exception("Erro ao obter informações do cliente.");
        }
        $emailCliente = $usuarioInfo[0]['email'];

       

       $agendamentos = new Agendamento();

       $resultado = $agendamentos->selectAgendamento($id);

       if (!empty($resultado) && isset($resultado[0])) {
        $nomeCliente = $resultado[0]['nome_cliente'];
        $telefoneCliente = $resultado[0]['telefone_cliente'];
        $nomeServico = $resultado[0]['nome_servico'];
        $dataHora = $resultado[0]['data_agendamento']; 
        $data = date('Y-m-d', strtotime($dataHora)); 
        $hora = date('H:i:s', strtotime($dataHora)); 
        $nomeBarbeiro = $resultado[0]['nome_barbeiro'];
    } else {
        // Caso não haja resultados
        echo "Nenhum agendamento encontrado.";
    }

        $usuarios = new Usuario();
        $infoBarbeiro = $usuarios->selectUsuario('*', ['nome' => $nomeBarbeiro]);
        if (empty($infoBarbeiro) || !is_array($infoBarbeiro)) {
            throw new Exception("Erro ao obter informações do barbeiro.");
        }
        $emailBarbeiro = $infoBarbeiro[0]['email'];

        $agendamentos = new Agendamento;
        $agendamentos->deleteAgendamento('id', $id);
        if($agendamentos){
            $this->enviarEmailConfirmacaoCancelamento($nomeCliente, $emailCliente, $nomeServico, $data, $hora, $nomeBarbeiro, $nomeBarbearia);
            $this->enviarEmailNotificacaoBarbeiroCancelamento($emailBarbeiro, $nomeServico, $data, $hora, $nomeCliente, $nomeBarbearia, $nomeBarbeiro);
        }
        header('Location: '.URL_BASE.'admin/minha-agenda');
        exit();
    }


    
}