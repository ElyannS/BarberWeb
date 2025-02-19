<!DOCTYPE html>
<html lang="pt-br">
    <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
    <title>Exclusive Barbershop</title>
    <link rel="shortcut icon" href="<?=URL_BASE?>resources/imagens/favicon.png"/>    
    <link href="<?=URL_BASE?>resources/css/css.css" rel="stylesheet"/>
    <link href="<?=URL_BASE?>resources/fonts/fontawesome/css/all.min.css" rel="stylesheet"/>
    </head>
    <body>
        <section class="pagina_login cliente">
            <div class="container">
                <div class="center">
                    <img src="<?=URL_BASE.$data['informacoes']['nome_logo']?>" alt="">
                    <div class="form">
                        <h1>Redefinir Senha</h1>
                        <form action="<?=URL_BASE?>admin/gerar-token" method="post" class="form_ajax">
                            <input type="email" name="email" placeholder="Digite seu e-mail" required>
                                <button type="submit">receber e-mail</button>
                            <div class="alerta"></div>
                        </form>
                    </div>
                </div>
                
                <div class="bottom">
                    <div class="copy">
                        Todos direitos reservados &copy 2024
                    </div>
                    <div class="dev">
                        Desenvolvido por Elyann S
                        <a href="https://www.instagram.com/elyann_soares">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    <script src="<?=URL_BASE?>resources/js/jquery/jquery.min.js"></script>
	<script src="<?=URL_BASE?>resources/js/form/jquery.form.min.js"></script>
	<script src="<?=URL_BASE?>resources/fonts/fontawesome/js/all.min.js"></script>
	<script src="https://kit.fontawesome.com/9c14b7c190.js" crossorigin="anonymous"></script>
	<script src="<?=URL_BASE?>resources/js/js.min.js"></script>
    </body>
</html>