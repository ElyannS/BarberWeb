<?=$this->fetch('../commons/header.php', $data)?>

<section class="dashboard">
    <div class="container">
        <div class="titulo_pagina">
       <i class="fa-regular fa-calendar"></i> Agendamento - Novo 
        </div> 
        <div class="form">
            <form action="<?=URL_BASE?>admin/agendamentos_insert" id="form_create" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <label>
                        Nome Cliente
                        <input type="text" name="nome_cliente" required>
                    </label>
                </div>
                <div class="row">
                    <label>
                        Telefone Cliente
                        <input type="tel" name="telefone_cliente" required>
                    </label>
                </div>
                <div class="row">
                    <div class="w-80">
                        <label>
                            Selecione o Serviço
                            <select name="select_servico" id="tempo" required>
                                
                                <?php foreach ($data['informacoes']['servico'] as $servicos) {?>
                                
                                    <option value="<?=$servicos['tempo_servico']?>;<?=$servicos['id']?>"><?=$servicos['titulo']?></option>
                                <?php }?>
                            </select>
                        </label>
                    </div>
                    <div class="w-20">
                        <label for="data">
                            Data
                            <input type="date" id="data" name="data">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <label>
                        Horários Disponíveis
                        <select name="time" id="horariosDisponiveis"></select>
                    </label>
                </div>
                <div class="row">
                    <label>
                        Selecione o Barbeiro
                        <select name="select_barbeiro" required>
                            <?php foreach ($data['informacoes']['barbeiro'] as $barbeiros) {?>
                                <option value="<?=$barbeiros['id']?>"><?=$barbeiros['nome']?></option>
                            <?php }?>
                        </select>
                    </label>
                </div>
                <div class="row">
                    <button type="submit">Salvar</button>
                </div>
            </form>
        </div>
</section>
<?=$this->fetch('../commons/footer.php', $data)?>