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
		FROM produtos
		WHERE nr_sequencial=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] == $Codigo) {
        echo "<script language='javascript'>window.parent.document.getElementById('cd_produto').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtproduto').value='" . $RS["ds_produto"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtunidade').value='" . $RS["vl_unitario"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('ativo').value='" . $RS["ds_status"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtproduto').focus();</script>";
    }
}
//=======================		INCLUSAO DOS DADOS
if ($Tipo == "I") {

     $SQL = "SELECT nr_sequencial 
              FROM produtos
             WHERE UPPER(ds_produto)=UPPER('" . $produto . "') 
             LIMIT 1"; echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] >0) {
        echo "<script language='JavaScript'>alert('J\u00e1 tem um produto cadastrado com esse nome! Verifique.');</script>";
    } else {
 
        $insert = "INSERT INTO produtos (ds_produto, vl_unitario, ds_status, cd_usercadastro) 
      VALUES (UPPER('" . $produto . "'), " . $unitario . ", '" . $status . "', " . $_SESSION["CD_USUARIO"] . ") ";
       echo $insert;

       $rss_insert = mysqli_query($conexao, $insert);
  
       
       $SQL1 = "SELECT nr_sequencial
                     FROM produtos
                WHERE nr_sequencial = (SELECT max(nr_sequencial) FROM produtos)
                 AND UPPER(ds_produto)=UPPER('" . $produto . "')";       
               // echo $SQL1;
                $RSS1 = mysqli_query($conexao, $SQL1);
                while ($linha1 = mysqli_fetch_row($RSS1)) {
                    $nr_produto = $linha1[0];
                }
        

        if ($nr_produto != '') {
            echo "<script language='JavaScript'>
                    alert('Produto cadastrado com sucesso!');
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

    $SQL = "SELECT nr_sequencial 
              FROM produtos
             WHERE UPPER(ds_produto)=UPPER('" . $produto . "') 
             LIMIT 1"; echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] >0) {
        echo "<script language='JavaScript'>alert('J\u00e1 tem um produto cadastrado com esse nome! Verifique.');</script>";
    } else {
    
        $update = "UPDATE produtos
      SET ds_produto=UPPER('" . $produto . "'), vl_unitario=" . $unitario . ", ds_status='" . $status . "', cd_useralterado=" . $_SESSION["CD_USUARIO"] . ", dt_alterado=CURRENT_TIMESTAMP   
      WHERE nr_sequencial=" . $codigo;
        mysqli_query($conexao, $update);

        echo "<script language='JavaScript'>
                alert('Produto alterado com sucesso!');
                window.parent.executafuncao('new');
                window.parent.consultar(0);
              </script>";
    }
  }

if ($Tipo == "E") {

  $SQL = "SELECT COUNT(*)
              FROM vendas
             WHERE nr_seq_produto=" . $codigo;
$RSS = mysqli_query($conexao, $SQL);
while ($line = mysqli_fetch_row($RSS)) {$v_existe = $line[0];}

if ($v_existe > 0) {
 echo "<script language='JavaScript'>alert('Produto vinculado a uma venda! Verifique.');</script>";
}
 else {

 $update = "DELETE FROM produtos WHERE nr_sequencial=" . $codigo;
 mysqli_query($conexao, $update);

 echo "<script language='JavaScript'>
                alert('Produto excluido com sucesso');
                window.parent.executafuncao('new');
                window.parent.consultar(0);
              </script>";
}
}
?>