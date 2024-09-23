<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
    <title><?=$data['informacoes']['pagina']['nome_site']?></title>
    <link href="<?=URL_BASE?>resources/css/css.css" rel="stylesheet"/>
    <link href="<?=URL_BASE?>resources/fonts/fontawesome/css/all.min.css" rel="stylesheet"/>
</head>
<body>
	<header>
        <div class="container">
            <div class="header-top">
                <div class="social">
                    <?php
                        if ($data['informacoes']['pagina']['link_facebook'] !== "") {?>
                            <a href="<?=$data['informacoes']['pagina']['link_facebook']?>" target="blank">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                    <?php } ?>
                    <?php
                        if ($data['informacoes']['pagina']['link_instagram'] !== "") {?>
                            <a href="<?=$data['informacoes']['pagina']['link_instagram']?>" target="blank">
                            <i class="fa-brands fa-instagram"></i>
                            </a>
                    <?php } ?>
                    <?php
                        if ($data['informacoes']['pagina']['link_youtube'] !== "") {?>
                            <a href="<?=$data['informacoes']['pagina']['link_youtube']?>" target="blank">
                            <i class="fa-brands fa-youtube"></i>
                            </a>
                    <?php } ?>
                 </div>
                <div class="contatos">
                    <?php
                        if ($data['informacoes']['pagina']['telefone_contato'] !== "") {?>
                            <a href="tel:<?=$data['informacoes']['pagina']['telefone_contato']?>" target="blank">
                                <i class="fa-solid fa-mobile-screen-button"></i>
                                <?=$data['informacoes']['pagina']['telefone_contato']?>
                            </a>
                    <?php } ?>
                
                    <?php
                        if ($data['informacoes']['pagina']['email_contato'] !== "") {?>
                            <a href="mailto:<?=$data['informacoes']['pagina']['email_contato']?>" target="blank">
                                <i class="fa-regular fa-envelope"></i>
                                <?=$data['informacoes']['pagina']['email_contato']?>
                            </a>
                    <?php } ?>
                </div>
            </div>
           <div class="logo-menu">
               <div class="header-logo">
                   <a href="<?=URL_BASE?>">
                       <img src="<?=URL_BASE.$data['informacoes']['pagina']['logo_site']?>">
                   </a>
               </div>
               <div class="header-bottom">
                   <div class="bar">
                       <i class="fa-solid fa-bars"></i>
                   </div>
                   <div class="menu">
                       <ul>
                           <li><a href="<?=URL_BASE?>">Home</a></li>
                           <li><a href="<?=URL_BASE?>a-rlbs-motors">A Exclusive</a></li>
                           <li><a href="<?=URL_BASE?>servicos">Serviços</a></li>
                           <li><a href="<?=URL_BASE?>videos">Agendar</a></li>
                           <li><a href="<?=URL_BASE?>fale-conosco">Fale Conosco</a></li>
                       </ul>
                   </div>
               </div>
           </div>
        </div>
	</header>