<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard background-white">
    <div class="container">
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Caixa - Editar Informações</p>
            </div>
        </div>
        
        <div class="form">
            <form action="<?=URL_BASE?>admin/caixa_update" method="post" enctype="multipart/form-data">
            <div class="row">
                    <div class="w-80">
                    <input type="hidden" name="id" value="<?=$data['informacoes']['lista']['id']?>">
                        <label>
                            Nome Cliente*
                            <input type="text" name="nome_cliente" value="<?=$data['informacoes']['lista']['nome_cliente']?>" >
                        </label>
                    </div>
                    <div class="w-20">
                    <label>
                            Data*
                            <input id="campoData" type="date" name="data" value="<?=$data['informacoes']['lista']['data']?>" >
                        </label>
                    </div>
                </div>
               
                <div class="row">
                    <label>
                        Valor do Serviço
                        <input type="number" name="dinheiro" placeholder="Dinheiro" value="<?=$data['informacoes']['lista']['dinheiro']?>">
                    </label>
                </div>
                <div class="row">
                    <label>
                        Valor do Serviço
                        <input type="number" name="pix" placeholder="Pix" value="<?=$data['informacoes']['lista']['pix']?>">
                    </label>
                </div>
                <div class="row">
                    <label>
                        Valor do Serviço
                        <input type="number" name="cartao" placeholder="Cartão" value="<?=$data['informacoes']['lista']['cartao']?>">
                    </label>
                </div>
                <div class="row">
                    <button type="submit">Salvar</button>
                </div>
            </form>
           
        </div>
      
</section>
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'descricao' );
</script>
<?=$this->fetch('../commons/footer.php')?>