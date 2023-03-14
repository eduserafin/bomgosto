<?php require_once('config/servers.php'); 
?>
<?php
//SE O USUÁRIO JÁ ESTÁ LOGADO REDIRECIONA PARA A DASHBOARD
if (isset($_SESSION['CD_USUARIO']) && strlen($_SESSION['CD_USUARIO']) > 0 && isset($_SESSION['ALIAS_EMPRESA']) && strlen($_SESSION['ALIAS_EMPRESA']) > 0) {
    header('location: dashboard.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BG | Login</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

</head>

<body class="hold-transition login-page vsc-initialized">
    <div class="row fundo-login">
        <div class="row form-login">
            <div class="col-12 col-sm-6 login-esquerda">
                <div class="cabecalho-esquerda" style="justify-content: center; display: flex; margin-bottom: -80px;">
                    <img class="logo" src="img/logo.png" alt="" height="350" width="350">
                </div>
                <p class="conteudo-esquerda">
                    Bom gosto é melhor que mau gosto, mas mau gosto é melhor que gosto nenhum..<br><b style="font-size: 12px;
                    font-weight: 400;
                    display: flex;
                    justify-content: right;">(Arnold Bennett).</b></p>

            </div>
            <div class="col-12 col-sm-6 login-direita">
                <form action="conecta.php" method="post">
                    <!-- <h6 class="titulo-h6">ENTRE COM SEU USUARIO</h6> -->
                    <!-- <h3 class="titulo-h3">Login Ginfo</h3> -->
                    <h6 class="titulo-h6">&nbsp;</h6>
                    <h3 class="titulo-h3">&nbsp;</h3>
                    <div class="pt-5">
                        <?php if (!defined('ALIAS_EMPRESA') or strpos($host, 'bkp.ginfo.i9ss.com.br') !== FALSE) : ?>
                            <div class="inputBox">
                                <input type="text" name="nomeempresa" id="nomeempresa" class="inputUser">
                                <label for="nome" class="labelInput">Empresa</label>
                            </div>
                        <?php else : ?>
                            <input type="hidden" name="nomeempresa" value="<?php echo $ALIAS_EMPRESA ?>">
                        <?php endif; ?>
                        <div class="inputBox">
                            <input type="text" name="usuario" id="usuario" class="inputUser" required>
                            <label for="email" class="labelInput">Usuário</label>
                        </div>

                        <div class="inputBox">
                            <input type="password" name="senha" id="senha" class="inputUser" required>
                            <label for="nome" class="labelInput">Senha</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-login">Entrar</button>
                </form>
            </div>
        </div>
    </div>
    <script src="./I9 Sistemas _ Login_files/jquery-2.2.3.min.js.download"></script>
    <script src="./I9 Sistemas _ Login_files/bootstrap.min.js.download"></script>
    <script src="./I9 Sistemas _ Login_files/icheck.min.js.download"></script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    <style>
        body {
            overflow: hidden;
        }

        @media screen and (max-width: 940px) {
            .cabecalho-esquerda {
                margin-top: -33px;
                margin-bottom: -60px !important;
            }

            .logo {
                width: 171px;
                height: 173px;
            }

            .login-direita {
                margin-top: -82px;
                padding: 7%;
            }

            .login-esquerda {

                margin-left: 0px !important;
            }

            .form-login {
                padding: 0;
                height: 89%!important;
                width: 79%!important;
            }
        }

        .fundo-login {
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: linear-gradient(to right, #0000001f, #0000001f), url(img/fundo3.jpg);
            background-size: cover;
            background-position: bottom;
            height: 100vh;
        }

        .form-login {
            height: 75%;
            width: 65%;
            background-color: #fff;
            border-radius: 32px;
        }

        .login-esquerda {

            border-radius: 32px;
            margin-left: -16px;
            background-image: linear-gradient(to right, #6570c0, #612db5), url(img/fundo2.jpg);
            background-size: cover;
            background-position: top;
            display: grid;
            align-items: center;
            justify-content: center;
        }

        .login-direita {
            padding: 4%;
            display: grid;
            align-items: center;
        }

        .titulo-h6 {
            font-family: poppins;
            color: #6dc065;
            font-size: 11px;
        }

        .titulo-h3 {
            font-family: 'Poppins';
            font-size: 28px;
        }

        .conteudo-esquerda {
            color: #ffffff;
            font-size: 14px;
            font-family: poppins;
            padding: 10%;
        }

        .btn-login {
            background: #612db5;
            width: 100%;
            border: none;
            margin-top: 5%;
            color: #fff;
            font-family: 'poppins';
            font-size: 15px;
            padding: 10px;
            border-radius: 18px;
        }

        .btn-login:hover {
            background: #197374;
        }
    </style>
    <style>
        .nav {
            display: block;
        }

        .nav-link {
            color: #010000 !important;
        }

        .box {
            display: flex;
            justify-content: center;
        }

        .inputUser {
            background: none;
            border: none;
            border-bottom: 1px solid #adadad;
            outline: none;
            color: #212529;
            margin-bottom: 10%;
            width: 100%;
            padding: 5px;
            font-family: 'poppins';
            font-size: 14px;
            /* letter-spacing: 1px; */
        }

        .page-section {
            padding-top: 20px !important;
        }

        .inputBox {
            position: relative;
        }

        .labelInput {
            position: absolute;
            top: 0px;
            left: 0px;
            pointer-events: none;
            transition: .5s;
            font-weight: 300;
            font-family: 'poppins';
            font-size: 14px;
        }
        .inputUser:focus~.labelInput,
        .inputUser:valid~.labelInput {
            top: -20px;
            font-size: 11px;
            color: #197374;
        }
    </style>

</body>

</html>