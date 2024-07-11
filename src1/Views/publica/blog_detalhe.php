<?=$this->fetch('commons/header.php', $data)?>
<?=$this->fetch('commons/migalha.php', $data)?>
    <div class="blog_detalhe">
        <div class="container">
            <section class="noticia">
                <h2 class="titulo"><?=$data['blog']['titulo']?></h2>
                <p class="data"><?=date("d/m/Y", strtotime($data['blog']['data_cadastro']))?> - Por: <?=$data['blog']['autor']?></p>
                <img src="<?=URL_BASE.$data['blog']['imagem_principal']?>">
                <?=$data['blog']['descricao']?>
            </section>

            <section class="ultimas_noticias">
                <h2 class="titulo">Últimas Notícias</h2>
                <div class="itens">

                <?php 

                    $i = 0;

                    foreach($data['blogs'] as $blog){
                        if ($i > 2){
                            break;
                        }
                        ?>
                        <div class="item">
                            <div class="img">
                            <img src="<?=URL_BASE.$blog['imagem_principal']?>">
                            </div>
                            <div class="info">
                                <div class="data">
                                    <?=date("d/m/Y", strtotime($blog['data_cadastro']))?>
                                </div>
                                <div class="titulo">
                                    <h2><?=$blog['titulo']?></h2>
                                </div>
                                <div class="link">
                                <a href="<?=URL_BASE.$blog['url_amigavel']?>">Ver notícia</a>
                                </div>
                            </div>
                        </div>
                <?php $i++;}?>
                </div>
            </section>
        </div>    
    </div>
<?=$this->fetch('commons/footer.php', $data)?>