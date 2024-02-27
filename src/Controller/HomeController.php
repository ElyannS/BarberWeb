<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Configuracao;
use App\Model\Servico;
use App\Model\Recomendacao;
use App\Model\Blog;
use App\Model\Video;

final class HomeController
{
    public function home(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $config = new Configuracao();

        $configuracoes = $config->selectConfiguracao('*', array('1' => 1));
        $info = array();

        foreach ($configuracoes as $c) {

            $info[$c['nome']] = $c['valor'];
            
        }

        $servicos = new Servico();
        $data['servicos'] = $servicos->selectServico('*', array('status' => 's'));

        $recomendacoes = new Recomendacao();
        $data['recomendacoes'] = $recomendacoes->selectRecomendacao('*', array('status' => 's'));

        $blogs = new Blog();
        $data['blogs'] = $blogs->selectBlog('*', array('status' => 's'));

        $data['informacoes'] = array(
            'pagina' => $info,
        );

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES);
        return $renderer->render($response, "home.php", $data);
    }

    public function a_rlbs_motors(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $servicos = new Servico();
        $data['servicos'] = $servicos->selectServico('*', array('status' => 's'));

        $config = new Configuracao();

        $configuracoes = $config->selectConfiguracao('*', array('1' => 1));
        $info = array();

        foreach ($configuracoes as $c) {

            $info[$c['nome']] = $c['valor'];
            
        }
        $info['nome_site'] = "A RLBS Motor - ".$info['nome_site'];

        $recomendacoes = new Recomendacao();

        $data['recomendacoes'] = $recomendacoes->selectRecomendacao('*', array('status' => 's'));

        $data['informacoes'] = array(
            'title' => 'A RLBS Motors',
            'descricao' => 'Aqui vem a descricao da página institucional',
            'pagina' => $info
        );
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES);
        return $renderer->render($response, "a_rlbs_motors.php", $data);
    }

    public function servicos(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $config = new Configuracao();

        $configuracoes = $config->selectConfiguracao('*', array('1' => 1));
        $info = array();

        foreach ($configuracoes as $c) {

            $info[$c['nome']] = $c['valor'];
            
        }
        $info['nome_site'] = "Nossos Serviços - ".$info['nome_site'];

        $servicos = new Servico();
        $data['servicos'] = $servicos->selectServico('*', array('status' => 's'));

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES);

        $data['informacoes'] = array(
            'title' => 'Nossos Serviços',
            'descricao' => 'Aqui vem a descricao da página servicos',
            'pagina' => $info
        );
        return $renderer->render($response, "servicos.php", $data);
    }

    public function videos(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $config = new Configuracao();

        $configuracoes = $config->selectConfiguracao('*', array('1' => 1));
        $info = array();

        foreach ($configuracoes as $c) {

            $info[$c['nome']] = $c['valor'];
            
        }
        $info['nome_site'] = "Vídeos - ".$info['nome_site'];

        $videos = new Video();
        $data['videos'] = $videos->selectVideo('*', array('status' => 's'));
        
        $servicos = new Servico();
        $data['servicos'] = $servicos->selectServico('*', array('status' => 's'));


        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES);

        $data['informacoes'] = array(
            'title' => 'Vídeos',
            'descricao' => 'Aqui vem a descricao da página vídeos',
            'pagina' => $info
        );
        return $renderer->render($response, "videos.php", $data);
    }

    public function blog(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $config = new Configuracao();

        $configuracoes = $config->selectConfiguracao('*', array('1' => 1));
        $info = array();

        foreach ($configuracoes as $c) {

            $info[$c['nome']] = $c['valor'];
            
        }
        $info['nome_site'] = "Blogs - ".$info['nome_site'];

        $servicos = new Servico();
        $data['servicos'] = $servicos->selectServico('*', array('status' => 's'));
        
        $blogs = new Blog();

        $limit = 9;
        $paginaAtual = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($paginaAtual*$limit) - $limit;

        $qntTotal = count($blogs->selectBlog('*' , array('1'=>'1')));

        $proximaPagina = ($qntTotal > ($paginaAtual*$limit)) ? URL_BASE."blog?page=".($paginaAtual+1) : false;

        $paginaAnterior = ($paginaAtual > 1) ? URL_BASE."blog?page=".($paginaAtual-1) : false;

        $data['blogs'] = $blogs->selectBlogsPage($limit, $offset);

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES);

        $data['informacoes'] = array(
            'title' => 'Blog',
            'descricao' => 'Aqui vem a descricao da página blog',
            'pagina' => $info,
            'proximaPagina' => $proximaPagina,
            'paginaAnterior' => $paginaAnterior,
            'paginaAtual' => $paginaAtual
        );
        return $renderer->render($response, "blog.php", $data);
    }

    public function fale_conosco(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $config = new Configuracao();

        $configuracoes = $config->selectConfiguracao('*', array('1' => 1));
        $info = array();

        foreach ($configuracoes as $c) {

            $info[$c['nome']] = $c['valor'];
            
        }
        $info['nome_site'] = "Fale Conosco - ".$info['nome_site'];

        $servicos = new Servico();
        $data['servicos'] = $servicos->selectServico('*', array('status' => 's'));
        
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES);

        $data['informacoes'] = array(
            'title' => 'Fale Conosco',
            'descricao' => 'Aqui vem a descricao da página fale Conosco',
            'pagina' => $info
        );
        return $renderer->render($response, "fale_conosco.php", $data);
    }

    public function page(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES);

        $config = new Configuracao();

        $configuracoes = $config->selectConfiguracao('*', array('1' => 1));
        $info = array();

        foreach ($configuracoes as $c) {

            $info[$c['nome']] = $c['valor'];
            
        }
        $info['nome_site'] = "Blogs - ".$info['nome_site'];

        $servicos = new Servico();
        $data['servicos'] = $servicos->selectServico('*', array('status' => 's'));
        
        $url = $args['any'];

        $data['servico'] = $servicos->selectServico('*', array('status' => 's', 'url_amigavel' => $url));

        if (isset($data['servico']) && count($data['servico']) > 0) {

            $data['servico'] =  $data['servico'][0];
            $data['galeria'] = $servicos->selectGaleria($data['servico']['id']);

            $data['informacoes'] = array(
                'title' =>  $data['servico']['titulo'],
                'descricao' => substr(strip_tags($data['servico']['descricao']), 0, 80).'...',
                'pagina' => $info
            );

            return $renderer->render($response, "servico_detalhe.php", $data);

        } else {
            $blogs = new Blog();

            $data['blog'] = $blogs->selectBlog('*', array('status' => 's', 'url_amigavel' => $url));

            if (isset($data['blog']) && count($data['blog']) > 0) {

                $data['blogs'] = $blogs->selectBlog('*', array('status' => 's'));

                $data['blog'] =  $data['blog'][0];

                $data['informacoes'] = array(
                    'title' =>  $data['blog']['titulo'],
                    'descricao' => $data['blog']['descricao'],
                    'pagina' => $info
                );
                return $renderer->render($response, "blog_detalhe.php", $data);
            } else {
                header('Location: '.URL_BASE);
                exit();
            }
        }
    }
    public function enviar_formulario_contato(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
    
        $nome =  $request->getParsedBody()['nome'];
        $email =  $request->getParsedBody()['email'];
        $telefone =  $request->getParsedBody()['telefone'];
        $assunto =  $request->getParsedBody()['assunto'];
        $mensagem =  $request->getParsedBody()['mensagem'];
        $data_envio = date('d/m/Y');
        $hora_envio = date('H:i:s');
    
        // Compo E-mail
        $msgHtml = "
        <style type='text/css'>
        body {
        margin:0px;
        font-family:Verdane;
        font-size:12px;
        color: #666666;
        }
        a{
        color: #666666;
        text-decoration: none;
        }
        a:hover {
        color: #FF0000;
        text-decoration: none;
        }
        </style>
        <html>
            <table width='510' border='1' cellpadding='1' cellspacing='1' bgcolor='#CCCCCC'>
                <tr>
                  <td>
        <tr>
                     <td width='500'>Nome:$nome</td>
                    </tr>
                    <tr>
                      <td width='320'>E-mail:<b>$email</b></td>
         </tr>
          <tr>
                      <td width='320'>Telefone:<b>$telefone</b></td>
                    </tr>
         <tr>
                      <td width='320'>Assunto:$assunto</td>
                    </tr>
                    <tr>
                      <td width='320'>Mensagem:$mensagem</td>
                    </tr>
                </td>
              </tr>
              <tr>
                <td>Este e-mail foi enviado em <b>$data_envio</b> às <b>$hora_envio</b></td>
              </tr>
            </table>
        </html>
        ";
    
        $destino = "ebfs49@gmail.com";
        $assunto_email = "Contato pelo Site: ".$assunto;
    
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: $nome <$email>';
    
        $enviaremail = mail($destino, $assunto_email, $msgHtml, $headers);
        if($enviaremail){
            $js['status'] = 1;
            $js['msg'] = 'Contato enviado com sucesso. Logo entraremos em contato!';
            $js['resetar_form'] = true;
            echo json_encode($js);
            exit();
        } else {
            $js['status'] = 0;
            $js['msg'] = 'Erro ao enviar o Formulário. Tente novamente mais tarde!';
            $js['resetar_form'] = true;
            echo json_encode($js);
            exit();
        }
    
    }
    public function enviar_formulario_orcamento(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
    
        $nome =  $request->getParsedBody()['name'];
        $email =  $request->getParsedBody()['email'];
        $telefone =  $request->getParsedBody()['telefone'];
        $servicos =  $request->getParsedBody()['servicos'];
        $mensagem =  $request->getParsedBody()['mensagem'];
        $data_envio = date('d/m/Y');
        $hora_envio = date('H:i:s');

        $servicos = implode(", ", $servicos);
    
        // Compo E-mail
        $msgHtml = "
        <style type='text/css'>
        body {
        margin:0px;
        font-family:Verdane;
        font-size:12px;
        color: #666666;
        }
        a{
        color: #666666;
        text-decoration: none;
        }
        a:hover {
        color: #FF0000;
        text-decoration: none;
        }
        </style>
        <html>
            <table width='510' border='1' cellpadding='1' cellspacing='1' bgcolor='#CCCCCC'>
                <tr>
                  <td>
        <tr>
                     <td width='500'>Nome:$nome</td>
                    </tr>
                    <tr>
                      <td width='320'>E-mail:<b>$email</b></td>
         </tr>
          <tr>
                      <td width='320'>Telefone:<b>$telefone</b></td>
                    </tr>
         <tr>
                      <td width='320'>Servicos:$servicos</td>
                    </tr>
                    <tr>
                      <td width='320'>Mensagem:$mensagem</td>
                    </tr>
                </td>
              </tr>
              <tr>
                <td>Este e-mail foi enviado em <b>$data_envio</b> às <b>$hora_envio</b></td>
              </tr>
            </table>
        </html>
        ";
    
        $destino = "ebfs49@gmail.com";
        $assunto_email = "Orçamento pelo Site: ".$nome;
    
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: $nome <$email>';
    
        $enviaremail = mail($destino, $assunto_email, $msgHtml, $headers);
        if($enviaremail){
            $js['status'] = 1;
            $js['msg'] = 'Orçamento enviado com sucesso. Logo entraremos em contato!';
            $js['resetar_form'] = true;
            echo json_encode($js);
            exit();
        } else {
            $js['status'] = 0;
            $js['msg'] = 'Erro ao enviar o Orçamento. Tente novamente mais tarde!';
            $js['resetar_form'] = true;
            echo json_encode($js);
            exit();
        }
    
    }
}