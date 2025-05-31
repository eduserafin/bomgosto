<?php

  foreach($_GET as $key => $value){
    $$key = $value;
  }

  session_start(); 
  include "../../conexao.php";

?>

<?php

  //=====================================-CARREGA DADOS NO FORMULARIO-=========================================

  if ($Tipo == "D") {

      $SQL = "SELECT * 
                FROM lead_site
              WHERE nr_sequencial=" . $Codigo;
      $RSS = mysqli_query($conexao, $SQL);
      $RS = mysqli_fetch_assoc($RSS);
      if ($RS["nr_sequencial"] == $Codigo) {
            echo "<script language='javascript'>window.parent.document.getElementById('cd_lead').value='" . $RS["nr_sequencial"] . "';</script>";
            echo "<script language='javascript'>window.parent.document.getElementById('txtnome').value='" . $RS["ds_nome"] . "';</script>";
            echo "<script language='javascript'>window.parent.document.getElementById('txtcontato').value='" . $RS["nr_telefone"] . "';</script>";
            echo "<script language='javascript'>window.parent.document.getElementById('txtmunicipio').value='" . $RS["nr_seq_cidade"] . "';</script>";
            echo "<script language='javascript'>window.parent.document.getElementById('txtvalor').value='" . $RS["vl_valor"] . "';</script>";
            echo "<script language='javascript'>window.parent.document.getElementById('txtsegmento').value='" . $RS["nr_seq_produto"] . "';</script>";
            echo "<script language='javascript'>window.parent.document.getElementById('txtemail').value='" . $RS["ds_email"] . "';</script>";
            echo "<script language='javascript'>window.parent.document.getElementById('txtnome').focus();</script>";
            echo "<script language='javascript'>window.parent.buscaComercial('".$RS["nr_sequencial"]."');</script>";
      }

  } 

  //=======================		INCLUSAO DOS DADOS
if ($Tipo == "I") {

    $SQL = "SELECT nr_sequencial 
          FROM lead_site
          WHERE UPPER(ds_nome)=UPPER('" . $nome . "') 
          AND vl_valor = $valor
          AND nr_seq_produto = $segmento
          LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Lead já cadastrada! Verifique.'
            });
        </script>";

    } else {

      $insert = "INSERT INTO lead_site (ds_nome, nr_telefone, nr_seq_cidade, vl_valor, nr_seq_produto, ds_email, nr_seq_usercadastro) 
                  VALUES (UPPER('" . $nome . "'), '" . $contato . "', " . $cidade . ", " . $valor . ", " . $segmento . ", '" . $email . "', " . $_SESSION["CD_USUARIO"] . ")";
      $rss_insert = mysqli_query($conexao, $insert); //echo  $insert;

      // Valida se deu certo
      if ($rss_insert) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Lead cadastrada com sucesso!'
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
            FROM lead_site
            WHERE UPPER(ds_nome)=UPPER('" . $nome . "') 
            AND vl_valor = $valor
            AND nr_seq_produto = $segmento
            AND nr_sequencial <> " . $codigo . "  
            LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Lead já cadastrada! Verifique.'
            });
        </script>";

    } else {

      $update = "UPDATE lead_site 
                    SET ds_nome = UPPER('" . $nome . "'), 
                        nr_telefone = '" . $contato . "',
                        nr_seq_cidade = " . $cidade . ",
                        vl_valor = " . $valor . ",
                        nr_seq_produto = " . $segmento . ",
                        ds_email = '" . $email . "',
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
                    text: 'Lead alterada com sucesso!'
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

    $delete = "DELETE FROM lead_site WHERE nr_sequencial=" . $codigo;
    $result = mysqli_query($conexao, $delete);

    if ($result) {
    
      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Lead excluído com sucesso!'
              });
              window.parent.executafuncao('new');
              window.parent.consultar(0);
            </script>";

    } else {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Problemas ao excluir a lead. Verifique!'
              });
            </script>";

    }


}

   //=====================================-ALTERA STATUS LEAD-=========================================

   if ($Tipo == "STATUS") {

      $update = "UPDATE lead_site SET st_situacao = '$status' WHERE nr_sequencial = $codigo";
      $rss_update = mysqli_query($conexao, $update);

      if ($rss_update) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Status alterado com sucesso!'
                });
                window.parent.buscaComercial($codigo);
                window.parent.consultar(0);
            </script>";

      } else {

          echo "<script language='JavaScript'>
                  window.parent.Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Problemas ao alterar o status!'
                  });
              </script>";

      }

   }

   //=====================================-ALTERA DATA AGENDA-=========================================

   if ($Tipo == "AGENDA") {

    if($data=="") { $data = "NULL"; }
    else { $data = "'$data'"; } 

    $update = "UPDATE lead_site SET dt_agenda = $data WHERE nr_sequencial = $codigo";
    $rss_update = mysqli_query($conexao, $update); 

    if ($rss_update) {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                  icon: 'success',
                  title: 'Show...',
                  text: 'Data alterada com sucesso!'
              });
              window.parent.buscaComercial($codigo);
              window.parent.consultar(0);
          </script>";

    } else {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Problemas ao alterar a data!'
                });
            </script>";

    }

 }

  //==================================-GRAVAR COMENTÁRIOS-======================================================

if($Tipo == 'enviaComentario'){

  $arquivo = '';
  $insert = "INSERT INTO lead_anexos (nr_seq_lead, ds_comentario, ds_arquivo, dt_cadastro, nr_seq_usercadastro)
          VALUES ($codigo, '$comentario', '$arquivo', NOW(), $_SESSION[CD_USUARIO])";
  echo $insert;
  $rss_insert = mysqli_query($conexao, $insert);

  if ($rss_insert) {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                  icon: 'success',
                  title: 'Show...',
                  text: 'Comentário gravado com sucesso!'
              });
              window.parent.buscaComercial($codigo);
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

//==================================-CARREGAR ANEXOS-======================================================

if($Tipo == 'enviarArquivo'){

   
  if(!$_FILES){
      response_json('400', array('message' => 'Nenhum arquivo enviado'));
  }

  include '../../inc/upload_helper.php';
  
  $values = [];
  foreach($_FILES as $file){
      $resultadoUpload = fileUpload($file, './arquivos/');
      if($resultadoUpload['error'] == true){
          continue;
      }

      $arquivo = $resultadoUpload['filename'];
  
      $values[] = "($codigo, '', '$arquivo', NOW(), $_SESSION[CD_USUARIO])";
  }

  $sql = "INSERT INTO lead_anexos (nr_seq_lead, ds_comentario, ds_arquivo, dt_cadastro, nr_seq_usercadastro)
      VALUES " . join(', ', $values);
  $rss =  mysqli_query($conexao, $sql);

  $response = [];
  $response['mensagem'] = sizeof($values) . " arquivos enviados";

  response_json('200', $resultadoUpload);

}


//==================================-EXCLUI ANEXOS-======================================================

elseif($Tipo == 'removerArquivo'){

  if(!isset($arquivo)){
      response_json('400', '');
  }

  if(unlink("./arquivos/$arquivo")){
      $sql = "DELETE FROM lead_anexos WHERE nr_sequencial = $nr_sequencial";
       mysqli_query($conexao, $sql);
      response_json('200', '');
  }else{
      response_json('500', array('message' => 'falha ao apagar o arquivo'));
  }
}

?>