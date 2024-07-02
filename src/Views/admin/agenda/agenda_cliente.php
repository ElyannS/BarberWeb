<?=$this->fetch('../commons/header.php', $data)?>
<section class="agenda">
    <div class="container">
        <div class="top-container">
            <div class="agenda-top"> 
                <div class="menu-agenda">
                
                    <div class="title-menu">
                        <div class="dateCliente"></div>
                    </div>
                    <label>
                        Selecione o serviço:
                        <select name="servico" id="servicoCliente">
                            <option value="sel">Selecione um opção</option>
                            <?php foreach ($data['informacoes']['servico'] as $servico) {?>
                                <option value="<?=$servico['tempo_servico']?>;<?=$servico['id']?>"><?=$servico['titulo']?></option>
                            <?php }?>
                        </select>
                    </label>
                    <label>
                        Selecione uma data:
                        <input type="date" id="dataCliente"/>
                    </label>
                    <label>
                        <button id="mostrarHorarios">VER HORÁRIOS</button>
                    </label>
                </div>
                <div class="alertaAviso">

                </div>
                
                <div class="containerHorarios">
                    <div class="itensHorarios">
                       
                    </div>
                </div>
                
                <div class="form">
                    <div class="close-popup">
                        <i class="fa-solid fa-xmark close-form"></i>
                    </div>
                    <form action="<?=URL_BASE?>admin/agendamentos_insert" class="form_ajax" id="form_create" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <label>
                                Nome Cliente
                                <select  class="js-example-basic-single" name="id_cliente">
                                    <option value="3">sem cadastro</option>
                                    <?php foreach ($data['informacoes']['cliente'] as $clientes) {?>
                                        <option value="<?=$clientes['id']?>"><?=$clientes['nome']?> <?php if($clientes['telefone']) echo ' - ' . $clientes['telefone']?></option>
                                    <?php }?>
                                </select>
                            </label>
                        </div>
                        <div class="row">
                            <label>
                                Observação
                                <input type="text" name="descricao" >
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
                                    <input type="hidden" id="data1" name="date">
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <label>
                                Horário
                                <select name="time" id="horariosDisponiveis"></select>
                            </label>
                        </div>
                        <div class="row">
                            <label>
                                <input name="select_barbeiro" id="selectBarbeiro" type="hidden">
                            </label>
                        </div>
                        <div class="row">
                            <button type="submit" id="">Agendar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?=$this->fetch('../commons/footer.php')?>