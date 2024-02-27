<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard">
    <div class="container">
        <div class="titulo_pagina">
            <i class="fa-solid fa-cart-shopping"></i> Caixa
            - Última semana R$ <?=$data['informacoes']['resultadoSemana']?>,00 - Último mês R$<?=$data['informacoes']['resultadoMes']?>,00 - Último ano R$ <?=$data['informacoes']['resultadoAno']?>,00
        </div>

        <div class="topo">
            <div class="btn">
                <a href="<?=URL_BASE?>admin/caixa-create">Cadastrar novo</a>
               
            </div>
            <div class="form_pesquisa">
                <form action="<?=URL_BASE?>admin/caixa" method="GET">
                    <input type="text" name="pesquisa" placeholder="Titulo do item...">
                    <button type="submit">Pesquisar</button>
                </form>
            </div>
        </div> 
        <div class="lista">
            <table>
                <thead>
                    <tr>
                        <td class="acao">AÇÕES</td>
                        <td class="data">DATA DE CADASTRO</td>
                    </tr>
                </thead>
                <tbody> 
                <?php
                     
                     foreach($data['informacoes']['lista'] as $caixa) {?>
                 <tr>
                   
                     <td class="acao">
                         <a href="<?=URL_BASE?>admin/caixa-edit-data/<?=$caixa['data']?>"><i class="far fa-edit"></i></a>

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