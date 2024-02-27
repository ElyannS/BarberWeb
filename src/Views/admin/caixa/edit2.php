<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard">
    <div class="container">
        <div class="titulo_pagina">
        <i class="fa-solid fa-cart-shopping"></i> Caixa - Editar  <?=date("d/m/Y", strtotime($data['informacoes']['dataUrl']))?>
        </div>
        <div class="form">
            <form action="<?=URL_BASE?>admin/caixa_insert" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="w-80">
                        <label>
                            Nome Cliente*
                            <input type="text" name="nome_cliente" required>
                        </label>
                    </div>
                    <div class="w-20">
                    <label>
                            Data*
                            <input id="campoData" type="date" name="data"  value="<?=$data['informacoes']['dataUrl']?>" >
                        </label>
                    </div>
                </div>
                <div class="row">
                    <label>
                        Valor do Serviço
                        <input type="number" name="dinheiro" placeholder="Dinheiro" >
                    </label>
                </div>
                <div class="row">
                    <label>
                        Valor do Serviço
                        <input type="number" name="pix" placeholder="Pix" >
                    </label>
                </div>
                <div class="row">
                    <label>
                        Valor do Serviço
                        <input type="number" name="cartao" placeholder="Cartão" >
                    </label>
                </div>
                
                <div class="row">
                    <button type="submit">Salvar</button>
                </div>
            </form>
        </div>

        <div class="lista">
            <table>
                <thead>
                    <tr>
                        <td class="id">ID</td>
                        <td class="acao">AÇÕES</td>
                        <td class="nome_cliente">NOME CLIENTE</td>
                        <td class="dinheiro">DINHEIRO</td>
                        <td class="pix">PIX</td>
                        <td class="cartao">CARTÃO</td>
                        <td class="data">DATA</td>
                    </tr>
                </thead>
                <tbody> 
                    <?php
                       
                        foreach($data['informacoes']['lista'] as $caixa) {?>
                    <tr>
                        <td class="id"><?=$caixa['id']?></td>
                        <td class="acao">
                            <a href="<?=URL_BASE?>admin/caixa-edit/<?=$caixa['id']?>"><i class="far fa-edit"></i></a>
                            <div class="delete">
                                <button type="submit" id="deleteButton"><i class="fa-solid fa-trash"></i></button>
                                <div id="confirmationDialog" style="display: none;">
                                    <h3>Tem certeza de que deseja excluir?</h3>
                                    <div class="btn-cancel">
                                        <form  action="<?=URL_BASE?>admin/caixa_delete"  id="deleteForm"  method="post">
                                            <input type="hidden" name="id" value="<?=$caixa['id']?>">
                                            <button id="confirmDeleteButton">Sim</button>
                                        </form>
                                        <button id="cancelDeleteButton">Fechar</button>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="nome_cliente"><?=$caixa['nome_cliente']?></td>
                        <td class="dinheiro"><?=$caixa['dinheiro']?></td>
                        <td class="pix"><?=$caixa['pix']?></td>
                        <td class="cartao"><?=$caixa['cartao']?></td>
                        <td class="data"><?=date("d/m/Y", strtotime($caixa['data']))?></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            <div class="titulo_pagina">
                Valor total do Dinheiro: R$ <?=$data['informacoes']['valorCartao']?>,00
            </div>
            <div class="titulo_pagina">
                Valor total do Pix: R$ <?=$data['informacoes']['valorDinheiro']?>,00
            </div>
            <div class="titulo_pagina">
                Valor total do Cartão: R$ <?=$data['informacoes']['valorPix']?>,00
            </div>
            <div class="titulo_pagina">
                Valor total do dia: R$ <?=$data['informacoes']['valorDoDia']?>,00
            </div>
        </div>
</section>
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'descricao' );
</script>
<?=$this->fetch('../commons/footer.php')?>