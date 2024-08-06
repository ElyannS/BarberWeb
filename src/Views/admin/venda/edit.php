<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard background-white">
    <div class="container">
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Venda - Editar Informações</p>
            </div>
        </div>
        
        <div class="form">
            <form action="<?=URL_BASE?>admin/venda_update" method="post" enctype="multipart/form-data">
            <div class="row">
                    <div class="w-80">
                    <input type="hidden" name="id" value="<?=$data['informacoes']['lista']['id']?>">
                        <label>
                            Nome Cliente*
                            <input type="text" name="nome_cliente" value="<?=$data['informacoes']['lista']['nome_cliente']?>" requered>
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
                    <label >
                        Valor em Dinheiro
                        <input id="dinheiro-edit" step="0.01"  type="number" name="dinheiro" placeholder="Dinheiro" value="<?=$data['informacoes']['lista']['dinheiro']?>">
                    </label>
                </div>
                <div class="row">
                    <label>
                        Produto
                       <select name="id_produto" id="">
                            <?php foreach($data['informacoes']['produto'] as $produtos){?>
                                <option value="<?=$produtos['id']?>" <?= ($data['informacoes']['lista']['id_produto'] === $produtos['id']) ? 'selected="selected"' : '' ?>><?=$produtos['descricao']?></option>
                            <?php }?>
                       </select>
                    </label>
                </div>
                <div class="row">
                    <label >
                        Quantidade
                        <input id="cartao-edit" type="numbers" name="quantidade" value="<?=$data['informacoes']['lista']['quantidade']?>">
                    </label>
                </div>
               
                <div class="row">
                    <button type="submit">Salvar</button>
                </div>
            </form>
            <div id="aviso">
                    
            </div>
        </div>
    </div>
        
</section>
<?=$this->fetch('../commons/footer.php')?>