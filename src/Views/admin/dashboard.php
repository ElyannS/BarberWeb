<?=$this->fetch('commons/header.php', $data)?>
<section class="dashboard">
    <div class="container">
        <div class="logo">
            <img src="<?=URL_BASE.$data['informacoes']['nome_logo']?>" alt="">
        </div>
        <div class="menu_pagina_inicial">
           <div class="itens_menu">
                <a href="#" class="item_menu">
                    <div class="circulo"><img class="icon_svg" src="<?=URL_BASE?>resources/imagens/calendar.svg"></div>
                    <p>Agenda</p>
                </a>
                <a href="#" class="item_menu">
                    <div class="circulo"><img class="icon_svg" src="<?=URL_BASE?>resources/imagens/cash.svg"></div>
                    <p>Caixa</p>
                </a>
            </div>
            <div class="itens_menu">    
                <a href="#" class="item_menu">
                    <div class="circulo"><img class="icon_svg" src="<?=URL_BASE?>resources/imagens/servico.svg"></div>
                    <p>Serviços</p>
                </a>
                <a href="#" class="item_menu">
                    <div class="circulo"><img class="icon_svg" src="<?=URL_BASE?>resources/imagens/barber.svg"></div>
                    <p>Barbeiros</p>
                </a>
           </div>
        </div>
    </div>
</section>
<?=$this->fetch('commons/footer.php', $data)?>