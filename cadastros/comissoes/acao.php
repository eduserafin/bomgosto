<?php
foreach($_GET as $key => $value){
	$$key = $value;
}

session_start(); 
include "../../conexao.php";

//=======================		CARREGA DADOS NO FORMULARIO
if ($Tipo == "D") {
    $SQL = "SELECT * 
            FROM comissoes 
            WHERE nr_sequencial=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] == $Codigo) {
        echo "<script language='javascript'>window.parent.document.getElementById('cd_parametro').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('selcolaborador').value='" . $RS["nr_seq_colaborador"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtcomissao').value='" . $RS["vl_comissao"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtparcelas').value='" . $RS["nr_parcelas"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('seladministradora').value='" . $RS["nr_seq_administradora"] . "';</script>";
        echo "<script language='javascript'>window.parent.BuscarComissao('".$RS["nr_parcelas"]."', '".$RS["nr_sequencial"]."');</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').focus();</script>";
    }
}

//=======================		INCLUSAO DOS DADOS
if ($Tipo == "I") {

    $SQL = "SELECT nr_sequencial 
            FROM comissoes
            WHERE nr_seq_administradora = $administradora
            AND nr_seq_colaborador = $colaborador
            LIMIT 1"; echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Comissões já cadastradas para esse colaborador e administradora! Verifique.'
            });
        </script>";

    } else {

      $comissao = floatval(str_replace(',', '.', $_GET['comissao']));
     
      $insert = "INSERT INTO comissoes (nr_seq_colaborador, nr_seq_administradora, vl_comissao, nr_parcelas) 
                  VALUES (" . $colaborador . ", " . $administradora . ", " . $comissao . ", " . $parcelas . ")";
      $rss_insert = mysqli_query($conexao, $insert); //echo  $insert;

      // Valida se deu certo
      if ($rss_insert) {

        $nr_comissao = mysqli_insert_id($conexao); 

        $comissoesParcelas = explode(',', $_GET['comissoes']);
        $comissoesParcelas = array_map(function($v) {
            return str_replace(',', '.', $v);
        }, $comissoesParcelas);

        foreach ($comissoesParcelas as $indice => $valor) {
            $parcela = $indice + 1;

            $insert = "INSERT INTO parcelas_comissoes (nr_seq_comissao, nr_parcela, vl_comissao) 
                        VALUES (" . $nr_comissao . ", " . $parcela . ", " . $valor . ")";
            $rss_insert = mysqli_query($conexao, $insert); //echo  $insert;

        }

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Commissões cadastradas com sucesso!'
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
            FROM comissoes
            WHERE nr_seq_administradora = $administradora
            AND nr_seq_colaborador = $colaborador
            AND nr_sequencial <> " . $codigo . "  
            LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Comissões já cadastradas para esse colaborador e administradora! Verifique.'
            });
        </script>";

    } else {

      $comissao = floatval(str_replace(',', '.', $_GET['comissao']));

      $update = "UPDATE comissoes 
                SET nr_seq_colaborador = " . $colaborador . ", 
                    nr_seq_administradora = " . $administradora . ", 
                    nr_parcelas = " . $parcelas . ", 
                    vl_comissao = " . $comissao . ", 
                    nr_seq_useralterado = " . $_SESSION["CD_USUARIO"] . ",
                    dt_alterado = CURRENT_TIMESTAMP
                WHERE nr_sequencial = " . $codigo;
      //echo"<pre> $update</pre>";
      $rss_update = mysqli_query($conexao, $update);

      if ($rss_update) {

        $delete = "DELETE FROM parcelas_comissoes WHERE nr_seq_comissao=" . $codigo;
        $result = mysqli_query($conexao, $delete);

        $comissoesParcelas = explode(',', $_GET['comissoes']);
        $comissoesParcelas = array_map(function($v) {
            return str_replace(',', '.', $v);
        }, $comissoesParcelas);

        foreach ($comissoesParcelas as $indice => $valor) {
            $parcela = $indice + 1;

            $insert = "INSERT INTO parcelas_comissoes (nr_seq_comissao, nr_parcela, vl_comissao) 
                        VALUES (" . $codigo . ", " . $parcela . ", " . $valor . ")";
            $rss_insert = mysqli_query($conexao, $insert); //echo  $insert;

        }

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Commissões alteradas com sucesso!'
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

  $delete1 = "DELETE FROM parcelas_comissoes WHERE nr_seq_comissao=" . $codigo;
  $result1 = mysqli_query($conexao, $delete1);

  $delete2 = "DELETE FROM comissoes WHERE nr_sequencial=" . $codigo;
  $result2 = mysqli_query($conexao, $delete2);

  if ($result2) {
  
    echo "<script language='JavaScript'>
            window.parent.Swal.fire({
              icon: 'success',
              title: 'Show...',
              text: 'Comissões excluídas com sucesso!'
            });
            window.parent.executafuncao('new');
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