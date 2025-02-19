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
                        <input type="hidden" id="valueIn" >
                        <select name="servico" id="servicoCliente" >
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
            <form  method="post" class="form_ajax" action="<?=URL_BASE?>admin/insert_agendCliente">
                <label>
                    Barbeiro
                    <input type="text" id="nomeBarber" disabled>
                    <input type="hidden" id="idBaber" name="idBarbeiro">
                </label>
                <label>
                    Serviço
                    <input type="text" id="nomeSevico"disabled>
                    <input type="hidden" id="idServ" name="idServico">
                </label>
                <label>
                    Horário
                    <input type="text" id="horarioAgen"disabled>
                    <input type="hidden" id="horarioA" name="horarioAgenda">
                </label>
                <label >
                    Data
                    <input type="date" id="dataAgen"disabled>
                    <input type="hidden" id="agendData" name="dataAgen">
                </label>
                <label>
                    Observação
                    <input type="text" id="descricao" name="observacao">
                </label>
                <button type="submit">Confirmar agendamento</button>
                <div class="alerta">

                </div>
            </form>
        </div>
   
    </section>

<?=$this->fetch('../commons/footer.php', $data)?>