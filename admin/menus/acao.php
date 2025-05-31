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
		FROM menus 
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
              FROM menus
             WHERE UPPER(ds_menu)=UPPER('" . $nome . "')
             LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
     if ($RS["ds_menu"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Menu já cadastrado! Verifique.'
            });
        </script>";

    } else {

        $insert = "INSERT INTO menus (ds_menu, lk_menu, ic_menu, nr_seq_usercadastro) 
      VALUES (UPPER('" . $nome . "'), '" . $link . "', '" . $icone . "', " . $_SESSION["CD_USUARIO"] . ") ";
      $rss_insert = mysqli_query($conexao, $insert);

      if ($rss_insert) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Menu cadastro com sucesso!'
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

if ($Tipo == "A") {

  $SQL = "SELECT ds_menu 
          FROM menus
          WHERE UPPER(ds_menu)=UPPER('" . $nome . "')
          AND nr_sequencial <> " . $codigo . "  
          LIMIT 1"; //echo  $SQL;
  $RSS = mysqli_query($conexao, $SQL);
  $RS = mysqli_fetch_assoc($RSS);
  if ($RS["ds_menu"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Menu já cadastrado! Verifique.'
            });
          </script>";

  } else {

    $update = "UPDATE menus 
                SET ds_menu=UPPER('" . $nome . "'), 
                    lk_menu='" . $link . "', 
                    ic_menu='" . $icone . "', 
                    nr_seq_useralterado=" . $_SESSION["CD_USUARIO"] . ", 
                    dt_alterado=CURRENT_TIMESTAMP 
                WHERE nr_sequencial=" . $codigo;
    $rss_update = mysqli_query($conexao, $update);

    if ($rss_update) {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                  icon: 'success',
                  title: 'Show...',
                  text: 'Menu alterado com sucesso!'
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

//=======================		EXCLUS�O DOS DADOS

if ($Tipo == "E") {

  $SQL = "SELECT *
          FROM submenus
          WHERE nr_seq_menu = " . $codigo;
  $RSS = mysqli_query($conexao, $SQL);
  $RS = mysqli_fetch_assoc($RSS);
  if ($RS["nr_sequencial"] >0) {

    echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Não é possível excluir o registro, Menu está vinculado a um Submenu! Verifique.'
            });
          </script>";

  } else {

    $delete = "DELETE FROM menus WHERE nr_sequencial=" . $codigo;
    $rss_delete = mysqli_query($conexao, $delete);

    if ($rss_delete) {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Menu excluído com sucesso!'
              });
              window.parent.executafuncao('new');
              window.parent.consultar(0);
            </script>";

    } else {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Problemas ao excluir o Menu. Verifique!'
              });
            </script>";

    }

  }

}
?>