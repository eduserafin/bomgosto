<?php
header('Content-Type: application/json');

require 'conexao.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$response = [
    'status' => 'error',
    'title' => 'Erro',
    'message' => 'Algo deu errado.',
    'redirect' => null
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['email'])) {
        $response = [
            'status' => 'warning',
            'title' => 'E-mail vazio!',
            'message' => 'Por favor, informe um e-mail válido.',
            'redirect' => null
        ];
        echo json_encode($response);
        exit;
    }

    $email = $conexao->real_escape_string($_POST['email']);

    $sql = "SELECT nr_sequencial FROM usuarios WHERE ds_email = '$email'";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        $token = bin2hex(random_bytes(32));
        $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $sql_update = "UPDATE usuarios SET ds_token = '$token', dt_token = '$expira' WHERE nr_sequencial = " . $usuario['nr_sequencial'];
        $conexao->query($sql_update);

        $link = "https://conectasys.com/resetar.php?token=$token";

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'contato@conectasys.com';
            $mail->Password = '@E135792e@';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';
            $mail->setFrom('contato@conectasys.com', 'ConectaSys');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Recuperação de Senha - ConectaSys';
            $mail->Body = "
                <p>Olá,</p>
                <p>Recebemos uma solicitação para redefinir sua senha.</p>
                <p>Clique no link abaixo para criar uma nova senha. O link é válido por 1 hora.</p>
                <p><a href='$link'>Redefinir minha senha</a></p>
                <p>Se você não solicitou esta alteração, por favor ignore este e-mail.</p>
                <br>
                <p>Atenciosamente,<br>Equipe ConectaSys</p>
            ";
            
            $mail->AltBody = "Olá,\n\nRecebemos uma solicitação para redefinir sua senha.\n\nUse o link abaixo para criar uma nova senha (válido por 1 hora):\n$link\n\nSe você não solicitou esta alteração, por favor ignore este e-mail.\n\nAtenciosamente,\nEquipe ConectaSys";

            $mail->send();

            $response = [
                'status' => 'success',
                'title' => 'E-mail enviado!',
                'message' => 'Verifique sua caixa de entrada.',
                'redirect' => 'index.php'
            ];
        } catch (Exception $e) {
            $response = [
                'status' => 'error',
                'title' => 'Erro ao enviar e-mail',
                'message' => $mail->ErrorInfo,
                'redirect' => null
            ];
        }
    } else {
        $response = [
            'status' => 'warning',
            'title' => 'E-mail não encontrado!',
            'message' => 'Verifique o e-mail informado.',
            'redirect' => null
        ];
    }
} else {
    $response = [
        'status' => 'error',
        'title' => 'Método inválido',
        'message' => 'Requisição deve ser POST.',
        'redirect' => null
    ];
}

echo json_encode($response);
exit;
