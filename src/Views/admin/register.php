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
                    <div class="form backg">
                        <form action="<?=URL_BASE?>admin/clientes_insert" class="margin" method="post" enctype="multipart/form-data">
                            <label>
                                Nome
                                <input type="text" name="nome" required>
                            </label>
                            <label>
                                Email
                                <input type="email" name="email" required>
                            </label>
                            <label>
                                Telefone
                                <input type="tel" name="telefone" required>
                            </label>
                            <label>
                                Senha
                                <input type="password" name="senha" required>
                            </label>
                            <label>
                                Senha
                                <input type="password" name="confirmar_senha" required>
                            </label>
                            <button type="submit">Registrar</button>
                        </form>
                        <div class="cadastro">
                            <a href="<?=URL_BASE?>login-cliente">Já possui conta?</a>
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