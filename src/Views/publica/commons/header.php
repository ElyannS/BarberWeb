<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
    <title><?=$data['informacoes']['pagina']['nome_site']?></title>
    <link href="<?=URL_BASE?>resources/fonts/fontawesome/css/all.min.css" rel="stylesheet"/>
    <link href="<?=URL_BASE?>resources/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=URL_BASE?>resources/css/estilo.css" rel="stylesheet">
</head>
<body>
    <div class="hero_area">
        <div class="hero_bg_box">
        <img src="<?=URL_BASE?>resources/imagens/hero-bg.jpg" alt="">
        </div>
    </div>
	<header>
        <div class="container">
            <nav class="navbar navbar-default navbar-fixed-top">
                <section class="container">
                    <div class="navbar-header">
                        <button type="button"
                                class="navbar-toggle collapsed"
                                data-toggle="collapse"
                                data-target="#movelmenu"
                                aria-expanded="false">

                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>                      
                        
                        <a href="#" class="navbar-brand logoB">
                            <img class="img-responsive" width="80"  src="<?=URL_BASE.$data['informacoes']['pagina']['logo_site']?>">
                        </a>
                    </div>
                    
                    <div class="collapse navbar-collapse pull-right"  id="movelmenu">
                        <ul class="nav navbar-nav">
                            <li><a href="<?=URL_BASE?>">Início</a></li>
                            <li><a href="<?=URL_BASE?>login-cliente">Agendamento</a></li>
                            <li><a href="<?=URL_BASE?>servicos">Serviços</a></li>
                            <li><a href="<?=URL_BASE?>produtos">Produtos</a></li>
                            <li>
                                <a class="nav-link" href="https://www.instagram.com/<?=$data['informacoes']['pagina']['link_instagram']?>" target="_blank">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            </li>
                            <li>
                            <a class="nav-link" href="http://api.whatsapp.com/send?1=pt_BR&amp;phone= <?=$data['informacoes']['pagina']['telefone_contato']?>" target="_blank">
                                <i class="fa-brands fa-whatsapp" aria-hidden="true"></i> </a>
                            </li>      
                        </ul>           
                    </div>
                </section>
            </nav>
        </div>
	</header>