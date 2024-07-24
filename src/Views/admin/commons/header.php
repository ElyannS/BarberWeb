<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
    <title>Exclusive Barbershop</title>
    <link rel="shortcut icon" href="<?=URL_BASE?>resources/imagens/favicon.png"/>
    <link href="<?=URL_BASE?>resources/css/css.css" rel="stylesheet"/>
    <link href="<?=URL_BASE?>resources/fonts/fontawesome/css/all.min.css" rel="stylesheet"/>
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body class="admin">
	<header>
        <div class="container">
            <div class="left">
                <a href="#">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
            <div class="right">
                <div class="menu">
                
                    <ul>       
                        <?php if($data['informacoes']['menu_active'] === 'agendamentos'){?>
                            <?php if($_SESSION['usuario_logado']['type'] != 3){?>
                                <li>
                                    <select name="idBarbeiro" id="idBarbeiro">
                                        <?php foreach($data['informacoes']['barbeiro'] as $barbeiros){?>
                                            <option value="<?=$barbeiros['id']?>" <?= ($_SESSION['usuario_logado']['id'] === $barbeiros['id']) ? 'selected="selected"' : '' ?>><?= $barbeiros['nome'] ?></option>
                                        <?php }?>
                                    </select>
                                </li>
                            <?php }?>
                        <?php }?>
                        <li>
                            <?php if($data['informacoes']['menu_active'] === 'agendamentos'){?>
                                <?php if($_SESSION['usuario_logado']['type'] != '3'){?>
                                    <i class="fa-solid fa-calendar-days"></i>
                                    <input type="date" id="dataMarcada" class="hidden"/>
                                <?php }?>
                            <?php }?>
                            <img src="<?=URL_BASE.$_SESSION['usuario_logado']['foto_usuario']?>">
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="menu_lateral">
            <div class="top">
                <img src="<?=URL_BASE.$data['informacoes']['nome_logo']?>" alt="" class="logo">
                <div class="menu">
                    <ul>
                        <li>
                            <img src="<?=URL_BASE.$_SESSION['usuario_logado']['foto_usuario']?>">
                            <div class="name_user">
                                <?=$_SESSION['usuario_logado']['nome']?>
                            </div>
                        </li>
                    </ul>
                </div>
                <hr>
                <ul>
                    <?php if($data['informacoes']['usuario']['type'] != '3'){ ?>
                        <li class="<?=($data['informacoes']['menu_active'] === 'dashboard') ? 'active' : ''?> dash">
                            <a href="<?=URL_BASE?>dashboard">
                                <i class="fas fa-chart-area"></i>
                                Dashboard
                            </a>
                        </li>
                    <?php } ?>

                    <?php if($data['informacoes']['usuario']['type'] == '3'){ ?>
                        <li class="<?=($data['informacoes']['menu_active'] === 'dashboard') ? 'active' : ''?> dash">
                            <a href="<?=URL_BASE?>dashboard-cliente">
                                <i class="fas fa-chart-area"></i>
                                Dashboard
                            </a>
                        </li>
                    <?php } ?>

                    <?php if($data['informacoes']['usuario']['type'] != '99' AND $data['informacoes']['usuario']['type'] != '3'){ ?>
                        <li class="<?=($data['informacoes']['menu_active'] === 'agendamentos') ? 'active' : ''?>">
                            <a href="<?=URL_BASE?>admin/agendamentos">
                                <img class="icon_svg" src="<?=URL_BASE?>resources/imagens/calendar1.svg">
                                Agenda
                            </a>
                        </li>
                    <?php } ?>

                    <?php if($data['informacoes']['usuario']['type'] == '3'){ ?>
                        <li class="<?=($data['informacoes']['menu_active'] === 'agendamentos') ? 'active' : ''?>">
                            <a href="<?=URL_BASE?>admin/agenda-cliente">
                                <img class="icon_svg" src="<?=URL_BASE?>resources/imagens/calendar1.svg">
                                Agendar
                            </a>
                        </li>
                    <?php } ?>
                    
                    <?php if($data['informacoes']['usuario']['type'] == '3'){ ?>
                        <li class="<?=($data['informacoes']['menu_active'] === 'minha_agenda') ? 'active' : ''?>">
                            <a href="<?=URL_BASE?>admin/minha-agenda">
                               <img class="icon_svg" src="<?=URL_BASE?>resources/imagens/calendar3.svg">
                                Minha agenda
                            </a>
                        </li>
                    <?php } ?>

                    <?php if($data['informacoes']['usuario']['type'] != '99'){ ?>
                        <li class="<?=($data['informacoes']['menu_active'] === 'servicos') ? 'active' : ''?>">
                            <a href="<?=URL_BASE?>admin/servicos">
                            <img class="icon_svg" src="<?=URL_BASE?>resources/imagens/servico1.svg">
                                Serviços
                            </a>
                        </li>
                    <?php } ?>
                    <?php if($data['informacoes']['usuario']['type'] == '1'){ ?>
                        <li class="<?=($data['informacoes']['menu_active'] === 'caixa') ? 'active' : ''?>">
                            <a href="<?=URL_BASE?>admin/produtos">
                            <i class="fa-solid fa-bag-shopping"></i>
                                Produtos
                            </a>
                        </li>
                    <?php } ?>
                    <?php if($data['informacoes']['usuario']['type'] != '3'){ ?>
                        <li class="<?=($data['informacoes']['menu_active'] === 'caixa') ? 'active' : ''?>">
                            <a href="<?=URL_BASE?>admin/caixa">
                            <img class="icon_svg" src="<?=URL_BASE?>resources/imagens/cash1.svg">
                                Caixa
                            </a>
                        </li>
                    <?php } ?>

                    <?php if($data['informacoes']['usuario']['type'] != '99'){ ?>
                        <li class="<?=($data['informacoes']['menu_active'] === 'barbeiros') ? 'active' : ''?>">
                            <a href="<?=URL_BASE?>admin/barbeiros">
                            <img class="icon_svg" src="<?=URL_BASE?>resources/imagens/barber1.svg">
                                Barbeiros
                            </a>
                        </li>
                    <?php } ?>

                    <?php if($data['informacoes']['usuario']['type'] != '99' AND $data['informacoes']['usuario']['type'] != '3'){ ?>
                        <li class="<?=($data['informacoes']['menu_active'] === 'clientes') ? 'active' : ''?>">
                            <a href="<?=URL_BASE?>admin/clientes">
                                <i class="fa-solid fa-user-group"></i>
                                Clientes
                            </a>
                        </li>
                    <?php } ?>

                    <?php if($data['informacoes']['usuario']['type'] != '99'){ ?>
                        <li class="<?=($data['informacoes']['menu_active'] === 'horarios') ? 'active' : ''?>">
                            <a href="<?=URL_BASE?>admin/horarios">
                                <img class="icon_svg" src="<?=URL_BASE?>resources/imagens/relogio.svg">
                                Horários
                            </a>
                        </li>
                    <?php } ?>

                    <?php if($data['informacoes']['usuario']['type'] == '1'){ ?>
                        <li class="<?=($data['informacoes']['menu_active'] === 'horariosT') ? 'active' : ''?>">
                            <a href="<?=URL_BASE?>admin/horarios-barbeiro">
                                <i class="fa-solid fa-briefcase"></i>
                                Horários de trabalho 
                            </a>
                        </li>
                    <?php } ?>
                    <?php if($data['informacoes']['usuario']['type'] == '2'){ ?>
                        <li class="<?=($data['informacoes']['menu_active'] === 'horariosT') ? 'active' : ''?>">
                            <a href="<?=URL_BASE?>admin/horarios-barbeiro">
                                <i class="fa-solid fa-briefcase"></i>
                                Horários de trabalho 
                            </a>
                        </li>
                    <?php } ?>
                    <?php if($data['informacoes']['usuario']['type'] != '3'){ ?>
                        <li class="<?=($data['informacoes']['menu_active'] === 'perfil') ? 'active' : ''?>">
                            <a href="<?=URL_BASE?>admin/perfil">
                                <i class="fas fa-user"></i>
                                Usuário
                            </a>
                        </li>
                    <?php } ?>

                    <?php if($data['informacoes']['usuario']['type'] === '3'){ ?>
                        <li class="<?=($data['informacoes']['menu_active'] === 'perfil') ? 'active' : ''?>">
                            <a href="<?=URL_BASE?>admin/perfil-cliente">
                                <i class="fas fa-user"></i>
                                Usuário
                            </a>
                        </li>
                    <?php } ?>

                    <?php if($data['informacoes']['usuario']['type'] === '1'){ ?>
                        <li class="<?=($data['informacoes']['menu_active'] === 'site') ? 'active' : ''?>">
                            <a href="<?=URL_BASE?>admin/site">
                                <img class="icon_svg" src="<?=URL_BASE?>resources/imagens/parametros.svg">
                                Parametros
                            </a>
                        </li> 
                    <?php } ?>
                    <hr> 
                    <?php if($data['informacoes']['usuario']['type'] === '3'){ ?>
                        <li>
                            <a href="<?=URL_BASE?>admin/logout-cliente">
                                <i class="fas fa-sign-out-alt"></i>
                                Sair
                            </a>
                        </li>
                    <?php } ?>

                    <?php if($data['informacoes']['usuario']['type'] != '3'){ ?>
                        <li>
                            <a href="<?=URL_BASE?>admin/logout">
                                <i class="fas fa-sign-out-alt"></i>
                                Sair
                            </a>
                        </li>
                    <?php } ?>
                    
                </ul>
            </div>
            <div class="closeMenu">
                <i class="fas fa-times"></i>
            </div>
        </div>
	</header>
    <div class="conteudo">
