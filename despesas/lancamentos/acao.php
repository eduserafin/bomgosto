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
		FROM despesas  
		WHERE nr_sequencial=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] == $Codigo) {
        echo "<script language='javascript'>window.parent.document.getElementById('cd_despesa').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtdespesa').value='" . $RS["ds_descricao"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtdata').value='" . $RS["dt_despesa"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtvalor').value='" . $RS["vl_despesa"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtdespesa').focus();</script>";
    }
}
//=======================		INCLUSAO DOS DADOS
if ($Tipo == "I") {
 
        $insert = "INSERT INTO despesas (ds_descricao, vl_despesa, dt_despesa, cd_usercadastro) 
      VALUES (UPPER('" . $despesa . "'), " . $valor . ", '" . $data . "', ". $_SESSION["CD_USUARIO"] . ") ";
      $rss_insert = mysqli_query($conexao, $insert);

      $SQL1 = "SELECT nr_sequencial
                     FROM despesas
                WHERE nr_sequencial = (SELECT max(nr_sequencial) FROM despesas)
                 AND UPPER(ds_descricao)=UPPER('" . $despesa . "')";       
               // echo $SQL1;
        $RSS1 = mysqli_query($conexao, $SQL1);
        while ($linha1 = mysqli_fetch_row($RSS1)) {
            $nr_despesa = $linha1[0];
        }
        
        if ($nr_despesa != '') {
            echo "<script language='JavaScript'>
                    alert('Despesa cadastrada com sucesso!');
                    window.parent.executafuncao('new');
                    window.parent.consultar(0);
                  </script>";
        } else {
            echo "<script language='JavaScript'>alert('Problemas ao gravar!');</script>";
        }
    }

//=======================		ALTERACAO DOS DADOS
if ($Tipo == "A") {
    
        $update = "UPDATE despesas
      SET ds_descricao=UPPER('" . $despesa . "'), vl_despesa=" . $valor . ", dt_despesa='" . $data . "', cd_useralterado=" . $_SESSION["CD_USUARIO"] . ", dt_alterado=CURRENT_TIMESTAMP   
     WHERE nr_sequencial=" . $codigo;
        mysqli_query($conexao, $update); echo  $update;

        echo "<script language='JavaScript'>
                alert('Despesa alterada com sucesso!');
                window.parent.executafuncao('new');
                window.parent.consultar(0);
              </script>";
    }

if ($Tipo == "E") {

 $update = "DELETE FROM despesas WHERE nr_sequencial=" . $codigo;
 mysqli_query($conexao, $update);

 echo "<script language='JavaScript'>
                alert('Despesa excluida com sucesso');
                window.parent.executafuncao('new');
                window.parent.consultar(0);
              </script>";
}

?>