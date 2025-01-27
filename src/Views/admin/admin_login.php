<!DOCTYPE html>
<html lang="pt-br">
    <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
    <title>Exclusive Barbearia</title>
    <link rel="shortcut icon" href="<?=URL_BASE?>resources/imagens/favicon.png"/>    
    <link href="<?=URL_BASE?>resources/css/css.css" rel="stylesheet"/>
    <link href="<?=URL_BASE?>resources/fonts/fontawesome/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?=URL_BASE?>resources/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    </head>
   
    <body class="bg-gradient-primary" style="background: #1f1f1f;color: rgb(25,44,184);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-12 col-xl-10 text-center pt-5 mt-5">
                    <div class="card shadow-lg o-hidden border-0 my-5">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-flex" style="background: #e3e3e3;"><img src="<?=URL_BASE?>resources/assets/img/login.png" width="516" height="455"></div>
                                <div class="col-lg-6" style="background: #e3e3e3;">
                                    <div class="p-5 pb-0 mt-0 pt-0" style="background: #e3e3e3;"><img class="d-lg-none d-xl-none d-xxl-none mt-4" src="<?=URL_BASE?>resources/assets/img/logo%20(4).png" width="141" height="65">
                                        <div class="text-center"></div>
                                        <form class="user">
                                            <div class="mb-3"></div>
                                            <div class="mb-3"></div>
                                        </form>
                                        <div class="text-center"></div>
                                        <div class="text-center"></div>
                                    </div>
                                    <div class="p-5 mt-0 pt-4" style="background: #e3e3e3;">
                                        <div class="text-center">
                                            <h4 class="text-dark mb-4">Bem Vindo Barbeiro!</h4>
                                        </div>
                                        <form class="form_ajax user" action="<?=URL_BASE?>admin/login" method="post" class="form_ajax">
                                            <div class="mb-3"><input class="form-control form-control-user" type="email" id="exampleInputEmail-1" aria-describedby="emailHelp" placeholder="Digite seu E-mail" name="email"></div>
                                            <div class="mb-3"><input class="form-control form-control-user" type="password" id="exampleInputPassword-1" placeholder="Digite sua Senha" name="senha"></div>
                                            <div class="mb-3">
                                                <div class="custom-checkbox small">
                                                    <div class="form-check text-start text-sm-start text-md-start text-lg-start text-xl-start text-xxl-start"><input class="form-check-input" type="checkbox" id="formCheck-2"><label class="form-check-label" for="formCheck-2">lembrar-me</label></div>
                                                </div>
                                            </div><button class="btn btn-primary d-block btn-user w-100" type="submit">Entrar</button>
                                            <div class="alerta" role="alert"></div>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div></div>
                </div>
            </div>
        </div>
    <script src="<?=URL_BASE?>resources/js/jquery/jquery.min.js"></script>
	<script src="<?=URL_BASE?>resources/js/form/jquery.form.min.js"></script>
	<script src="<?=URL_BASE?>resources/fonts/fontawesome/js/all.min.js"></script>
	<script src="https://kit.fontawesome.com/9c14b7c190.js" crossorigin="anonymous"></script>
	<script src="<?=URL_BASE?>resources/js/js.min.js"></script>
    <script src="<?=URL_BASE?>resources/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=URL_BASE?>resources/assets/js/theme.js"></script>
    </body>
</html>