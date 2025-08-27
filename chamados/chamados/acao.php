<?php
foreach($_GET as $key => $value){
	$$key = $value;
}

session_start(); 
include "../../conexao.php";

//=======================		CARREGA DADOS NO FORMULARIO
if ($Tipo == "D") {
    $SQL = "SELECT * 
            FROM chamados 
            WHERE nr_sequencial=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] == $Codigo) {
        echo "<script language='javascript'>window.parent.document.getElementById('cd_chamado').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtempresa').value='" . $RS["nr_seq_empresa"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtabertura').value='" . $RS["dt_abertura"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtfechamento').value='" . $RS["dt_fechamento"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtcategoria').value='" . $RS["st_categoria"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtprioridade').value='" . $RS["st_prioridade"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtstatus').value='" . $RS["st_status"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txttitulo').value='" . $RS["ds_titulo"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtdescricao').value='" . $RS["ds_descricao"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtempresa').focus();</script>";
    }
}

//=======================		INCLUSAO DOS DADOS
if ($Tipo == "I") {

    if($fechamento=="") { $fechamento = "NULL"; }
    else { $fechamento = "'$fechamento'"; } 

      $insert = "INSERT INTO chamados (nr_seq_empresa, dt_abertura, dt_fechamento, st_categoria, st_prioridade, st_status, ds_titulo, ds_descricao, nr_seq_usercadastro) 
                VALUES (" . $empresa . ", '" . $abertura . "', $fechamento, '" . $categoria . "', '" . $prioridade . "', '" . $status . "', '" . $titulo . "', '" . $descricao . "', " . $_SESSION["CD_USUARIO"] . ")";
      $rss_insert = mysqli_query($conexao, $insert); //echo  $insert;

      // Valida se deu certo
      if ($rss_insert) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Chamado cadastrado com sucesso!'
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

//=======================		ALTERACAO DOS DADOS
if ($Tipo == "A") {

  if($fechamento=="") { $fechamento = "NULL"; }
  else { $fechamento = "'$fechamento'"; } 

  $update = "UPDATE chamados 
              SET nr_seq_empresa = " . $empresa . ",
                  dt_abertura = '" . $abertura . "',
                  dt_fechamento = $fechamento,
                  st_categoria = '" . $categoria . "',
                  st_prioridade = '" . $prioridade . "',
                  st_status = '" . $status . "',
                  ds_titulo = '" . $titulo . "',
                  ds_descricao = '" . $descricao . "',
                  nr_seq_useralterado = " . $_SESSION["CD_USUARIO"] . "
              WHERE nr_sequencial = " . $codigo;
  //echo"<pre> $update</pre>";
  $rss_update = mysqli_query($conexao, $update);

  // Valida se deu certo
  if ($rss_update) {

    echo "<script language='JavaScript'>
            window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Chamado alterado com sucesso!'
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

//==================================-EXCLUSÃO DOS DADOS-===============================================

if ($Tipo == "E") {

    $delete = "DELETE FROM chamados WHERE nr_sequencial=" . $codigo;
    $result = mysqli_query($conexao, $delete);

    if ($result) {
    
      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Chamado excluído com sucesso!'
              });
              window.parent.executafuncao('new');
              window.parent.consultar(0);
            </script>";

    } else {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Problemas ao excluir o chamado. Verifique!'
              });
            </script>";

    }
}
?>