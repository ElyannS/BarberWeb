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
use App\Model\Horario;


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
        $nome = $request->getParsedBody()['nome'];
        $email = $request->getParsedBody()['email'];
        $telefone = $request->getParsedBody()['telefone'];
        $senha = $request->getParsedBody()['senha'];
        $confirmar_senha = $request->getParsedBody()['confirmar_senha'];
        $data_envio = date('d/m/Y');
        $hora_envio = date('H:i:s');
      
        $config = new Configuracao();
        $nomeBarbearia = $config->getConfig('nome_site');

        if($senha !== $confirmar_senha){
            $js['status'] = 0;
            $js['msg'] = 'As senhas não são iguais.';
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
            'nome' => $nome,
            'telefone' => $telefone,
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
            $msgHtml = "<!DOCTYPE html>
                <html lang='pt-BR'>
                <head>
                    <meta charset='UTF-8'>
                    <title>Email</title>
                    <style type='text/css'>
                        body {
                            margin: 0;
                            font-family: Arial, sans-serif;
                            font-size: 14px;
                            color: white;
                            background-color: #f4f4f4;
                            padding: 20px;
                        }
                        .email-container {
                            width: 100%;
                            max-width: 600px;
                            margin: 0 auto;
                            background-color: #ffffff;
                            border: 1px solid #dddddd;
                            border-radius: 5px;
                            overflow: hidden;
                            color: #333; /* Cor dos textos dentro do container */
                        }
                        .email-header {
                            background-color: #0099ff;
                            color: white;
                            padding: 10px;
                            text-align: center;
                        }
                        .email-header h2, .email-header p, .email-header a {
                            color: white; /* Textos dentro do cabeçalho */
                        }
                        .email-footer {
                            background-color: #f4f4f4;
                            color: #666666;
                            padding: 10px;
                            text-align: center;
                            font-size: 12px;
                        }
                        a {
                            color: #0099ff; /* Cor dos links */
                            text-decoration: none;
                        }
                        a:hover {
                            color: #0056b3; /* Cor do link ao passar o mouse */
                        }
                    </style>
                </head>
                <body>
                    <div class='email-container'>
                        <div class='email-header'>
                            <h2>Seja Bem-vindo, $nome, à $nomeBarbearia!</h2>
                            <p>Guarde bem seus dados, pois servirão para acessar sua agenda.</p>
                            <a href='https://exclusivebarbershop.com.br/login-cliente'>Acesse sua agenda aqui</a>
                        </div>
                        <div class='email-footer'>
                            Este e-mail foi enviado em <strong>$data_envio</strong> às <strong>$hora_envio</strong>.
                            Para suporte entre em contato com o estabelecimento.
                        </div>
                    </div>
                </body>
                </html>
            ";
            

            $destino = $email;
            $assunto_email = "Agradecemos seu cadastro ".$nome."!";

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From:'.$nomeBarbearia.'<$email>';

            $enviaremail = mail($destino, $assunto_email, $msgHtml, $headers);
            if($enviaremail){
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
        $nome = $request->getParsedBody()['nome'];
        $email = $request->getParsedBody()['email'];
        $telefone = $request->getParsedBody()['telefone'];
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
    
                    $nome_imagem_principal = "resources/imagens/cliente/" . $nome_imagem;

                    $imagem_principal->moveTo($nome_imagem_principal);
                   
                    unlink($nome_imagem_atual);

                }
            }
        }
       

        $campos = array(
            'nome' => $nome,
            'email' => $email,
            'telefone' => $telefone,
        );
        $campos['senha'] = password_hash($password, PASSWORD_DEFAULT, ["const"=>12]);
        
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
        Usuario::verificarLogin();

        $agendamentos = new Agendamento();
        $consultaAgendamentos  = $agendamentos->selectAgendamento('*', array('*'));

        $barbeiros = new Usuario();
        $resultado = $barbeiros->selectUsuario('*', array('*'));

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');
        
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
            'cliente' => $consultaClientes
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/agenda");
        return $renderer->render($response, "agenda_cliente.php", $data);
    }

    public function confirma_agendamento(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();

        
  
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');
        

        $data['informacoes'] = array(
            'menu_active' => 'agendamentos', 
            'nome_logo' => $nome_logo_site,
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/agenda");
        return $renderer->render($response, "confirma_agendamento.php", $data);
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
        
                $ConsultaHorarios = new Horario();
                $diasSemana = [
                    'Domingo',
                    'Segunda-Feira',
                    'Terça-Feira',
                    'Quarta-Feira',
                    'Quinta-Feira',
                    'Sexta-Feira',
                    'Sábado'
                ];
        
                $horariosTrabalho = [];
        
                if (isset($diasSemana[$diaSemana])) {
                    $turnos = $ConsultaHorarios->selectHorarioSemana($diasSemana[$diaSemana]);
        
                    $turno1 = $turnos[0]['turno1'];
                    $turno2 = $turnos[0]['turno2'];
        
                    if ($turno1 !== "FECHADO") {
                        $arrayTurno1 = explode(",", $turno1);
                        foreach ($arrayTurno1 as $horario) {
                            $horariosTrabalho[] = str_replace(" ", "", $horario);
                        }
                    }
        
                    if ($turno2 !== "FECHADO") {
                        $arrayTurno2 = explode(",", $turno2);
                        foreach ($arrayTurno2 as $horario) {
                            $horariosTrabalho[] = str_replace(" ", "", $horario);
                        }
                    }
                }
        
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
        
                    foreach ($horariosTrabalho as $horario) {
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
        
                            if (!in_array($proximoHorario, $horariosIndisponiveis) && !in_array($horarioFinal, $horariosIndisponiveis)) {
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
    
    
    
    

}