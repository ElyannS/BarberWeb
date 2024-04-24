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
