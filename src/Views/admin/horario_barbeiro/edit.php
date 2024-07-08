<?=$this->fetch('../commons/header.php', $data)?>
<section class="background-white dashboard">
    <div class="container">
        <div class="titulo_pagina">
        <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Horários - <?=$data['informacoes']['horarios']['dia_semana']?></p>
            </div>
            <div class="topo">
                &nbsp;
            </div> 
        </div>
        <div class="form">
            <form id="meuFormulario" action="<?=URL_BASE?>admin/horarios_barbeiro_update" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-1">
                    <div class="w-49">
                   
                        <label>
                            Hora início 1
                          
                                <select name="selectI1" id="selectHora1" required>
                                    <option value="FECHADO" <?php if(trim($data['informacoes']['turnoInicio2']) === "FECHADO") echo 'selected'?>>FECHADO</option>
                                    <?php 
                                        $arrayHoras = explode(", ", $data['informacoes']['horarios']['horas']);
                                        foreach($arrayHoras as $horas) { ?> 
                                            <option value="<?=$horas?>" <?php if($horas === trim($data['informacoes']['turnoInicio1'])) echo 'selected'?>><?=$horas?></option>   
                                    <?php }?>
                                </select>
                           
                        </label>
                    </div>        
                    <div class="w-49">
                        <label>
                            Hora fim 1
                            <select name="selectF1" id="selectHora2" required>
                                <option value="FECHADO" <?php if(trim($data['informacoes']['turnoFim1']) === "FECHADO") echo 'selected'?>>FECHADO</option>
                                <?php 
                                    $arrayHoras = explode(", ", $data['informacoes']['horarios']['horas']);
                                    foreach($arrayHoras as $horas) { ?> 
                                        <option value="<?=$horas?>" <?php if($horas === trim($data['informacoes']['turnoFim1'])) echo 'selected'?>><?=$horas?></option>   
                                <?php }?>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col-2">
                    <div class="w-49">
                        <label>
                            Hora início 2
                            <select name="selectI2" id="selectHora3" required>
                                <option value="FECHADO" <?php if(trim($data['informacoes']['turnoInicio2']) === "FECHADO") echo 'selected'?>>FECHADO</option>
                                <?php 
                                    $arrayHoras = explode(", ", $data['informacoes']['horarios']['horas']);
                                    foreach($arrayHoras as $horas) { ?> 
                                        <option value="<?=$horas?>" <?php if($horas === trim($data['informacoes']['turnoInicio2'])) echo 'selected'?>><?=$horas?></option>   
                                <?php }?>
                            </select>
                        </label>
                    </div>    
                    <div class="w-49">
                        <label>
                            Hora fim 2
                            <select name="selectF2" id="selectHora4" required>
                                <option value="FECHADO" <?php if(trim($data['informacoes']['turnoFim2']) === "FECHADO") echo 'selected'?>>FECHADO</option>
                                <?php 
                                    $arrayHoras = explode(", ", $data['informacoes']['horarios']['horas']);
                                    foreach($arrayHoras as $horas) { ?> 
                                        <option value="<?=$horas?>" <?php if($horas === trim($data['informacoes']['turnoFim2'])) echo 'selected'?>><?=$horas?></option>   
                                <?php }?>
                            </select>
                        </label>
                    </div>
                </div>
                    
                    <div class="row">
                        <button type="submit">Salvar</button>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?=$data['informacoes']['horarios']['id']?>">

            </form>
           
        </div>
        <div id="aviso">
                    
        </div>
        <div id="avisoSucesso">
                    
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'descricao' );
</script>
<?=$this->fetch('../commons/footer.php')?>