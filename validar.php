<?php
if (session_id() == '') {
    session_start();
}

if(!isset($_SESSION['CD_USUARIO'])){
	echo "<meta http-equiv=refresh content='0;url=index.php'>";
	exit;
}

?>