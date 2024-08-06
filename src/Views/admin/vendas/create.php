<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard background-white">
    <div class="container"> 
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Nova Venda</p>
            </div>
        </div>
        <div class="form">
            <form action="<?=URL_BASE?>admin/vendas_insert" method="post" enctype="multipart/form-data">
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
                            <input id="campoData" type="date" name="data" required>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <label>
                        Selecione o Produto
                        <Select name="idProduto">
                            <option value="1">cerveja</option>
                        </Select>
                    </label>
                </div>
                <div class="row">
                    <label class="cartao">
                        Quantidade
                        <input type="number" value="1" name="quantidade" placeholder="Quantidade">
                    </label>
                </div>
                <div class="row">
                    <label class="dinheiro">
                        Valor em Dinheiro
                        <input  type="number" step="0.01" id="dinProduto" name="dinheiroProduto" placeholder="Dinheiro">
                    </label>
                </div>
                <div class="row">
                    <label class="pix">
                        Valor em Pix
                        <input type="number" step="0.01" id="pixProduto" name="pixProduto" placeholder="Pix">
                    </label>
                </div>
                <div class="row">
                    <label class="cartao">
                        Valor em Cartão
                        <input type="number" step="0.01" id="cartProduto" name="cartaoProduto" placeholder="Cartão">
                    </label>
                </div>
                <div class="row">
                    <button type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</section>
<script>    
    //seta a data atual
     document.getElementById("campoData").value = value='<?php echo date("Y-m-d"); ?>';
</script>
<?=$this->fetch('../commons/footer.php', $data)?>