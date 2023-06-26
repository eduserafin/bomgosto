<?php

  foreach($_GET as $key => $value){
      $$key = $value;
  }

?>
<?php

  if ($consulta == "sim") {
      require_once '../../conexao.php';
  }

  $SQL0 = "SELECT nr_sequencial, nr_seq_simulacao
            FROM consorcio_propostas_cotas
          WHERE nr_seq_proposta = $nr_seq_proposta
          ORDER BY nr_seq_simulacao ASC";
          // echo $SQL0;
  $RSS0 = mysqli_query($conexao, $SQL0);
  while ($linha0 = mysqli_fetch_row($RSS0)) {
    $nr_seq_cota = $linha0[0];
    $nr_seq_simulacao = $linha0[1];

    $SQL1 = "SELECT nr_seq_mes
              FROM consorcio_propostas
            WHERE nr_sequencial = $nr_seq_simulacao"; //echo $SQL1;
    $RES1 = mysqli_query($conexao, $SQL1);
    while($linha1=mysqli_fetch_row($RES1)){
      $nr_seq_mes= $linha1[0];

    }

    $SQL2 = "SELECT nr_quantidade
          FROM consorcio_quantidade_mes
        WHERE nr_sequencial = $nr_seq_mes"; //echo $SQL2;
    $RES2 = mysqli_query($conexao, $SQL2);
    while($linha2=mysqli_fetch_row($RES2)){
      $qtd_mes= $linha2[0];

      }

      $ds_parcela1 = $qtd_mes / 2; //Obtem o numero do primeiro grupo de parcelas
      $ds_parcela2 = $ds_parcela1 + 1; //Obtem o numero do segundo grupo de parcelas

    ?>

    <!--<table width="100%" class="table table-bordered table-striped">
      <thead>
        <tr style="background-color: RGB(116, 187, 207);">
            <td align="center">Dispon&iacute;vel Em: 
                <a onClick="javascript: Pdf();" title="Exportar para PDF" alt="Exportar para PDF" class="fa fa-file-pdf-o" style="color: green;cursor:pointer; font-size: 16px;"></a>
            </td>
        </tr>
      </thead>
    </table> -->
    <div class="form-group col-md-12">
        <div class="row">
            <button type="button" class="btn btn-warning" onclick="javascript: editarSimulacao(<?php echo $nr_seq_simulacao; ?>);" title="EDITAR" alt="EDITAR"><span class="glyphicon glyphicon-edit"></span> EDITAR SIMULAÇÃO</button>
            <button type="button" class="btn btn-danger" onclick="javascript: excluirSimulacao(<?php echo $nr_seq_simulacao; ?>, <?php echo $nr_seq_proposta; ?> );" title="EXCLUIR" alt="EXCLUIR"><span class="glyphicon glyphicon-remove"></span> EXCLUIR SIMULAÇÃO</button>
        </div>
    </div>
    <table width="100%" class="table table-dark table-bordered table-striped">
      <thead class="thead-dark">
        <tr class="bottom-bordered-dark">
          <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong>COTA</strong></font></th>
          <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong>CREDITO</strong></font></th>
          <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong>LANCE EMBUTIDO</strong></font></th>
          <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong>CREDITO LIQUIDO</strong></font></th>
          <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong>VL R.PROPRÍO</strong></font></th>
          <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong>VL PARCELAS 1º - <?php echo $ds_parcela1; ?>º</strong></font></th>
          <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong>VL PARCELAS <?php echo $ds_parcela2; ?>º - <?php echo $qtd_mes; ?>º</strong></font></th>
          <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong>APÓS CONTEMPLAÇÃO 1º - <?php echo $ds_parcela1; ?>º</strong></font></th>
          <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong>APÓS CONTEMPLAÇÃO <?php echo $ds_parcela2; ?>º - <?php echo $qtd_mes; ?>º</strong></font></th>
          <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong>CUSTO</strong></font></th>
        </tr>
      </thead>
      <tbody>

          <?php

              $SQL3 = "SELECT nr_sequencial, vl_credito, nr_cotas, vl_embutido, vl_liquido, vl_proprio, vl_parcela1, vl_parcela2, vl_parcela_final1, vl_parcela_final2
                        FROM consorcio_propostas_cotas
                      WHERE nr_seq_proposta = $nr_seq_proposta
                      AND nr_seq_simulacao = $nr_seq_simulacao";
                      // echo $SQL3;
              $RSS3 = mysqli_query($conexao, $SQL3);
              while ($linha3 = mysqli_fetch_row($RSS3)) {
                $nr_sequencial = $linha3[0];
                $vl_credito = $linha3[1];
                $nr_cotas = $linha3[2];
                $vl_embutido = $linha3[3];
                $vl_liquido = $linha3[4];
                $vl_proprio = $linha3[5];
                $vl_parcela1 = $linha3[6];
                $vl_parcela2 = $linha3[7];
                $vl_parcela_final1 = $linha3[8];
                $vl_parcela_final2 = $linha3[9];

              }
                
                for ($i = 1; $i <= $nr_cotas; $i++){ ?>

                  <tr class="bottom-bordered-dark">
                    <td class="border-right-dark bg-secondary" align="center"><font size=1><?php echo $i; ?></font></td>
                    <td class="border-right-dark bg-secondary" align="center"><font size=1><?php echo number_format($vl_credito, 2, ",", "."); ?></font></td>
                    <td class="border-right-dark bg-secondary" align="center"><font size=1><?php echo number_format($vl_embutido, 2, ",", "."); ?></font></td>
                    <td class="border-right-dark bg-secondary" align="center"><font size=1><?php echo number_format($vl_liquido, 2, ",", "."); ?></font></td>
                    <td class="border-right-dark bg-secondary" align="center"><font size=1><?php echo number_format($vl_proprio, 2, ",", "."); ?></font></td>
                    <td class="border-right-dark bg-secondary" align="center"><font size=1><?php echo number_format($vl_parcela1, 2, ",", "."); ?></font></td>
                    <td class="border-right-dark bg-secondary" align="center"><font size=1><?php echo number_format($vl_parcela2, 2, ",", "."); ?></font></td>
                    <td class="border-right-dark bg-secondary" align="center"><font size=1><?php echo number_format($vl_parcela_final1, 2, ",", "."); ?></font></td>
                    <td class="border-right-dark bg-secondary" align="center"><font size=1><?php echo number_format($vl_parcela_final2, 2, ",", "."); ?></font></td>
                    <td class="border-right-dark bg-secondary" align="center"><font size=1></font></td>
                  </tr>

              <?php } ?>

                <?php
            
                  //Soma de totais
                  $vl_total = $vl_credito * $nr_cotas; //Credito total
                  $vl_lance_total = $vl_embutido * $nr_cotas; //Lance embutido total
                  $vl_liquido_total = $vl_liquido * $nr_cotas; //valor liquido total
                  $vl_proprio_total = $vl_proprio * $nr_cotas; //valor recurso proprio total
                  $vl_parcela1_total = $vl_parcela1 * $nr_cotas; //primeiro grupo de parcelas total
                  $vl_parcela2_total = $vl_parcela2 * $nr_cotas; //Segundo grupo de parcelas total
                  $parcelas_finais1_total = $vl_parcela_final1 * $nr_cotas; //primeiro grupo de parcelas apos contemplação total
                  $parcelas_finais2_total = $vl_parcela_final2 * $nr_cotas; //Segundo grupo de parcelas apos contemplação total

                ?>
          <tr class="bottom-bordered-dark">
          <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong>#</strong></font></th>
            <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong><?php echo number_format($vl_total, 2, ",", "."); ?></strong></font></th>
            <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong><?php echo number_format($vl_lance_total, 2, ",", "."); ?></strong></font></th>
            <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong><?php echo number_format($vl_liquido_total, 2, ",", "."); ?></strong></font></th>
            <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong><?php echo number_format($vl_proprio_total, 2, ",", "."); ?></strong></font></th>
            <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong><?php echo number_format($vl_parcela1_total, 2, ",", "."); ?></strong></font></th>
            <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong><?php echo number_format($vl_parcela2_total, 2, ",", "."); ?></strong></font></th>
            <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong><?php echo number_format($parcelas_finais1_total, 2, ",", "."); ?></strong></font></th>
            <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong><?php echo number_format($parcelas_finais2_total, 2, ",", "."); ?></strong></font></th>
            <th class="border-right-dark bg-info" style="text-align:center;"><font size=2><strong></strong></font></th>
          </tr>
      <tbody>
    </table>

    <script type="text/javascript">

      function editarSimulacao(codigo) {

        window.open('consorcios/simulador/acao.php?Tipo=ED&Codigo=' + codigo, "acao");

      }

      function excluirSimulacao(codigo, proposta) {

        Swal.fire({
            title: 'Deseja excluir a simulacao selecionada?',
            text: "Não tem como reverter esta ação!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, excluir!'
        }).then((result) => {
            if (result.isConfirmed) {
                
              window.open('consorcios/simulador/acao.php?Tipo=EX&Codigo=' + codigo + '&proposta=' + proposta, "acao");

            } else {

                return false;

            }
        });

      }

    </script>

<?php } ?>


     

