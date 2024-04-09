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
                                    
                                    if($horarios['turno1'] === 'FECHADO'){
                                     
                                            
                                    } else {
                                        $turno1 = $horarios['turno1'];
                                      
                                        if(trim($turno1) === ""){
                                            echo '';
                                        } else {
                                            $primeiroUltimo = explode(", ", $turno1);    
                                            echo $primeiroUltimo[0] . " às " . end($primeiroUltimo);
                                        }
                                        
                                        
                                    }
                                    if($horarios['turno2'] === 'FECHADO'){
                                          
                                    } else{
                                        $turno2 = $horarios['turno2'];

                                        if(trim($turno2) === ""){
                                            echo '';
                                        } else {
                                            $primeiroUltimo = explode(", ", $turno2);    
                                            echo " " . $primeiroUltimo[0] . " às " . end($primeiroUltimo);
                                        }
                                    }
                                    ?>
                                </div>
                            </td>
                            <td class="acao">
                                <div class="btn">
                                    <a href="<?=URL_BASE?>admin/horarios-edit/<?=$horarios['id']?>">Editar</a>
                                </div>
                            </td>
                        </tr>
                    <?php }?> 
                </tbody>
            </table>
            <div class="paginacao">
                <?php if(isset($data['informacoes']['paginaAnterior']) && $data['informacoes']['paginaAnterior'] !== false){?>
                    <a href="<?=$data['informacoes']['paginaAnterior'] ?>"><i class="fas fa-arrow-circle-left"></i></a>
                <?php }?>
                
                <span><?=$data['informacoes']['paginaAtual']?></span>

                <?php if(isset($data['informacoes']['proximaPagina']) && $data['informacoes']['proximaPagina'] !== false){?>
                    <a href="<?=$data['informacoes']['proximaPagina'] ?>"> <i class="fas fa-arrow-circle-right"></i></a>
                <?php }?>
            </div>
        </div>
    </div>
</section>
<?=$this->fetch('../commons/footer.php')?>