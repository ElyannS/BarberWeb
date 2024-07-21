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
            <div id="aviso"></div>
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
                                <input type="hidden" id="horaAnteCanc" value="<?=date('H:i', strtotime($agendamentos['data_agendamento']))?>">
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
                                    <div class="btn displayBtn" id="btn<?=$agendamentos['id']?>">
                                        <button id="CancelarHorario" value="<?=$agendamentos['id']?>">Cancelar Agendamento</button>
                                        <a href="https://wa.me/55<?=$agendamentos['telefone_barbeiro']?>?text=Olá,%20Tudo%20bem?%20Meu%20agendamento%20é%20as%20<?=date('H:i', strtotime($agendamentos['data_agendamento']))?>%20no%20dia%20<?=date('d-m-Y', strtotime($agendamentos['data_agendamento']))?>%20com%20o%20barbeiro%20<?=$agendamentos['nome_barbeiro']?>.">Chamar no Whats <i class="fa-brands fa-whatsapp"></i></a>
                                    </div>
                                    <div class="btn CancelAganda" id="Cancel<?=$agendamentos['id']?>">
                                        <form action="<?=URL_BASE?>admin/agendacliente_delete" method="post">
                                            <input type="hidden" name="id" value="<?=$agendamentos['id']?>">
                                            <button>Cancelar</button>
                                        </form>
                                        <button id="confirmarCancelar" value="<?=$agendamentos['id']?>">Fechar</button>
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