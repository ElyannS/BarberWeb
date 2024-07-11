<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard background-white">
    <div class="container">
    <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Agendamento - Editar</p>
            </div>
        </div>
        <div class="form">
            <form action="<?=URL_BASE?>admin/agendamentos_update" method="post" enctype="multipart/form-data">
                <div class="row">
                    <label>
                        Nome Cliente
                        <select  class="js-example-basic-single" name="id_cliente">
                        <option value="<?=$data['informacoes']['agendamento']['id_cliente']?>"><?=$data['informacoes']['agendamento']['nome_cliente']?> <?php if($data['informacoes']['agendamento']['telefone_cliente']) echo '- ' . $data['informacoes']['agendamento']['telefone_cliente']?></option>
                            <?php foreach ($data['informacoes']['cliente'] as $clientes) {?>
                                <option value="<?=$clientes['id']?>"><?=$clientes['nome']?> <?php if($clientes['telefone']) echo '- ' . $clientes['telefone'] ?></option>
                            <?php }?>
                        </select>
                    </label>
                </div>
                <div class="row">
                    <label>
                        Observação
                        <input type="text" name="descricao" value="<?=$data['informacoes']['agendamento']['descricao']?>">
                    </label>
                </div>
                <div class="row">
                            <div class="w-80">
                                <label>
                                    Selecione o Serviço
                                    <select name="select_servico" id="tempo" disabled>
                                        <option value=""><?=$data['informacoes']['agendamento']['nome_servico']?></option>
                                    </select>
                                </label>
                            </div>
                            <div class="w-20">
                                <label for="data">
                                    Data
                                    <input type="date" id="data" name="data" value="<?= date('Y-m-d', strtotime($data['informacoes']['agendamento']['data_agendamento']))?>" disabled>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <label>
                                Horário
                                <input type="text" value="<?=date('H:i', strtotime($data['informacoes']['agendamento']['data_agendamento']))?>" disabled>
                            </label>
                        </div>
                        <div class="row">
                            <label>
                                Barbeiro
                                <select name="select_barbeiro" disabled>
                                    <option value=""><?=$data['informacoes']['agendamento']['nome_barbeiro']?></option>
                                </select>
                            </label>
                        </div>
                <div class="row">
                    <button class="button" type="submit">Atualizar Agendamento</button>
                </div>
                <input type="hidden" id="idAgendamento" name="id" value="<?=$data['informacoes']['agendamento']['id']?>">
            </form>
            
            <form action="<?=URL_BASE?>admin/agendamentos_delete"  method="post">
                <input type="hidden" name="id" value="<?=$data['informacoes']['agendamento']['id']?>">
                <button class="button" type="submit">Cancelar Agendamento</button>
            </form>
        </div>



</section>
<?=$this->fetch('../commons/footer.php', $data)?>