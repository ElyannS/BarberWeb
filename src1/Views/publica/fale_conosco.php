<?=$this->fetch('commons/header.php', $data)?>
<?=$this->fetch('commons/migalha.php', $data)?>
<section class="fale_conosco">
    <div class="container">
        <div class="topo">
            <div class="form">
                <h2>Nos envie uma mensagem</h2>
                <form action="<?=URL_BASE?>enviar_formulario_contato" method="post" class="form_ajax">
                    <input type="text" name="name" placeholder="Nome" required>
                    <input type="email" name="email" placeholder="E-mail" required>
                    <input type="text" name="telefone" placeholder="Telefone" required>
                    <input type="text" name="assunto" placeholder="Assunto" required>
                    <textarea placeholder="Mensagem" name="mensagem" required></textarea>
                    <div class="btn_acao">
                        <div class="recaptcha"></div>
                        <div class="btn">
                            <button type="submit">Enviar mensagem</button>
                        </div>
                    </div>
					<div class="alerta"></div>
                </form>
            </div>
            <div class="contatos">
					<div class="titulo">Nossos Contatos</div>

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
										</a>>
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
        </div>
        <div class="iframe_mapa">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3472.2180843383526!2d-51.81365418428992!3d-29.510001813585596!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x951c7034eaf2518b%3A0x62d2e6a0ad69ff95!2sRua%20Capit%C3%A3o%20Schneider%20-%20Canabarro%2C%20Teut%C3%B4nia%20-%20RS%2C%2095890-000!5e0!3m2!1spt-BR!2sbr!4v1674268420219!5m2!1spt-BR!2sbr" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>
<?=$this->fetch('commons/footer.php', $data)?>