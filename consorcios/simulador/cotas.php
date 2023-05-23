<?php
    foreach($_GET as $key => $value){
        $$key = $value;
    }

    if ($consulta == "sim") {
        require_once '../../conexao.php';
    }

    if($credito == "") { $credito = 0; }

    $SQL = "SELECT nr_quantidade
              FROM consorcio_quantidade_mes
            WHERE nr_sequencial = $mes"; //echo $SQL;
    $RES = mysqli_query($conexao, $SQL);
    while($linhames=mysqli_fetch_row($RES)){
      $qtd_mes= $linhames[0];

    }

    $ds_parcela1 = $qtd_mes / 2; //Obtem o numero do primeiro grupo de parcelas
    $ds_parcela2 = $ds_parcela1 + 1; //Obtem o numero do segundo grupo de parcelas


?>

  <table width="100%" class="table table-bordered table-striped">
    <thead>
      <tr style="background-color: RGB(116, 187, 207);">
          <td align="center">Dispon&iacute;vel Em: 
              <a onClick="javascript: pdf();" title="Exportar para PDF" alt="Exportar para PDF" class="fa fa-file-pdf-o" style="color: green;cursor:pointer; font-size: 16px;"></a>
          </td>
      </tr>
    </thead>
  </table>

    <table width="100%" class="table table-bordered table-striped">
        <tr>
          <th style="vertical-align:middle;">COTA</th>
          <th style="vertical-align:middle;">CREDITO</th>
          <th style="vertical-align:middle;">LANCE EMBUTIDO</th>
          <th style="vertical-align:middle;">CREDITO LIQUIDO</th>
          <th style="vertical-align:middle;">VL R.PROPRÍO</th>
          <th style="vertical-align:middle;">VL PARCELAS 1º - <?php echo $ds_parcela1; ?>º</th>
          <th style="vertical-align:middle;">VL PARCELAS <?php echo $ds_parcela2; ?>º - <?php echo $qtd_mes; ?>º</th>  
          <th style="vertical-align:middle;">APÓS CONTEMPLAÇÃO 1º - <?php echo $ds_parcela1; ?>º</th>
          <th style="vertical-align:middle;">APÓS CONTEMPLAÇÃO <?php echo $ds_parcela2; ?>º - <?php echo $qtd_mes; ?>º</th>
          <th style="vertical-align:middle;">CUSTO</th>
        </tr>

        <?php

          $count = 0;
          for($i=1; $i<=$quantidade; $i++) { 
          
            $pc_lance = $lance / 100; // Transforma o lance em porcentagem 
            $lance_embutido = $credito * $pc_lance; //Calcula lance embutido
            $credito_liquido = $credito - $lance_embutido; //Calcula credito liquido
  
            if($plano == 1) { // Se for plano DEGRAU

              if($convertidada <= 60) { // Se as parcelas convertidas for < 60

                //Calcula o valor de recurso proprio necessario
                $vl_proprio = $convertidada * $parcela2; 
                $vl_proprio_final = $vl_proprio - $lance_embutido;

              } else if ($convertidada > 60) { // Se as parcelas convertidas for > 60

                //Calcula a soma das parcelas de ambos grupos
                $vl_proprio1 = 60 * $parcela2;
                $diferenca = $convertidada - 60;
                $vl_proprio2 = $diferenca * $parcela1;

                //Calcula o valor de recurso proprio necessario
                $vl_proprio = $vl_proprio1 + $vl_proprio2;
                $vl_proprio_final = $vl_proprio - $lance_embutido;

              }

            } else if($plano == 2) { // Se for plano LINEAR

              //Calcula o valor de recurso proprio necessario
              $vl_proprio = $convertidada * $parcela1;
              $vl_proprio_final = $vl_proprio - $lance_embutido;
              $parcela2 = 0;

            }

            $pc_taxa = $taxa / 100; // Converte taxa em porcentagem
            $taxa_adm = $pc_taxa * $credito; // calcula o valor da taxa

            $seguro_prestamista = $seguro * $qtd_mes; // calcula o seguro conforme a quantidade de meses
  
            $credito_taxa = $credito + $taxa_adm; // Soma o credito + a taxa calculada

            $seguro_operacao = ($seguro_prestamista / 100) * $credito_taxa; // calcula o seguro da operação 

            $credito_taxa_seguro = $credito_taxa + $seguro_operacao; // Calcula o valor da operação, credito + taxa calculada + seguro da operação

            $vl_saldo_devedor = $lance_embutido + $vl_proprio_final; // Calcula o saldo devedor + lance embutido + recurso proprio

            $parcela_apos1 = $credito_taxa_seguro - $vl_saldo_devedor; // Calcula a soma da operação - saldo devedor 

            $parcelas_finais1 = $parcela_apos1 / $qtd_mes - 1; // Calcula o valor da parcela apos contemplação - primeiro grupo

            $dif_parcela = $parcela1 - $parcelas_finais1;  // calcula a diferença de valor do grupo 1 para aplicar no grupo 2

            $parcelas_finais2=  $parcela2 - $dif_parcela; // Calcula o valor da parcela apos contemplação - Segundo grupo


            ?>

            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo number_format($credito, 2, ",", "."); ?></td>
              <td><?php echo number_format($lance_embutido, 2, ",", "."); ?></td>
              <td><?php echo number_format($credito_liquido, 2, ",", "."); ?></td>
              <td><?php echo number_format($vl_proprio_final, 2, ",", "."); ?></td>
              <td><?php echo number_format($parcela1, 2, ",", "."); ?></td>
              <td><?php echo number_format($parcela2, 2, ",", "."); ?></td>
              <td><?php echo number_format($parcelas_finais1, 2, ",", "."); ?></td>
              <td><?php echo number_format($parcelas_finais2, 2, ",", "."); ?></td>
            </tr>

            <?php
            $count++;
          } 
          
          //Soma de totais
          $vl_total = $credito * $count; //Credito total
          $vl_lance_total = $lance_embutido * $count; //Lance embutido total
          $vl_liquido_total = $credito_liquido * $count; //valor liquido total
          $vl_proprio_total = $vl_proprio_final * $count; //valor recurso proprio total
          $vl_parcela1_total = $parcela1 * $count; //primeiro grupo de parcelas total
          $vl_parcela2_total = $parcela2 * $count; //Segundo grupo de parcelas total
          $parcelas_finais1_total = $parcelas_finais1 * $count; //primeiro grupo de parcelas apos contemplação total
          $parcelas_finais2_total = $parcelas_finais2 * $count; //Segundo grupo de parcelas apos contemplação total

        ?>
         <tr>
            <th><?php echo $count; ?></th>
            <th><?php echo number_format($vl_total, 2, ",", "."); ?></th>
            <th><?php echo number_format($vl_lance_total, 2, ",", "."); ?></th>
            <th><?php echo number_format($vl_liquido_total, 2, ",", "."); ?></th>
            <th><?php echo number_format($vl_proprio_total, 2, ",", "."); ?></th>
            <th><?php echo number_format($vl_parcela1_total, 2, ",", "."); ?></th>
            <th><?php echo number_format($vl_parcela2_total, 2, ",", "."); ?></th>
            <th><?php echo number_format($parcelas_finais1_total, 2, ",", "."); ?></th>
            <th><?php echo number_format($parcelas_finais2_total, 2, ",", "."); ?></th>
          </tr>

      </table>

      <script type="text/javascript">

        var credito = <?php echo $credito; ?>
    
        window.open('consorcios/simulador/pdf.php?credito=' + credito, "acao");

      </script>
