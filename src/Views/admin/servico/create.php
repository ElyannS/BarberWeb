<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard">
    <div class="container">
        <div class="titulo_pagina">
        <i class="fas fa-wrench"></i> Serviços - Novo 
        </div> 
        <div class="form">
            <form action="<?=URL_BASE?>admin/servicos_insert" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="w-80">
                        <label>
                            Título*
                            <input type="text" name="titulo" required>
                        </label>
                    </div>
                    <div class="w-20">
                    <label>
                            Data*
                            <input type="date" name="data" required>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <label>
                        Descrição*
                        <textarea name="descricao" id="descricao" required></textarea>
                    </label>
                </div>
                <div class="row">
                    <label>
                        Imagem Pricipal*
                        <input type="file" name="imagem_principal" required accept="image/*">
                    </label>
                    
                </div>
                <div class="row">
                    <label>
                        Tempo do Serviço
                        <select name="tempo_servico" required>
                            <option value="30">30 min</option>
                            <option value="60">1 hora</option>
                        </select>
                    </label>
                </div>
                <div class="row">
                    <button type="submit">Salvar</button>
                </div>
            </form>
        </div>
</section>
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'descricao' );
</script>
<?=$this->fetch('../commons/footer.php', $data)?>