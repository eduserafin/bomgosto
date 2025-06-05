<?php
foreach($_GET as $key => $value){
	$$key = $value;
}

session_start(); 
include "../../conexao.php";

//=======================		CARREGA DADOS NO FORMULARIO
if ($Tipo == "D") {
    $SQL = "SELECT * 
            FROM segmentos 
            WHERE nr_sequencial=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] == $Codigo) {
        echo "<script language='javascript'>window.parent.document.getElementById('cd_segmento').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').value='" . $RS["ds_segmento"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtstatus').value='" . $RS["st_status"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').focus();</script>";
    }
}

//=======================		INCLUSAO DOS DADOS
if ($Tipo == "I") {

    $segmento = mb_strtoupper($segmento, 'UTF-8');

    $SQL = "SELECT nr_sequencial 
          FROM segmentos
          WHERE ds_segmento = '" . $segmento . "' 
          AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "
          LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Segmento já cadastrado! Verifique.'
            });
        </script>";

    } else {

      $insert = "INSERT INTO segmentos (ds_segmento, st_status, nr_seq_usercadastro, nr_seq_empresa) 
                  VALUES ('" . $segmento . "', '" . $status . "', " . $_SESSION["CD_USUARIO"] . ", " . $_SESSION["CD_EMPRESA"] . ")";
      $rss_insert = mysqli_query($conexao, $insert); //echo  $insert;

      // Valida se deu certo
      if ($rss_insert) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Segmento cadastrado com sucesso!'
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

    $segmento = mb_strtoupper($segmento, 'UTF-8');

    $SQL = "SELECT nr_sequencial 
            FROM segmentos
            WHERE ds_segmento = '" . $segmento . "' 
            AND nr_sequencial <> " . $codigo . "  
            AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "
            LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Segmento já cadastrado! Verifique.'
            });
        </script>";

    } else {

      $update = "UPDATE segmentos 
                SET ds_segmento = '" . $segmento . "', 
                    st_status ='" . $status . "',
                    nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . ",
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
                    text: 'Segmento alterado com sucesso!'
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
          WHERE nr_seq_segmento = $codigo";
  $RSS = mysqli_query($conexao, $SQL);
  while ($line = mysqli_fetch_row($RSS)) {
    $v_existe = $line[0];
  }

  if ($v_existe > 0) {

    echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Não é possível excluir o registro, segmento está vinculado a outros cadastros!'
            });
        </script>";
        exit;

  } else {

    $delete = "DELETE FROM segmentos WHERE nr_sequencial=" . $codigo;
    $result = mysqli_query($conexao, $delete);

    if ($result) {
    
      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Segmento excluído com sucesso!'
              });
              window.parent.executafuncao('new');
              window.parent.consultar(0);
            </script>";

    } else {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Problemas ao excluir o segmento. Verifique!'
              });
            </script>";

    }

  }

}
?>