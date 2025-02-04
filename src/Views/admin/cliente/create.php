<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard background-white">
    <div class="container">
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Cliente - Cadastrar Novo</p>
            </div>
        </div>
        <div class="form">
            <form action="<?=URL_BASE?>admin/clientes_insert" method="post" enctype="multipart/form-data">
            <div class="row">
                    <label>
                        Primeiro Nome
                        <input type="text" name="first_name" required>
                    </label>
                </div>
                <div class="row">
                    <label>
                        Último nome
                        <input type="text" name="last_name" required>
                    </label>
                </div>
                <div class="row">
                    <label>
                        Email
                        <input type="email" name="email" required>
                    </label>
                </div>
                <div class="row">
                    <label>
                        Telefone
                        <input type="tel" name="telefone" required>
                    </label>
                </div>
                <div class="row">
                    <label>
                        Senha
                        <input type="password" name="password" required>
                    </label>
                </div>
                <div class="row">
                    <label>
                        Foto Usuario
                        <input type="file" name="imagem_principal" required accept="image/*">
                    </label>
                </div>
                <div class="row">
                    <button type="submit">Salvar</button>
                </div>
            </form>
        </div>
</section>
<?=$this->fetch('../commons/footer.php')?>