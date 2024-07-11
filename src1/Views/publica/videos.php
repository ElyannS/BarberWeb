<?=$this->fetch('commons/header.php', $data)?>
<?=$this->fetch('commons/migalha.php', $data)?>
<section class="listagem_videos">
    <div class="container">
        <div class="top">
            <div class="titulo">
                Vídeos
            </div>
            <div class="botao">
               <a href="#" target="_blank"> 
                   Inscreva-se em nosso Canal
               </a>
            </div>
        </div>
        <div class="descricao">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Reprehenderit nihil autem
            sapiente quae similique recusandae! Dolorem, maiores sit. Eveniet numquam quisquam
            beatae fuga dolorum eos dicta rerum aut deleniti totam.
        </div>
        <div class="lista">
            <?php
                foreach ($data['videos'] as $video) {?>
                <div class="item">
                    <div class="img">
                    <img src="<?=URL_BASE.$video['imagem_principal']?>">
                    <div class="icone">
                            <a href="<?=$video['link_video']?>" class="swipebox-video" title="Video Institucional">
                                <i class="fas fa-play"></i>
                            </a>
                        </div>
                    </div>
                    <div class="titulo_video">
                        <?=$video['titulo']?>
                    </div>
                </div>
                <?php }?>
        </div>
    </div>
</section>
<?=$this->fetch('commons/footer.php', $data)?>