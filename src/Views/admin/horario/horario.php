<?=$this->fetch('../commons/header.php', $data)?>
<section class="<?=($data['informacoes']['menu_active'] === 'horarios') ? 'background-white' : ''?>">
    <div class="container">
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Horários</p>
            </div>
            <div class="topo">
                <div class="btn">
                    <a href="<?=URL_BASE?>admin/servicos-create">Cadastrar novo</a>
                </div>
            </div> 
        </div>

        <?php

            echo  var_dump($data);
      ?> 
        <div class="lista">
            <table>
                <tbody> 
                    <tr>
                        <td class="titulo_item">
                            <div class="titulo-ser">
                                Domingo
                            </div>
                            <div class="valor-ser">
                                <?php echo $data['informacoes']['lista'][0]['domingo']?> 
                               
                            </div>
                        </td>
                        <td class="acao">
                            <div class="btn">
                                <a href="<?=URL_BASE?>admin/horarios-edit/">Editar</a>
                            </div>
                            <form action="<?=URL_BASE?>admin/horarios_delete" method="post">
                                <input type="hidden" name="id" value="">
                                <button type="submit"><i class="fa-solid fa-trash"></i></i></button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo_item">
                            <div class="titulo-ser">
                                Segunda-Feira
                            </div>
                            <div class="valor-ser">
                                <?php echo $data['informacoes']['lista'][0]['segunda']?> 
                               
                            </div>
                        </td>
                        <td class="acao">
                            <div class="btn">
                                <a href="<?=URL_BASE?>admin/horarios-edit/">Editar</a>
                            </div>
                            <form action="<?=URL_BASE?>admin/horarios_delete" method="post">
                                <input type="hidden" name="id" value="">
                                <button type="submit"><i class="fa-solid fa-trash"></i></i></button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo_item">
                            <div class="titulo-ser">
                                Terça-Feira
                            </div>
                            <div class="valor-ser">
                                <?php echo $data['informacoes']['lista'][0]['terca']?> 
                               
                            </div>
                        </td>
                        <td class="acao">
                            <div class="btn">
                                <a href="<?=URL_BASE?>admin/horarios-edit/">Editar</a>
                            </div>
                            <form action="<?=URL_BASE?>admin/horarios_delete" method="post">
                                <input type="hidden" name="id" value="">
                                <button type="submit"><i class="fa-solid fa-trash"></i></i></button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo_item">
                            <div class="titulo-ser">
                                Quarta-Feira
                            </div>
                            <div class="valor-ser">
                                <?php echo $data['informacoes']['lista'][0]['quarta']?> 
                               
                            </div>
                        </td>
                        <td class="acao">
                            <div class="btn">
                                <a href="<?=URL_BASE?>admin/horarios-edit/">Editar</a>
                            </div>
                            <form action="<?=URL_BASE?>admin/horarios_delete" method="post">
                                <input type="hidden" name="id" value="">
                                <button type="submit"><i class="fa-solid fa-trash"></i></i></button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo_item">
                            <div class="titulo-ser">
                                Quinta-Feira
                            </div>
                            <div class="valor-ser">
                                <?php echo $data['informacoes']['lista'][0]['quinta']?> 
                               
                            </div>
                        </td>
                        <td class="acao">
                            <div class="btn">
                                <a href="<?=URL_BASE?>admin/horarios-edit/">Editar</a>
                            </div>
                            <form action="<?=URL_BASE?>admin/horarios_delete" method="post">
                                <input type="hidden" name="id" value="">
                                <button type="submit"><i class="fa-solid fa-trash"></i></i></button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo_item">
                            <div class="titulo-ser">
                                Sexta-Feira
                            </div>
                            <div class="valor-ser">
                                <?php echo $data['informacoes']['lista'][0]['sexta']?> 
                               
                            </div>
                        </td>
                        <td class="acao">
                            <div class="btn">
                                <a href="<?=URL_BASE?>admin/horarios-edit/">Editar</a>
                            </div>
                            <form action="<?=URL_BASE?>admin/horarios_delete" method="post">
                                <input type="hidden" name="id" value="">
                                <button type="submit"><i class="fa-solid fa-trash"></i></i></button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo_item">
                            <div class="titulo-ser">
                                Sábado
                            </div>
                            <div class="valor-ser">
                                <?php echo $data['informacoes']['lista'][0]['sabado']?> 
                               
                            </div>
                        </td>
                        <td class="acao">
                            <div class="btn">
                                <a href="<?=URL_BASE?>admin/horarios-edit/">Editar</a>
                            </div>
                            <form action="<?=URL_BASE?>admin/horarios_delete" method="post">
                                <input type="hidden" name="id" value="">
                                <button type="submit"><i class="fa-solid fa-trash"></i></i></button>
                            </form>
                        </td>
                    </tr>
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