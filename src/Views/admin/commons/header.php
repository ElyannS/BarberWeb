<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
    <title>Painel Administrativo</title>
    <link href="<?=URL_BASE?>resources/css/css.css" rel="stylesheet"/>
    <link href="<?=URL_BASE?>resources/fonts/fontawesome/css/all.min.css" rel="stylesheet"/>
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
                        <li>
                            <div class="name_user">
                                <?=$_SESSION['usuario_logado']['nome']?>
                            </div>
                           
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
                    <li class="<?=($data['informacoes']['menu_active'] === 'dashboard') ? 'active' : ''?> dash">
                        <a href="<?=URL_BASE?>dashboard">
                            <i class="fas fa-chart-area"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="<?=($data['informacoes']['menu_active'] === 'agendamentos') ? 'active' : ''?>">
                        <a href="<?=URL_BASE?>admin/agendamentos">
                            <img class="icon_svg" src="<?=URL_BASE?>resources/imagens/calendar1.svg">
                            Agenda
                        </a>
                    </li>
                    <li class="<?=($data['informacoes']['menu_active'] === 'servicos') ? 'active' : ''?>">
                        <a href="<?=URL_BASE?>admin/servicos">
                        <img class="icon_svg" src="<?=URL_BASE?>resources/imagens/servico1.svg">
                            Serviços
                        </a>
                    </li>
                    <li class="<?=($data['informacoes']['menu_active'] === 'caixa') ? 'active' : ''?>">
                        <a href="<?=URL_BASE?>admin/caixa">
                        <img class="icon_svg" src="<?=URL_BASE?>resources/imagens/cash1.svg">
                            Caixa
                        </a>
                    </li>
                    <li class="<?=($data['informacoes']['menu_active'] === 'barbeiros') ? 'active' : ''?>">
                        <a href="<?=URL_BASE?>admin/barbeiros">
                        <img class="icon_svg" src="<?=URL_BASE?>resources/imagens/barber1.svg">
                            Barbeiros
                        </a>
                    </li>
                    <li class="<?=($data['informacoes']['menu_active'] === 'clientes') ? 'active' : ''?>">
                        <a href="<?=URL_BASE?>admin/clientes">
                            <i class="fa-solid fa-user-group"></i>
                            Clientes
                        </a>
                    </li>
                    <li class="<?=($data['informacoes']['menu_active'] === 'horarios') ? 'active' : ''?>">
                        <a href="<?=URL_BASE?>admin/horarios">
                            <img class="icon_svg" src="<?=URL_BASE?>resources/imagens/relogio.svg">
                            Horários
                        </a>
                    </li>
                    <li class="<?=($data['informacoes']['menu_active'] === 'perfil') ? 'active' : ''?>">
                        <a href="<?=URL_BASE?>admin/perfil">
                            <i class="fas fa-user"></i>
                            Usuário
                        </a>
                    </li>
                    <?php if($data['informacoes']['usuario']['type'] === '1'){ ?>
                        <li class="<?=($data['informacoes']['menu_active'] === 'site') ? 'active' : ''?>">
                            <a href="<?=URL_BASE?>admin/site">
                                <img class="icon_svg" src="<?=URL_BASE?>resources/imagens/parametros.svg">
                                Parametros
                            </a>
                        </li> 
                    <?php } ?>
                    <hr> 
                    <li>
                        <a href="<?=URL_BASE?>admin/logout">
                            <i class="fas fa-sign-out-alt"></i>
                            Sair
                        </a>
                    </li>
                </ul>
            </div>
            <div class="close">
                <i class="fas fa-times"></i>
            </div>
        </div>
	</header>
    <div class="conteudo">
