<?=$this->fetch('../commons/header.php', $data)?>
<section class="agenda clienteAgenda">
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
            </div>
        </div>
    </div>
</section>
<section class="index">
    <div class="container-popup">
        <div class="close-popup">
            <i class="fa-solid fa-xmark closeAgenda"></i>
        </div>
        <div class="opcao-popup">
        Confira os dados abaixo:
        <form action="">
            <label>
                Barbeiro
                <input type="text" id="nomeBarber">
            </label>
            <label>
                Serviço
                <input type="text" id="nomeSevico">
            </label>
            <label>
                Horário
                <input type="text" id="horarioAgen">
            </label>
            <label >
                Data
                <input type="date" id="dataAgen">
            </label>
            <button type="submit">Confirmar agendamento</button>
        </form>
    </div>
</section>
<?=$this->fetch('../commons/footer.php')?>