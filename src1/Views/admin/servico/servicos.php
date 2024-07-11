<?=$this->fetch('../commons/header.php', $data)?>
<section class="<?=($data['informacoes']['menu_active'] === 'servicos') ? 'background-white' : ''?>">
    <div class="container">
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Serviços</p>
            </div>
            <div class="topo">
                <?php if($data['informacoes']['usuario']['type'] === '1'){ ?>
                    <div class="btn">
                        <a href="<?=URL_BASE?>admin/servicos-create">Cadastrar novo</a>
                    </div>
                <?php }?>
            </div> 
        </div>

       
        <div class="lista">
            <table>
                <tbody> 
                    <?php
                        foreach($data['informacoes']['lista'] as $servico) {?>
                    <tr>
                        <td class="id">
                            <img class="icon_svg" src="<?=URL_BASE?>resources/imagens/servico.svg">
                        </td>
                        <td class="titulo_item">
                            <div class="titulo-ser">
                                <?=$servico['titulo']?>
                            </div>
                            <div class="valor-ser">
                                R$ <?=$servico['valor']?>
                                <span class="span-clock"><i class="fa-regular fa-clock"></i> <?=$servico['tempo_servico']?> min </span>
                            </div>
                        </td>
                        <?php if($data['informacoes']['usuario']['type'] === '1'){ ?>
                            <td class="acao">
                                <div class="btn">
                                    <a href="<?=URL_BASE?>admin/servicos-edit/<?=$servico['id']?>">Editar</a>
                                </div>
                                <form action="<?=URL_BASE?>admin/servicos_delete" method="post">
                                    <input type="hidden" name="id" value="<?=$servico['id']?>">
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