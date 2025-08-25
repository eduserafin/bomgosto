<?php
require 'config.php';
require_once '../conexao.php';

if (isset($_SESSION["CD_USUARIO"])) {
    $userId = $_SESSION["CD_USUARIO"];

    // Recupera o token do usuário
    $sql = "SELECT ds_token FROM fb_tokens WHERE nr_seq_user = $userId LIMIT 1";
    $res = mysqli_query($conexao, $sql);
    if ($res && $row = mysqli_fetch_assoc($res)) {
        $token = $row['ds_token'];

        // Opcional: Invalidar token via Facebook
        $url = "https://graph.facebook.com/v19.0/me/permissions?access_token=" . $token;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        // Você pode logar a resposta se quiser auditar:
        // file_put_contents('fb_logout_log.txt', $response);
    }

    // Remove o token do banco
    $sql = "DELETE FROM fb_tokens WHERE nr_seq_user = $userId";
    mysqli_query($conexao, $sql);
}

// Redireciona de volta para o dashboard
header("Location: https://conectasys.com/dashboard.php?form=facebook/index.php&id_menu=3&ds_men=Api%20Facebook&ds_mod=CRM&id_smenu=14");
exit;
?>
