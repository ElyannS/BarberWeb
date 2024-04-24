<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard">
    <div class="container">
        <div class="titulo_pagina">
        <i class="fa-solid fa-user"></i> Barbeiros - Novo 
        </div>
        <div class="form">
            <form action="<?=URL_BASE?>admin/barbeiros_insert" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="row">
                        <label>
                            Nome
                            <input type="text" name="nome" required>
                        </label>
                    </div>
                    <div class="row">
                    <label>
                            Cargo
                            <input type="text" name="cargo" required>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <label>
                        Imagem Pricipal
                        <input type="file" name="imagem_principal" required accept="image/*">
                    </label>
                    
                </div>
                <div class="row">
                    <label>
                        Ativo
                        <select name="ativo" required>
                            <option value="s">Sim</option>
                            <option value="n">Não</option>
                        </select>
                    </label>
                </div>
                <div class="row">
                    <button type="submit">Salvar</button>
                </div>
            </form>
        </div>
</section>
<?=$this->fetch('../commons/footer.php')?>