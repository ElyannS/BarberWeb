<?=$this->fetch('commons/header.php', $data)?>
<section class="dashboard height">
    <div class="container">
        <div class="titulo_pagina">
            <div class="titulo-migalha light-color">
                <i class="fa-solid fa-circle"></i>
                <p>Usuário</p>
            </div>
            <div class="topo">
               &nbsp;
            </div> 
        </div>
        <div class="form light">
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
                            Comissão
                            <input type="number" name="comissao" required value="<?=$data['informacoes']['usuario']['comissao']?>">
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
                <div class="row light-color">
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
                <input type="hidden" name="id" value="<?=$data['informacoes']['usuario']['id']?>">
                <input type="hidden" name="nome_imagem_atual" value="<?=$data['informacoes']['usuario']['foto_usuario']?>">
                <div class="alerta light-color"></div>
            </form>
        </div>
</section>
<?=$this->fetch('commons/footer.php')?>