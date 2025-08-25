<?php

$Codigo = $_GET['Codigo'];
$Tipo = $_GET['Tipo'];
$codigo = $_GET['codigo'];
$administradora = $_GET['administradora'];
$grupo = $_GET['grupo'];
$cota = $_GET['cota'];
$credito = $_GET['credito'];
$entrada = $_GET['entrada'];
$prazo = $_GET['prazo'];
$parcela = $_GET['parcela'];
$nome = $_GET['nome'];
$status = $_GET['status'];

session_start(); 
include "../../conexao.php";

//=======================		CARREGA DADOS NO FORMULARIO
if ($Tipo == "D") {
    $SQL = "SELECT * 
            FROM cotas_contempladas 
            WHERE nr_sequencial=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] == $Codigo) {

        $valor_credito = number_format($RS["vl_credito"], 2, ',', '.');
        $valor_entrada = number_format($RS["vl_entrada"], 2, ',', '.');
        $valor_parcela = number_format($RS["vl_parcela"], 2, ',', '.');

        echo "<script language='javascript'>window.parent.document.getElementById('cd_cota').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('seladministradora').value='" . $RS["nr_seq_administradora"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtgrupo').value='" . $RS["ds_grupo"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtcota').value='" . $RS["nr_cota"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtvalor').value='" . $valor_credito . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtvalorentrada').value='" . $valor_entrada . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtprazo').value='" . $RS["nr_prazo"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtvalorparcela').value='" . $valor_parcela . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').value='" . $RS["ds_nome"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtstatus').value='" . $RS["st_status"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('seladministradora').focus();</script>";
    }
}

//=======================		INCLUSAO DOS DADOS
if ($Tipo == "I") {

    $SQL = "SELECT nr_sequencial 
            FROM cotas_contempladas
            WHERE nr_seq_administradora = $administradora
            AND ds_grupo = '$grupo'
            AND nr_cota = $cota
            LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Já existe um registro lançado para essa administradora, grupo e cota! Verifique.'
            });
        </script>";

    } else {

      $insert = "INSERT INTO cotas_contempladas (nr_seq_administradora, ds_grupo, nr_cota, vl_credito, vl_entrada, nr_prazo, vl_parcela, ds_nome, st_status, nr_seq_usercadastro, nr_seq_empresa) 
                VALUES (" . $administradora . ", '" . $grupo . "', " . $cota . ", " . $credito . ", " . $entrada . ", " . $prazo . ", " . $parcela . ", '" . $nome . "', '" . $status . "', " . $_SESSION["CD_USUARIO"] . ", " . $_SESSION["CD_EMPRESA"] . ")";
      $rss_insert = mysqli_query($conexao, $insert); echo  $insert;

      // Valida se deu certo
      if ($rss_insert) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Cota cadastrada com sucesso!'
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
            FROM cotas_contempladas
            WHERE nr_seq_administradora = $administradora
            AND ds_grupo = '$grupo'
            AND nr_cota = $cota
            AND nr_sequencial <> " . $codigo . "  
            LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Já existe um registro lançado para essa administradora, grupo e cota! Verifique.'
            });
        </script>";

    } else {

      $update = "UPDATE cotas_contempladas 
                SET nr_seq_administradora = " . $administradora . ", 
                    ds_grupo = '" . $grupo . "', 
                    nr_cota = " . $cota . ", 
                    vl_credito = " . $credito . ", 
                    vl_entrada = " . $entrada . ",
                    nr_prazo = " . $prazo . ", 
                    vl_parcela = " . $parcela . ", 
                    ds_nome = '" . $nome . "', 
                    st_status = '" . $status . "', 
                    nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . ",
                    nr_seq_useralterado = " . $_SESSION["CD_USUARIO"] . ",
                    dt_alterado = CURRENT_TIMESTAMP
                WHERE nr_sequencial = " . $codigo;
      echo"<pre> $update</pre>";
      $rss_update = mysqli_query($conexao, $update);

      if ($rss_update) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Cota alterada com sucesso!'
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

  $delete = "DELETE FROM cotas_contempladas WHERE nr_sequencial=" . $codigo;
  $result = mysqli_query($conexao, $delete);

  if ($result) {
  
    echo "<script language='JavaScript'>
            window.parent.Swal.fire({
              icon: 'success',
              title: 'Show...',
              text: 'Cota excluída com sucesso!'
            });
            window.parent.consultar(0);
          </script>";

  } else {

    echo "<script language='JavaScript'>
            window.parent.Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Problemas ao excluir. Verifique!'
            });
          </script>";

  }

}
?>