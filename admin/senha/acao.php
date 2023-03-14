<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<?php
session_start(); 
include "../../conexao.php";
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php

//=======================		CARREGA DADOS NO FORMULARIO
if($Alterar == "OK"){
	$TxSenhaA = str_replace("'","",$TxSenhaA);
	$TxSenhaN = str_replace("'","",$TxSenhaN);
	
	$SQL = "SELECT COUNT(idusuario) AS nrusuario
		FROM tb_usuarios 
		WHERE idusuario=".$_SESSION["CD_USUARIO"]." 
			AND senha=md5('".$TxSenhaA."') 
		LIMIT 1";
	$RSS = mysqli_query($conexao, $SQL);
	$RS = mysqli_fetch_assoc($RSS);
	if($RS["nrusuario"] <= 0){
		echo "<script language='JavaScript'>alert('A Senha Atual informada nao confere. Tente Novamente!'); document.getElementById('txtsenhaa').focus();</script>";
	} else {
		$update = "UPDATE tb_usuarios 
			SET senha=md5('".$TxSenhaN."') 
			WHERE idusuario=".$_SESSION["CD_USUARIO"];
		
		mysqli_query($conexao, $update);
		echo "<script language='javascript'>alert('Senha alterada com sucesso!');</script>";
	}
}
?>
</body>
</html>