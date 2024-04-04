<?=$this->fetch('../commons/header.php', $data)?>
<section class="background-white dashboard">
    <div class="container">
        <div class="titulo_pagina">
        <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Horários - Editar</p>
            </div>
            <div class="topo">
                &nbsp;
            </div> 
        </div>
        <div class="form">
            <form action="<?=URL_BASE?>admin/servicos_update" method="post" enctype="multipart/form-data">
                <div class="row">
                <div class="w-20">
                        <label>
                            Hora início 1
                            <select name="selectI1" id="" required>
                                <option value="">Fechado</option>
                                <option value="">00:00</option>
                                <option value="">00:30</option>
                                <option value="">01:00</option>
                                <option value="">01:30</option>
                                <option value="">02:00</option>
                                <option value="">02:30</option>
                                <option value="">03:00</option>
                                <option value="">03:30</option>
                                <option value="">04:00</option>
                                <option value="">04:30</option>
                                <option value="">05:00</option>
                                <option value="">05:30</option>
                                <option value="">06:00</option>
                                <option value="">06:30</option>
                                <option value="">07:00</option>
                                <option value="">07:30</option>
                                <option value="">08:00</option>
                                <option value="">08:30</option>
                                <option value="">09:00</option>
                                <option value="">09:30</option>
                                <option value="">10:00</option>
                                <option value="">10:30</option>
                                <option value="">11:00</option>
                                <option value="">11:30</option>
                                <option value="">12:00</option>
                                <option value="">12:30</option>
                                <option value="">13:00</option>
                                <option value="">13:30</option>
                                <option value="">14:00</option>
                                <option value="">14:30</option>
                                <option value="">15:00</option>
                                <option value="">15:30</option>
                                <option value="">16:00</option>
                                <option value="">16:30</option>
                                <option value="">17:00</option>
                                <option value="">17:30</option>
                                <option value="">18:00</option>
                                <option value="">18:30</option>
                                <option value="">19:00</option>
                                <option value="">19:30</option>
                                <option value="">20:00</option>
                                <option value="">20:30</option>
                                <option value="">21:00</option>
                                <option value="">21:30</option>
                                <option value="">22:00</option>
                                <option value="">22:30</option>
                                <option value="">23:00</option>
                                <option value="">23:30</option>
                            </select>
                        </label>
                        <label>
                            Hora fim 1
                            <select name="selectF1" id="" required>
                                <option value="">Fechado</option>
                                <option value="">00:00</option>
                                <option value="">00:30</option>
                                <option value="">01:00</option>
                                <option value="">01:30</option>
                                <option value="">02:00</option>
                                <option value="">02:30</option>
                                <option value="">03:00</option>
                                <option value="">03:30</option>
                                <option value="">04:00</option>
                                <option value="">04:30</option>
                                <option value="">05:00</option>
                                <option value="">05:30</option>
                                <option value="">06:00</option>
                                <option value="">06:30</option>
                                <option value="">07:00</option>
                                <option value="">07:30</option>
                                <option value="">08:00</option>
                                <option value="">08:30</option>
                                <option value="">09:00</option>
                                <option value="">09:30</option>
                                <option value="">10:00</option>
                                <option value="">10:30</option>
                                <option value="">11:00</option>
                                <option value="">11:30</option>
                                <option value="">12:00</option>
                                <option value="">12:30</option>
                                <option value="">13:00</option>
                                <option value="">13:30</option>
                                <option value="">14:00</option>
                                <option value="">14:30</option>
                                <option value="">15:00</option>
                                <option value="">15:30</option>
                                <option value="">16:00</option>
                                <option value="">16:30</option>
                                <option value="">17:00</option>
                                <option value="">17:30</option>
                                <option value="">18:00</option>
                                <option value="">18:30</option>
                                <option value="">19:00</option>
                                <option value="">19:30</option>
                                <option value="">20:00</option>
                                <option value="">20:30</option>
                                <option value="">21:00</option>
                                <option value="">21:30</option>
                                <option value="">22:00</option>
                                <option value="">22:30</option>
                                <option value="">23:00</option>
                                <option value="">23:30</option>
                            </select>
                        </label>
                    </div>
                    <div class="w-20">
                        <label>
                            Hora início 2
                            <select name="" id="" required>
                                <option value="">Fechado</option>
                                <option value="">00:00</option>
                                <option value="">00:30</option>
                                <option value="">01:00</option>
                                <option value="">01:30</option>
                                <option value="">02:00</option>
                                <option value="">02:30</option>
                                <option value="">03:00</option>
                                <option value="">03:30</option>
                                <option value="">04:00</option>
                                <option value="">04:30</option>
                                <option value="">05:00</option>
                                <option value="">05:30</option>
                                <option value="">06:00</option>
                                <option value="">06:30</option>
                                <option value="">07:00</option>
                                <option value="">07:30</option>
                                <option value="">08:00</option>
                                <option value="">08:30</option>
                                <option value="">09:00</option>
                                <option value="">09:30</option>
                                <option value="">10:00</option>
                                <option value="">10:30</option>
                                <option value="">11:00</option>
                                <option value="">11:30</option>
                                <option value="">12:00</option>
                                <option value="">12:30</option>
                                <option value="">13:00</option>
                                <option value="">13:30</option>
                                <option value="">14:00</option>
                                <option value="">14:30</option>
                                <option value="">15:00</option>
                                <option value="">15:30</option>
                                <option value="">16:00</option>
                                <option value="">16:30</option>
                                <option value="">17:00</option>
                                <option value="">17:30</option>
                                <option value="">18:00</option>
                                <option value="">18:30</option>
                                <option value="">19:00</option>
                                <option value="">19:30</option>
                                <option value="">20:00</option>
                                <option value="">20:30</option>
                                <option value="">21:00</option>
                                <option value="">21:30</option>
                                <option value="">22:00</option>
                                <option value="">22:30</option>
                                <option value="">23:00</option>
                                <option value="">23:30</option>
                            </select>
                        </label>
                        <label>
                            Hora fim 2
                            <select name="select" id="" required>
                                <option value="">Fechado</option>
                                <option value="">00:00</option>
                                <option value="">00:30</option>
                                <option value="">01:00</option>
                                <option value="">01:30</option>
                                <option value="">02:00</option>
                                <option value="">02:30</option>
                                <option value="">03:00</option>
                                <option value="">03:30</option>
                                <option value="">04:00</option>
                                <option value="">04:30</option>
                                <option value="">05:00</option>
                                <option value="">05:30</option>
                                <option value="">06:00</option>
                                <option value="">06:30</option>
                                <option value="">07:00</option>
                                <option value="">07:30</option>
                                <option value="">08:00</option>
                                <option value="">08:30</option>
                                <option value="">09:00</option>
                                <option value="">09:30</option>
                                <option value="">10:00</option>
                                <option value="">10:30</option>
                                <option value="">11:00</option>
                                <option value="">11:30</option>
                                <option value="">12:00</option>
                                <option value="">12:30</option>
                                <option value="">13:00</option>
                                <option value="">13:30</option>
                                <option value="">14:00</option>
                                <option value="">14:30</option>
                                <option value="">15:00</option>
                                <option value="">15:30</option>
                                <option value="">16:00</option>
                                <option value="">16:30</option>
                                <option value="">17:00</option>
                                <option value="">17:30</option>
                                <option value="">18:00</option>
                                <option value="">18:30</option>
                                <option value="">19:00</option>
                                <option value="">19:30</option>
                                <option value="">20:00</option>
                                <option value="">20:30</option>
                                <option value="">21:00</option>
                                <option value="">21:30</option>
                                <option value="">22:00</option>
                                <option value="">22:30</option>
                                <option value="">23:00</option>
                                <option value="">23:30</option>
                            </select>
                        </label>
                </div>
                
               
                <div class="row">
                    <button type="submit">Salvar</button>
                </div>
                <input type="hidden" name="id" value="<?=$data['informacoes']['horarios']['id']?>">
            </form>
        </div>
</section>
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'descricao' );
</script>
<?=$this->fetch('../commons/footer.php')?>