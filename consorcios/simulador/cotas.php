<?php
    foreach($_GET as $key => $value){
        $$key = $value;
    }

    if ($consulta == "sim") {
        require_once '../../conexao.php';
    }

    if($credito == "") { $credito = 0; }

?>

    <table width="100%" class="table table-bordered table-striped">
        <tr>
          <th style="vertical-align:middle;">COTA</th>
          <th style="vertical-align:middle;">CREDITO</th>
          <th style="vertical-align:middle;">LANCE EMBUTIDO</th>
          <th style="vertical-align:middle;">CREDITO LIQUIDO</th>
          <th style="vertical-align:middle;">VL R.PROPRÍO</th>
          <th style="vertical-align:middle;">VL PARCELAS 1º - 60º</th>
          <th style="vertical-align:middle;">VL PARCELAS 61º - 120º</th>  
          <th style="vertical-align:middle;">PARCELA APÓS CONTEMPLAÇÃO</th>
          <th style="vertical-align:middle;">CUSTO</th>
        </tr>

        <?php

          $count = 0;
          for($i=1; $i<=$quantidade; $i++) { 
          
            $pc_lance = $lance / 100;
            $lance_embutido = $credito * $pc_lance;
            $credito_liquido = $credito - $lance_embutido;

            if($plano == 1) {

              if($convertidada <= 60) {

                $vl_proprio = $convertidada * $parcela2;
                $vl_proprio_final = $vl_proprio - $lance_embutido;

              } else if ($convertidada > 60) {

                $vl_proprio1 = 60 * $parcela2;
                $diferenca = $convertidada - 60;
                $vl_proprio2 = $diferenca * $parcela1;

                $vl_proprio = $vl_proprio1 + $vl_proprio2;
                $vl_proprio_final = $vl_proprio - $lance_embutido;

              }

            } else if($plano == 2) {

              $vl_proprio = $convertidada * $parcela1;
              $vl_proprio_final = $vl_proprio - $lance_embutido;
              $parcela2 = 0;

            }

            ?>

            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo number_format($credito, 2, ",", "."); ?></td>
              <td><?php echo number_format($lance_embutido, 2, ",", "."); ?></td>
              <td><?php echo number_format($credito_liquido, 2, ",", "."); ?></td>
              <td><?php echo number_format($vl_proprio_final, 2, ",", "."); ?></td>
              <td><?php echo number_format($parcela1, 2, ",", "."); ?></td>
              <td><?php echo number_format($parcela2, 2, ",", "."); ?></td>
            </tr>

            <?php
            $count++;
          } 
          
          $vl_total = $credito * $count;
          $vl_lance_total = $lance_embutido * $count;
          $vl_liquido_total = $credito_liquido * $count;
          $vl_proprio_total = $vl_proprio_final * $count;
          $vl_parcela1_total = $parcela1 * $count;
          $vl_parcela2_total = $parcela2 * $count;

        ?>
         <tr>
            <th><?php echo $count; ?></th>
            <th><?php echo number_format($vl_total, 2, ",", "."); ?></th>
            <th><?php echo number_format($vl_lance_total, 2, ",", "."); ?></th>
            <th><?php echo number_format($vl_liquido_total, 2, ",", "."); ?></th>
            <th><?php echo number_format($vl_proprio_total, 2, ",", "."); ?></th>
            <th><?php echo number_format($vl_parcela1_total, 2, ",", "."); ?></th>
            <th><?php echo number_format($vl_parcela2_total, 2, ",", "."); ?></th>
          </tr>

      </table>
