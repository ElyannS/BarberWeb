<?=$this->fetch('../commons/header.php', $data)?>
<section class="background-white">
    <div class="container">
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Despesas</p>
            </div>
            <div class="topo">
            <div class="form_pesquisa d-none">
                    <form action="<?=URL_BASE?>admin/despesa" method="GET">
                        <input type="text" name="pesquisa" placeholder="Digita uma data...">
                        <button type="submit">Pesquisar</button>
                    </form>
                </div>
                <div class="btn">
                    <a href="<?=URL_BASE?>admin/despesa-relatorio">Relatório</a>
                </div>
                <div class="btn">
                    <a href="<?=URL_BASE?>admin/despesa-create">Adicionar Despesa</a>
                </div>
            </div> 
        </div>
        <div class="topo flex">
            <div class="form_pesquisa">
                <form action="<?=URL_BASE?>admin/despesa" method="GET">
                    <input type="text" name="pesquisa" placeholder="Digita uma data...">
                    <button type="submit">Pesquisar</button>
                </form>
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
                            <a href="<?=URL_BASE?>admin/despesa-edit-data/<?=$caixa['data']?>">Editar Despesa <i class="far fa-edit"></i></a>
                        </div>
                         

                         <form action="<?=URL_BASE?>admin/despesa_total_delete" method="post">
                             <input type="hidden" name="data" value="<?=$caixa['data']?>">
                             <button type="submit" class="colorBlack"><i class="fa-solid fa-trash"></i></i></button>
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