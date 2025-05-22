<?php
foreach($_GET as $key => $value){
	$$key = $value;
}

session_start(); 
include "../../conexao.php";

//=======================		CARREGA DADOS NO FORMULARIO
if ($Tipo == "D") {
    $SQL = "SELECT * 
            FROM funcoes 
            WHERE nr_sequencial=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] == $Codigo) {
        echo "<script language='javascript'>window.parent.document.getElementById('cd_funcao').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtfuncao').value='" . $RS["ds_funcao"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtstatus').value='" . $RS["st_status"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtfuncao').focus();</script>";
    }
}

//=======================		INCLUSAO DOS DADOS
if ($Tipo == "I") {

    $SQL = "SELECT nr_sequencial 
          FROM funcoes
          WHERE UPPER(ds_funcao)=UPPER('" . $funcao . "') 
          LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Função já cadastrada! Verifique.'
            });
        </script>";

    } else {

      $insert = "INSERT INTO funcoes (ds_funcao, st_status, cd_usercadastro) 
                  VALUES (UPPER('" . $funcao . "'), '" . $status . "', " . $_SESSION["CD_USUARIO"] . ")";
      $rss_insert = mysqli_query($conexao, $insert); //echo  $insert;

      // Valida se deu certo
      if ($rss_insert) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Função cadastrada com sucesso!'
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
            FROM funcoes
            WHERE UPPER(ds_funcao)=UPPER('" . $funcao . "')
            AND nr_sequencial <> " . $codigo . "  
            LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Função já cadastrada! Verifique.'
            });
        </script>";

    } else {

      $update = "UPDATE funcoes 
                SET ds_funcao = UPPER('" . $funcao . "'), 
                    st_status ='" . $status . "',
                    cd_useralterado = " . $_SESSION["CD_USUARIO"] . ",
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
                    text: 'Função alterada com sucesso!'
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
          FROM colaboradores 
          WHERE nr_seq_funcao = $codigo";
  $RSS = mysqli_query($conexao, $SQL);
  while ($line = mysqli_fetch_row($RSS)) {
    $v_existe = $line[0];
  }

  if ($v_existe > 0) {

    echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Não é possível excluir o registro, função está vinculada a um colaborador!'
            });
        </script>";
        exit;

  } else {

    $delete = "DELETE FROM funcoes WHERE nr_sequencial=" . $codigo;
    $result = mysqli_query($conexao, $delete);

    if ($result) {
    
      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Função excluída com sucesso!'
              });
              window.parent.executafuncao('new');
              window.parent.consultar(0);
            </script>";

    } else {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Problemas ao excluir a função. Verifique!'
              });
            </script>";

    }

  }

}
?>