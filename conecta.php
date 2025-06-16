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

	$SQL = "SELECT u.nr_sequencial, u.nr_seq_empresa, c.ds_colaborador, u.ds_login, u.ds_senha, u.st_admin
			FROM usuarios u
			INNER JOIN colaboradores c ON c.nr_sequencial = u.nr_seq_colaborador
			INNER JOIN empresas e ON e.nr_sequencial = u.nr_seq_empresa
			WHERE u.ds_login = '$TxUsuario'
			AND UPPER(e.ds_empresa) = UPPER('$TxEmpresa')
			AND u.st_status = 'A'";

	$RSS = mysqli_query($conexao, $SQL);
	$RS = mysqli_fetch_array($RSS);

	if ($RS) {
		// Verifica a senha digitada com o hash do banco
		if (password_verify($TxSenha, $RS["ds_senha"])) {
			$_SESSION["CD_USUARIO"] = $RS["nr_sequencial"];
			$_SESSION["DS_USUARIO"] = strtoupper($RS["ds_login"]);
			$_SESSION["NM_USUARIO"] = strtoupper($RS["ds_colaborador"]);
			$_SESSION["ST_ADMIN"] = strtoupper($RS["st_admin"]);
			$_SESSION["CD_EMPRESA"] = strtoupper($RS["nr_seq_empresa"]);

			echo "<script language='javascript'>window.open('dashboard.php', '_self');</script>";
			exit;
		}
	}

	// Caso não autenticado
	echo "<script language='javascript'>alert('Possíveis problemas para você não acessar o SISTEMA: Usuário Inativo, Usuário não Cadastrado, Senha Incorreta. Contate o Administrador!');</script>";
	echo "<script language='javascript'>window.open('index.php', '_self');</script>";

?>
