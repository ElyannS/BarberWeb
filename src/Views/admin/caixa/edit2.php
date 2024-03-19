<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard background-white">
    <div class="container">
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Caixa - Editar  <?=date("d/m/Y", strtotime($data['informacoes']['dataUrl']))?></p>
            </div>
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
                       
                        <td class="acao-btn">AÇÕES</td>
                        <td class="nome_cliente">NOME CLIENTE</td>
                        <td class="dinheiro">DINHEIRO</td>
                        <td class="pix">PIX</td>
                        <td class="cartao">CARTÃO</td>
                        <td class="data-caixa">DATA</td>
                    </tr>
                </thead>
                <tbody> 
                    <?php
                       
                        foreach($data['informacoes']['lista'] as $caixa) {?>
                    <tr>
                       
                        <td class="acao-btn acao">
                            <div class="topo">
                                <div class="btn">
                                    <a href="<?=URL_BASE?>admin/caixa-edit/<?=$caixa['id']?>">Editar <i class="far fa-edit"></i></a>
                                </div>
                                <div class="btn">
                                   
                                    <form  action="<?=URL_BASE?>admin/caixa_delete"  id="deleteForm"  method="post">
                                        <input type="hidden" name="id" value="<?=$caixa['id']?>">
                                        <button type="submit">Excluir <i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td class="nome_cliente"><?=$caixa['nome_cliente']?></td>
                        <td class="dinheiro"><?=$caixa['dinheiro']?></td>
                        <td class="pix"><?=$caixa['pix']?></td>
                        <td class="cartao"><?=$caixa['cartao']?></td>
                        <td class="data-caixa"><?=date("d/m/Y", strtotime($caixa['data']))?></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            <div class="titulo_pagina">
                Valor total do Dinheiro: R$ <?=$data['informacoes']['valorDinheiro']?>,00
            </div>
            <div class="titulo_pagina">
                Valor total do Pix: R$ <?=$data['informacoes']['valorPix']?>,00
            </div>
            <div class="titulo_pagina">
                Valor total do Cartão: R$ <?=$data['informacoes']['valorCartao']?>,00
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