<?=$this->fetch('commons/header.php', $data)?>
<?=$this->fetch('commons/migalha.php', $data)?>
<section class="listagem_noticias">
		<div class="container">
			<div class="titulo">
				<h2>Notícias</h2>
			</div>
			<div class="descricao">
				Lorem ipsum dolor sit amet consectetur adipisicing elit.
				Officiis facilis doloremque nobis quis magni obcaecati nemo 
                Officiis facilis doloremque nobis quis magni obcaecati nemo 
				reprehenderit eaque animi illum autem tempore.
			</div>
			<div class="itens">
			<?php
				foreach ($data['blogs'] as $blog) {?>
				<div class="item">
					<div class="img">
						<img src="<?=URL_BASE.$blog['imagem_principal']?>">
					</div>
					<div class="info">
						<div class="data">
							<?=date("d/m/Y", strtotime($blog['data_cadastro']))?>
						</div>
						<div class="titulo">
							<h2> <?=$blog['titulo']?></h2>
						</div>
						<div class="link">
							<a href="<?=URL_BASE.$blog['url_amigavel']?>">Ver notícia</a>
						</div>
					</div>
				</div>
			<?php }?>
			</div>
			</div>
            <div class="paginacao">
                <ul>

				<?php if(isset($data['informacoes']['paginaAnterior']) && $data['informacoes']['paginaAnterior'] !== false){?>
					<li><a href="<?=$data['informacoes']['paginaAnterior'] ?>"><i class="fas fa-angle-double-left"></i></a></li>
                <?php }?>
                
				<li><a href="#" class="active"><?=$data['informacoes']['paginaAtual']?></a></li>

                <?php if(isset($data['informacoes']['proximaPagina']) && $data['informacoes']['proximaPagina'] !== false){?>
					<li><a href="<?=$data['informacoes']['proximaPagina']?>"><i class="fas fa-angle-double-right"></i></a></li>
                <?php }?>

                </ul>
            </div>
		</div>
	</section>
<?=$this->fetch('commons/footer.php', $data)?>