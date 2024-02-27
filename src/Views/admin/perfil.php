<?=$this->fetch('commons/header.php', $data)?>
<section class="dashboard">
    <div class="container">
        <div class="titulo_pagina">
            <i class="fas fa-user"></i>Perfil
        </div>
        <div class="form">
            <form action="<?=URL_BASE?>admin/perfil_update" class="form_ajax" method="post" enctype="multipart/form-data">
                <div class="row">
                    <label>
                        Nome
                        <input type="text" name="nome" required value="<?=$data['informacoes']['usuario']['nome']?>">
                    </label>
                </div>
                <div class="row">
                        <label>
                            E-mail
                            <input type="email" name="email" required value="<?=$data['informacoes']['usuario']['email']?>">
                        </label>
                </div>
                <div class="row">
                    <label>
                        Foto do Usuário
                        <input type="file" name="foto_usuario">
                    </label>
                    <div class="img">
                        <img src="<?=URL_BASE.$data['informacoes']['usuario']['foto_usuario']?>">
                        <label>
                            <input type="checkbox" name="excluir_foto_usuario">
                            Excluir imagem
                        </label>
                    </div>
                </div>
                <div class="row">
                    <p>Caso deseja alterar a sua senha atual, preencha os dois campos abaixo, caso não queira alterar, deixe em branco.</p>
                </div>
                <div class="row">
                    <label>
                        Senha
                        <input type="password" name="senha">
                    </label>
                </div>
                <div class="row">
                    <label>
                        Confirmar Senha
                        <input type="password" name="confirmar_senha">
                    </label>
                </div>
                <div class="row">
                    <button type="submit">Salvar</button>
                </div>
                <input type="hidden" name="id" value="1">
                <input type="hidden" name="nome_imagem_atual" value="<?=$data['informacoes']['usuario']['foto_usuario']?>">
                <div class="alerta"></div>
            </form>
        </div>
</section>
<?=$this->fetch('commons/footer.php')?>