<?=$this->fetch('../commons/header.php', $data)?>
<section class="background-white">
    <div class="container">
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Caixa</p>
            </div>
            <div class="topo">
                <div class="btn">
                    <a href="<?=URL_BASE?>admin/caixa-relatorio">Relatório</a>
                </div>
                <div class="btn">
                    <a href="<?=URL_BASE?>admin/caixa-create">Adicionar Caixa</a>
                </div>
            </div> 
        </div>
       

       
        <div class="lista">
            <table>
                <tbody> 
                <?php
                     
                     foreach($data['informacoes']['lista'] as $caixa) {?>
                 <tr class="border-bottom">
                   
                     <td class="acaoCaixa topo">
                        <div class="btn">
                            <a href="<?=URL_BASE?>admin/caixa-edit-data/<?=$caixa['data']?>">Editar caixa <i class="far fa-edit"></i></a>
                        </div>
                         

                         <form action="<?=URL_BASE?>admin/caixa_total_delete" method="post">
                             <input type="hidden" name="data" value="<?=$caixa['data']?>">
                             <button type="submit"><i class="fa-solid fa-trash"></i></i></button>
                         </form>
                     </td>
                     <td class="data"><?=date("d/m/Y", strtotime($caixa['data']))?></td>
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