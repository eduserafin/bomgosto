<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<?php
session_start(); 
include "../../conexao.php";

// Envio de e-mail com PHPMailer
require '../../PHPMailer/PHPMailer.php';
require '../../PHPMailer/SMTP.php';
require '../../PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//=======================		CARREGA DADOS NO FORMULARIO

if ($Tipo == "D") {

    $SQL = "SELECT * 
		FROM usuarios 
		WHERE nr_sequencial=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] == $Codigo) {
        echo "<script language='javascript'>window.parent.document.getElementById('cd_user').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtempresa').value='" . $RS["nr_seq_empresa"] . "';</script>";
        echo "<script language='javascript'>window.parent.BuscarColaborador('".$RS["nr_seq_empresa"]."', '".$RS["nr_seq_colaborador"]."');</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtlogin').value='" . $RS["ds_login"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtemail').value='" . $RS["ds_email"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtadmin').value='" . $RS["st_admin"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtstatus').value='" . $RS["st_status"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtsenha').value='';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').focus();</script>";
    }
}

//=======================		INCLUSAO DOS DADOS

if ($Tipo == "I") {
    
    $ds_empresa = "";
    $SQLE = "SELECT ds_empresa 
            FROM empresas
            WHERE nr_sequencial = " . $empresa . "";
    $RSSE = mysqli_query($conexao, $SQLE);
    while($line=mysqli_fetch_row($RSSE)){
        $ds_empresa = $line[0];
    }

    $SQL = "SELECT ds_login 
            FROM usuarios
            WHERE UPPER(ds_login) = UPPER('" . $login . "')
            AND nr_seq_colaborador = " . $colaborador . "
            AND nr_seq_empresa = " . $empresa . "
            LIMIT 1";
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);

    if ($RS["ds_login"] != '') {

        echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Usuário já cadastrado! Verifique.'
            });
          </script>";
          exit;

    }  
    
    $quantidade = 0;
    $SQL0 = "SELECT COUNT(*) 
            FROM usuarios
            WHERE nr_seq_empresa = " . $empresa . "";
    $RSS0 = mysqli_query($conexao, $SQL0);
    while($lin0=mysqli_fetch_row($RSS0)){
        $quantidade = $lin0[0];
    }
    
    $SQL1 = "SELECT nr_quantidade 
            FROM assinaturas
            WHERE nr_seq_empresa = " . $empresa . "
            LIMIT 1";
    $RSS1 = mysqli_query($conexao, $SQL1);
    $RS1 = mysqli_fetch_assoc($RSS1);

   if ($quantidade >= $RS1["nr_quantidade"]) {

        echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Limite de usuarios atingido!.'
            });
          </script>";
        exit;

    } else {

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT); 

        $insert = "INSERT INTO usuarios (ds_login, ds_senha, nr_seq_colaborador, ds_email, st_admin, st_status, nr_seq_empresa) 
                  VALUES (LOWER('" . $login . "'), '" . $senha_hash . "', " . $colaborador . ", '" . $email . "', '" . $admin . "', '" . $status . "', " . $empresa . ") ";
        $rss_insert = mysqli_query($conexao, $insert);

        if ($rss_insert) {

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
                $mail->addAddress($email, $login);
                $mail->isHTML(true);
                $mail->Subject = 'Credenciais de acesso - ConectaSys';
                $mail->Body = "
                    <h3>Olá, {$login}!</h3>
                    <p>Seu usuário foi cadastrado com sucesso no sistema ConectaSys.</p>
                    <p><strong>Empresa:</strong> {$ds_empresa}<br>
                    <p><strong>Login:</strong> {$login}<br>
                    <strong>Senha:</strong> {$senha}</p>
                    <p>Acesse o sistema e altere sua senha no primeiro login.</p>
                    <p><a href='https://conectasys.com/' target='_blank'>Clique aqui para acessar o ConectaSys</a></p>
                    <br>
                    <p>Atenciosamente,<br>Equipe ConectaSys</p>
                ";

                $mail->send();

                echo "<script language='JavaScript'>
                    window.parent.Swal.fire({
                        icon: 'success',
                        title: 'Show...',
                        text: 'Usuário cadastrado com sucesso e e-mail enviado!'
                    });
                    window.parent.executafuncao('new');
                    window.parent.consultar(0);
                </script>";

            } catch (Exception $e) {
                echo "<script language='JavaScript'>
                    window.parent.Swal.fire({
                        icon: 'warning',
                        title: 'Usuário cadastrado',
                        text: 'Usuário cadastrado, mas houve problema ao enviar o e-mail!'
                    });
                    window.parent.executafuncao('new');
                    window.parent.consultar(0);
                </script>";
            }

        } else {

            echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Problemas ao gravar!'
                });
            </script>";

        }

    }

}


//=======================		ALTERACAO DOS DADOS

if ($Tipo == "A") {

    $SQL = "SELECT ds_login 
            FROM usuarios
            WHERE UPPER(ds_login) = UPPER('" . $login . "')
            AND nr_seq_colaborador = " . $colaborador . "
            AND nr_seq_empresa = " . $empresa . "
            AND nr_sequencial <>" . $codigo . "  
            LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
     if ($RS["ds_login"] !='') {
       
        echo "<script language='javascript'>
                window.parent.Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Usuario ja cadastrado! Verifique.'
                });
            </script>";

    } else {

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT); 
        
        if (!empty($senha)) {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $senha_sql = ", ds_senha = '" . $senha_hash . "'";
        } else {
            $senha_sql = "";
        }

        $update = "UPDATE usuarios 
                    SET nr_seq_colaborador = " . $colaborador . ", 
                        ds_email = '" . $email . "',
                        ds_login = '" . $login . "', 
                        st_admin = '". $admin ."',
                        st_status = '". $status ."',
                        nr_seq_empresa = " . $empresa . ",
                        dt_alterado = CURRENT_TIMESTAMP
                        $senha_sql
                    WHERE nr_sequencial=" . $codigo;
        $rss_update = mysqli_query($conexao, $update);

        if ($rss_update) {
    
            echo "<script language='JavaScript'>
                    window.parent.Swal.fire({
                        icon: 'success',
                        title: 'Show...',
                        text: 'Usuario alterado com sucesso!'
                    });
                    window.parent.executafuncao('new');
                    window.parent.consultar(0);
                </script>";
    
        } else {
    
            echo "<script language='JavaScript'>
                    window.parent.Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Problemas ao gravar!'
                    });
                </script>";
    
        }

    }

}
?>