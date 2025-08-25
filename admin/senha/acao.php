<?php

session_start(); 
include "../../conexao.php";

foreach ($_GET as $key => $value) {
    $$key = htmlspecialchars(trim($value));
}

// Verifica se o usuário está logado
if (!isset($_SESSION["CD_USUARIO"])) {
    exit("<script>parent.Swal.fire('Erro', 'Sessão expirada. Faça login novamente.', 'error');</script>");
}

if ($Alterar == "OK") {
    $senhaAtual = mysqli_real_escape_string($conexao, $TxSenhaA);
    $senhaNova  = mysqli_real_escape_string($conexao, $TxSenhaN);

    // Busca a senha atual hash no banco
    $sql = "SELECT ds_senha FROM usuarios WHERE nr_sequencial = {$_SESSION['CD_USUARIO']} LIMIT 1";
    $result = mysqli_query($conexao, $sql);

    if (!$result || mysqli_num_rows($result) === 0) {
        echo "<script>
            parent.Swal.fire('Erro', 'Usuário não encontrado.', 'error');
        </script>";
        exit;
    }

    $dados = mysqli_fetch_assoc($result);
    $senhaHashAtual = $dados['ds_senha'];

    // Verifica se a senha informada bate com a hash
    if (!password_verify($senhaAtual, $senhaHashAtual)) {
        echo "<script>
            parent.Swal.fire('Erro', 'A senha atual está incorreta.', 'error');
        </script>";
        exit;
    }

    // Cria o novo hash seguro da nova senha
    $novaHash = password_hash($senhaNova, PASSWORD_DEFAULT);

    // Atualiza no banco
    $sqlUpdate = "UPDATE usuarios SET ds_senha = '{$novaHash}' WHERE nr_sequencial = {$_SESSION['CD_USUARIO']}";

    if (mysqli_query($conexao, $sqlUpdate)) {
        echo "<script>
            parent.Swal.fire({
                title: 'Sucesso',
                text: 'Senha alterada com sucesso!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                parent.location.reload();
            });
        </script>";
    } else {
        echo "<script>
            parent.Swal.fire('Erro', 'Erro ao atualizar a senha. Tente novamente.', 'error');
        </script>";
    }
}
?>
