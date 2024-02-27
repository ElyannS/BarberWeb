<?=$this->fetch('commons/header.php', $data)?>

	<section class="banners">
		<ul class="itens">
		<li class="item">
			<a href="#">
				<img src="<?=URL_BASE?>resources/imagens/banner.png">
			</a>
		</li>
		
		<li class="item">
			<a href="#">
				<img src="<?=URL_BASE?>resources/imagens/banner.png">
			</a>
		</li>
		</ul>
	</section>
	

	<?php
    $data['slider_servicos'] = true;
    echo $this->fetch('commons/servicos.php', $data);
?>
	
	<section class="call_to_action">
			<video autoplay loop muted src="<?=URL_BASE?>resources/imagens/videos/video.mp4"></video>
			<div class="container">
				<div class="titulo_principal">
					Somos a Oficina mecânica mais completa de Sertãozinho com excelente qualidade e preços acessíveis
				</div>
				<div class="btn">
					<?php
						if (isset($data['servicos']) && count($data['servicos']) > 0) { ?>
							<a href="<?=URL_BASE.$data['servicos'][0]['url_amigavel']."#formulario_orcamento"?>"></i>Fazer Orçamento</a>
					<?php } ?>
				</div>
			</div>
	</section>

	<section class="institucional">
		<div class="container">
			<div class="informacoes">
				<div class="titulo">
					<h2>Quem Somos</h2>
				</div>
				<div class="descricao">
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
					Officiis facilis doloremque nobis quis magni obcaecati nemo 
					reprehenderit eaquee. nobis quis magni obcaecati nemo 
					reprehenderit eaquee</p>
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
					Officiis facilis doloremque nobis quis magni obcaecati nemo 
					reprehenderit eaquee nobis quis magni obcaecati nemo 
					reprehenderit eaquee.</p>
				</div>
				<div class="btn">
					<a href="<?=URL_BASE."a-rlbs-motors"?>">
						Continue Lendo
					</a>
				</div>
			</div>
			<div class="video">
				<img src="<?=URL_BASE?>resources/imagens/institucional.png">
				<div class="conteudo">
					<div class="texto">
						ASSISTA O VÍDEOS ESPECIAL QUE PREPARAMOS PARA VOCÊ
					</div>
					<div class="icone">
						<a href="https://www.youtube.com/watch?v=eI5FkVWz_dI" class="swipebox-video" title="Video Institucional">
							<i class="fas fa-play"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?=$this->fetch('commons/clientes.php', $data)?>

	<section class="marcas">
		<div class="container">
			<div class="galeria"> 
				<div class="item">
					<img src="<?=URL_BASE?>resources/imagens/marcas/logo_audi.png">
				</div>
				<div class="item">
					<img src="<?=URL_BASE?>resources/imagens/marcas/logo_bmw.png">
				</div>
				<div class="item">
					<img src="<?=URL_BASE?>resources/imagens/marcas/logo_chevrolet.png">
				</div>
				<div class="item">
					<img src="<?=URL_BASE?>resources/imagens/marcas/logo_citroen.png">
				</div>
				<div class="item">
					<img src="<?=URL_BASE?>resources/imagens/marcas/logo_fiat.png">
				</div>
				<div class="item">
					<img src="<?=URL_BASE?>resources/imagens/marcas/logo_ford.png">
				</div>
				<div class="item">
					<img src="<?=URL_BASE?>resources/imagens/marcas/logo_honda.png">
				</div>
				<div class="item">
					<img src="<?=URL_BASE?>resources/imagens/marcas/logo_hyundai.png">
				</div>
				<div class="item">
					<img src="<?=URL_BASE?>resources/imagens/marcas/logo_jac.png">
				</div>
				<div class="item">
					<img src="<?=URL_BASE?>resources/imagens/marcas/logo_land_rover.png">
				</div>
				<div class="item">
					<img src="<?=URL_BASE?>resources/imagens/marcas/logo_mercedes.png">
				</div>
				<div class="item">
					<img src="<?=URL_BASE?>resources/imagens/marcas/logo_mitsubishi.png">
				</div>
				<div class="item">
					<img src="<?=URL_BASE?>resources/imagens/marcas/logo_nissan.png">
				</div>
				<div class="item">
					<img src="<?=URL_BASE?>resources/imagens/marcas/logo_peugeot.png">
				</div>
				<div class="item">
					<img src="<?=URL_BASE?>resources/imagens/marcas/logo_renault.png">
				</div>
				<div class="item">
					<img src="<?=URL_BASE?>resources/imagens/marcas/logo_suzuki.png">
				</div>
				<div class="item">
					<img src="<?=URL_BASE?>resources/imagens/marcas/logo_toyota.png">
				</div>
				<div class="item">
					<img src="<?=URL_BASE?>resources/imagens/marcas/logo_volkswagen.png">
				</div>
				<div class="item">
					<img src="<?=URL_BASE?>resources/imagens/marcas/logo_volvo.png">
				</div>
			</div>
		</div>
	</section>

	<section class="noticias">
		<div class="container">
			<div class="titulo center">
				<h2>Notícias</h2>
			</div>
			<div class="descricao">
				Lorem ipsum dolor sit amet consectetur adipisicing elit.
				Officiis facilis doloremque nobis quis magni obcaecati nemo 
				reprehenderit eaque animi illum autem tempore.
			</div>
			<div class="itens">
				<?php foreach($data['blogs'] as $blog){?>
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
								<a href="<?=URL_BASE.$blog['url_amigavel']?>">Saiba Mais</a>
							</div>
						</div>
					</div>
				<?php }?>
			</div>
		</div>
	</section>
<?=$this->fetch('commons/footer.php', $data)?>