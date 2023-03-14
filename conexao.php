<?php
 // ini_set('display_errors', 1);
 // ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


//SE NENHUMA SESSÃO FOI INICIADA
if (session_id() == '') {
    session_start();
}
//=============== CONEXÃO LOCAL ======================================

$conexao = new mysqli("localhost", "root", "", "viveiro");

if($conexao -> connect_error) {

   echo "ERROR: " . $conexao->connect_error;

  }

//=============== CONEXÃO OFICIAL ======================================

//$conexao = new mysqli("localhost", "u496495623_viveiro", "Vs@135792", "u496495623_viveiro");

//if($conexao -> connect_error) {

  //echo "ERROR: " . $conexao->connect_error;
//}

?>
