<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard">
    <div class="container">
        <div class="titulo_pagina light-color">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Editar - Serviço</p>
            </div>
            <div class="topo">
                &nbsp;
            </div> 
        </div>
        <div class="form light">
            <form action="<?=URL_BASE?>admin/servicos_update" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="w-80">
                        <label>
                            Título
                            <input type="text" name="titulo" required value="<?=$data['informacoes']['servico']['titulo']?>">
                        </label>
                    </div>
                    <div class="w-20">
                    <label>
                            Data
                            <input type="date" name="data" required  value="<?=date('Y-m-d', strtotime($data['informacoes']['servico']['data_cadastro']))?>">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <label>
                        Valor
                        <input type="text" name="valor" value="<?=$data['informacoes']['servico']['valor']?>">
                    </label>
                    
                </div>
                <div class="row">
                    <label>
                        Imagem Pricipal
                        <input type="file" name="imagem_principal">
                    </label>
                    <div class="img">
                        <img src="<?=URL_BASE.$data['informacoes']['servico']['imagem_principal']?>">
                        <label>
                            <input type="checkbox" name="excluir_imagem_principal">
                            Excluir imagem
                        </label>
                    </div>
                </div>
                <div class="row">
                    <label>
                        Tempo do Serviço
                        <select name="tempo_servico" required>
                            <option value="60" <?php if($data['informacoes']['servico']['tempo_servico'] === '60') echo 'selected'?>>1 hora</option>
                            <option value="30" <?php if($data['informacoes']['servico']['tempo_servico'] === '30') echo 'selected'?>>30 min</option>
                        </select>
                    </label>
                </div>
                <div class="row">
                    <button type="submit">Salvar</button>
                </div>
                <input type="hidden" name="id" value="<?=$data['informacoes']['servico']['id']?>">
                <input type="hidden" name="nome_imagem_atual" value="<?=$data['informacoes']['servico']['imagem_principal']?>">
            </form>
        </div>
</section>
<?=$this->fetch('../commons/footer.php')?>