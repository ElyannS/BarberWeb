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
            <form action="<?=URL_BASE?>admin/venda_insert" method="post" enctype="multipart/form-data">
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
                        Produto
                       <select name="id_produto" id="">
                            <?php foreach($data['informacoes']['produto'] as $produtos){?>
                                <option value="<?=$produtos['id']?>"><?=$produtos['descricao']?></option>
                            <?php }?>
                       </select>
                    </label>
                </div>
                <div class="row">
                    <label>
                        Quantidade
                        <input  type="number" name="quantidade" value="1" placeholder="Quantidade">
                    </label>
                </div>
                <div class="row">
                    <label class="dinheiro">
                        Valor em Dinheiro
                        <input  type="text" name="dinheiro" placeholder="Dinheiro">
                    </label>
                </div>               
                <div class="row">
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
                        <td class="client-name">NOME CLIENTE</td>
                        <td class="cash">DINHEIRO</td>
                        <td class="pix">QUANT</td>
                        <td class="card">PRODUTO</td>
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
                                        <a href="<?=URL_BASE?>admin/venda-edit/<?=$caixa['id']?>">Editar</a>
                                    </div>
                                    <div class="buttonCaixa">
                                        <form action="<?=URL_BASE?>admin/venda_delete" id="deleteForm" method="post">
                                            <input type="hidden" name="id" value="<?=$caixa['id']?>">
                                            <button type="submit">Excluir</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td class="client-name"><?=$caixa['nome_cliente']?></td>
                            <td class="cash-amount"><?=$caixa['dinheiro']?></td>
                            <td class="pix-amount"><?=$caixa['quantidade']?></td>
                            <td class="card-amount"><?=$caixa['nome_produto']?></td>
                            <td class="date"><?=date("d/m/Y", strtotime($caixa['data']))?></td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
            <div class="total">
                <div class="total-section">
                    Valor total do dia: R$ <?=$data['informacoes']['valorDoDia']?>
                </div>
            </div>
        </div>
    </div>
</section>
<?=$this->fetch('../commons/footer.php')?>