<?php

  foreach($_GET as $key => $value){
    $$key = $value;
  }

  session_start(); 
  include "../conexao.php";

?>

<?php

  
  //==========================================-CADASTRAR LEAD-========================================

  if ($Tipo == "SL") {

    if($produto == ""){ $produto = "NULL"; }
    if($valor == ""){ $valor = "NULL"; }
    else {$valor = str_replace([",", "."], "", $valor);}

    $insert = "INSERT INTO lead_site (tp_tipo, ds_nome, ds_email, nr_telefone, nr_whatsapp, nr_seq_cidade, ds_mensagem, nr_seq_produto, vl_valor, st_situacao) 
              VALUES ('" . $tipo . "', '" . $nome . "',  '" . $email . "', '" . $telefone . "', '" . $whatsapp . "', " . $cidade . ", '" . $mensagem . "', " . $produto . ", " . $valor . ", 'P')";
    echo $insert;
    $rss_insert = mysqli_query($conexao, $insert);

    if ($rss_insert) {
      // Registro gravado com sucesso

      if($modal == 'S' or $tipo == 'S'){
        
        echo "<script language='JavaScript'>
                alert('Informações gravadas com sucesso! Sua proposta esta sendo gerada e embreve retornaremos seu contato.');   
            </script>";

        if($modal == 'S'){
          echo "<script language='JavaScript'>
                  window.parent.fecharModalSimulador(); 
                </script>";
        } else {
          echo "<script language='JavaScript'>
                  window.parent.recarregarPagina();    
              </script>";
        }

      } else {

        echo "<script language='JavaScript'>
                alert('Informações gravadas com sucesso, em breve retornaremos o contato!');
                window.parent.recarregarPagina();  
              </script>";

      }

    } else {

      echo "<script language='JavaScript'>
        alert('Problemas ao gravar informações, tente novamente!');
      </script>";

    }
    
  }

  //==========================================-CADASTRAR EMAIL-========================================

  if ($Tipo == "EMAIL") {

    $v_existe = 0;
    $SQL = "SELECT COUNT(nr_sequencial)
              FROM emails
            WHERE ds_email = '$email'";
    $RSS = mysqli_query($conexao, $SQL);
    while($linha = mysqli_fetch_row($RSS)){
      $v_existe = $linha[0];
    }

    if($v_existe == 0) {

      $insert = "INSERT INTO emails (ds_email) 
                VALUES ('" . $email . "')";
      //echo $insert;
      $rss_insert = mysqli_query($conexao, $insert);

      if ($rss_insert) {

        echo "<script language='JavaScript'>
                alert('E-mail cadastrado com sucesso!');
              </script>";


      } else {

        echo "<script language='JavaScript'>
          alert('Problemas ao gravar, tente novamente!');
        </script>";

      }

    } else {

      echo "<script language='JavaScript'>
              alert('E-mail já cadastrado!');
            </script>";
    }
    
  }

 ?>