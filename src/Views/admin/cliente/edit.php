<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard background-white">
    <div class="container">
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Barbeiros - Editar</p>
            </div>
        </div>
       
        <div class="form">
            <form action="<?=URL_BASE?>admin/barbeiros_update" method="post" enctype="multipart/form-data">
                <div class="row">
                    <label>
                        <?php if($data['informacoes']['usuario']['type'] === '1'){ ?>
                            Gestor
                            <input type="checkbox" name="gestor" id="gestor" value="2" <?php if($data['informacoes']['barbeiro']['type'] === '1') echo 'checked'?>>
                        <?php } ?>
                    </label>
                </div>
                <div class="row">
                    <label>
                        Nome
                        <input type="text" name="nome" required value="<?=$data['informacoes']['barbeiro']['nome']?>">
                    </label>
                </div>
                <div class="row">
                    <label>
                        Email
                        <input type="email" name="email" value="<?=$data['informacoes']['barbeiro']['email']?>">
                    </label>
                </div>
                <div class="row">
                    <label>
                        Imagem Pricipal
                        <input type="file" name="foto_usuario" accept="image/*">
                    </label>
                    <div class="img">
                        <img src="<?=URL_BASE.$data['informacoes']['barbeiro']['foto_usuario']?>">
                        <label>
                            <input type="checkbox" name="excluir_imagem_principal">
                            Excluir imagem
                        </label>
                    </div>
                </div>
                <div class="row">
                    <label>
                        Ativo
                        <select name="ativo" required>
                            <option value="s" <?php if($data['informacoes']['barbeiro']['status'] === 's') echo 'selected'?>>Sim</option>
                            <option value="n" <?php if($data['informacoes']['barbeiro']['status'] === 'n') echo 'selected'?>>Não</option>
                        </select>
                    </label>
                </div>
                <div class="row">
                    <button type="submit">Salvar</button>
                </div>   
                <input type="hidden" name="id" value="<?=$data['informacoes']['barbeiro']['id']?>">
                <input type="hidden" name="nome_imagem_atual" value="<?=$data['informacoes']['barbeiro']['foto_usuario']?>">
            </form>  
        </div>
</section>
<?=$this->fetch('../commons/footer.php')?>