<?php

namespace App\Controller;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Agendamento;
use App\Model\Cliente;
use App\Model\Servico;
use App\Model\Configuracao;
use App\Model\Usuario;
use App\Model\Horario;
use App\Model\HorarioBarbeiro;
final class AgendamentoController 
{
     
    public function agendamentos (
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
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/agendamento");
        return $renderer->render($response, "agendamentos.php", $data);
    }
    public function atualizar_data(
        ServerRequestInterface $request, 
        ResponseInterface $response
        )
    {
        $data = '';
        $idBarbeiro = $_POST['idBarbeiro'];
        $horarios = [];

        if ($request->getMethod() === 'POST') {
            $params = $request->getParsedBody();
            if (isset($params['data'])) {
                $data = $params['data'];
                
               
                $diaSemana = date('w', strtotime($data));
                
                $ConsultaHorarios = new HorarioBarbeiro();
                $diasSemana = [
                    'Domingo',
                    'Segunda',
                    'Terça',
                    'Quarta',
                    'Quinta',
                    'Sexta',
                    'Sabado'
                ];
                
                $horariosTrabalho = [];
                
                if (isset($diasSemana[$diaSemana])) {

                    $turnos = $ConsultaHorarios->selectHorarioSemanaBarbeiro($diasSemana[$diaSemana], $idBarbeiro);
                
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
                
               
                    
                $agendamentos = new Agendamento();
                $consultaAgendamentos = $agendamentos->selectAgendamentoData($data, $idBarbeiro);

                $horariosIndisponiveis = [];

                foreach ($consultaAgendamentos as $agendamento) {
                    $horariosIndisponiveis[] = date('H:i', strtotime($agendamento['data_agendamento']));
                }

               
                foreach ($horariosTrabalho as $horario) {
                    $agendamentoEncontrado = false;
                    $agendamentoNome = '';
                    $nomeServico = '';
                    $idAgendamento = '';
                    $descricao = '';
                    $type = '';
                    
                    if (in_array($horario, $horariosIndisponiveis)) {
                        foreach ($consultaAgendamentos as $agendamento) {
                            if (date('H:i', strtotime($agendamento['data_agendamento'])) === $horario) {
                                $agendamentoEncontrado = true;
                                $contato = '';
                                $semCadastro = '';
                            
                                if($agendamento['telefone_cliente']){
                                    $contato = ' - ' . $agendamento['telefone_cliente'];
                                }
                                if($agendamento['nome_cliente'] === 'sem cadastro '){
                                    $semCadastro = ' - '. $agendamento['descricao'];
                                }
                                if($agendamento['nome_cliente'] === 'BLOQUEADO'){
                                    $nomeServico = '';
                                } else{
                                    $nomeServico = ' - ' .$agendamento['nome_servico'];
                                }
                                $agendamentoNome = $agendamento['nome_cliente'] . $nomeServico . $contato . ' ' . $semCadastro;
                                $nomeServico = $agendamento['nome_servico'];
                                $idAgendamento = $agendamento['id'];
                                $descricao = $agendamento['descricao'];
                                break;
                            }
                        }
                    }

                    if ($agendamentoEncontrado) {
                        $horarios[] = ['horario' => $horario, 'nome' => $agendamentoNome, 'servico' => $nomeServico, 'idAgendamento' => $idAgendamento, 'descricao' => $descricao, 'type' => $type];
                    } else {
                        $horarios[] = ['horario' => $horario, 'nome' => ''];
                    }
                }
            }
        }

    $responseData = ['horarios' => $horarios];
    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode($responseData));
    return $response;
}

