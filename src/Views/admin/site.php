<?=$this->fetch('commons/header.php', $data)?>
<section class="dashboard">
    <div class="container">
        <div class="titulo_pagina">
            <i class="fas fa-cogs"></i> Site
        </div>
        <div class="form">
            <form action="<?=URL_BASE?>admin/site_update" method="post" class="form_ajax" enctype="multipart/form-data">
            <div class="row">
                    <label>
                        Nome Site
                        <input type="text" name="nome_site" value="<?=$data['informacoes']['info']['nome_site']?>">
                    </label>
                </div>
                <div class="row">
                    <label>
                        Logo do Site
                        <input type="file" name="logo_site" >
                    </label>
                    <div class="img">
                        <img src="<?=URL_BASE.$data['informacoes']['info']['logo_site']?>">
                        <label>
                            <input type="checkbox" name="excluir_logo_site" value="<?=$data['informacoes']['info']['logo_site']?>">
                            <input type="hidden" name="excluir_logo_site_nome" value="<?=$data['informacoes']['info']['logo_site']?>">
                            Excluir imagem
                        </label>
                </div>
                </div>
                <div class="row">
                    <label>
                        Facebook
                        <input type="text" name="link_facebook" value="<?=$data['informacoes']['info']['link_facebook']?>">
                    </label>
                </div>
                <div class="row">
                    <label>
                        Instagram
                        <input type="text" name="link_instagram" value="<?=$data['informacoes']['info']['link_instagram']?>">
                    </label>
                </div>
                <div class="row">
                    <label>
                        Youtube
                        <input type="text" name="link_youtube" value="<?=$data['informacoes']['info']['link_youtube']?>">
                    </label>
                </div>
                <div class="row">
                    <label>
                    Telefone
                        <input type="tel" name="telefone_contato" value="<?=$data['informacoes']['info']['telefone_contato']?>">
                    </label>
                </div>
                <div class="row">
                    <label>
                    E-mail
                        <input type="email" name="email_contato" value="<?=$data['informacoes']['info']['email_contato']?>">
                    </label>
                </div>
                <div class="row">
                    <label>
                    Endereço
                        <input type="text" name="endereco_contato" value="<?=$data['informacoes']['info']['endereco_contato']?>">
                    </label>
                </div>
                <div class="row">
                    <button type="submit">Salvar</button>
                </div>   
                <div class="alerta"></div>
            </form>
        </div>
</section>
<?=$this->fetch('commons/footer.php')?>