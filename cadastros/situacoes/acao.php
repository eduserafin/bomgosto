<?php
foreach($_GET as $key => $value){
	$$key = $value;
}

session_start(); 
include "../../conexao.php";

//=======================		CARREGA DADOS NO FORMULARIO
if ($Tipo == "D") {
    $SQL = "SELECT * 
            FROM situacoes 
            WHERE nr_sequencial=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] == $Codigo) {
        echo "<script language='javascript'>window.parent.document.getElementById('cd_situacao').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').value='" . $RS["ds_situacao"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtstatus').value='" . $RS["st_status"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').focus();</script>";
    }
}

//=======================		INCLUSAO DOS DADOS
if ($Tipo == "I") {

    $situacao = mb_strtoupper($situacao, 'UTF-8');

    $SQL = "SELECT nr_sequencial 
          FROM situacoes
          WHERE ds_situacao = '" . $situacao . "'
          LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Situação já cadastrada! Verifique.'
            });
        </script>";

    } else {

      $insert = "INSERT INTO situacoes (ds_situacao, st_status, nr_seq_usercadastro) 
                  VALUES ('" . $situacao . "', '" . $status . "', " . $_SESSION["CD_USUARIO"] . ")";
      $rss_insert = mysqli_query($conexao, $insert); //echo  $insert;

      // Valida se deu certo
      if ($rss_insert) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Situação cadastrada com sucesso!'
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

    $situacao = mb_strtoupper($situacao, 'UTF-8');

    $SQL = "SELECT nr_sequencial 
            FROM situacoes
            WHERE ds_situacao = '" . $situacao . "'
            AND nr_sequencial <> " . $codigo . "  
            LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Situação já cadastrada! Verifique.'
            });
        </script>";

    } else {

      $update = "UPDATE situacoes 
                SET ds_situacao = '" . $situacao . "', 
                    st_status ='" . $status . "',
                    nr_seq_useralterado = " . $_SESSION["CD_USUARIO"] . ",
                    dt_alterado = CURRENT_TIMESTAMP
                WHERE nr_sequencial = " . $codigo;
      //echo"<pre> $update</pre>";
      $rss_update = mysqli_query($conexao, $update);

      // Valida se deu certo
      if ($rss_update) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Situação alterada com sucesso!'
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

  $v_existe = 0;
  $SQL = "SELECT COUNT(*)  
          FROM lead
          WHERE nr_seq_situacao = $codigo";
  $RSS = mysqli_query($conexao, $SQL);
  while ($line = mysqli_fetch_row($RSS)) {
    $v_existe = $line[0];
  }

  if ($v_existe > 0) {

    echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Não é possível excluir o registro, Situação está vinculado a outros cadastros!'
            });
        </script>";
        exit;

  } else {

    $delete = "DELETE FROM situacoes WHERE nr_sequencial=" . $codigo;
    $result = mysqli_query($conexao, $delete);

    if ($result) {
    
      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Situação excluída com sucesso!'
              });
              window.parent.executafuncao('new');
              window.parent.consultar(0);
            </script>";

    } else {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Problemas ao excluir a Situação. Verifique!'
              });
            </script>";

    }

  }

}
?>