    public function agendamentos_create(
        ServerRequestInterface $request,
        ResponseInterface $response)
    {
        Usuario::verificarLogin();

        $barbeiros = new Usuario();

        $resultado = $barbeiros->selectUsuario('*', array('*'));

        $servicos = new Servico();

        $infoServicos = $servicos->selectServico('*', array('1' => 1));

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'agendamentos',
            'barbeiro' => $resultado,
            'servico' => $infoServicos,
            'usuario' => $usuario,
            'nome_logo' => $nome_logo_site
            );

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN . "/agendamento");
        return $renderer->render($response, "create.php", $data);
    }
        

    public function agendamentos_edit(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        
        $id = $args['id'];
        $agendamentos = new Agendamento();

        $resultado = $agendamentos->selectAgendamento($id);


        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $clientes = new Cliente();
        $consultaClientes  = $clientes->selectCliente('*', array('*'));

        $data['informacoes'] = array(
            'menu_active' => 'agendamento',
            'agendamento' => $resultado[0],
            'usuario' => $usuario,
            'nome_logo' => $nome_logo_site,
            'cliente' => $consultaClientes
        );

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/agendamento");
        return $renderer->render($response, "edit.php", $data);
    }
    public function agendamentos_insert(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    )  {
        $id_cliente = $request->getParsedBody()['id_cliente'];
        $descricao = $request->getParsedBody()['descricao'];
        $data = date('Y-m-d', strtotime($request->getParsedBody()['date']));
        $time = date('H:i', strtotime($request->getParsedBody()['time']));
        $select_barbeiro = $request->getParsedBody()['select_barbeiro'];
        $selectServico = $request->getParsedBody()['select_servico'];
        $valores = explode(';', $selectServico);
        $idServico = $valores[1];
        $tempoServico = $valores[0];
        $datetime = $data . ' ' . $time;

        $agendamentos_verificar = new Agendamento();
        $numero_agendamentos = count($agendamentos_verificar->selectAgendamentoVerificar($datetime, $select_barbeiro));
       


    

        if ($numero_agendamentos > 0) {
            $js['status'] = 0;
            $js['msg'] = "Conflito de horários!";
            echo json_encode($js);
            exit();
        } else {
            if($tempoServico == '30'){
                $campos = array(
                    'barbeiro_id' => $select_barbeiro,
                    'servico_id' => $idServico,
                    'data_agendamento' => $datetime,
                    'id_cliente' => $id_cliente,
                    'descricao' => $descricao,
                );
                
                $agendamentos = new Agendamento();
                $agendamentos->insertAgendamento($campos);
    
                $js['status'] = 1;
                $js['msg'] = "Agendamento inserido com sucesso!";
                $js['redirecionar_pagina'] = URL_BASE.'admin/agendamentos';
                echo json_encode($js);
                exit();
            }
            if($tempoServico == '60'){
                $agendamentos_verificar = new Agendamento();
                $consultaAgendamentos = count($agendamentos_verificar->selectAgendamentoVerificar(date('Y-m-d H:i', strtotime('+30 minutes', strtotime($datetime))), $select_barbeiro));
                if($consultaAgendamentos > 0){
                    $js['status'] = 0;
                    $js['msg'] = "Conflito de horários!";
                    echo json_encode($js);
                    exit();
                } else{
                    $campos = array(
                        'barbeiro_id' => $select_barbeiro,
                        'servico_id' => $idServico,
                        'data_agendamento' => $datetime,
                        'id_cliente' => $id_cliente,
                        'descricao' => $descricao,
                    );
                
                    $agendamentos = new Agendamento();
                    $agendamentos->insertAgendamento($campos);
        
                    $js['status'] = 1;
                    $js['msg'] = "Agendamento inserido com sucesso!";
                    $js['redirecionar_pagina'] = URL_BASE.'admin/agendamentos';
                    echo json_encode($js);
                    exit();
                }
            } 
        }



        
    }
    public function agendamentos_insert_bloquear(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    )  {
        $id_cliente = $request->getParsedBody()['id_cliente'];
        $data = date('Y-m-d', strtotime($request->getParsedBody()['date']));
        $time = date('H:i', strtotime($request->getParsedBody()['time']));
        $select_barbeiro = $request->getParsedBody()['select_barbeiro1'];
        $selectServico = $request->getParsedBody()['select_servico'];
        $datetime = $data . ' ' . $time;

        $agendamentos_verificar = new Agendamento();
        $numero_agendamentos = count($agendamentos_verificar->selectAgendamentoVerificar($datetime, $select_barbeiro));
       
 

    

        if ($numero_agendamentos > 0) {
            $js['status'] = 0;
            $js['msg'] = "Conflito de horários!";
            echo json_encode($js);
            exit();
        } else {
            if($selectServico == '3'){
                $campos = array(
                    'barbeiro_id' => $select_barbeiro,
                    'servico_id' => $selectServico,
                    'data_agendamento' => $datetime,
                    'id_cliente' => $id_cliente
                );
                
                $agendamentos = new Agendamento();
                $agendamentos->insertAgendamento($campos);
    
                $js['status'] = 1;
                $js['msg'] = "Bloqueado com sucesso!";
                $js['redirecionar_pagina'] = URL_BASE.'admin/agendamentos';
                echo json_encode($js);
                exit();
            }
            if($selectServico == '2'){
                $agendamentos_verificar = new Agendamento();
                $consultaAgendamentos = count($agendamentos_verificar->selectAgendamentoVerificar(date('Y-m-d H:i', strtotime('+30 minutes', strtotime($datetime))), $select_barbeiro));
                if($consultaAgendamentos > 0){
                    $js['status'] = 0;
                    $js['msg'] = "Conflito de horários!";
                    echo json_encode($js);
                    exit();
                } else{
                    $campos = array(
                        'barbeiro_id' => $select_barbeiro,
                        'servico_id' => $selectServico,
                        'data_agendamento' => $datetime,
                        'id_cliente' => $id_cliente
                    );
                
                    $agendamentos = new Agendamento();
                    $agendamentos->insertAgendamento($campos);
        
                    $js['status'] = 1;
                    $js['msg'] = "Bloqueado com sucesso!";
                    $js['redirecionar_pagina'] = URL_BASE.'admin/agendamentos';
                    echo json_encode($js);
                    exit();
                }
            } 
        }
    }
    public function agendamentos_insert_publica(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    )  {
        $nome_cliente = $request->getParsedBody()['nome_cliente'];
        $telefone_cliente = $request->getParsedBody()['telefone_cliente'];
        $data = date('Y-m-d', strtotime($request->getParsedBody()['data']));
        $time = date('H:i', strtotime($request->getParsedBody()['time']));
        $select_barbeiro = $request->getParsedBody()['select_barbeiro'];
        $selectServico = $request->getParsedBody()['select_servico'];
        $valores = explode(';', $selectServico);
        $idServico = $valores[1];
        $datetime = $data . ' ' . $time;
        
       

        $agendamentos_verificar = new Agendamento();
        $numero_agendamentos = count($agendamentos_verificar->selectAgendamentoVerificar($datetime, $select_barbeiro));

        if ($numero_agendamentos > 0) {
           
            $errorUrl = URL_BASE . 'error?nome_cliente=' . urlencode($nome_cliente);
            header('Location: ' . $errorUrl);
            exit();
        } else {
           
            $campos = array(
                'nome_cliente' => $nome_cliente,
                'telefone_cliente' => $telefone_cliente,
                'data_agendamento' => $datetime,
                'servico_id' => $idServico,
                'barbeiro_id' => $select_barbeiro
            );
        
            $agendamentos = new Agendamento();
            $agendamentos->insertAgendamento($campos);
             
            $successUrl = URL_BASE . 'agendamento_sucesso?nome_cliente=' . urlencode($nome_cliente) . '&data_hora=' . urlencode($datetime);
            header('Location: ' . $successUrl);
            exit();
        }
    }

//UPDATE Agendamentos

    public function agendamentos_update(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $request->getParsedBody()['id'];
        $id_cliente = $request->getParsedBody()['id_cliente'];
        $descricao = $request->getParsedBody()['descricao'];
       

        $campos = array(
            'id_cliente' => $id_cliente,
            'descricao' => $descricao
        );
        
        $agendamentos = new Agendamento();
        
        $agendamentos->updateAgendamento($campos, array('id' => $id));
        
        header('Location: '.URL_BASE.'admin/agendamentos');
        exit();
    }

    public function agendamentos_delete(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
       $id = $request->getParsedBody()['id'];

       $agendamentos = new Agendamento();

       $agendamentos->deleteAgendamento('id', $id);

       header('Location: '.URL_BASE.'admin/agendamentos');
       exit();
    }
    
} 