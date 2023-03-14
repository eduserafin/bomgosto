<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Viveiro Florestal Dois Irmãos</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
    <img src="img/logosf1.png" border="0" width="360" height="220">
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">SISTEMA VIVEIRO</p>
        <form action="conecta.php" method="post">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Usu&aacute;rio" name="usuario" id="usuario" >
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Senha" name="senha" id="senha">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck"></div>
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
                </div>
            </div>
        </form>
<!--<a href="EsqueceuSenha/index.php">Esqueci Minha Senha</a><br>-->
<!--<a href="registro.php" class="text-center">Solicitar Acesso</a>-->
    </div>
</div>
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
$(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
});
</script>
</body>
</html>