<?=$this->fetch('commons/header.php', $data)?>
<?=$this->fetch('commons/migalha.php', $data)?>

    <section class="servico_detalhe">
        <div class="container">
            <div class="texto">
                <img src="<?=URL_BASE.$data['servico']['imagem_principal']?>">
                <h2 class="titulo"><?=$data['servico']['titulo']?></h2>
                <?=$data['servico']['descricao']?>
            </div>
        </div>
    </section>
    <?php if(isset($data['galeria']) && count($data['galeria']) > 0) { ?>
        <section class="galeria_fotos">
            <div class="container">
                <div class="titulo center">
                    <h2>Galeria de fotos</h2>
                </div>
                <div class="itens">
                    <?php foreach ( $data['galeria'] as $galeria) { ?>
                        <div class="item">
                            <div class="img">
                                <a class="swipebox" title="Nome da Imagem" href="<?=URL_BASE.$galeria['caminho_imagem']?>">
                                    <img src="<?=URL_BASE.$galeria['caminho_imagem']?>">
                                    <div class="hover">
                                        <i class="fa fa-image"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    <?php } ?>

    <section class="formulario_orcamento">
    <div class="container">
        <div class="img">
             <img src="<?=URL_BASE?>resources/imagens/imagem_orcamento.png">
        </div>
        <div class="form" id="formulario_orcamento">
                    <h2>Fazer orçamento</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <form action="<?=URL_BASE?>enviar_formulario_orcamento" method="post" class="form_ajax">
                        <input type="text" name="name" placeholder="Nome" required>
                        <input type="text" name="telefone" placeholder="Telefone" required>
                        <input type="email" name="email" placeholder="E-mail" required>
                        

                        <strong>Selecione o serviço desejados:</strong>

                        <?php 
                        if (isset($data['servicos']))
                        foreach ( $data['servicos'] as $servico) { ?>
                            <label>
                                <input type="checkbox" name="servicos[]" value="<?=$servico['titulo']?>">
                                <?=$servico['titulo']?>
                            </label>
                        <?php } ?>

                        <p>Nos de mais informações no campo abaixo, como ano e modelo do carro, 
                           problema que vem observando a algum temppo e tudo o que achar relevante para nos contar:</p>
                        <textarea placeholder="Mensagem" name="mensagem" required></textarea>
                        <div class="btn_acao">
                            <div class="recaptcha"></div>
                            <div class="btn">
                                <button type="submit">Enviar orçamento</button>
                            </div>
                        </div>
                        <div class="alerta"></div>
                    </form>
         </div>            
     </div>
         
</section>

<?=$this->fetch('commons/footer.php', $data)?>