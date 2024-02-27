	<footer>
		<div class="container">
			<div class="footer-top">
				<div class="logo">
					<div class="img">
						<a href="<?=URL_BASE?>">
                   			<img src="<?=URL_BASE.$data['informacoes']['pagina']['logo_site']?>">
              			  </a>
					</div>
					<div class="descricao">
						A RLBS lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos unde
						quod autem nulla quasi corrupti quibusdam rerum! Nemo amet optio ratione, 
						consequatur itaque, odio pariatur nobis explicabo blanditiis quisquam eos.
					</div>
					<div class="redes-sociais">
						<?php
							if ($data['informacoes']['pagina']['link_facebook'] !== "") {?>
								<a href="<?=$data['informacoes']['pagina']['link_facebook']?>" target="blank">
									<i class="fa-brands fa-facebook-f"></i>
								</a>
						<?php } ?>
						<?php
							if ($data['informacoes']['pagina']['link_instagram'] !== "") {?>
								<a href="<?=$data['informacoes']['pagina']['link_instagram']?>" target="blank">
								<i class="fa-brands fa-instagram"></i>
								</a>
						<?php } ?>
						<?php
							if ($data['informacoes']['pagina']['link_youtube'] !== "") {?>
								<a href="<?=$data['informacoes']['pagina']['link_youtube']?>" target="blank">
								<i class="fa-brands fa-youtube"></i>
								</a>
						<?php } ?>
					</div>
				</div>

				<div class="menu-institucional">
					<div class="titulo">Institucional</div>

					<div class="">
						<ul>
							<li><a href="<?=URL_BASE."a-rlbs-motors"?>"><i class="fa-solid fa-chevron-right"></i>A RLBS</a></li>
							<li><a href="<?=URL_BASE."servicos"?>"><i class="fa-solid fa-chevron-right"></i>Serviços</a></li>
							<li><a href="<?=URL_BASE."videos"?>"><i class="fa-solid fa-chevron-right"></i>Vídeos</a></li>
							<li><a href="<?=URL_BASE."blog"?>"><i class="fa-solid fa-chevron-right"></i>Blog</a></li>
							<li><a href="<?=URL_BASE."fale-conosco"?>"><i class="fa-solid fa-chevron-right"></i>Fale Conosco</a></li>
							<li><a href="<?=URL_BASE."#recomendacoes"?>"><i class="fa-solid fa-chevron-right"></i>Depoimentos</a></li>

							<?php
								if (isset($data['servicos']) && count($data['servicos']) > 0) { ?>
								<li><a href="<?=URL_BASE.$data['servicos'][0]['url_amigavel']."#formulario_orcamento"?>"><i class="fa-solid fa-chevron-right"></i>Fazer Orçamento</a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
				
				<div class="menu-servicos">
					<div class="titulo">Serviços</div>

					<div class="">
						<ul>
							<?php 
								if (isset($data['servicos']))
								for($i=0; $i < count($data['servicos']); $i++){ 
									if ($i > 6) 
										break;
								?>
									<li><a href="<?=URL_BASE.$data['servicos'][$i]['url_amigavel']?>"><i class="fa-solid fa-chevron-right"></i><?=$data['servicos'][$i]['titulo']?></a></li>
							<?php }?>
						</ul>
					</div>
				</div>

				<div class="contatos">
					<div class="titulo">Contatos</div>

					<div class="informacoes">
						<?php if ($data['informacoes']['pagina']['endereco_contato'] !== "") {?>
							<div class="endereco">
								<div class="icon">
									<i class="fa-solid fa-location-dot"></i>
								</div>
								<p>
									<strong>Endereço</strong>
										<a href="https://www.google.com.br/maps/dir//<?=$data['informacoes']['pagina']['endereco_contato']?>" target="_blank"> 
											<?=$data['informacoes']['pagina']['endereco_contato']?>
										</a>
								</p>
							</div>
						<?php } ?>

						<?php if ($data['informacoes']['pagina']['telefone_contato'] !== "") {?>
						<div class="telefone">
							<div class="icon">
								<i class="fa-solid fa-mobile-screen-button"></i>
							</div>
							<p>
								<strong>Telefone</strong>
								<a href="tel:<?=$data['informacoes']['pagina']['telefone_contato']?>" target="blank">
									<?=$data['informacoes']['pagina']['telefone_contato']?>
								</a>
							</p>
						</div>
						<?php } ?>

						<?php if ($data['informacoes']['pagina']['email_contato'] !== "") {?>
						<div class="email">
							<div class="icon">
								<i class="fa-regular fa-envelope"></i>
							</div>
							<p>
								<strong>E-mail</strong>
								<a href="mailto:<?=$data['informacoes']['pagina']['email_contato']?>" target="blank">
									<?=$data['informacoes']['pagina']['email_contato']?>
								</a>
						</p>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<div class="container">
				<div class="copy">
					Todos direitos reservados &copy <?=date('Y')?>
				</div>
				<div class="dev">
					Desenvolvido por Elyann S
					<a href="https://www.instagram.com/elyann_soares/" target="_blank">
							<i class="fa-brands fa-instagram"></i>
					</a>
				</div>
			</div>	
		</div>
	</footer>
    <script src="<?=URL_BASE?>resources/js/jquery/jquery.min.js"></script>
	<script src="<?=URL_BASE?>resources/js/slick/slick.min.js"></script>
	<script src="<?=URL_BASE?>resources/js/form/jquery.form.min.js"></script>
	<script src="<?=URL_BASE?>resources/js/js.min.js"></script>
	<script src="<?=URL_BASE?>resources/fonts/fontawesome/js/all.min.js"></script>
	<script src="https://kit.fontawesome.com/9c14b7c190.js" crossorigin="anonymous"></script>
	<script src="<?=URL_BASE?>resources/js/swipebox/jquery.swipebox.min.js"></script>
</body>
</html>