<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard">
    <div class="container">
        <div class="titulo_pagina">
        <i class="fa-solid fa-cart-shopping"></i> Caixa - Novo 
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
                            <input id="campoData" type="date" name="data" required>
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