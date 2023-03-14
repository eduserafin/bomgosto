<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<?php
session_start(); 
include "../../conexao.php";
//=======================		CARREGA DADOS NO FORMULARIO
if ($Tipo == "D"){
	$SQL = "SELECT * 
		FROM g_smenus 
		WHERE nr_sequencial=".$Codigo;
	$RSS = mysqli_query($conexao, $SQL);
	$RS = mysqli_fetch_assoc($RSS);
	if($RS["nr_sequencial"] == $Codigo){
		echo "<script language='javascript'>
            window.parent.document.getElementById('cd_smenu').value='".$RS["nr_sequencial"]."';
            window.parent.document.getElementById('menu').value='".$RS["nr_seq_menu"]."';
            window.parent.document.getElementById('txtnome').value='".$RS["ds_smenu"]."';
            window.parent.document.getElementById('txtlink').value='".$RS["lk_smenu"]."';
            window.parent.document.getElementById('modulo').value='".$RS["tipo_menu"]."';
            window.parent.document.getElementById('txticone').value='".$RS["ic_smenu"]."';
            window.parent.document.getElementById('menu').focus();
          </script>";
	}
}
//=======================		INCLUSAO DOS DADOS
if ($Tipo == "I"){

	$SQL = "SELECT ds_smenu 
             	 FROM g_smenus
             WHERE UPPER(ds_smenu)=UPPER('" . $nome . "')
             AND tipo_menu=".$modulo." 
			AND nr_seq_menu=".$menu."  
			LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["ds_smenu"] !='') {
        echo "<script language='JavaScript'>alert('Sub Menu ja cadastrado! Verifique.');</script>";
    } else {

    $insert = "INSERT INTO g_smenus (ds_smenu, lk_smenu, ic_smenu, nr_seq_menu, cd_usercadastro, tipo_menu) 
      VALUES ('".$nome."', '".$link."', '".$icone."', ".$menu.", ".$_SESSION["CD_USUARIO"].", ".$modulo.")";
	$rss_insert = mysqli_query($conexao, $insert);
		
	 $SQL1 = "SELECT nr_sequencial
                     FROM g_smenus
                WHERE nr_sequencial = (SELECT max(nr_sequencial) FROM g_smenus)
                 AND UPPER(ds_smenu)=UPPER('" . $nome . "')";       
               // echo $SQL1;
        $RSS1 = mysqli_query($conexao, $SQL1);
        while ($linha1 = mysqli_fetch_row($RSS1)) {
            $nr_smenu = $linha1[0];
        }
		
		if($nr_smenu!=''){
			echo "<script language='JavaScript'>
              alert('Sub Menu gravado com sucesso!');
              window.parent.executafuncao('new');
              window.parent.consultar(0);
            </script>";
		} else {
			echo "<script language='JavaScript'>alert('Problemas ao gravar registro!');</script>";
		}
  }
}
//=======================		ALTERACAO DOS DADOS
if ($Tipo == "A"){
	

    $update = "UPDATE g_smenus 
      SET ds_smenu='".$nome."', 
          lk_smenu='".$link."', 
          ic_smenu='".$icone."', 
          nr_seq_menu=".$menu.", 
          cd_useralterado=".$_SESSION["CD_USUARIO"].", 
          dt_alterado=CURRENT_TIMESTAMP, 
          tipo_menu=".$modulo." 
      WHERE nr_sequencial=".$codigo;
		mysqli_query($conexao, $update);
		
		echo "<script language='JavaScript'>
            alert('Sub Menu alterado com sucesso!');
            window.parent.executafuncao('new');
            window.parent.consultar(0);
          </script>";
  }

//=======================		ALTERACAO DOS DADOS
if ($Tipo == "E"){

$SQL = "SELECT *
			FROM g_smenu_user
         WHERE nr_seq_smenu=".$codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] >0) {
        echo "<script language='JavaScript'>alert('Sub-menu est\u00e1 liberado para usu\u00e1rios! Verifique.');</script>";
    } else {

    $delete = "DELETE FROM g_smenus WHERE nr_sequencial=".$codigo;
		mysqli_query($conexao, $delete);
		
		echo "<script language='JavaScript'>
            alert('Sub Menu exclu\u00eddo com sucesso!');
            window.parent.executafuncao('new');
            window.parent.consultar(0);
          </script>";
  }
}
?>