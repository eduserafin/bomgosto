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
                FROM consorcio_propostas
              WHERE nr_sequencial=" . $Codigo;
      $RSS = mysqli_query($conexao, $SQL);
      $RS = mysqli_fetch_assoc($RSS);

      if ($RS["nr_sequencial"] == $Codigo) {

        echo "<script language='javascript'>window.parent.document.getElementById('cd_proposta').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').value='" . $RS["ds_nome"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtcredito').value='" . $RS["vl_credito"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('selmes').value='" . $RS["nr_seq_mes"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('selprazo').value='" . $RS["nr_seq_prazo"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txttaxa').value='" . $RS["pc_taxa"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('selplano').value='" . $RS["nr_seq_plano"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtseguro').value='" . $RS["pc_seguro"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtlance').value='" . $RS["pc_embutido"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtconvertidadas').value='" . $RS["nr_convertidas"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtreduzida').value='" . $RS["nr_seq_reduzida"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txttipo').value='" . $RS["nr_seq_tipo"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtcotas').value='" . $RS["nr_cotas"] . "';</script>";
        echo "<script language='javascript'>window.parent.parcelas('" . $RS["nr_seq_plano"] . "');</script>";
        echo "<script language='javascript'>window.parent.cotas('" . $RS["nr_cotas"] . "', '" . $RS["vl_parcela1"] . "', '" . $RS["vl_parcela2"] . "');</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').focus();</script>";
      
      }

  }

  //==========================================-INCLUSAO DOS DADOS-========================================

  if ($Tipo == "I") {
  
      if($parcela2 == "" or $parcela2 == 0) {$parcela2 = "NULL";}

        $insert = "INSERT INTO consorcio_propostas (ds_nome, vl_credito, nr_cotas, nr_seq_mes, nr_seq_prazo, pc_taxa, nr_seq_plano, pc_seguro, vl_parcela1, vl_parcela2, pc_embutido, nr_convertidas, nr_seq_reduzida, nr_seq_tipo, cd_usercadastro) 
                    VALUES (UPPER('" . $nome . "'), " . $credito . ", " . $cotas . ", " . $mes . ", " . $prazo . ", " . $taxa . ", " . $plano . ", " . $seguro . ", " . $parcela1 . ", " . $parcela2 . ", " . $lance . ", " . $convertidada . ", " . $reduzida . ", " . $tipo . ", " . $_SESSION["CD_USUARIO"] . ") ";
        //echo $insert;
        $rss_insert = mysqli_query($conexao, $insert);
    
        $SQL1 = "SELECT nr_sequencial
                    FROM consorcio_propostas
                  WHERE nr_sequencial = (SELECT max(nr_sequencial) FROM consorcio_propostas)
                  AND UPPER(ds_nome)=UPPER('" . $nome . "')";       
        //echo $SQL1;
        $RSS1 = mysqli_query($conexao, $SQL1);
        while ($linha1 = mysqli_fetch_row($RSS1)) {
            $nr_proposta = $linha1[0];
        }
          
        if ($nr_proposta != '') {

          echo "<script language='JavaScript'>
                  window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Proposta cadastrada com sucesso!'
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


  //==================================-ALTERACAO DOS DADOS-===============================================

  if ($Tipo == "A") {

      $update = "UPDATE consorcio_propostas
                    SET ds_nome=UPPER('" . $nome . "'),
                        vl_credito=" . $credito . ", 
                        nr_cotas=" . $cotas . ", 
                        nr_seq_mes=" . $mes . ", 
                        nr_seq_prazo=" . $prazo . ", 
                        pc_taxa=" . $taxa . ", 
                        nr_seq_plano=" . $plano . ", 
                        pc_seguro=" . $seguro . ", 
                        vl_parcela1=" . $parcela1 . ",
                        vl_parcela2=" . $parcela2 . ",
                        pc_embutido=" . $lance . ",
                        nr_convertidas=" . $convertidada . ",
                        nr_seq_reduzida=" . $reduzida . ", 
                        nr_seq_tipo=" . $tipo . ",
                        cd_useralterado=" . $_SESSION["CD_USUARIO"] . ", 
                        dt_alterado=CURRENT_TIMESTAMP   
                  WHERE nr_sequencial=" . $codigo;
        mysqli_query($conexao, $update);

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                  icon: 'success',
                  title: 'Show...',
                  text: 'Proposta cadastrada com sucesso!'
                }); 
                window.parent.executafuncao('new');
                window.parent.consultar(0);  
              </script>";
    }

  //==================================-EXCLUSÃO DOS DADOS-===============================================

  if ($Tipo == "E") {

      $update = "DELETE FROM consorcio_propostas WHERE nr_sequencial=" . $codigo;
      mysqli_query($conexao, $update); echo $update;
      
      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Proposta excluída com sucesso!'
              });
              window.parent.executafuncao('new');
              window.parent.consultar(0);
            </script>";
    }

?>