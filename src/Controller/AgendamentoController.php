<?php

namespace App\Controller;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Agendamento;
use App\Model\Servico;
use App\Model\Configuracao;
use App\Model\Usuario;

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
        
        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'agendamentos',
            'agendamento' => $consultaAgendamentos,
            'barbeiro' => $resultado,
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario,
            'servico' => $consultaServicos
            ,3,
            
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/agendamento");
        return $renderer->render($response, "agendamentos.php", $data);
    }
    public function atualizar_horarios(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $data = '';
        $tempoServico = '';
        $horarios = [];
    
        if ($request->getMethod() === 'POST') {
            $params = $request->getParsedBody();
            if (isset($params['data']) && isset($params['tempoServico'])) {
                $data = $params['data'];
                
                $tempoServico = $params['tempoServico'];
    
               
                $diaSemana = date('w', strtotime($data));
                if ($diaSemana == 0 || $diaSemana == 1) {
                    $responseData =  ['horarios' => 'fechada'];
                    $response = $response->withHeader('Content-Type', 'application/json');
                    $response->getBody()->write(json_encode($responseData));
                    return $response;
                }
              
                $horariosTrabalho = [];
                if ($diaSemana == 6) { // Sábado
                    $horariosTrabalho = [
                        '08:00','08:30','09:00', '09:30', '10:00', '10:30', '11:00',
                        '11:30', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00'
                    ];
                } elseif ($diaSemana >= 2 && $diaSemana <= 4) { // Terça a Quinta
                    $horariosTrabalho = [
                        '08:30','09:00', '09:30', '10:00', '10:30', '11:00', '11:30','13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30'
                    ];
                } elseif ($diaSemana == 5) { // Sexta
                    $horariosTrabalho = [
                        '08:30','09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '13:30', '14:00',
                        '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30'
                    ];
                } 
                $agendamentos = new Agendamento();
                $consultaAgendamentos = $agendamentos->selectAgendamentoData($data);

                $horariosIndisponiveis = [];
                foreach ($consultaAgendamentos as $agendamento) {
                    $horariosIndisponiveis[] = date('H:i', strtotime($agendamento['data_agendamento']));
                    $horarioAtual = $agendamento['servico_id'];

                   
                    if ($horarioAtual == 2) {
                        $proximoHorario = date('H:i', strtotime($agendamento['data_agendamento']) + 1800);
                        $horariosIndisponiveis[] = $proximoHorario;
                    }
                }
 
               
                if (empty($horariosIndisponiveis)) {
                    $horarios = $horariosTrabalho;
                } else {
                    $horarios = [];
                    foreach ($horariosTrabalho as $horario) { 
                       
                        if (in_array($horario, $horariosIndisponiveis)) {
                            continue; 
                        } 
                
                        
                        if ($tempoServico == 30) {
                         
                            $proximoHorario = date('H:i', strtotime($horario));
                            if (!in_array($proximoHorario, $horariosIndisponiveis)) {
                                $horarios[] = $horario;
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
                                    if($data == date('Y-m-d')){
                                        if($horario > $hora){
                                            $horarios[] = $horario;
                                        }
                                    } else {
                                        $horarios[] = $horario;
                                    }
                                } 
                            }
                        }
                    }
                }                
            }
        }
    
        $responseData = ['horarios' => $horarios];
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode($responseData));
        return $response;
    } 
    public function atualizar_data(
        ServerRequestInterface $request, 
        ResponseInterface $response
        )
    {
        $data = '';
        $horarios = [];

        if ($request->getMethod() === 'POST') {
            $params = $request->getParsedBody();
            if (isset($params['data'])) {
                $data = $params['data'];

               
                $diaSemana = date('w', strtotime($data));
                if ($diaSemana == 0 || $diaSemana == 1) {
                    $responseData =  ['horarios' => 'fechada'];
                    $response = $response->withHeader('Content-Type', 'application/json');
                    $response->getBody()->write(json_encode($responseData));
                    return $response;
                }

               
                $horariosTrabalho = [];
                if ($diaSemana == 6) { // Sábado
                    $horariosTrabalho = [
                        '08:00','08:30','09:00', '09:30', '10:00', '10:30', '11:00',
                        '11:30', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00'
                    ];
                } elseif ($diaSemana >= 2 && $diaSemana <= 4) { // Terça a Quinta
                    $horariosTrabalho = [
                        '08:30','09:00', '09:30', '10:00', '10:30', '11:00', '11:30','13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30'
                    ];
                } elseif ($diaSemana == 5) { // Sexta
                    $horariosTrabalho = [
                        '08:30','09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '13:30', '14:00',
                        '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30'
                    ];
                }

                $agendamentos = new Agendamento();
                $consultaAgendamentos = $agendamentos->selectAgendamentoData($data);

                $horariosIndisponiveis = [];
                foreach ($consultaAgendamentos as $agendamento) {
                    $horariosIndisponiveis[] = date('H:i', strtotime($agendamento['data_agendamento']));
                }

               
                foreach ($horariosTrabalho as $horario) {
                    $agendamentoEncontrado = false;
                    $agendamentoNome = '';
                    $nomeServico = '';
                    $idAgendamento = '';
                    
                    
                    if (in_array($horario, $horariosIndisponiveis)) {
                        foreach ($consultaAgendamentos as $agendamento) {
                            if (date('H:i', strtotime($agendamento['data_agendamento'])) === $horario) {
                                $agendamentoEncontrado = true;
                                $agendamentoNome = $agendamento['nome_cliente'].' - '.$agendamento['nome_servico'].' - '.$agendamento['telefone_cliente'];
                                $nomeServico = $agendamento['nome_servico'];
                                $idAgendamento = $agendamento['id'];
                                break;
                            }
                        }
                    }

                    if ($agendamentoEncontrado) {
                        $horarios[] = ['horario' => $horario, 'nome' => $agendamentoNome, 'servico' => $nomeServico, 'idAgendamento' => $idAgendamento];
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
        
        $data['informacoes'] = array(
            'menu_active' => 'agendamentos',
            'barbeiro' => $resultado,
            'servico' => $infoServicos,
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

        $resultado = $agendamentos->selectAgendament('*', array('id' => $id))[0];


        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');
        $data['informacoes'] = array(
            'menu_active' => 'agendamentos',
            'agendamento' => $resultado,
            'nome_logo' => $nome_logo_site
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/agendamento");
        return $renderer->render($response, "edit.php", $data);
    }
    public function agendamentos_insert(
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
        
        


        $campos = array(
            'nome_cliente' => $nome_cliente,
            'telefone_cliente' => $telefone_cliente,
            'data_agendamento' => $datetime,
            'servico_id' => $idServico,
            'barbeiro_id' => $select_barbeiro
        );
        
        $agendamentos = new Agendamento();
        
        $agendamentos->insertAgendamento($campos);

        header('Location: '.URL_BASE.'admin/agendamentos');
        exit();
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
        $numero_agendamentos = count($agendamentos_verificar->selectAgendamentoVerificar($datetime));

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
        $nome_cliente = $request->getParsedBody()['nome_cliente'];
        $telefone_cliente = $request->getParsedBody()['telefone_cliente'];
       

        $campos = array(
            'id' => $id,
            'nome_cliente' => $nome_cliente,
            'telefone_cliente' => $telefone_cliente,
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