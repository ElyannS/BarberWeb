<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard">
    <div class="container">
        <div class="titulo_pagina light-color">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Editar - Produto</p>
            </div>
            <div class="topo">
                &nbsp;
            </div> 
        </div>
        <div class="form light">
            <form action="<?=URL_BASE?>admin/produtos_update" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="w-80">
                        <label>
                            Descrição
                            <input type="text" name="descricao" required value="<?=$data['informacoes']['produtos']['descricao']?>">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <label>
                        Código de Barras
                        <input type="number" name="barras" value="<?=$data['informacoes']['produtos']['barras']?>">
                    </label>
                </div>
                <div class="row">
                    <label>
                        Estoque
                        <input type="number" name="estoque" value="<?=$data['informacoes']['produtos']['estoque']?>">
                    </label>
                </div>
                <div class="row">
                    <label>
                        Preço de Custo
                        <input type="number" name="vlrCusto" value="<?=$data['informacoes']['produtos']['vlrCusto']?>">
                    </label>
                </div>
                <div class="row">
                    <label>
                        Preço de Venda
                        <input type="number" name="vlrVenda" value="<?=$data['informacoes']['produtos']['vlrVenda']?>">
                    </label>
                </div>
               
                <div class="row">
                    <button type="submit">Salvar</button>
                </div>
                <input type="hidden" name="id" value="<?=$data['informacoes']['produtos']['id']?>">
            </form>
        </div>
</section>
<?=$this->fetch('../commons/footer.php')?>