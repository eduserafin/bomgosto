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
                FROM lead
              WHERE nr_sequencial=" . $Codigo;
      $RSS = mysqli_query($conexao, $SQL);
      $RS = mysqli_fetch_assoc($RSS);
      if ($RS["nr_sequencial"] == $Codigo) {

        $valor_formatado = number_format($RS["vl_valor"], 2, ',', '.');
        echo "<script language='javascript'>window.parent.document.getElementById('cd_lead').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').value='" . $RS["ds_nome"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtcontato').value='" . $RS["nr_telefone"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtmunicipio').value='" . $RS["nr_seq_cidade"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtvalor').value='" . $valor_formatado . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtsegmento').value='" . $RS["nr_seq_segmento"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtemail').value='" . $RS["ds_email"] . "';</script>";
        echo "<script language='javascript'>window.parent.buscaComercial('".$RS["nr_sequencial"]."');</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').focus();</script>";
      
      }

  } 

  //=======================		INCLUSAO DOS DADOS
if ($Tipo == "I") {

    $nome = mb_strtoupper($nome, 'UTF-8');

    $SQL = "SELECT nr_sequencial 
          FROM lead
          WHERE ds_nome = '" . $nome . "' 
          AND vl_valor = " . $valor . "
          AND nr_seq_segmento = " . $segmento . "
          AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "
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

      $insert = "INSERT INTO lead (ds_nome, nr_telefone, nr_seq_cidade, vl_valor, nr_seq_segmento, ds_email, nr_seq_usercadastro, nr_seq_empresa) 
                  VALUES (UPPER('" . $nome . "'), '" . $contato . "', " . $cidade . ", " . $valor . ", " . $segmento . ", '" . $email . "', " . $_SESSION["CD_USUARIO"] . ", " . $_SESSION["CD_EMPRESA"] . ")";
      $rss_insert = mysqli_query($conexao, $insert); echo  $insert;

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

    $nome = mb_strtoupper($nome, 'UTF-8');

    $SQL = "SELECT nr_sequencial 
            FROM lead
            WHERE ds_nome = '" . $nome . "' 
            AND vl_valor = " . $valor . "
            AND nr_seq_segmento = " . $segmento . "
            AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "
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

      $update = "UPDATE lead 
                    SET ds_nome = '" . $nome . "', 
                        nr_telefone = '" . $contato . "',
                        nr_seq_cidade = " . $cidade . ",
                        vl_valor = " . $valor . ",
                        nr_seq_segmento = " . $segmento . ",
                        ds_email = '" . $email . "',
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

    $delete = "DELETE FROM lead WHERE nr_sequencial=" . $codigo;
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

      $update = "UPDATE lead SET nr_seq_situacao = $status WHERE nr_sequencial = $codigo";
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

    //=====================================-ALTERA VALOR CONTRATADO LEAD-=========================================

    if ($Tipo == "CONTRATAR") {

      if($percentual == "") { $percentual = "NULL"; }
      $status = 1; //Altera o status para CONTRATADO

      $update = "UPDATE lead 
                  SET nr_seq_situacao = " . $status . ",
                      ds_grupo = '" . $grupo . "', 
                      nr_seq_administradora = " . $administratadora . ",
                      nr_cota = " . $cota . ",
                      pc_reduzido = " . $percentual . ",
                      vl_contratado = " . $valorcontratado . ",
                      vl_considerado = " . $valorfinal . ",
                      nr_seq_useralterado = " . $_SESSION["CD_USUARIO"] . ",
                      dt_alterado = CURRENT_TIMESTAMP, 
                      dt_contratada = CURRENT_TIMESTAMP
                WHERE nr_sequencial = " . $codigo;
      //echo"<pre> $update</pre>";
      $rss_update = mysqli_query($conexao, $update);

      if ($rss_update) {

        $delete = "DELETE FROM pagamentos WHERE nr_seq_lead=" . $codigo;
        $result = mysqli_query($conexao, $delete);

        $mes_atual = date('m');
        $ano_atual = date('Y');

        //BUSCA O CÓDIGO DO COLABORADOR
        $nr_seq_colaborador = "";
        $SQLU = "SELECT nr_seq_colaborador
                FROM usuarios
                WHERE nr_sequencial = " . $_SESSION["CD_USUARIO"] . "";
        //echo "<pre>$SQLU</pre>";
        $RSSU = mysqli_query($conexao, $SQLU);
        while ($linhau = mysqli_fetch_row($RSSU)) {
            $nr_seq_colaborador = $linhau[0];
        }

        $SQLC = "SELECT pc.nr_parcela, pc.vl_comissao
                FROM parcelas_comissoes pc
                INNER JOIN comissoes c ON c.nr_sequencial = pc.nr_seq_comissao
                WHERE c.nr_seq_colaborador = $nr_seq_colaborador
                AND c.nr_seq_administradora = $administratadora
                ORDER BY pc.nr_parcela ASC";
        //echo "<pre>$SQLC</pre>";
        $RSSC = mysqli_query($conexao, $SQLC);
        while ($linhac = mysqli_fetch_row($RSSC)) {
            $nr_parcela = $linhac[0];
            $vl_comissao = $linhac[1];

            //calcula o valor da parcela
            $vl_parcela = ($vl_comissao / 100) * $valorfinal;

             // Calcula o mês e ano da parcela
            $data_parcela = new DateTime();
            $data_parcela->setDate($ano_atual, $mes_atual, 10); // sempre dia 10 do mês atual
            $data_parcela->modify("+".($nr_parcela)." months");

            $dt_parcela = $data_parcela->format("Y-m-d"); // formato para salvar no banco

            $insert = "INSERT INTO pagamentos (nr_seq_lead, nr_parcela, vl_comissao, vl_parcela, dt_parcela) 
                        VALUES (" . $codigo . ", " . $nr_parcela . ", " . $vl_comissao . ", " . $vl_parcela . ", '" . $dt_parcela . "')";
            $rss_insert = mysqli_query($conexao, $insert); //echo $insert;

        }

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Gravado com sucesso!'
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

   //=====================================-ALTERA DATA AGENDA-=========================================

   if ($Tipo == "AGENDA") {

    if($data=="") { $data = "NULL"; }
    else { $data = "'$data'"; } 

    $update = "UPDATE lead SET dt_agenda = $data WHERE nr_sequencial = $codigo";
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
  $insert = "INSERT INTO anexos_lead (nr_seq_lead, ds_comentario, ds_arquivo, dt_cadastro)
          VALUES ($codigo, '$comentario', '$arquivo', NOW())";
  //echo $insert;
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
  
      $values[] = "($codigo, '', '$arquivo', NOW())";
  }

  $sql = "INSERT INTO anexos_lead (nr_seq_lead, ds_comentario, ds_arquivo, dt_cadastro)
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
      $sql = "DELETE FROM anexos_lead WHERE nr_sequencial = $nr_sequencial";
       mysqli_query($conexao, $sql);
      response_json('200', '');
  }else{
      response_json('500', array('message' => 'falha ao apagar o arquivo'));
  }
}

?>