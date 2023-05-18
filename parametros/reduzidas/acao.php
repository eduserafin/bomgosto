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
                FROM consorcio_parcelas_reduzidas
              WHERE nr_sequencial=" . $Codigo;
      $RSS = mysqli_query($conexao, $SQL);
      $RS = mysqli_fetch_assoc($RSS);

      if ($RS["nr_sequencial"] == $Codigo) {

        echo "<script language='javascript'>window.parent.document.getElementById('cd_reduzida').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').value='" . $RS["ds_plano"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtpercentual').value='" . $RS["pc_percentual"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtquantidade').value='" . $RS["nr_quantidade"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('ativo').value='" . $RS["st_status"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').focus();</script>";
      
      }

  }

  //==========================================-INCLUSAO DOS DADOS-========================================

  if ($Tipo == "I") {

      $SQL = "SELECT nr_sequencial 
                FROM consorcio_parcelas_reduzidas
              WHERE UPPER(ds_plano)=UPPER('" . $nome . "') 
              LIMIT 1"; 
              //echo  $SQL;
      $RSS = mysqli_query($conexao, $SQL);
      $RS = mysqli_fetch_assoc($RSS);

      if ($RS["nr_sequencial"] >0) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'J\u00e1 tem uma parcela reduzida cadastrado com esse nome! Verifique.'
                });
              </script>";
      
      } else {

        if($percentual == "") {$percentual = "NULL";}
        if($quantidade == "") {$quantidade = "NULL";}
  
        $insert = "INSERT INTO consorcio_parcelas_reduzidas (ds_plano, pc_percentual, nr_quantidade, st_status, cd_usercadastro) 
                    VALUES (UPPER('" . $nome . "'), " . $percentual . ", " . $quantidade . ", '" . $status . "', " . $_SESSION["CD_USUARIO"] . ") ";
                    //echo $insert;
        $rss_insert = mysqli_query($conexao, $insert);
    
        $SQL1 = "SELECT nr_sequencial
                    FROM consorcio_parcelas_reduzidas
                  WHERE nr_sequencial = (SELECT max(nr_sequencial) FROM consorcio_parcelas_reduzidas)
                  AND UPPER(ds_plano)=UPPER('" . $nome . "')";       
                  // echo $SQL1;
        $RSS1 = mysqli_query($conexao, $SQL1);
        while ($linha1 = mysqli_fetch_row($RSS1)) {
            $nr_plano = $linha1[0];
        }
          
        if ($nr_plano != '') {

          echo "<script language='JavaScript'>
                  window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Parcela reduzida cadastrado com sucesso!'
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

  //==================================-ALTERACAO DOS DADOS-===============================================

  if ($Tipo == "A") {

    if($percentual == "") {$percentual = "NULL";}
    if($quantidade == "") {$quantidade = "NULL";}
    
      $update = "UPDATE consorcio_parcelas_reduzidas
                    SET ds_plano=UPPER('" . $nome . "'),
                        pc_percentual=" . $percentual . ",
                        nr_quantidade=" . $quantidade . ",
                        st_status='" . $status . "', 
                        cd_useralterado=" . $_SESSION["CD_USUARIO"] . ", 
                        dt_alterado=CURRENT_TIMESTAMP   
                  WHERE nr_sequencial=" . $codigo;
        mysqli_query($conexao, $update);

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                  icon: 'success',
                  title: 'Show...',
                  text: 'Parcela reduzida alterada com sucesso!'
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
            WHERE nr_seq_reduzida=".$codigo;
    $RSS = mysqli_query($conexao, $SQL);
    while ($line = mysqli_fetch_row($RSS)) {$v_existe = $line[0];}

    if ($v_existe > 0) {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Parcela reduzida vinculada a uma proposta! Verifique.'
              });
            </script>";

	  } else {

      $update = "DELETE FROM consorcio_parcelas_reduzidas WHERE nr_sequencial=" . $codigo;
      mysqli_query($conexao, $update);
      
      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Parcela reduzida com sucesso!'
              });
              window.parent.executafuncao('new');
              window.parent.consultar(0);
            </script>";
    }

  }

?>