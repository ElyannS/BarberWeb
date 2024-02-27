<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard">
    <div class="container">
        <div class="titulo_pagina">
        <i class="fa-regular fa-calendar"></i> Agendamento - Editar 
        </div>
        <div class="form">
            <form action="<?=URL_BASE?>admin/agendamentos_update" method="post" enctype="multipart/form-data">
            <div class="row">
                    <label>
                        Nome Cliente
                        <input type="text" name="nome_cliente" value="<?=$data['informacoes']['agendamento']['nome_cliente']?>" required>
                    </label>
                </div>
                <div class="row">
                    <label>
                        Telefone Cliente
                        <input type="tel" name="telefone_cliente" value="<?=$data['informacoes']['agendamento']['telefone_cliente']?>" required>
                    </label>
                </div>
                <div class="row">
                    <button class="button" type="submit">Atualizar Agendamento</button>
                </div>
                <input type="hidden" name="id" value="<?=$data['informacoes']['agendamento']['id']?>">
            </form>
            <div class="delete">
                <button type="submit" class="button" id="deleteButton">Cancelar Agendamento</button>
                <div id="confirmationDialog" style="display: none;">
                    <h3>Tem certeza de que deseja cancelar o Agendamento?</h3>
                    <div class="btn-cancel">
                        <form action="<?=URL_BASE?>admin/agendamentos_delete"  id="deleteForm"  method="post">
                            <input type="hidden" name="id" value="<?=$data['informacoes']['agendamento']['id']?>">
                            <button id="confirmDeleteButton">Sim</button>
                        </form>
                        <button id="cancelDeleteButton">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
</section>
<?=$this->fetch('../commons/footer.php', $data)?>