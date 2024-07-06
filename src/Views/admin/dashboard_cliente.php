<?=$this->fetch('commons/header.php', $data)?>
<section class="dashboard">
    <div class="container">
        <div class="logo">
            <p>Bem-vindo, <?=$_SESSION['usuario_logado']['nome']?>!</p>
            <img src="<?=URL_BASE.$data['informacoes']['nome_logo']?>" alt="">
        </div>
        <div class="menu_pagina_inicial">
           <div class="itens_menu">
                    <a href="<?=URL_BASE?>admin/agenda-cliente" class="item_menu">
                        <div class="circulo"><img class="icon_svg" src="<?=URL_BASE?>resources/imagens/calendar.svg"></div>
                        <p>Agendar</p>
                    </a>
                <a href="<?=URL_BASE?>admin/minha-agenda" class="item_menu">
                    <div class="circulo"><img class="icon_svg" src="<?=URL_BASE?>resources/imagens/agenda.svg"></div>
                    <p>Minha agenda</p>
                </a>
            </div>
            <div class="itens_menu">    
                <a href="<?=URL_BASE?>admin/servicos" class="item_menu">
                    <div class="circulo"><img class="icon_svg" src="<?=URL_BASE?>resources/imagens/servico.svg"></div>
                    <p>Serviços</p>
                </a>
                <a href="<?=URL_BASE?>admin/localizacao" class="item_menu">
                    <div class="circulo"><img class="icon_svg" src="<?=URL_BASE?>resources/imagens/localizacao.svg"></div>
                    <p>Localização</p>
                </a>
           </div>
        </div>
    </div>
</section>
<?=$this->fetch('commons/footer.php', $data)?>