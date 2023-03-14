<?php
foreach($_GET as $key => $value){
	$$key = $value;
}

session_start(); 
include "../conexao.php";
//=======================		CARREGA DADOS NO FORMULARIO
if ($Tipo == "D") {
    $SQL = "SELECT * 
		FROM  controle_equipamentos
		WHERE nr_sequencial=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] == $Codigo) {
        echo "<script language='javascript'>window.parent.document.getElementById('cd_equipamento').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtequipamento').value='" . $RS["nr_seq_equipamento"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtquantidade').value='" . $RS["nr_quantidade"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').value='" . $RS["ds_cliente"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtequipamento').focus();</script>";
    }
}
//=======================		INCLUSÃO DOS DADOS
if ($Tipo == "I") {
 
        $st_devolvido = 'N';
        $insert = "INSERT INTO controle_equipamentos (nr_seq_equipamento, nr_quantidade, ds_cliente, st_devolvido, cd_usercadastro) 
            VALUES (" . $equipamento . ", " . $quantidade . ", UPPER('" . $nome . "'), '" . $st_devolvido . "', " . $_SESSION["CD_USUARIO"] . ") ";
        $rss_insert = mysqli_query($conexao, $insert); //echo  $insert;

            echo "<script language='JavaScript'>
                    alert('Registro cadastrada com sucesso!');
                    window.parent.executafuncao('new');
                    window.parent.consultar(0);
                  </script>";
        } 

//=======================		ALTERACÃO DOS DADOS
if ($Tipo == "A") {
    
        $update = "UPDATE controle_equipamentos
      SET nr_seq_equipamento=" . $equipamento . ", nr_quantidade=" . $quantidade . ", ds_cliente=UPPER('" . $nome . "') , cd_useralterado=" . $_SESSION["CD_USUARIO"] . ", dt_alterado=CURRENT_TIMESTAMP   
      WHERE nr_sequencial=" . $codigo; //echo $update;
        mysqli_query($conexao, $update);

        echo "<script language='JavaScript'>
                alert('Registro alterado com sucesso!');
                window.parent.executafuncao('new');
                window.parent.consultar(0);
              </script>";
    }
//=======================		ATUALIZA STATUS DE DEVOLUÇÃO DO EQUIPAMENTO 
if ($Tipo == "S") {
    
  $st_devolvido = 'S';
  $update = "UPDATE controle_equipamentos
SET st_devolvido='" . $st_devolvido . "', cd_useralterado=" . $_SESSION["CD_USUARIO"] . ", dt_devolvido=CURRENT_TIMESTAMP   
WHERE nr_sequencial=" . $Codigo; echo $update;
  mysqli_query($conexao, $update);

  echo "<script language='JavaScript'>
          alert('Equipamento devolvido com sucesso!');
          window.parent.executafuncao('new');
          window.parent.consultar(0);
        </script>";
}



//=======================		EXCLUSÃO DE DADOS
if ($Tipo == "E") {

 $update = "DELETE FROM controle_equipamentos WHERE nr_sequencial=" . $codigo;
 mysqli_query($conexao, $update);

 echo "<script language='JavaScript'>
                alert('Registro excluida com sucesso');
                window.parent.executafuncao('new');
                window.parent.consultar(0);
              </script>";
}

?>