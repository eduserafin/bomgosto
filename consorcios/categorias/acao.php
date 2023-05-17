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
                FROM categorias
              WHERE nr_sequencial=" . $Codigo;
      $RSS = mysqli_query($conexao, $SQL);
      $RS = mysqli_fetch_assoc($RSS);

      if ($RS["nr_sequencial"] == $Codigo) {

        echo "<script language='javascript'>window.parent.document.getElementById('cd_categoria').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtcategoria').value='" . $RS["ds_categoria"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('ativo').value='" . $RS["st_status"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtcategoria').focus();</script>";
      
      }

  }

  //==========================================-INCLUSAO DOS DADOS-========================================

  if ($Tipo == "I") {

      $SQL = "SELECT nr_sequencial 
                FROM categorias
              WHERE UPPER(ds_categoria)=UPPER('" . $categoria . "') 
              LIMIT 1"; 
              //echo  $SQL;
      $RSS = mysqli_query($conexao, $SQL);
      $RS = mysqli_fetch_assoc($RSS);

      if ($RS["nr_sequencial"] >0) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'J\u00e1 tem uma categoria cadastrada com esse nome! Verifique.'
                });
              </script>";
      
      } else {
  
        $insert = "INSERT INTO categorias (ds_categoria, st_status, cd_usercadastro) 
                    VALUES (UPPER('" . $categoria . "'), '" . $status . "', " . $_SESSION["CD_USUARIO"] . ") ";
        echo $insert;
        $rss_insert = mysqli_query($conexao, $insert);
    
        $SQL1 = "SELECT nr_sequencial
                    FROM categorias
                  WHERE nr_sequencial = (SELECT max(nr_sequencial) FROM categorias)
                  AND UPPER(ds_categoria)=UPPER('" . $categoria . "')";       
                  // echo $SQL1;
        $RSS1 = mysqli_query($conexao, $SQL1);
        while ($linha1 = mysqli_fetch_row($RSS1)) {
            $nr_categoria = $linha1[0];
        }
          
        if ($nr_categoria != '') {

          echo "<script language='JavaScript'>
                  window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Categoria cadastrada com sucesso!'
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

    $SQL = "SELECT nr_sequencial 
              FROM categorias
            WHERE UPPER(ds_categoria)=UPPER('" . $categoria . "') 
            LIMIT 1"; 
            //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);

    if ($RS["nr_sequencial"] >0) {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'J\u00e1 tem uma categoria cadastrada com esse nome! Verifique.'
              });
            </script>";
              
    } else {
    
      $update = "UPDATE categorias
                    SET ds_categoria=UPPER('" . $categoria . "'),
                        st_status='" . $status . "', 
                        cd_useralterado=" . $_SESSION["CD_USUARIO"] . ", 
                        dt_alterado=CURRENT_TIMESTAMP   
                  WHERE nr_sequencial=" . $codigo;
        mysqli_query($conexao, $update);

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                  icon: 'success',
                  title: 'Show...',
                  text: 'Categoria cadastrada com sucesso!'
                }); 
                window.parent.executafuncao('new');
                window.parent.consultar(0);  
              </script>";
    }

  }

  //==================================-EXCLUSÃO DOS DADOS-===============================================

  if ($Tipo == "E") {

    $v_existe = 0;
    $SQL = "SELECT nr_sequencial  
              FROM produtos 
            WHERE nr_seq_categoria=".$codigo;
    $RSS = mysqli_query($conexao, $SQL);
    while ($line = mysqli_fetch_row($RSS)) {$v_existe = $line[0];}

    if ($v_existe > 0) {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Categoria vínculada a um produto! Verifique.'
              });
            </script>";

	  } else {

      $update = "DELETE FROM categorias WHERE nr_sequencial=" . $codigo;
      mysqli_query($conexao, $update);
      
      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Categoria excluída com sucesso!'
              });
              window.parent.executafuncao('new');
              window.parent.consultar(0);
            </script>";
    }

  }

?>