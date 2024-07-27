<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard">
    <div class="container">
        <div class="colunas">
            <div class="col1">
                <div class="form light">
                    <form action="<?=URL_BASE?>admin/vendas_insert" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="w-80">
                                <label>
                                    Nome Cliente*
                                    <input type="text" name="nomeCliente" required>
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
                                Serviço
                                <select name="servico" id="">

                                </select>
                            </label>
                            
                        </div>
                        <div class="row">
                            <label>
                                Produto
                                <select name="servico" id="">
                                    
                                </select>
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
            </div>
            <div class="col2">
     
            </div>
        </div>
    </div>
</section>
<?=$this->fetch('../commons/footer.php', $data)?>