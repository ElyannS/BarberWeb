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
                            <input id="campoData" type="date" name="data" required>
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
                        <input  type="number" step="0.01" name="dinheiro" placeholder="Dinheiro">
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