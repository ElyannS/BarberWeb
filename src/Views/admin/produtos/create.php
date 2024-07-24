<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard">
    <div class="container">
    <div class="titulo_pagina light-color">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Novo - Produto</p>
            </div>
            <div class="topo">
                &nbsp;
            </div> 
        </div>
        <div class="form light">
            <form action="<?=URL_BASE?>admin/produtos_insert" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="w-80">
                        <label>
                            Descrição*
                            <input type="text" name="descricao" required>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <label>
                        Código de Barras
                        <input type="text" name="barras" >
                    </label>
                    
                </div>
                <div class="row">
                    <label>
                        Estoque
                        <input type="text" name="estoque" >
                    </label>
                    
                </div>
                
                <div class="row">
                    <label>
                        Preço de Custo
                        <input type="text" name="vlrCusto" >
                    </label>
                    
                </div>
                <div class="row">
                    <label>
                        Preço de Venda
                        <input type="text" name="vlrVenda" >
                    </label>
                    
                </div>
                <div class="row">
                    <button type="submit">Salvar</button>
                </div>
            </form>
        </div>
</section>
<?=$this->fetch('../commons/footer.php', $data)?>