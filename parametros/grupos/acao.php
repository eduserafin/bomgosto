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

      $SQL = "SELECT nr_sequencial 
                FROM consorcio_prazo_grupo
              WHERE nr_quantidade = " . $prazo . " 
              LIMIT 1"; 
              //echo  $SQL;
      $RSS = mysqli_query($conexao, $SQL);
      $RS = mysqli_fetch_assoc($RSS);

      if ($RS["nr_sequencial"] >0) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'J\u00e1 tem esse prazo cadastrado! Verifique.'
                });
              </script>";
      
      } else {
  
        $insert = "INSERT INTO consorcio_prazo_grupo (nr_quantidade, st_status, nr_seq_usercadastro) 
                    VALUES (" . $prazo . ", '" . $status . "', " . $_SESSION["CD_USUARIO"] . ") ";
                    //echo $insert;
        $rss_insert = mysqli_query($conexao, $insert);
    
        $SQL1 = "SELECT nr_sequencial
                    FROM consorcio_prazo_grupo
                  WHERE nr_sequencial = (SELECT max(nr_sequencial) FROM consorcio_prazo_grupo)
                  AND nr_quantidade = " . $prazo . "";       
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
                    text: 'Prazo cadastrado com sucesso!'
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
    
      $update = "UPDATE consorcio_prazo_grupo
                    SET nr_quantidade=" . $prazo . ",
                        st_status='" . $status . "', 
                        nr_seq_useralterado=" . $_SESSION["CD_USUARIO"] . ", 
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