<?=$this->fetch('commons/header.php', $data)?>
<section class="dashboard">
    <div class="container">
        <div class="logo">
            <img src="<?=URL_BASE.$data['informacoes']['nome_logo']?>" alt="">
        </div>
        <div class="menu_pagina_inicial">
           <div class="itens_menu">
                <?php if($data['informacoes']['usuario']['type'] != '99'){ ?>
                    <a href="<?=URL_BASE?>admin/agendamentos" class="item_menu">
                        <div class="circulo"><img class="icon_svg" src="<?=URL_BASE?>resources/imagens/calendar.svg"></div>
                        <p>Agenda</p>
                    </a>
                <?php } ?>
                <a href="<?=URL_BASE?>admin/caixa" class="item_menu">
                    <div class="circulo"><img class="icon_svg" src="<?=URL_BASE?>resources/imagens/cash.svg"></div>
                    <p>Caixa</p>
                </a>
                <?php if($data['informacoes']['usuario']['type'] == '99'){ ?>
                    <a href="<?=URL_BASE?>admin/perfil" class="item_menu">
                        <div class="circulo"><img class="icon_svg" src="<?=URL_BASE?>resources/imagens/usuario.svg"></div>
                        <p>Usuário</p>
                    </a>
                <?php } ?>
            </div>
            <div class="itens_menu">    
                <?php if($data['informacoes']['usuario']['type'] != '99'){ ?>
                    <a href="<?=URL_BASE?>admin/servicos" class="item_menu">
                        <div class="circulo"><img class="icon_svg" src="<?=URL_BASE?>resources/imagens/servico.svg"></div>
                        <p>Serviços</p>
                    </a>
                <?php } ?>
                <?php if($data['informacoes']['usuario']['type'] != '99'){ ?>
                    <a href="<?=URL_BASE?>admin/barbeiros" class="item_menu">
                        <div class="circulo"><img class="icon_svg" src="<?=URL_BASE?>resources/imagens/barber.svg"></div>
                        <p>Barbeiros</p>
                    </a>
                <?php } ?>
               
           </div>
        </div>
    </div>
</section>
<?=$this->fetch('commons/footer.php', $data)?>