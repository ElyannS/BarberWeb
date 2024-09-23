<section class="servicos <?php echo($data['slider_servicos'] == true) ? 'slider' : '';?>">
		<div class="container">
			<div class="titulo center">
				<h2>Nossos Serviços</h2>
			</div>
			<div class="descricao">
				Lorem ipsum dolor sit amet consectetur adipisicing elit.
				Officiis facilis doloremque nobis quis magni obcaecati nemo 
				reprehenderit eaque animi illum autem tempore.
			</div>
			<div class="itens">
				<?php foreach ($data['servicos'] as $servico) {?>
					<div class="item">
						<div class="img">
							<img src="<?=URL_BASE.$servico['imagem_principal']?>">
						</div>
						<div class="info">
							<div class="titulo">
								<h2><?=$servico['titulo']?></h2>
							</div>
							<div class="descricao">
								<?=substr(strip_tags($servico['descricao']), 0, 80)?>...
							</div>
							<div class="linkSite">
								<a href="<?=URL_BASE.$servico['url_amigavel']?>">Saiba Mais</a>
							</div>
						</div>
					</div>	
				<?php }?>
			</div>
		</div>
	</section>