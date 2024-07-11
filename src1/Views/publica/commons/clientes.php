<section class="clientes" id="recomendacoes">
		<div class="container">
		<div class="titulo center">
				<h2>O que nossos clientes dizem</h2>
			</div>

			<div class="conteudo">
				<div class="img">
				<img src="<?=URL_BASE?>resources/imagens/imagem_lateral_clientes.png">
				</div>
				<div class="carrocel">
					<?php foreach ($data['recomendacoes'] as $recomendacao) { ?>
						<div class="item">
							<div class="top">
								<i class="fa-solid fa-quote-left"></i>
							</div>
							<div class="descricao">
								<?=$recomendacao['descricao']?>
							</div>
							<div class="bottom">
								<div class="img">
									<img src="<?=URL_BASE.$recomendacao['foto_cliente']?>">
								</div>
								<div class="info">
									<div class="estrela">
										<?php for($i=0; $i < (int)$recomendacao['avaliacao']; $i++){?>
											<i class="fa-solid fa-star"></i>
										<?php }?>
									</div>

									<div class="nome">
										<span><?=$recomendacao['nome']?></span>
										<small><?=$recomendacao['profissao']?></small>
									</div>
								</div>
							</div>
						</div>
					<?php }?>
				</div>
			</div>
		</div>
	</section>