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
		FROM vendas 
		WHERE nr_sequencial=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] == $Codigo) {
        echo "<script language='javascript'>window.parent.document.getElementById('cd_venda').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtproduto').value='" . $RS["nr_seq_produto"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtquantidade').value='" . $RS["nr_quantidade"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtvalor').value='" . $RS["vl_venda"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtopcao').value='" . $RS["tp_pagamento"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').value='" . $RS["ds_cliente"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtproduto').focus();</script>";
    }
}
//=======================		INCLUSAO DOS DADOS
if ($Tipo == "I") {
 
        $insert = "INSERT INTO vendas (nr_seq_produto, vl_venda, nr_quantidade, tp_pagamento, ds_cliente, cd_usercadastro) 
            VALUES (" . $produto . ", " . $valor . ", " . $quantidade . ", '" . $pagamento . "', UPPER('" . $nome . "') , " . $_SESSION["CD_USUARIO"] . ") ";
        $rss_insert = mysqli_query($conexao, $insert);

            echo "<script language='JavaScript'>
                    alert('Venda cadastrada com sucesso!');
                    window.parent.executafuncao('new');
                    window.parent.consultar(0);
                  </script>";
        } 

//=======================		ALTERACAO DOS DADOS
if ($Tipo == "A") {
    
        $update = "UPDATE vendas
      SET nr_seq_produto=" . $produto . ", vl_venda=" . $valor . ", nr_quantidade=" . $quantidade . ", tp_pagamento='" . $pagamento . "', ds_cliente=UPPER('" . $nome . "') , cd_useralterado=" . $_SESSION["CD_USUARIO"] . ", dt_alterado=CURRENT_TIMESTAMP   
      WHERE nr_sequencial=" . $codigo;
        mysqli_query($conexao, $update);

        echo "<script language='JavaScript'>
                alert('Venda alterada com sucesso!');
                window.parent.executafuncao('new');
                window.parent.consultar(0);
              </script>";
    }

if ($Tipo == "E") {

 $update = "DELETE FROM vendas WHERE nr_sequencial=" . $codigo;
 mysqli_query($conexao, $update);

 echo "<script language='JavaScript'>
                alert('Venda excluida com sucesso');
                window.parent.executafuncao('new');
                window.parent.consultar(0);
              </script>";
}

?>