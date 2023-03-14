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
		FROM g_menus 
		WHERE nr_sequencial=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] == $Codigo) {
        echo "<script language='javascript'>window.parent.document.getElementById('cd_menu').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').value='" . $RS["ds_menu"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtlink').value='" . $RS["lk_menu"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txticone').value='" . $RS["ic_menu"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('tabgeral').click();</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').focus();</script>";
    }
}
//=======================		INCLUSAO DOS DADOS
if ($Tipo == "I") {

  $SQL = "SELECT ds_menu 
              FROM g_menus
             WHERE UPPER(ds_menu)=UPPER('" . $nome . "')
             LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
     if ($RS["ds_menu"] !='') {
        echo "<script language='JavaScript'>alert('Menu ja cadastrado! Verifique.');</script>";
    } else {

        $insert = "INSERT INTO g_menus (ds_menu, lk_menu, ic_menu, cd_usercadastro) 
      VALUES (UPPER('" . $nome . "'), '" . $link . "', '" . $icone . "', " . $_SESSION["CD_USUARIO"] . ") ";
      $rss_insert = mysqli_query($conexao, $insert);

       $SQL1 = "SELECT nr_sequencial
                     FROM g_menus
                WHERE nr_sequencial = (SELECT max(nr_sequencial) FROM g_menus)
                 AND UPPER(ds_menu)=UPPER('" . $nome . "')";       
               // echo $SQL1;
        $RSS1 = mysqli_query($conexao, $SQL1);
        while ($linha1 = mysqli_fetch_row($RSS1)) {
            $nr_menu = $linha1[0];
        }

        if ($nr_menu != '') {
            echo "<script language='JavaScript'>
                    alert('Menu cadastrado com sucesso!'); 
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


        $update = "UPDATE g_menus 
      SET ds_menu=UPPER('" . $nome . "'), lk_menu='" . $link . "', ic_menu='" . $icone . "', cd_useralterado=" . $_SESSION["CD_USUARIO"] . ", dt_alterado=CURRENT_TIMESTAMP 
      WHERE nr_sequencial=" . $codigo;
        mysqli_query($conexao, $update);

        echo "<script language='JavaScript'>
                alert('Menu alterado com sucesso!'); 
                window.parent.executafuncao('new');
                window.parent.consultar(0);
              </script>";
    }


//=======================		EXCLUS�O DOS DADOS
if ($Tipo == "E") {

  $SQL = "SELECT *
              FROM g_menus
             WHERE nr_seq_menu = " . $codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] >0) {
        echo "<script language='JavaScript'>alert('Menu ja cadastrado! Verifique.');</script>";
    } else {

        $delete = "DELETE FROM g_menus WHERE nr_sequencial=" . $codigo;
        mysqli_query($conexao, $delete);

        echo "<script language='JavaScript'>
                alert('Menu exclu\u00eddo com sucesso!'); 
                window.parent.executafuncao('new');
                window.parent.consultar(0);
              </script>";
    }
}
?>