<?php

require 'conexao.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conexao->real_escape_string($_POST['email']);

    // Buscar usuário pelo e-mail
    $sql = "SELECT nr_sequencial FROM usuarios WHERE ds_email = '$email'";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        $token = bin2hex(random_bytes(32));
        $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Atualizar token e expiração
        $sql_update = "UPDATE usuarios SET ds_token = '$token', dt_token = '$expira' WHERE nr_sequencial = " . $usuario['nr_sequencial'];
        $conexao->query($sql_update);

        $link = "https://seusite.com/resetar_senha.php?token=$token";

        // Enviar e-mail com PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'luiz-serafin@hotmail.com';
            $mail->Password = '@E135792e@';
            $mail->SMTPSecure = 'tls'; 
            $mail->Port = 587; 
        
            $mail->setFrom('luiz-serafin@hotmail.com', 'Csimulador');
            $mail->addAddress($email); // usa o e-mail informado
        
            $mail->isHTML(true);
            $mail->Subject = 'Recuperação de Senha';
            $mail->Body    = "Clique no link para redefinir sua senha: <a href='$link'>Redefinir Senha</a>";
        
            $mail->send();
            echo 'E-mail enviado com sucesso!';
        } catch (Exception $e) {
            echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
        }

    } else {
        echo "E-mail não encontrado.";
    }
}
?>

