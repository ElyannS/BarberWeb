<?=$this->fetch('../commons/header.php', $data)?>
<section class="<?=($data['informacoes']['menu_active'] === 'horarios') ? 'background-white' : ''?>">
    <div class="container">
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Horários</p>
            </div>
          
        </div>

        <div class="lista">
            <table>
                <tbody> 
                    <?php foreach($data['informacoes']['lista'] as $horarios){?> 
                        <tr>
                            <td class="titulo_item">
                                <div class="titulo-ser">
                                    <?=$horarios['dia_semana']?>
                                </div>
                                <div class="valor-ser">
                                    <?php 
                                        if($horarios['turno1'] === 'FECHADO' and $horarios['turno2'] === 'FECHADO'){
                                        echo 'FECHADO';
                                                
                                        } else {
                                            $turno1 = $horarios['turno1'];
                                        
                                            if(trim($turno1) === 'FECHADO'){
                                                echo '';
                                            } else {
                                                $primeiroUltimo = explode(", ", $turno1);    
                                                echo $primeiroUltimo[0] . " às " . end($primeiroUltimo);
                                            }
                                            $turno2 = $horarios['turno2'];

                                            if(trim($turno2) === 'FECHADO'){
                                                echo '';
                                            } else {
                                                $primeiroUltimo = explode(", ", $turno2);    
                                                echo " " . $primeiroUltimo[0] . " às " . end($primeiroUltimo);
                                            }
                                            
                                        }
                                    ?>
                                </div>
                            </td>
                            <?php if($data['informacoes']['usuario']['type'] === '1'){ ?>
                                <td class="acao">
                                    <div class="btn">
                                        <a href="<?=URL_BASE?>admin/horarios-edit-barbeiro/<?=$horarios['id']?>">Editar</a>
                                    </div>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php }?> 
                </tbody>
            </table>
    
        </div>
    </div>
</section>
<?=$this->fetch('../commons/footer.php')?>