<!DOCTYPE html>
<html lang="pt-br">
    <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
    <title>Exclusive Barbershop</title>
    <link rel="shortcut icon" href="<?=URL_BASE?>resources/imagens/favicon.png"/>    
    <link rel="stylesheet" href="<?=URL_BASE?>resources/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link href="<?=URL_BASE?>resources/css/css.css" rel="stylesheet"/>
    <link href="<?=URL_BASE?>resources/fonts/fontawesome/css/all.min.css" rel="stylesheet"/>
    </head>
    <body class="bg-gradient-primary" style="background: #1f1f1f;color: rgb(25,44,184);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-12 col-xl-10 text-center pt-5 mt-5">
                    <div class="card shadow-lg o-hidden border-0 my-5">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-flex" style="background: #e3e3e3;"><img src="<?=URL_BASE?>resources/assets/img/login.png" width="450" height="384"></div>
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
                                            <h4 class="text-dark mb-0">Recuperar Senha</h4>
                                        </div>
                                        <p class="mb-4">&nbsp;<span style="background-color: rgba(227, 227, 227, 0);">Basta inserir seu endereço de e-mail abaixo e enviaremos um link para redefinir sua senha!</span></p>
                                        <form class="user form_ajax" action="<?=URL_BASE?>admin/gerar-token" method="post" >
                                            <div class="mb-3"><input class="form-control form-control-user" type="email" id="exampleInputEmail-1" aria-describedby="emailHelp" placeholder="Digite seu E-mail" name="email"></div>
                                            <div class="mb-3"></div>
                                            <div class="mb-3">
                                                <div class="custom-checkbox small"></div>
                                            </div><button class="btn btn-primary d-block btn-user w-100" type="submit">Receber e-mail</button>
                                            <hr>
                                            <div class="alerta"  role="alert"></div>
                                        </form>
                                        <div class="text-center"><a class="small text-dark" href="<?=URL_BASE?>login-cliente">Já possui uma conta? acesse</a></div>
                                        <div class="text-center"><a class="small text-dark" href="<?=URL_BASE?>register">Criar uma conta</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?=URL_BASE?>resources/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?=URL_BASE?>resources/assets/js/bs-init.js"></script>
        <script src="<?=URL_BASE?>resources/assets/js/theme.js"></script>
        <script src="<?=URL_BASE?>resources/js/jquery/jquery.min.js"></script>
        <script src="<?=URL_BASE?>resources/js/form/jquery.form.min.js"></script>
        <script src="<?=URL_BASE?>resources/fonts/fontawesome/js/all.min.js"></script>
        <script src="https://kit.fontawesome.com/9c14b7c190.js" crossorigin="anonymous"></script>
        <script src="<?=URL_BASE?>resources/js/js.min.js"></script>
    </body>
</html>