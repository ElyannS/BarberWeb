<?=$this->fetch('../commons/header.php', $data)?>
<section class="<?=($data['informacoes']['menu_active'] === 'servicos') ? 'background-white' : ''?>">
    <div class="container">
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Produtos</p>
            </div>
            <div class="topo">
                <?php if($data['informacoes']['usuario']['type'] === '1'){ ?>
                    <div class="btn">
                        <a href="<?=URL_BASE?>admin/produtos-create">Cadastrar novo</a>
                    </div>
                <?php }?>
            </div> 
        </div>

       
        <div class="lista">
            <table>
                <tbody> 
                    <?php
                        foreach($data['informacoes']['lista'] as $produto) {?>
                    <tr>
                        <td class="id">
                            <div class="codigoProduto">
                                <h1><?=$produto['id']?></h1>
                            </div>
                        </td>
                        <td class="titulo_item">
                            <div class="titulo-ser prod">
                                <?=$produto['descricao']?>
                            </div>
                            <div class="valor-ser vlr">
                                R$ <?=$produto['vlrVenda']?>
                            </div>
                        </td>
                        <?php if($data['informacoes']['usuario']['type'] === '1'){ ?>
                            <td class="acao">
                                <div class="btn">
                                    <a href="<?=URL_BASE?>admin/produtos-edit/<?=$produto['id']?>">Editar</a>
                                </div>
                                <form action="<?=URL_BASE?>admin/produtos_delete" method="post">
                                    <input type="hidden" name="id" value="<?=$produto['id']?>">
                                    <button type="submit" class="colorBlack">excluir</i></i></button>
                                </form>
                            </td>
                        <?php } ?>
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