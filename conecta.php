<?php
session_start();


include "conexao.php";

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

$TxUsuario = str_replace("'","",$usuario);
$TxSenha = str_replace("'","",$senha);
	
$SQL = "select idusuario, nome, login, senha
	from tb_usuarios
	where login = '".$TxUsuario."' 
		and senha = '".$TxSenha."'
    and status = '1'"; //echo $SQL;

$RSS = mysqli_query($conexao, $SQL);
$RS = mysqli_fetch_array($RSS);

if(strtoupper($RS["login"]) == strtoupper($TxUsuario) && strtoupper($RS["senha"]) == strtoupper($TxSenha)){
	$_SESSION["CD_USUARIO"] = $RS["idusuario"];
	$_SESSION["DS_USUARIO"] = strtoupper($RS["login"]);
	$_SESSION["NM_USUARIO"] = strtoupper($RS["nome"]);
  
	echo "<script language='javascript'>window.open('dashboard.php', '_self');</script>";
} else {
	echo "<script language='javascript'>alert('Poss\u00edveis problemas para voc\u00ea n\u00e3o acessar o PROGRAMA: Usu\u00e1rio Inativo, Usu\u00e1rio n\u00e3o Cadastrado, Senha Incorreta. Contate a Administrador!');</script>";
	echo "<script language='javascript'>window.open('index.php', '_self');</script>";
}
?>
