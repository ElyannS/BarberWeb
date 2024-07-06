<?=$this->fetch('../commons/header.php', $data)?>
<section class="minhaAgenda">
    <div class="container">
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Minha Agenda</p>
            </div>
        </div>
        <div class="agendamentosCliente">
            <div class="itensAgen">

                <?php foreach($data['informacoes']['agendamentos_futuros'] as $agendamentos ){ ?>
                    <div class="itemAgend">
                        <div class="agendaTopo">
                            <i class="fa-regular fa-calendar-check"></i>
                            <h1>Agendamento</h1>
                        </div>
                        <div class="infoAgendamento">
                            <span class="horaClient">
                                <i class="fa-solid fa-user-clock"></i>
                                <?=date('H:i', strtotime($agendamentos['data_agendamento']))?>, <?=date('d-m-Y', strtotime($agendamentos['data_agendamento']))?>
                            </span>
                            <span class="servicoMarcado">
                                <img class="icon_svg" src="<?=URL_BASE?>resources/imagens/servico1.svg">
                                <?=$agendamentos['nome_servico']?>
                            </span>
                            <span class="barbeiroCliente">
                                <img class="icon_svg" src="<?=URL_BASE?>resources/imagens/barber1.svg">
                                <?=$agendamentos['nome_barbeiro']?>
                            </span>
                            <span class="btnClient">
                                <div class="topo">
                                    <div class="btn displayBtn">
                                        <button id="CancelarHorario">Cancelar Agendamento</button>
                                        <a href="<?=URL_BASE?>admin/barbeiros-create">Chamar no Whats <i class="fa-brands fa-whatsapp"></i></a>
                                    </div>
                                    <div class="btn CancelAganda">
                                        <form action="">
                                            <button>Cancelar</button>
                                        </form>
                                        <button id="confirmarCancelar">Fechar</button>
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
                <?php }?>
                <div class="titulo_pagina topAgen">
                    <div class="titulo-migalha">
                        <i class="fa-solid fa-circle"></i>
                        <p>Agendamentos passados</p>
                    </div>
                </div>

                <?php foreach($data['informacoes']['agendamentos_passados'] as $agendamentos ){ ?>
                    <div class="itemAgend">
                        <div class="agendaTopo">
                            <i class="fa-regular fa-calendar-check"></i>
                            <h1>Agendamento</h1>
                        </div>
                        <div class="infoAgendamento">
                            <span class="horaClient">
                                <i class="fa-solid fa-user-clock"></i>
                                <?=date('H:i', strtotime($agendamentos['data_agendamento']))?>, <?=date('d-m-Y', strtotime($agendamentos['data_agendamento']))?>
                            </span>
                            <span class="servicoMarcado">
                                <img class="icon_svg" src="<?=URL_BASE?>resources/imagens/servico1.svg">
                                <?=$agendamentos['nome_servico']?>
                            </span>
                            <span class="barbeiroCliente">
                                <img class="icon_svg" src="<?=URL_BASE?>resources/imagens/barber1.svg">
                                <?=$agendamentos['nome_barbeiro']?>
                            </span>
                        </div>
                    </div>
                <?php }?>
                </div>
            </div>
        </div>

    </div>

</section>
<?=$this->fetch('../commons/footer.php', $data)?>