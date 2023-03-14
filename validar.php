<?php
if (session_id() == '') {
    session_start();
}

if(!isset($_SESSION['CD_USUARIO'])){
	echo "<meta http-equiv=refresh content='0;url=index.php'>";
	exit;
}
   /*
include "conexao.php";

$sql = "select nr_sequencial, ds_usuario, ds_senha  
	from g_usuarios 
	where LOWER(ds_usuario)=LOWER('".$_SESSION["DS_USUARIO"]."') 
		and LOWER(ds_senha)=LOWER('".$_SESSION["SN_USUARIO"]."')";

$busca = pg_query($conexao, $sql);

if(pg_num_rows($busca) == 0){
  echo "<meta http-equiv=refresh content='0;url=http://ginfo.i9ss.com.br'>";
  session_destroy();	
}    */
?>