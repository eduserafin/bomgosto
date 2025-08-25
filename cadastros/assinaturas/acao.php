<?php
foreach($_GET as $key => $value){
	$$key = $value;
}

session_start(); 
include "../../conexao.php";

//=======================		CARREGA DADOS NO FORMULARIO
if ($Tipo == "D") {
    $SQL = "SELECT * 
            FROM assinaturas 
            WHERE nr_sequencial=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] == $Codigo) {
        
        $valor_formatado = number_format($RS["vl_valor"], 2, ',', '.');
        echo "<script language='javascript'>window.parent.document.getElementById('cd_financeiro').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtempresa').value='" . $RS["nr_seq_empresa"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtquantidade').value='" . $RS["nr_quantidade"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtdatainicio').value='" . $RS["dt_inicio"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtdatafim').value='" . $RS["dt_fim"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtvalor').value='" . $valor_formatado . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtforma').value='" . $RS["tp_forma"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtstatus').value='" . $RS["st_status"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtcomentario').value='" . $RS["ds_observacoes"] . "';</script>";
        echo "<script language='javascript'>window.parent.usuarios('".$RS["nr_seq_empresa"]."', 'S', '".$RS["nr_quantidade"]."' );</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtempresa').focus();</script>";
    }
}

//=======================		INCLUSAO DOS DADOS
if ($Tipo == "I") {

    $SQL = "SELECT nr_sequencial 
          FROM assinaturas
          WHERE nr_seq_empresa = " . $empresa . "
          AND dt_inicio = '" . $datai . "'
          AND dt_fim = '" . $dataf . "'
          LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Assinatura já cadastrada para o período informado! Verifique.'
            });
        </script>";

    } else {

      $insert = "INSERT INTO assinaturas (nr_seq_empresa, dt_inicio, dt_fim, vl_valor, tp_forma, st_status, nr_quantidade, ds_observacoes) 
                  VALUES (" . $empresa . ", '" . $datai . "', '" . $dataf . "', " . $valor . ", '" . $forma . "', '" . $status . "', " . $quantidade . ", '" . $observacao . "')";
      $rss_insert = mysqli_query($conexao, $insert); //echo  $insert;

      // Valida se deu certo
      if ($rss_insert) {
          
        $nr_assinatura = mysqli_insert_id($conexao); 

        $usuarios = isset($_GET['usuario']) ? explode(',', $_GET['usuario']) : [];

        foreach ($usuarios as $usuario_id) {
           
            $insert1 = "INSERT INTO assinaturas_usuarios (nr_seq_assinatura, nr_seq_usuario) 
                        VALUES (" . $nr_assinatura . ", " . $usuario_id . ")";
            $rss_insert1 = mysqli_query($conexao, $insert1); //echo  $insert1;

        }

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Assinatura cadastrada com sucesso!'
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
            FROM assinaturas
            WHERE nr_seq_empresa = " . $empresa . "
            AND dt_inicio = '" . $datai . "'
            AND dt_fim = '" . $dataf . "'
            AND nr_sequencial <> " . $codigo . "  
            LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Assinatura já cadastrada! Verifique.'
            });
        </script>";

    } else {

      $update = "UPDATE assinaturas 
                  SET nr_seq_empresa = " . $empresa . ",
                      dt_inicio = '" . $datai . "',
                      dt_fim = '" . $dataf . "',
                      vl_valor = " . $valor . ",
                      tp_forma = '" . $forma . "',
                      st_status = '" . $status . "',
                      nr_quantidade = " . $quantidade . ",
                      ds_observacoes = '" . $observacao . "',
                      dt_cadastro = CURRENT_TIMESTAMP
                  WHERE nr_sequencial = " . $codigo;
      //echo"<pre> $update</pre>";
      $rss_update = mysqli_query($conexao, $update);

      // Valida se deu certo
      if ($rss_update) {
          
        $delete = "DELETE FROM assinaturas_usuarios WHERE nr_seq_assinatura=" . $codigo;
        $result = mysqli_query($conexao, $delete);
          
        $usuarios = isset($_GET['usuario']) ? explode(',', $_GET['usuario']) : [];

        foreach ($usuarios as $usuario_id) {
           
            $insert1 = "INSERT INTO assinaturas_usuarios (nr_seq_assinatura, nr_seq_usuario) 
                        VALUES (" . $codigo . ", " . $usuario_id . ")";
            $rss_insert1 = mysqli_query($conexao, $insert1); //echo  $insert1;

        }

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Assinatura alterada com sucesso!'
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
    
    $delete1 = "DELETE FROM assinaturas_usuarios WHERE nr_seq_assinatura=" . $codigo;
    $result1 = mysqli_query($conexao, $delete1);

    $delete2 = "DELETE FROM assinaturas WHERE nr_sequencial=" . $codigo;
    $result2 = mysqli_query($conexao, $delete2);

    if ($result2) {
    
      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Assinatura excluída com sucesso!'
              });
              window.parent.executafuncao('new');
              window.parent.consultar(0);
            </script>";

    } else {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Problemas ao excluir a Assinatura. Verifique!'
              });
            </script>";

    }
}
?>