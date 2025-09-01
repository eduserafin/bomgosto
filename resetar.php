<?php
include 'conexao.php';

$token = $_GET['token'] ?? '';
$token = $conexao->real_escape_string($token);

$mensagem = '';

if ($token) {
    // Verifica o token e validade
    $SQL = "SELECT nr_sequencial FROM usuarios WHERE ds_token = '$token' AND dt_token > NOW()";
    $resultado = $conexao->query($SQL);

    if ($resultado && $resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $novaSenha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

            // Atualiza a senha e remove o token
            $SQL_UPDATE = "UPDATE usuarios SET ds_senha = '$novaSenha', ds_token = NULL, dt_token = NULL WHERE nr_sequencial = {$usuario['nr_sequencial']}";
            $conexao->query($SQL_UPDATE);

            $mensagem = "Senha redefinida com sucesso.";
        }
    } else {
        $mensagem = "Token inválido ou expirado.";
    }
} else {
    $mensagem = "Token não fornecido.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('img/fundo3.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }
        .form-reset {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            max-width: 400px;
            width: 100%;
        }
        .form-reset h3 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }
        .btn-submit {
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
        .btn-submit:hover {
            background: #4e2391;
        }
    </style>
</head>
<body>

<div class="form-reset">
    <h3>Redefinir Senha</h3>

    <?php if ($mensagem): ?>
        <div class="alert alert-info text-center"><?= $mensagem ?></div>

        <?php if ($mensagem === 'Senha redefinida com sucesso.'): ?>
            <script>
                // Aguarda 3 segundos e redireciona para index.php
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 2000);
            </script>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($mensagem === '' || $mensagem === 'Senha redefinida com sucesso.'): ?>
        <?php if ($mensagem !== 'Senha redefinida com sucesso.'): ?>
        <form method="POST">
            <div class="mb-3">
                <label for="senha" class="form-label">Nova senha</label>
                <input type="password" name="senha" id="senha" class="form-control" required placeholder="Digite sua nova senha">
            </div>
            <button type="submit" class="btn-submit">Redefinir senha</button>
        </form>
        <?php endif; ?>
    <?php endif; ?>
</div>


</body>
</html>
