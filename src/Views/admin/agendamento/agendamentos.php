<?=$this->fetch('../commons/header.php', $data)?>
<section class="agenda">
    <div class="container">
        <div class="top-container">
            <div class="agenda-top"> 
                <div class="container-popup">
                    <div class="close-popup">
                        <i class="fa-solid fa-xmark close"></i>
                    </div>
                    <div class="opcao-popup">
                        <a href="#" id="btn-agendar">Agendar</a>
                        <a href="#">Bloquear</a>
                    </div>    
                </div>
                <div class="menu-agenda">
                    <div class="title-menu">
                        <div class="icon-menu">
                            <i id="prevButton" class="fa-solid fa-angle-left"></i>
                            <input type="date" id="dataMarcada" class="hidden" />
                            <span class="calendarIcon"><i class="fa-solid fa-calendar-days"></i></span>
                        </div>
                        <div class="date"></div>
                        <i id="nextButton" class="fa-solid fa-angle-right"></i>
                    </div>
                    
                    <div class="calendar">
                        <div class="week">
                            <p>D</p>
                            <p>S</p>
                            <p>T</p>
                            <p>Q</p>
                            <p>Q</p>
                            <p>S</p>
                            <p>S</p>
                        </div>
                       
                        <div class="date_ext">
    
                        </div>
                    </div>
                    
                </div>
                <div id="tabelaHorarios">

                    
                </div>
                <div id="aviso">

                </div>
                <div class="form">
                    <div class="close-popup">
                        <i class="fa-solid fa-xmark close-form"></i>
                    </div>
                    <form action="<?=URL_BASE?>admin/agendamentos_insert" class="form_ajax" id="form_create" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <label>
                                Nome Cliente
                                <select name="id_cliente">
                                    <?php foreach ($data['informacoes']['cliente'] as $clientes) {?>
                                        <option value="<?=$clientes['id']?>"><?=$clientes['nome']?> - <?=$clientes['telefone']?></option>
                                    <?php }?>
                                    </select>
                                </label>
                        </div>
                        <div class="row">
                            <label>
                                Descrição
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
                                Barbeiro
                                <select name="select_barbeiro" required>
                                    <?php foreach ($data['informacoes']['barbeiro'] as $barbeiros) {?>
                                        <?php if($data['informacoes']['usuario']['id'] === $barbeiros['id']){ ?> 
                                            <option value="<?=$barbeiros['id']?>"><?=$barbeiros['nome']?></option>
                                        <?php }?>
                                    <?php }?>
                                </select>
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