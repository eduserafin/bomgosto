<?php 
    require_once('config/servers.php'); 
    if (isset($_SESSION['CD_USUARIO']) && strlen($_SESSION['CD_USUARIO']) > 0 && isset($_SESSION['ALIAS_EMPRESA']) && strlen($_SESSION['ALIAS_EMPRESA']) > 0) {
        header('location: dashboard.php');
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Csimulador | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Fontes e Estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('img/fundo3.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-login {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }

        .form-login h3 {
            text-align: center;
            font-weight: 600;
            font-size: 26px;
            margin-bottom: 30px;
        }

        .inputBox {
            position: relative;
            margin-bottom: 30px;
        }

        .inputUser {
            width: 100%;
            border: none;
            border-bottom: 2px solid #ccc;
            outline: none;
            font-size: 15px;
            padding: 10px 5px;
            background: transparent;
            transition: border-color 0.3s;
        }

        .inputUser:focus {
            border-color: #612db5;
        }

        .labelInput {
            position: absolute;
            top: 10px;
            left: 5px;
            font-size: 14px;
            color: #777;
            pointer-events: none;
            transition: 0.3s ease;
        }

        .inputUser:focus ~ .labelInput,
        .inputUser:valid ~ .labelInput {
            top: -12px;
            font-size: 12px;
            color: #612db5;
        }

        .btn-login {
            background: #612db5;
            color: #fff;
            border: none;
            padding: 12px;
            width: 100%;
            font-weight: 500;
            font-size: 15px;
            border-radius: 12px;
            transition: background 0.3s ease;
        }

        .btn-login:hover {
            background: #4e2391;
        }

        @media (max-width: 480px) {
            .form-login {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

    <div class="form-login">
        <form action="conecta.php" method="post">
            <h3>Login</h3>

            <div class="inputBox">
                <input type="text" name="nomeempresa" id="nomeempresa" class="inputUser" required>
                <label for="nomeempresa" class="labelInput">Empresa</label>
            </div>

            <div class="inputBox">
                <input type="text" name="usuario" id="usuario" class="inputUser" required>
                <label for="usuario" class="labelInput">Usuário</label>
            </div>

            <div class="inputBox">
                <input type="password" name="senha" id="senha" class="inputUser" required>
                <label for="senha" class="labelInput">Senha</label>
            </div>

            <button type="submit" class="btn-login">Entrar</button>
        </form>
    </div>

</body>
</html>
