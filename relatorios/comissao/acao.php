<?php

  foreach($_GET as $key => $value){
    $$key = $value;
  }

  session_start(); 
  include "../../conexao.php";

?>

<?php

  //=====================================-GRAVA A DATA DO PAGAMENTO-=========================================

   if ($Tipo == "PAGAMENTO") {

      $update = "UPDATE pagamentos SET dt_pagamento = '$data' WHERE nr_seq_lead = $lead AND nr_parcela = $parcela";
      $rss_update = mysqli_query($conexao, $update); echo $update;

      if ($rss_update) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Data cadastrada com sucesso!'
                });
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

?>