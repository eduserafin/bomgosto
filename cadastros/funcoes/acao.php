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
		FROM tb_usuarios 
		WHERE idusuario=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["idusuario"] == $Codigo) {
        echo "<script language='javascript'>window.parent.document.getElementById('cd_user').value='" . $RS["idusuario"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').value='" . $RS["nome"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtlogin').value='" . $RS["login"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtemail').value='" . $RS["email"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtsenha').value='';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').focus();</script>";
    }
}
//=======================		INCLUSAO DOS DADOS
if ($Tipo == "I") {

  $SQL = "SELECT login 
              FROM tb_usuarios
             WHERE UPPER(login)=UPPER('" . $login . "') 
             LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
     if ($RS["login"] !='') {
        echo "<script language='JavaScript'>alert('Usuario ja cadastrado! Verifique.');</script>";
    } else {

        $insert = "INSERT INTO tb_usuarios (login, senha, nome, email) 
      VALUES (LOWER('" . $login . "'), '" . $senha . "', '" . $nome . "', '" . $email . "') ";
        $rss_insert = mysqli_query($conexao, $insert); //echo  $insert;

       $SQL1 = "SELECT idusuario
                     FROM tb_usuarios
                WHERE idusuario = (SELECT max(idusuario) FROM tb_usuarios)
                 AND UPPER(login)=UPPER('" . $login . "') ";     
               // echo $SQL1;
        $RSS1 = mysqli_query($conexao, $SQL1);
        while ($linha1 = mysqli_fetch_row($RSS1)) {
            $nr_usuario = $linha1[0];
        }

        if ($nr_usuario != '') {
            echo "<script language='JavaScript'>
                    alert('Usu\u00e1rio cadastrado com sucesso!');
                    window.parent.executafuncao('new');
                    window.parent.consultar(0);
                  </script>";
        } else {
            echo "<script language='JavaScript'>alert('Problemas ao gravar!');</script>";
        }
    }
}
//=======================		ALTERACAO DOS DADOS
if ($Tipo == "A") {

    $SQL = "SELECT login 
              FROM tb_usuarios
            WHERE UPPER(login)=UPPER('" . $login . "') 
            AND idusuario<>" . $codigo . "  
             LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
     if ($RS["login"] !='') {
        echo "<script language='JavaScript'>alert('Usuario ja cadastrado! Verifique.');</script>";
    } else {

        $update = "UPDATE tb_usuarios 
      SET nome=UPPER('" . $nome . "'), email='" . $email . "',
          login='" . $login . "', senha='". $senha ."'
      WHERE idusuario=" . $codigo;
        mysqli_query($conexao, $update);

        echo "<script language='JavaScript'>
                alert('Usu\u00e1rio alterado com sucesso!');
                window.parent.executafuncao('new');
                window.parent.consultar(0);
              </script>";
    }
}
?>