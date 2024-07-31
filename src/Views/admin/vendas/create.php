<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard background-white">
    <div class="container"> 
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Caixa - Novo</p>
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
                        Serviço
                        <input type="checkbox">
                        Produto
                        <input type="checkbox">
                    </label>
                </div>
                <div class="row">
                    <label>
                        Selecione o Serviço
                        <Select>
                            <option value="">corte</option>
                        </Select>
                    </label>
                </div>
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
                    <label>
                        Selecione o Produto
                        <Select>
                            <option value="">cerveja</option>
                        </Select>
                    </label>
                </div>
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
    </div>
</section>
<script>    
//seta a data atual
     document.getElementById("campoData").value = value='<?php echo date("Y-m-d"); ?>';
</script>
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'descricao' );
</script>
<?=$this->fetch('../commons/footer.php', $data)?>