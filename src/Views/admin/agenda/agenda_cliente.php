<?=$this->fetch('../commons/header.php', $data)?>
<section class="agenda">
    <div class="container">
        <div class="top-container">
            <div class="agenda-top"> 
            <div class="container-popup">
                    <div class="close-popup">
                        <i class="fa-solid fa-xmark close"></i>
                    </div>
                   
                </div>
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
            </div>
        </div>
    </div>
</section>
<?=$this->fetch('../commons/footer.php')?>