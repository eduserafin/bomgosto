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
                FROM consorcio_prazo_grupo
              WHERE nr_sequencial=" . $Codigo;
      $RSS = mysqli_query($conexao, $SQL);
      $RS = mysqli_fetch_assoc($RSS);

      if ($RS["nr_sequencial"] == $Codigo) {

        echo "<script language='javascript'>window.parent.document.getElementById('cd_grupo').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtprazo').value='" . $RS["nr_quantidade"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('ativo').value='" . $RS["st_status"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtprazo').focus();</script>";
      
      }

  }

  //==========================================-INCLUSAO DOS DADOS-========================================

  if ($Tipo == "I") {

    $insert = "INSERT INTO configuracao_site (ds_nome, ds_secao1, ds_secao2, ds_secao3, ds_secao4, ds_secao5, ds_subsecao1, ds_subsecao2, ds_subsecao3, ds_subsecao4, ds_subsecao5, nr_produtos, nr_campanhas, ds_titulo, ds_descricao, ds_facebook, ds_instagran, ds_linkedin, st_ativo) 
              VALUES ('" . $nome . "', '" . $secao1 . "',  '" . $secao2 . "', '" . $secao3 . "', '" . $secao4 . "', '" . $secao5 . "', '" . $secao4 . "', '" . $subsecao1 . "', '" . $subsecao2 . "', '" . $subsecao3 . "', '" . $subsecao4 . "', '" . $subsecao5 . "', '" . $qtdprodutos . "', '" . $qtdcampanhas . "', '" . $titulo . "', '" . $sobre . "', '" . $facebook . "', '" . $instagran . "', '" . $linkedin . "', '" . $status . "')";
    //echo $insert;
    $rss_insert = mysqli_query($conexao, $insert);

    if ($rss_insert) {
      // Registro gravado com sucesso
      $configuracao = mysqli_insert_id($conexao);

      $del = "DELETE FROM produtos_site WHERE nr_seq_configuracao = $configuracao";
      mysqli_query($conexao, $del);
  
      $campo = array();
      $dados = array();
      $campo = explode("|", $produtos);
  
      for($i=0;$i<$qtdprodutos;$i++){

          $dados = explode(";", $campo[$i]);
          $produto = $dados[0];
          $icone = $dados[1];
          $descricao = $dados[2];
  
          $insert_produto = "INSERT INTO produtos_site (nr_seq_configuracao, nr_ordem, ds_produto, ds_icone, ds_descricao) 
                            VALUES (" . $configuracao . ", " . $i . ",  '" . $produto . "', '" . $icone . "', '" . $descricao . "')";
          //echo $insert_produto;
          $rss_insert_produto = mysqli_query($conexao, $insert_produto);
      }

      $del = "DELETE FROM campanhas_site WHERE nr_seq_configuracao = $configuracao";
      mysqli_query($conexao, $del);
  
      $campo1 = array();
      $dados1 = array();
      $campo1 = explode("|", $campanhas);
  
      for($i=0;$i<$qtdcampanhas;$i++){

          $dados1 = explode(";", $campo1[$i]);
          $campanha = $dados1[0];
          $icone = $dados1[1];
  
          $insert_campanha = "INSERT INTO campanhas_site (nr_seq_configuracao, nr_ordem, ds_campanha, ds_icone) 
                            VALUES (" . $configuracao . ", " . $i . ",  '" . $campanha . "', '" . $icone . "')";
          //echo $insert_campanha;
          $rss_insert_campanha = mysqli_query($conexao, $insert_campanha);
      }

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Prazo cadastrado com sucesso!'
              }); 
              window.parent.executafuncao('new');
              window.parent.consultar(0);  
            </script>";


    } else {

      // Erro ao gravar o registro
      echo "Erro ao gravar o registro: " . mysqli_error($conexao);

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Problemas ao gravar!'
              });
            </script>";

      }
    
  }

  //==================================-ALTERACAO DOS DADOS-===============================================

  if ($Tipo == "A") {
    
      $update = "UPDATE consorcio_prazo_grupo
                    SET nr_quantidade=" . $prazo . ",
                        st_status='" . $status . "', 
                        cd_useralterado=" . $_SESSION["CD_USUARIO"] . ", 
                        dt_alterado=CURRENT_TIMESTAMP   
                  WHERE nr_sequencial=" . $codigo;
        mysqli_query($conexao, $update);

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                  icon: 'success',
                  title: 'Show...',
                  text: 'Prazo alterado com sucesso!'
                }); 
                window.parent.executafuncao('new');
                window.parent.consultar(0);  
              </script>";
    }


  //==================================-EXCLUSÃO DOS DADOS-===============================================

  if ($Tipo == "E") {

    $v_existe = 0;
    $SQL = "SELECT nr_sequencial  
              FROM consorcio_propostas 
            WHERE nr_seq_prazo=".$codigo;
    $RSS = mysqli_query($conexao, $SQL);
    while ($line = mysqli_fetch_row($RSS)) {$v_existe = $line[0];}

    if ($v_existe > 0) {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Prazo vinculado a uma proposta! Verifique.'
              });
            </script>";

	  } else {

      $update = "DELETE FROM consorcio_prazo_grupo WHERE nr_sequencial=" . $codigo;
      mysqli_query($conexao, $update);
      
      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Prazo excluído com sucesso!'
              });
              window.parent.executafuncao('new');
              window.parent.consultar(0);
            </script>";
    }

  }

?>