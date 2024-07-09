<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\HorarioBarbeiro;
use App\Model\Usuario;
use App\Model\Configuracao;

final class HorarioBarbeiroController 
{
     
    public function horarios_barbeiro(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        $horarios = new HorarioBarbeiro();
        $idBarbeiro = $_SESSION['usuario_logado']['id'];
    
        $paginaAtual = isset($_GET['page']) ? $_GET['page'] : 1;

        $lista = $horarios->selectHorarioBarbeiro('*' , array('id_barbeiro'=>$idBarbeiro));

        
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');
        
        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'horariosT',
            'lista' => $lista,
            'paginaAtual' => $paginaAtual,
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/horario_barbeiro");
        return $renderer->render($response, "horario_barbeiro.php", $data);
    }
    
    public function horarios_barbeiro_edit(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        $horarios = new HorarioBarbeiro();

        $id = $args['id'];
        $horarios = new HorarioBarbeiro();

        $resultadoHorarios = $horarios->selectHorarioBarbeiro('*', array('id' => $id))[0];
        if($resultadoHorarios) {
            $turno1 = explode(", ", $resultadoHorarios['turno1']);
            $turno2 = explode(", ", $resultadoHorarios['turno2']);
           
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

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'horariosT',
            'horarios' => $resultadoHorarios,
            'turnoInicio1' => $turnoInicio1,
            'turnoFim1' => $turnoFim1,
            'turnoInicio2' => $turnoInicio2,
            'turnoFim2' => $turnoFim2,
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/horario_barbeiro");
        return $renderer->render($response, "edit.php", $data);
    }


    public function horarios_barbeiro_update(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $request->getParsedBody()['id'];
        $selectI1 = $request->getParsedBody()['selectI1'];
        $selectF1 = $request->getParsedBody()['selectF1'];
        $selectI2 = $request->getParsedBody()['selectI2'];
        $selectF2 = $request->getParsedBody()['selectF2'];
        
        Usuario::verificarLogin();
        $idBarbeiro = $_SESSION['usuario_logado']['id'];

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

       
        
        $horarios = new HorarioBarbeiro();
        
        $horarios->updateHorarioTrabalho($upTurno1, $upTurno2, $idBarbeiro, $id);
        
        header('Location: '.URL_BASE.'admin/horarios-edit-barbeiro/'.$id);
        exit();
    }
} 
