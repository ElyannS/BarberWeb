<!DOCTYPE html>
<html data-bs-theme="light" lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
        <title>Exclusive Barbearia</title>
        <link rel="shortcut icon" href="<?=URL_BASE?>resources/imagens/favicon.png"/>    
        <link rel="stylesheet" href="<?=URL_BASE?>resources/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
        <link href="<?=URL_BASE?>resources/css/css.css" rel="stylesheet"/>
        <link href="<?=URL_BASE?>resources/fonts/fontawesome/css/all.min.css" rel="stylesheet"/>
    </head>
    <body class="bg-gradient-primary" style="background: #1f1f1f;">
        <div class="container">
            <div class="card shadow-lg o-hidden border-0 my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-5 d-none d-lg-flex"><img src="<?=URL_BASE?>resources/assets/img/login.png" width="435" height="552"></div>
                        <div class="col-lg-7">
                            <div class="p-5 ps-5">
                                <div></div>
                                <div class="text-center">
                                    <div></div><img class="d-lg-none mb-4" src="<?=URL_BASE?>resources/assets/img/logo%20(4).png" width="111" height="52">
                                    <h4 class="text-dark mb-4">Crie sua Conta!</h4>
                                </div>
                                <form class="user form_ajax" action="<?=URL_BASE?>admin/clientes_insert_cadastro" method="post" enctype="multipart/form-data">
                                    <div class="row mb-3">
                                        <div class="col-sm-6 mb-3 mb-sm-0"><input required class="form-control form-control-user" type="text" id="exampleFirstName" placeholder="Primeiro Nome" name="first_name"></div>
                                        <div class="col-sm-6"><input required class="form-control form-control-user" type="text" id="exampleLastName" placeholder="Último Nome" name="last_name"></div>
                                    </div>
                                    <div class="mb-3"><input required class="form-control form-control-user" type="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="E-mail" name="email"></div>
                                    <input required class="form-control form-control-user mb-3" type="tel" id="exampleInputEmail-1" placeholder="Telefone" name="telefone" inputmode="tel">
                                    <div class="row mb-3">
                                        <div class="col-sm-6 mb-3 mb-sm-0"><input required class="form-control form-control-user" type="password" id="examplePasswordInput" placeholder="Mínimo 4 dígitos" name="senha"></div>
                                        <div class="col-sm-6"><input required class="form-control form-control-user" type="password" id="exampleRepeatPasswordInput" placeholder="Repita a senha" name="confirmar_senha"></div>
                                    </div><button class="btn btn-primary d-block btn-user w-100" type="submit">Criar Conta</button>
                                    <hr>
                                    <div class="alerta" role="alert"></div>
                                </form>
                                <div class="text-center"><a class="small text-dark" href="<?=URL_BASE?>receber-email">Esqueceu sua Senha?</a></div>
                                <div class="text-center"><a class="small text-dark" href="<?=URL_BASE?>login-cliente">Já possui uma conta? Acesse</a></div>
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