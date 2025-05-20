<?php
	session_start();

	include "conexao.php";

	if (strtoupper($_POST['nomeempresa']) != "") {
		$_SESSION["ALIAS_EMPRESA"] = strtoupper($_POST['nomeempresa']);
	} else {
		$_SESSION["ALIAS_EMPRESA"] = ALIAS_EMPRESA;
	}

	$usuario = $_POST['usuario'];
	$senha = $_POST['senha'];
	$nomeempresa = $_POST['nomeempresa'];

	$TxUsuario = str_replace("'", "", pg_escape_string($usuario));
	$TxSenha = str_replace("'", "", pg_escape_string($senha));
	$TxEmpresa = str_replace("'", "", pg_escape_string($nomeempresa));
		
	$SQL = "SELECT idusuario, nome, login, senha, admin
			FROM tb_usuarios
			WHERE login = '".$TxUsuario."' 
			AND senha = '".$TxSenha."'
			AND UPPER(empresa) = UPPER('$TxEmpresa')
			AND status = '1'"; //echo $SQL;

	$RSS = mysqli_query($conexao, $SQL);
	$RS = mysqli_fetch_array($RSS);

	if(strtoupper($RS["login"]) == strtoupper($TxUsuario) && strtoupper($RS["senha"]) == strtoupper($TxSenha)){
		$_SESSION["CD_USUARIO"] = $RS["idusuario"];
		$_SESSION["DS_USUARIO"] = strtoupper($RS["login"]);
		$_SESSION["NM_USUARIO"] = strtoupper($RS["nome"]);
		$_SESSION["ST_ADMIN"] = strtoupper($RS["admin"]);
	
		echo "<script language='javascript'>window.open('dashboard.php', '_self');</script>";
	} else {
		echo "<script language='javascript'>alert('Poss\u00edveis problemas para voc\u00ea n\u00e3o acessar o PROGRAMA: Usu\u00e1rio Inativo, Usu\u00e1rio n\u00e3o Cadastrado, Senha Incorreta. Contate a Administrador!');</script>";
		echo "<script language='javascript'>window.open('index.php', '_self');</script>";
	}
?>
