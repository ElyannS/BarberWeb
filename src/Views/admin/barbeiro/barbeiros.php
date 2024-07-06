<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard background-white">
    <div class="container">
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Barbeiros</p>
            </div>
            <div class="topo">
                <?php if($data['informacoes']['usuario']['type'] === '1'){ ?>
                    <div class="btn">
                        <a href="<?=URL_BASE?>admin/barbeiros-create">Cadastrar novo</a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="lista">
            <table>
                <tbody>
                <?php foreach($data['informacoes']['lista'] as $barbeiros) {?>
                    <tr>
                       
                        <td class="titulo_item">
                            <div class="titulo-ser">
                                <?=$barbeiros['nome']?>
                            </div>
                        </td>
                        <?php if($data['informacoes']['usuario']['type'] === '1'){ ?>
                            <td class="acao">
                                <div class="btn">
                                    <a href="<?=URL_BASE?>admin/barbeiros-edit/<?=$barbeiros['id']?>">Editar</i></a>
                                </div>
                                <form action="<?=URL_BASE?>admin/barbeiros_delete" method="post">
                                    <input type="hidden" name="id" value="<?=$barbeiros['id']?>">
                                    <button type="submit">excluir</i></button>
                                </form>
                            </td>                      
                        <?php } ?>
                    </tr>
                    <?php }?>
                </tbody>
            </table>

            <input type="hidden" name="nome_imagem_atual" value="<?=$data['informacoes']['usuario']['foto_usuario']?>">

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