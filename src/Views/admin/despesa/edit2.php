<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard background-white">
    <div class="container">
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Despesa - Editar  <?=date("d/m/Y", strtotime($data['informacoes']['dataUrl']))?></p>
            </div>
        </div>
    
        <div class="form">
            <form action="<?=URL_BASE?>admin/despesa_insert" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="w-80">
                        <label>
                            Nome Despesa*
                            <input type="text" name="nome_despesa" required>
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
                <div class="row">
                    <label class="dinheiro">
                        Valor em Dinheiro
                        <input  type="text" name="dinheiro" placeholder="Dinheiro">
                    </label>
                </div>
                <div class="row">
                    <label class="pix">
                        Valor em Pix
                        <input type="text" name="pix" placeholder="Pix">
                    </label>
                </div>
                <div class="row">
                    <label class="cartao">
                        Valor em Cartão
                        <input type="text" name="cartao" placeholder="Cartão">
                    </label>
                </div>
                
                <div class="row">
                    <button type="submit">Salvar</button>
                </div>
            </form>
        </div>

        <div class="transactions-list">
            <table>
                <thead>
                    <tr>
                        <td class="actions">AÇÕES</td>
                        <td class="client-name">NOME DESPESA</td>
                        <td class="cash">DINHEIRO</td>
                        <td class="pix">PIX</td>
                        <td class="card">CARTÃO</td>
                        <td class="date">DATA</td>
                    </tr>
                </thead>

                <tbody> 
                    <?php
                        
                        foreach($data['informacoes']['lista'] as $caixa) {?>
                        <tr>
                            <td class="actions action-cell">
                                <div class="action-buttons">
                                    <div class="buttonCaixa">
                                        <a href="<?=URL_BASE?>admin/despesa-edit/<?=$caixa['id']?>">Editar</a>
                                    </div>
                                    <div class="buttonCaixa">
                                        <form action="<?=URL_BASE?>admin/despesa_delete" id="deleteForm" method="post">
                                            <input type="hidden" name="id" value="<?=$caixa['id']?>">
                                            <button type="submit">Excluir</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td class="client-name"><?=$caixa['nome_despesa']?></td>
                            <td class="cash-amount"><?=$caixa['dinheiro']?></td>
                            <td class="pix-amount"><?=$caixa['pix']?></td>
                            <td class="card-amount"><?=$caixa['cartao']?></td>
                            <td class="date"><?=date("d/m/Y", strtotime($caixa['data']))?></td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
            <div class="total">
                <div class="total-section">
                    Valor total do Dinheiro: R$ <?=$data['informacoes']['valorDinheiro']?>
                </div>
                <div class="total-section">
                    Valor total do Pix: R$ <?=$data['informacoes']['valorPix']?>
                </div>
                <div class="total-section">
                    Valor total do Cartão: R$ <?=$data['informacoes']['valorCartao']?>
                </div>
                <div class="total-section">
                    Valor total Despesa: R$ <?=$data['informacoes']['valorDoDia']?>
                </div>
            </div>
        </div>
    </div>
</section>
<?=$this->fetch('../commons/footer.php')?>