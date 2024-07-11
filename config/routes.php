<?php
use Slim\App;
return function (App $app) {
    //CONTROLADOR ADMIN
    $app->get('/admin-login', '\App\Controller\AdminController:login');
    $app->get('/dashboard', '\App\Controller\AdminController:dashboard');
    $app->get('/admin/perfil', '\App\Controller\AdminController:perfil');
    $app->get('/admin/site', '\App\Controller\AdminController:site');
    $app->get('/admin/logout', '\App\Controller\AdminController:logout');
    $app->post('/admin/perfil_update', '\App\Controller\AdminController:perfil_update');
    $app->post('/admin/login', '\App\Controller\AdminController:verificar_login');
    $app->post('/admin/site_update', '\App\Controller\AdminController:site_update');

    //CONTROLADOR SERVIÇOS
    $app->get('/admin/servicos', '\App\Controller\ServicoController:servicos');
    $app->get('/admin/servicos-create', '\App\Controller\ServicoController:servicos_create');
    $app->get('/admin/servicos-edit/{id}', '\App\Controller\ServicoController:servicos_edit');
    $app->post('/admin/servicos_insert', '\App\Controller\ServicoController:servicos_insert');
    $app->post('/admin/servicos_update', '\App\Controller\ServicoController:servicos_update');
    $app->post('/admin/servicos_delete', '\App\Controller\ServicoController:servicos_delete');


    //CONTROLADOR BARBEIROS
    $app->get('/admin/barbeiros', '\App\Controller\BarbeiroController:barbeiros');
    $app->get('/admin/barbeiros-create', '\App\Controller\BarbeiroController:barbeiros_create');
    $app->get('/admin/barbeiros-edit/{id}', '\App\Controller\BarbeiroController:barbeiros_edit');
    $app->post('/admin/barbeiros_insert', '\App\Controller\BarbeiroController:barbeiros_insert');
    $app->post('/admin/barbeiros_update', '\App\Controller\BarbeiroController:barbeiros_update');
    $app->post('/admin/barbeiros_delete', '\App\Controller\BarbeiroController:barbeiros_delete');
    
    //CONTROLADOR CLIENTES
    $app->get('/login-cliente', '\App\Controller\ClienteController:login_cliente');
    $app->get('/register', '\App\Controller\ClienteController:register_cliente');
    $app->post('/admin/login-cliente', '\App\Controller\ClienteController:verificar_login_cliente');
    $app->get('/admin/logout-cliente', '\App\Controller\ClienteController:logout_cliente');
    $app->get('/receber-email', '\App\Controller\ClienteController:receber_email');
    $app->post('/admin/gerar-token', '\App\Controller\ClienteController:gerar_token');
    $app->get('/redefinir-senha', '\App\Controller\ClienteController:redefinir_senha');
    $app->post('/admin/redefinir', '\App\Controller\ClienteController:redefinir_senha_nova');
    $app->get('/admin/clientes', '\App\Controller\ClienteController:clientes');
    $app->get('/admin/clientes-create', '\App\Controller\ClienteController:clientes_create');
    $app->get('/admin/clientes-edit/{id}', '\App\Controller\ClienteController:clientes_edit');
    $app->post('/admin/clientes_insert', '\App\Controller\ClienteController:clientes_insert');
    $app->post('/admin/clientes_insert_cadastro', '\App\Controller\ClienteController:clientes_insert_cadastro');
    $app->post('/admin/clientes_update', '\App\Controller\ClienteController:clientes_update');
    $app->post('/admin/clientes_delete', '\App\Controller\ClienteController:clientes_delete');
    $app->get('/dashboard-cliente', '\App\Controller\ClienteController:dashboard_cliente');
    $app->get('/admin/agenda-cliente', '\App\Controller\ClienteController:agenda_cliente');
    $app->post('/admin/mostrar_horarios', '\App\Controller\ClienteController:mostrar_horarios');
    $app->post('/admin/insert_agendCliente', '\App\Controller\ClienteController:insert_agendamento_cliente');
    $app->get('/admin/minha-agenda', '\App\Controller\ClienteController:minha_agenda');
    $app->post('/admin/agendacliente_delete', '\App\Controller\ClienteController:agendacliente_delete');
    $app->get('/admin/perfil-cliente', '\App\Controller\ClienteController:perfil_cliente');
    $app->post('/admin/perfil_updateCliente', '\App\Controller\ClienteController:perfil_updateCliente');
    
    
    //CONTROLADOR AGENDAMENTO
    $app->get('/admin/agendamentos', '\App\Controller\AgendamentoController:agendamentos');
    $app->get('/admin/agendamentos-create', '\App\Controller\AgendamentoController:agendamentos_create');
    $app->get('/admin/agendamentos-edit/{id}', '\App\Controller\AgendamentoController:agendamentos_edit');
    $app->post('/admin/atualizar_horarios', '\App\Controller\AgendamentoController:atualizar_horarios');
    $app->post('/admin/atualizar_data', '\App\Controller\AgendamentoController:atualizar_data');
    $app->post('/admin/agendamentos_insert', '\App\Controller\AgendamentoController:agendamentos_insert');
    $app->post('/admin/agendamentos_update', '\App\Controller\AgendamentoController:agendamentos_update');
    $app->post('/admin/agendamentos_delete', '\App\Controller\AgendamentoController:agendamentos_delete');

   //CONTROLADOR CAIXA
   $app->get('/admin/caixa', '\App\Controller\CaixaController:caixa');
   $app->get('/admin/caixa-create', '\App\Controller\CaixaController:caixa_create');
   $app->get('/admin/caixa-relatorio', '\App\Controller\CaixaController:caixa_relatorio');
   $app->get('/admin/caixa-edit/{id}', '\App\Controller\CaixaController:caixa_edit');
   $app->post('/admin/caixa_insert', '\App\Controller\CaixaController:caixa_insert');
   $app->get('/admin/caixa-edit-data/{id}', '\App\Controller\CaixaController:caixa_edit_data');
   $app->post('/admin/caixa_update', '\App\Controller\CaixaController:caixa_update');
   $app->post('/admin/caixa_delete', '\App\Controller\CaixaController:caixa_delete');
   $app->post('/admin/caixa_total_delete', '\App\Controller\CaixaController:caixa_total_delete');
   $app->post('/admin/gerar_relatorio', '\App\Controller\CaixaController:gerar_relatorio');

    //CONTROLADOR HORÁRIO
    $app->get('/admin/horarios', '\App\Controller\HorarioController:horarios');
    $app->get('/admin/horarios-create', '\App\Controller\HorarioController:horarios_create');
    $app->get('/admin/horarios-edit/{id}', '\App\Controller\HorarioController:horarios_edit');
    $app->post('/admin/horarios_insert', '\App\Controller\HorarioController:horarios_insert');
    $app->post('/admin/horarios_update', '\App\Controller\HorarioController:horarios_update');
    $app->post('/admin/horarios_delete', '\App\Controller\HorarioController:horarios_delete');
    $app->post('/admin/gerar_horario', '\App\Controller\HorarioController:gerar_horario');

    //CONTROLADOR HORÁRIO BARBEIRO
    $app->get('/admin/horarios-barbeiro', '\App\Controller\HorarioBarbeiroController:horarios_barbeiro');
    $app->get('/admin/horarios-create-barbeiro', '\App\Controller\HorarioBarbeiroController:horarios_create');
    $app->get('/admin/horarios-edit-barbeiro/{id}', '\App\Controller\HorarioBarbeiroController:horarios_barbeiro_edit');
    $app->post('/admin/horarios_barbeiro_insert', '\App\Controller\HorarioBarbeiroController:horarios_insert');
    $app->post('/admin/horarios_barbeiro_update', '\App\Controller\HorarioBarbeiroController:horarios_barbeiro_update');


    //ROTAS DO WEB SITE
    $app->get('/', '\App\Controller\HomeController:home');
    $app->get('/a-rlbs-motors', '\App\Controller\HomeController:a_rlbs_motors');
    $app->get('/servicos', '\App\Controller\HomeController:servicos');
    $app->get('/videos', '\App\Controller\HomeController:videos');
    $app->get('/blog', '\App\Controller\HomeController:blog');
    $app->get('/fale-conosco', '\App\Controller\HomeController:fale_conosco');
    $app->post('/enviar_formulario_contato', '\App\Controller\HomeController:enviar_formulario_contato');
    $app->post('/enviar_formulario_orcamento', '\App\Controller\HomeController:enviar_formulario_orcamento');
    $app->get('/{any}', '\App\Controller\HomeController:page');
};
