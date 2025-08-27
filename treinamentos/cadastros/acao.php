<?php
foreach($_GET as $key => $value){
	$$key = $value;
}

session_start(); 
include "../../conexao.php";

//=======================		CARREGA DADOS NO FORMULARIO
if ($Tipo == "D") {
    $SQL = "SELECT * 
            FROM treinamentos 
            WHERE nr_sequencial=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] == $Codigo) {

        $descricaoJS = json_encode($RS["ds_descricao"]);

        echo "<script language='javascript'>window.parent.document.getElementById('cd_treinamento').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtmenu').value='" . $RS["nr_seq_menu"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtsmenu').value='" . $RS["nr_seq_smenu"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtlink').value='" . $RS["ds_link"] . "';</script>";
        echo "<script>window.parent.document.getElementById('txtdescricao').value = $descricaoJS;</script>";
        echo "<script language='javascript'>window.parent.submenus('".$RS["nr_seq_menu"]."', '".$RS["nr_seq_smenu"]."' );</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtmenu').focus();</script>";
        
    }
}

//=======================		INCLUSAO DOS DADOS
if ($Tipo == "I") {

    $SQL = "SELECT nr_sequencial 
          FROM treinamentos
          WHERE nr_seq_menu = " . $menu . "
          AND nr_seq_smenu = " . $smenu . "
          LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Treinamento já cadastrado! Verifique.'
            });
        </script>";

    } else {

      $descricao = urldecode($descricao);

      $insert = "INSERT INTO treinamentos (nr_seq_menu, nr_seq_smenu, ds_link, ds_descricao) 
                VALUES (" . $menu . ", " . $smenu . ", '" . $link . "', '" . $descricao . "')";
      $rss_insert = mysqli_query($conexao, $insert); //echo  $insert;

      // Valida se deu certo
      if ($rss_insert) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Treinamento cadastrada com sucesso!'
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

    $SQL = "SELECT nr_sequencial 
            FROM treinamentos
            WHERE nr_seq_menu = " . $menu . "
            AND nr_seq_smenus = " . $smenu . "
            AND nr_sequencial <> " . $codigo . "  
            LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Treinamento já cadastrada! Verifique.'
            });
        </script>";

    } else {

      $descricao = urldecode($descricao);

      $update = "UPDATE treinamentos 
                  SET nr_seq_menu = " . $menu . ",
                      nr_seq_smenu = " . $smenu . ",
                      ds_link = '" . $link . "',
                      ds_descricao = '" . $descricao . "',
                      dt_cadastro = CURRENT_TIMESTAMP
                  WHERE nr_sequencial = " . $codigo;
      //echo"<pre> $update</pre>";
      $rss_update = mysqli_query($conexao, $update);

      // Valida se deu certo
      if ($rss_update) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Treinamento alterada com sucesso!'
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

//==================================-EXCLUSÃO DOS DADOS-===============================================

if ($Tipo == "E") {

    $delete = "DELETE FROM treinamentos WHERE nr_sequencial=" . $codigo;
    $result = mysqli_query($conexao, $delete);

    if ($result) {
    
      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Treinamento excluído com sucesso!'
              });
              window.parent.executafuncao('new');
              window.parent.consultar(0);
            </script>";

    } else {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Problemas ao excluir o treinamento. Verifique!'
              });
            </script>";

    }
}
?>