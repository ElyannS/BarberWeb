<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Usuario;
use App\Model\Configuracao;
use App\Model\HorarioBarbeiro;

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
   
    public function generateHourSelects($day, $arrayHoras) {
        $dayCapitalized = ucfirst($day);
        ob_start();
        ?>
        <div class='row'>
            <div class='col-1'>
                <div class='w-49'>
                    <label>
                        Hora início 1 <?= $dayCapitalized ?>
                        <select name='selectI1<?= $dayCapitalized ?>' id='selectHora1' required>
                            <option value='FECHADO'>FECHADO</option>
                            <?php foreach($arrayHoras as $horas) { ?>
                                <option value='<?= $horas ?>'><?= $horas ?></option>
                            <?php } ?>
                        </select>
                    </label>
                </div>
                <div class='w-49'>
                    <label>
                        Hora fim 1 <?= $dayCapitalized ?>
                        <select name='selectF1<?= $dayCapitalized ?>' id='selectHora2' required>
                            <option value='FECHADO'>FECHADO</option>
                            <?php foreach($arrayHoras as $horas) { ?>
                                <option value='<?= $horas ?>'><?= $horas ?></option>
                            <?php } ?>
                        </select>
                    </label>
                </div>
            </div>
            <div class='col-2'>
                <div class='w-49'>
                    <label>
                        Hora início 2 <?= $dayCapitalized ?>
                        <select name='selectI2<?= $dayCapitalized ?>' id='selectHora3' required>
                            <option value='FECHADO'>FECHADO</option>
                            <?php foreach($arrayHoras as $horas) { ?>
                                <option value='<?= $horas ?>'><?= $horas ?></option>
                            <?php } ?>
                        </select>
                    </label>
                </div>
                <div class='w-49'>
                    <label>
                        Hora fim 2 <?= $dayCapitalized ?>
                        <select name='selectF2<?= $dayCapitalized ?>' id='selectHora4' required>
                            <option value='FECHADO'>FECHADO</option>
                            <?php foreach($arrayHoras as $horas) { ?>
                                <option value='<?= $horas ?>'><?= $horas ?></option>
                            <?php } ?>
                        </select>
                    </label>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function barbeiros_create(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
       
        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');

        $usuario = $_SESSION['usuario_logado'];

        $horarios = new HorarioBarbeiro();
        $resultado = $horarios->selectHorarioBarbeiro('*', array('id' => '1'))[0];

        $arrayHoras = explode(", ", $resultado['horas']);
        $days = ['domingo', 'segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado'];

        ob_start();
        foreach ($days as $day) {
            echo $this->generateHourSelects($day, $arrayHoras);
        }
        $selectsHtml = ob_get_clean();

        $data['informacoes'] = array(
            'menu_active' => 'barbeiros',
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario,
            'horarios' => $resultado,
            'selectsHtml' => $selectsHtml
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
        $type =  $type = isset($parsedBody['gestor']);
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
            'telefone' => $telefone,
            'foto_usuario' => $nome_imagem_principal,
            'status' => $status,
            'type' => $gestor,
        );
        $campos['senha'] = password_hash($password, PASSWORD_DEFAULT, ["const"=>12]);
        
        $barbeiros = new Usuario();
        $barbeiros->insertUsuario($campos);
    
        // Obtendo o ID do barbeiro recém-criado
        $resultado = $barbeiros->selectUsuario('*', array('email' => $email))[0];
        $idBarbeiro = $resultado['id'];
    
        // HORÁRIOS DO BARBEIRO
        $diasDaSemana = ['Domingo', 'Segunda', 'Terca', 'Quarta', 'Quinta', 'Sexta', 'Sabado'];
        $horarios = new HorarioBarbeiro();
    
        $arrayHora = ['00:00, 00:30, 01:00, 01:30, 02:00, 02:30, 03:00, 03:30, 04:00, 04:30, 05:00, 05:30, 06:00, 06:30, 07:00, 07:30, 08:00, 08:30, 09:00, 09:30, 10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30, 14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00, 17:30, 18:00, 18:30, 19:00, 19:30, 20:00, 20:30, 21:00, 21:30, 22:00, 22:30, 23:00, 23:30'];

        foreach ($diasDaSemana as $dia) {
            $selectI1 = isset($parsedBody['selectI1'.$dia]) ? $parsedBody['selectI1'.$dia] : 'FECHADO';
            $selectF1 = isset($parsedBody['selectF1'.$dia]) ? $parsedBody['selectF1'.$dia] : 'FECHADO';
            $selectI2 = isset($parsedBody['selectI2'.$dia]) ? $parsedBody['selectI2'.$dia] : 'FECHADO';
            $selectF2 = isset($parsedBody['selectF2'.$dia]) ? $parsedBody['selectF2'.$dia] : 'FECHADO';
    
            $upTurno1 = $this->calcularTurno($selectI1, $selectF1);
            $upTurno2 = $this->calcularTurno($selectI2, $selectF2);
    
            $camposHorarios = array(
                'id_barbeiro' => $idBarbeiro,
                'dia_semana' => $dia,
                'turno1' => $upTurno1,
                'turno2' => $upTurno2,
                'horas' => $arrayHora
            );
    
            $horarios->insertHorarioBarbeiro($camposHorarios);
        }
    
        header('Location: '.URL_BASE.'admin/barbeiros');
        exit();
    }
    
    private function calcularTurno($horaInicio, $horaFim) {
        if ($horaInicio === "FECHADO" || $horaFim === "FECHADO") {
            return "FECHADO";
        }
    
        $horaInicio = date('H:i', strtotime($horaInicio));
        $horaFim = date('H:i', strtotime($horaFim));
        $horarios = [];
        $intervalo = 1800; // Intervalo de 30 minutos
    
        for ($horaAtual = strtotime($horaInicio); $horaAtual <= strtotime($horaFim); $horaAtual += $intervalo) {
            $horarioAtual = date('H:i', $horaAtual);
            $horarios[] = $horarioAtual;
        }
    
        return implode(", ", $horarios);
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
        $telefone = $request->getParsedBody()['telefone'];
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
            'telefone' => $telefone,
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

       $resultado = $barbeiros->selectUsuario('*', array('id' => $id))[0];

       unlink($resultado['imagem_principal']);

       $barbeiros->deleteUsuario('id', $id);

       header('Location: '.URL_BASE.'admin/barbeiros');
       exit();
    }

}