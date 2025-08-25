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
		FROM submenus 
		WHERE nr_sequencial=".$Codigo;
	$RSS = mysqli_query($conexao, $SQL);
	$RS = mysqli_fetch_assoc($RSS);
	if($RS["nr_sequencial"] == $Codigo){
		echo "<script language='javascript'>
            window.parent.document.getElementById('cd_smenu').value='".$RS["nr_sequencial"]."';
            window.parent.document.getElementById('menu').value='".$RS["nr_seq_menu"]."';
            window.parent.document.getElementById('txtnome').value='".$RS["ds_smenu"]."';
            window.parent.document.getElementById('txtlink').value='".$RS["lk_smenu"]."';
            window.parent.document.getElementById('modulo').value='".$RS["tp_smenu"]."';
            window.parent.document.getElementById('txticone').value='".$RS["ic_smenu"]."';
            window.parent.document.getElementById('perfil').value='".$RS["tp_perfil"]."';
            window.parent.document.getElementById('menu').focus();
          </script>";
	}

}

//=======================		INCLUSAO DOS DADOS

if ($Tipo == "I"){

	$SQL = "SELECT ds_smenu 
          FROM submenus
          WHERE UPPER(ds_smenu)=UPPER('" . $nome . "')
          AND tp_smenu=".$modulo." 
          AND nr_seq_menu=".$menu."  
          LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["ds_smenu"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Sub Menu já cadastrado! Verifique.'
            });
          </script>";
  
    } else {

      $insert = "INSERT INTO submenus (ds_smenu, lk_smenu, ic_smenu, nr_seq_menu, nr_seq_usercadastro, tp_smenu, tp_perfil) 
                VALUES ('".$nome."', '".$link."', '".$icone."', ".$menu.", ".$_SESSION["CD_USUARIO"].", ".$modulo.", '$perfil')";
      $rss_insert = mysqli_query($conexao, $insert);
      
      if ($rss_insert) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Sub Menu cadastro com sucesso!'
                });
                window.parent.executafuncao('new');
                window.parent.consultar(0);
            </script>";

      } else {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Problemas ao gravar!'
                });
            </script>";
      }

  }

}

//=======================		ALTERACAO DOS DADOS

if ($Tipo == "A"){

    $SQL = "SELECT ds_smenu 
            FROM submenus
            WHERE UPPER(ds_smenu)=UPPER('" . $nome . "')
            AND tp_smenu=".$modulo." 
            AND nr_seq_menu=".$menu." 
            AND nr_sequencial <> " . $codigo . "   
            LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["ds_smenu"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Sub Menu já cadastrado! Verifique.'
            });
          </script>";
  
    } else {
	
      $update = "UPDATE submenus 
                  SET ds_smenu='".$nome."', 
                      lk_smenu='".$link."', 
                      ic_smenu='".$icone."', 
                      nr_seq_menu=".$menu.", 
                      nr_seq_useralterado=".$_SESSION["CD_USUARIO"].", 
                      dt_alterado=CURRENT_TIMESTAMP, 
                      tp_smenu=".$modulo.",
                      tp_perfil='$perfil'
                  WHERE nr_sequencial=".$codigo;
      $rss_update = mysqli_query($conexao, $update);

      if ($rss_update) {
  
        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Sub Menu alterado com sucesso!'
                });
                window.parent.executafuncao('new');
                window.parent.consultar(0);
            </script>";
  
      } else {
  
        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Problemas ao gravar!'
                });
              </script>";
  
      }

  }

}

//=======================		ALTERACAO DOS DADOS

if ($Tipo == "E"){

  $SQL = "SELECT *
          FROM menus_user
          WHERE nr_seq_smenu=".$codigo;
  $RSS = mysqli_query($conexao, $SQL);
  $RS = mysqli_fetch_assoc($RSS);
  if ($RS["nr_sequencial"] >0) {

    echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Sub-menu está liberado para usuarios! Verifique.'
            });
          </script>";

  } else {

    $delete = "DELETE FROM submenus WHERE nr_sequencial=".$codigo;
	  $rss_delete = mysqli_query($conexao, $delete);

    if ($rss_delete) {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Sub Menu excluído com sucesso!'
              });
              window.parent.executafuncao('new');
              window.parent.consultar(0);
            </script>";

    } else {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Problemas ao excluir o Sub Menu. Verifique!'
              });
            </script>";

    }

  }

}
?>