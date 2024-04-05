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
    public function horarios_create(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        $horarios = new Horario();

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');
        $data['informacoes'] = array(
            'menu_active' => 'horarios',
            'nome_logo' => $nome_logo_site
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/horario");
        return $renderer->render($response, "create.php", $data);
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
    public function horarios_insert(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $titulo = $request->getParsedBody()['titulo'];
        $data = $request->getParsedBody()['data'];
        $descricao = $request->getParsedBody()['descricao'];
        $tempo_servico = $request->getParsedBody()['tempo_servico'];

        $nome_imagem_principal = "";

        if($request->getUploadedFiles()['imagem_principal']) {
            $imagem_principal = $request->getUploadedFiles()['imagem_principal'];
        } else {
            $imagem_principal = false;
        }

        if($imagem_principal) {
            if ($imagem_principal->getError() === UPLOAD_ERR_OK) {
                $extensao = pathinfo($imagem_principal->getClientFilename(), PATHINFO_EXTENSION);

                $nome = md5(uniqid(rand(), true)).pathinfo($imagem_principal->getClientFilename(), PATHINFO_FILENAME).".".$extensao;

                $nome_imagem_principal = "resources/imagens/" . $nome;

                $imagem_principal->moveTo($nome_imagem_principal);
            }
        }

        $campos = array(
            'titulo' => $titulo,
            'url_amigavel' => $this->gerarUrlAmigavel($titulo),
            'descricao' => $descricao,
            'imagem_principal' => $nome_imagem_principal,
            'data_cadastro' => $data,
            'tempo_servico' => $tempo_servico
        );
        
        $horarios = new Horario();
        
        $horarios->insertHorario($campos);

        $id_servico = $horarios->getUltimoHorario()['id'];


        header('Location: '.URL_BASE.'admin/horario');
        exit();
    }


//UPDATE SERVIÇOS

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
            'id' => $id,
            'turno1' => $upTurno1,
            'turno2' => $upTurno2,
        );
        
        $horarios = new Horario();
        
        $horarios->updateHorario($campos, array('id' => $id));
        
        header('Location: '.URL_BASE.'admin/horarios-edit/'.$id);
        exit();
    }

    public function horarios_delete(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
       $id = $request->getParsedBody()['id'];

       $horarios = new Horario();

       $resultado = $horarios->selectHorario('*', array('id' => $id))[0];

       unlink($resultado['imagem_principal']);

       $horarios->deleteServico('id', $id);

       header('Location: '.URL_BASE.'admin/horario');
       exit();
    }

    private function gerarUrlAmigavel($url) {

        $search = ['@<script[^>]*?>.*?</script>@si', '@<style[^>]*?>.*?</style>@siU', '@<[\/\!]*?[^<>]*?>@si', '@<![\s\S]*?--[ \t\n\r]*>@'];
    
        $string = preg_replace($search, '', $url);
    
        $table = ['Š'=>'S','š'=>'s','Đ'=>'Dj','đ'=>'dj','Ž'=>'Z','ž'=>'z','Č'=>'C','č'=>'c','Ć'=>'C','ć'=>'c','À'=>'A','Á'=>'A','Â'=>'A','Ã'=>'A','Ä'=>'A','Å'=>'A','Æ'=>'A','Ç'=>'C','È'=>'E','É'=>'E','Ê'=>'E','Ë'=>'E','Ì'=>'I','Í'=>'I','Î'=>'I','Ï'=>'I','Ñ'=>'N','Ò'=>'O','Ó'=>'O','Ô'=>'O','Õ'=>'O','Ö'=>'O','Ø'=>'O','Ù'=>'U','Ú'=>'U','Û'=>'U','Ü'=>'U','Ý'=>'Y','Þ'=>'B','ß'=>'Ss','à'=>'a','á'=>'a','â'=>'a','ã'=>'a','ä'=>'a','å'=>'a','æ'=>'a','ç'=>'c','è'=>'e','é'=>'e','ê'=>'e','ë'=>'e','ì'=>'i','í'=>'i','î'=>'i','ï'=>'i','ð'=>'o','ñ'=>'n','ò'=>'o','ó'=>'o','ô'=>'o','õ'=>'o','ö'=>'o','ø'=>'o','ù'=>'u','ú'=>'u','û'=>'u','ý'=>'y','ý'=>'y','þ'=>'b','ÿ'=>'y','Ŕ'=>'R','ŕ'=>'r'
        ];
    
        $string = strtr($string, $table);
        $string = mb_strtolower($string);
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        $string = str_replace(" ", "-", $string);
        return $string;
    }
} 