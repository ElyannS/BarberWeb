<?=$this->fetch('commons/header.php', $data)?>

	    <!-- slider section -->
	<section class="slider_section ">
      	<div id="customCarousel1" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item <?php echo $ativo ?>">
					<div class="container ">
					<div class="row">
						<div class="col-md-6 ">
						<div class="detail-box">
							<h1>Sua barba feita</h1>
							<p>
								alskdlksakds
							</p>
							<div class="btn-box">
							<a href="http://api.whatsapp.com/send?1=pt_BR&phone=" target="_blank" class="btn1">
								Contate-nos
							</a>
							</div>
						</div>
						</div>
					</div>
					</div>
				</div>
        	</div>
			<div class="container">
				<div class="carousel_btn-box">
					<a class="carousel-control-prev" href="#customCarousel1" role="button" data-slide="prev">
					<i class="fa fa-arrow-left" aria-hidden="true"></i>
					<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#customCarousel1" role="button" data-slide="next">
					<i class="fa fa-arrow-right" aria-hidden="true"></i>
					<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
      	</div>
    </section>
    <!-- end slider section -->


	

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
						if (isset($data['servicos']) && is_array($data['servicos']) && count($data['servicos']) > 0) { ?>
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
				<?php foreach($dat['blogs'] as $blog){?>
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
							<div class="linkSite">
								<a href="<?=URL_BASE.$blog['url_amigavel']?>">Saiba Mais</a>
							</div>
						</div>
					</div>
				<?php }?>
			</div>
		</div>
	</section>
<?=$this->fetch('commons/footer.php', $data)?>