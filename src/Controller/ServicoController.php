<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Servico;
use App\Model\Usuario;
use App\Model\Configuracao;

final class ServicoController 
{
     
    public function servicos(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        $servicos = new Servico();

        if(isset($_GET['pesquisa']) && $_GET['pesquisa'] !== ''){
            $lista = $servicos->selectServicosPesquisa($_GET['pesquisa']);
            $paginaAtual = 1;
            $proximaPagina = false;
            $paginaAnterior = false;
            
        } else{
            $limit = 10;
            $paginaAtual = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($paginaAtual*$limit) - $limit;

            $qntTotal = count($servicos->selectServico('*' , array('1'=>'1')));

            $proximaPagina = ($qntTotal > ($paginaAtual*$limit)) ? URL_BASE."admin/servicos?page=".($paginaAtual+1) : false;

            $paginaAnterior = ($paginaAtual > 1) ? URL_BASE."admin/servicos?page=".($paginaAtual-1) : false;

            $lista = $servicos->selectServicosPage($limit, $offset);
        }

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');
        
        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array(
            'menu_active' => 'servicos',
            'lista' => $lista,
            'paginaAtual' => $paginaAtual,
            'proximaPagina' => $proximaPagina,
            'paginaAnterior' => $paginaAnterior,
            'nome_logo' => $nome_logo_site,
            'usuario' => $usuario
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/servico");
        return $renderer->render($response, "servicos.php", $data);
    }
    public function servicos_create(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        $servicos = new Servico();

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');
        $data['informacoes'] = array(
            'menu_active' => 'servicos',
            'nome_logo' => $nome_logo_site
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/servico");
        return $renderer->render($response, "create.php", $data);
    }
    public function servicos_edit(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();
        $servicos = new Servico();

        $id = $args['id'];

        $servicos = new Servico();

        $resultado = $servicos->selectServico('*', array('id' => $id))[0];

        $config = new Configuracao();
        $nome_logo_site = $config->getConfig('logo_site');
        $data['informacoes'] = array(
            'menu_active' => 'servicos',
            'servico' => $resultado,
            'nome_logo' => $nome_logo_site
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/servico");
        return $renderer->render($response, "edit.php", $data);
    }
    public function servicos_insert(
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
            'imagem_principal' => $nome_imagem_principal,
            'data_cadastro' => $data,
            'tempo_servico' => $tempo_servico
        );
        
        $servicos = new Servico();
        
        $servicos->insertServico($campos);

        $id_servico = $servicos->getUltimoServico()['id'];


        header('Location: '.URL_BASE.'admin/servicos');
        exit();
    }


//UPDATE SERVIÇOS

    public function servicos_update(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $request->getParsedBody()['id'];
        $titulo = $request->getParsedBody()['titulo'];
        $data = $request->getParsedBody()['data'];
        $descricao = $request->getParsedBody()['descricao'];
        $tempo_servico = $request->getParsedBody()['tempo_servico'];
        

        $nome_imagem_atual = $request->getParsedBody()['nome_imagem_atual'];

        $imagem_atualizar = false;

        if($request->getUploadedFiles()['imagem_principal']->getClientFilename() !== '') {
            $imagem_atualizar = true;
            $nome_imagem_principal = "";

            //Usuario quer atualizar a imagem principal
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

                    unlink($nome_imagem_atual); // deleta as imagens do diretorio
                }
            }
        }

        $campos = array(
            'id' => $id,
            'titulo' => $titulo,
            'url_amigavel' => $this->gerarUrlAmigavel($titulo),
            'data_cadastro' => $data,
            'tempo_servico' => $tempo_servico
            
        );
        if($imagem_atualizar) {
            $campos['imagem_principal'] = $nome_imagem_principal;
        }
        
        $servicos = new Servico();
        
        $servicos->updateServico($campos, array('id' => $id));
        
        header('Location: '.URL_BASE.'admin/servicos');
        exit();
    }

    public function servicos_delete(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
       $id = $request->getParsedBody()['id'];

       $servicos = new Servico();

       $resultado = $servicos->selectServico('*', array('id' => $id))[0];

       unlink($resultado['imagem_principal']);

       $servicos->deleteServico('id', $id);

       header('Location: '.URL_BASE.'admin/servicos');
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