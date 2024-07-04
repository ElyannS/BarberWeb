<?=$this->fetch('../commons/header.php', $data)?>
<div class="container">
    <div class="confirma">
        Confira os dados abaixo:
        <form action="">
            <label>
                Barbeiro:
                <input type="text" id="nomeBarber">
            </label>
            <label>
                Serviço:
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
</div>