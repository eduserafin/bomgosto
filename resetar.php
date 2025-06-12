<?php
include 'conexao.php';

$token = $_GET['token'] ?? '';

if ($token) {
    // Verifica o token e validade
    $stmt = $conexao->prepare("SELECT id FROM usuarios WHERE token_recuperacao = ? AND token_expira > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $novaSenha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

            // Atualiza a senha e remove o token
            $stmt = $conexao->prepare("UPDATE usuarios SET senha = ?, token_recuperacao = NULL, token_expira = NULL WHERE id = ?");
            $stmt->bind_param("si", $novaSenha, $usuario['id']);
            $stmt->execute();

            echo "Senha redefinida com sucesso.";
        } else {
            // Exibe formulário de redefinição
            echo '<form method="POST">
                    <input type="password" name="senha" placeholder="Nova senha" required>
                    <button type="submit">Redefinir senha</button>
                  </form>';
        }
    } else {
        echo "Token inválido ou expirado.";
    }
} else {
    echo "Token não fornecido.";
}
