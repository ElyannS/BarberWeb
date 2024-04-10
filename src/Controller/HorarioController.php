<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Horario;
use App\Model\Usuario;
use App\Model\Configuracao;
use DateTime;
use DateInterval;

final class HorarioController 
{
     
    public function horarios(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        $horarios = new Horario();

    
        $limit = 10;
        $paginaAtual = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($paginaAtual*$limit) - $limit;

        $qntTotal = count($horarios->selectHorario('*' , array('1'=>'1')));

        $proximaPagina = ($qntTotal > ($paginaAtual*$limit)) ? URL_BASE."admin/horarios?page=".($paginaAtual+1) : false;

        $paginaAnterior = ($paginaAtual > 1) ? URL_BASE."admin/horarios?page=".($paginaAtual-1) : false;

        $lista = $horarios->selectHorariosPage($limit, $offset);


        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');
        
        $data['informacoes'] = array(
            'menu_active' => 'horarios',
            'lista' => $lista,
            'paginaAtual' => $paginaAtual,
            'proximaPagina' => $proximaPagina,
            'paginaAnterior' => $paginaAnterior,
            'nome_logo' => $nome_logo_site,
            
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/horario");
        return $renderer->render($response, "horario.php", $data);
    }
    
    public function horarios_edit(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        $horarios = new Horario();

        $id = $args['id'];

        $horarios = new Horario();

        $resultado = $horarios->selectHorario('*', array('id' => $id))[0];

        if($resultado) {
            $turno1 = explode(", ", $resultado['turno1']);
            $turno2 = explode(", ", $resultado['turno2']);
           
            if(isset($turno1)){
                $turnoInicio1 = $turno1[0];
                $turnoFim1 = end($turno1);
            } else{
                $turnoInicio1 = "FECHADO";
                $turnoFim1 = "FECHADO";
            }
            if(isset($turno2)){
                $turnoInicio2 = $turno2[0];
                $turnoFim2 = end($turno2);
            } else{
                $turnoInicio2 = "FECHADO";
                $turnoFim2 = "FECHADO";
            }
        }
    
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $data['informacoes'] = array(
            'menu_active' => 'horarios',
            'horarios' => $resultado,
            'turnoInicio1' => $turnoInicio1,
            'turnoFim1' => $turnoFim1,
            'turnoInicio2' => $turnoInicio2,
            'turnoFim2' => $turnoFim2,
            'nome_logo' => $nome_logo_site
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/horario");
        return $renderer->render($response, "edit.php", $data);
    }


    public function horarios_update(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $request->getParsedBody()['id'];
        $selectI1 = $request->getParsedBody()['selectI1'];
        $selectF1 = $request->getParsedBody()['selectF1'];
        $selectI2 = $request->getParsedBody()['selectI2'];
        $selectF2 = $request->getParsedBody()['selectF2'];
        

        if($selectI1 && $selectF1 === "FECHADO") {
            $upTurno1 = "FECHADO";
        } else{
            $horaInicio = date('H:i', strtotime($selectI1));
            $horaFim = date('H:i', strtotime($selectF1));

            $horarios = [];

            $intervalo = 1800; 

            for ($horaAtual = strtotime($horaInicio); $horaAtual <= strtotime($horaFim); $horaAtual += $intervalo) {
                
                $horarioAtual = date('H:i', $horaAtual);

                $horarios[] = $horarioAtual;
            }

            $upTurno1 = implode(", ", $horarios);
        }
        $campos = array(
            'turno1' => $upTurno1
        );
        
        $horarios = new Horario();
        
        $horarios->updateHorario($campos, array('id' => $id));

        if($selectI2 && $selectF2 === "FECHADO") {
            $upTurno2 = "FECHADO";
        } else{
            $horaInicio = date('H:i', strtotime($selectI2));
            $horaFim = date('H:i', strtotime($selectF2));

            $horarios = [];

            $intervalo = 1800; 

            for ($horaAtual = strtotime($horaInicio); $horaAtual <= strtotime($horaFim); $horaAtual += $intervalo) {
                
                $horarioAtual = date('H:i', $horaAtual);

                $horarios[] = $horarioAtual;
            }

            $upTurno2 = implode(", ", $horarios);
        }

        $campos = array(
            'turno2' => $upTurno2,
        );
        
        $horarios = new Horario();
        
        $horarios->updateHorario($campos, array('id' => $id));
        
        header('Location: '.URL_BASE.'admin/horarios-edit/'.$id);
        exit();
    }

    public function gerar_horario(
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

                if ($diaSemana == 2) {
                    $Horarios = new Horario();
                    $horarios = $Horarios->selectHorarioSemana('Terça-Feira');
                    
                }
            }
        }

    $responseData = ['horarios' => $horarios];
    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode($responseData));
    return $response;
}
} 
