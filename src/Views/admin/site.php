<?=$this->fetch('commons/header.php', $data)?>
<section class="dashboard">
    <div class="container">
        <div class="titulo_pagina">
            <div class="titulo-migalha light-color">
                <i class="fa-solid fa-circle"></i>
                <p>Parametros</p>
            </div>
            <div class="topo">
               &nbsp;
            </div> 
        </div>
        <div class="form light">
            <form action="<?=URL_BASE?>admin/site_update" method="post" class="form_ajax" enctype="multipart/form-data">
            <div class="row">
                    <label>
                        Nome Barbearia
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
                    <button type="submit">Salvar</button>
                </div>   
                <div class="alerta"></div>
            </form>
        </div>
</section>
<?=$this->fetch('commons/footer.php')?>