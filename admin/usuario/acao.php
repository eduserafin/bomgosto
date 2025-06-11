<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<?php
session_start(); 
include "../../conexao.php";

//=======================		CARREGA DADOS NO FORMULARIO

if ($Tipo == "D") {

    $SQL = "SELECT * 
		FROM usuarios 
		WHERE nr_sequencial=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] == $Codigo) {
        echo "<script language='javascript'>window.parent.document.getElementById('cd_user').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').value='" . $RS["nr_seq_colaborador"] . "';</script>";
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

  $SQL = "SELECT ds_login 
          FROM usuarios
          WHERE UPPER(ds_login) = UPPER('" . $login . "') 
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

        $insert = "INSERT INTO usuarios (ds_login, ds_senha, nr_seq_colaborador, ds_email, st_admin, st_status, nr_seq_empresa) 
                  VALUES (LOWER('" . $login . "'), '" . $senha . "', " . $colaborador . ", '" . $email . "', '" . $admin . "', '" . $status . "', " . $_SESSION["CD_EMPRESA"] . ") ";
        $rss_insert = mysqli_query($conexao, $insert); //echo  $insert;

        if ($rss_insert) {

            echo "<script language='JavaScript'>
                    window.parent.Swal.fire({
                        icon: 'success',
                        title: 'Show...',
                        text: 'Usuario cadastro com sucesso!'
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

//=======================		ALTERACAO DOS DADOS

if ($Tipo == "A") {

    $SQL = "SELECT ds_login 
            FROM usuarios
            WHERE UPPER(ds_login) = UPPER('" . $login . "') 
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

        $update = "UPDATE usuarios 
                    SET nr_seq_colaborador = " . $colaborador . ", 
                        ds_email = '" . $email . "',
                        ds_login = '" . $login . "', 
                        ds_senha = '". $senha ."',
                        st_admin = '". $admin ."',
                        st_status = '". $status ."',
                        nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . ",
                        dt_alterado = CURRENT_TIMESTAMP
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