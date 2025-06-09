<?php

  foreach($_GET as $key => $value){
    $$key = $value;
  }

  if ($consulta == "sim") {
      require_once '../../conexao.php';
      $ant = "../../";
  }

  if ($_GET['pg'] < 0){
      $pg = 0;
      echo "<script language='javascript'>document.getElementById('pgatual').value=1;</script>";
  }
  else if ($_GET['pg'] !== 0) {
      $pg = $_GET['pg'];
  } else {
      $pg = 0;
  }

  $porpagina = 15;
  $inicio = $pg * $porpagina;

  $colaborador = $_GET['colaborador'];
  if ($colaborador != 0) {
    $v_sql .= " AND c.nr_sequencial = $colaborador";
  }

  $administradora = $_GET['administradora'];
  if ($administradora != 0) {
    $v_sql .= " AND ls.nr_seq_adminsitradora = $administradora";
  }

  $segmento = $_GET['segmento'];
  if ($segmento != 0) {
    $v_sql .= " AND ls.nr_seq_segmento = $segmento";
  }

  $mes = $_GET['mes'];
  $ano = $_GET['ano'];
  $dia = 10;

  $data = "$ano/$mes/$dia";

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
      <table width="100%" class="table table-bordered table-striped modern-table">
        <tr>
          <th style="vertical-align:middle;">VALOR</th>
          <th style="vertical-align:middle;">DATA CONTRATADA</th>
          <th style="vertical-align:middle;">GRUPO</th>
          <th style="vertical-align:middle;">COTA</th>
          <th style="vertical-align:middle;">SEGMENTO</th>
          <th style="vertical-align:middle;">PARCELAS</th>
          <th style="vertical-align:middle;">COMISSÃO PARCELA</th>
          <th style="vertical-align:middle;">VALOR PARCELA</th>
          <th style="vertical-align:middle;">DATA PAGAMENTO</th>
        </tr>

        <?php
      
          $SQL = "SELECT ls.nr_sequencial, ls.vl_considerado, ls.dt_contratada, s.ds_segmento, ls.ds_grupo, ls.nr_cota,
                  p.nr_parcela, p.vl_comissao, p.vl_parcela, p.dt_pagamento,
                  (SELECT COUNT(*) FROM pagamentos p2 WHERE p2.nr_seq_lead = ls.nr_sequencial) AS total_parcelas
                  FROM lead ls
                  INNER JOIN segmentos s ON ls.nr_seq_segmento = s.nr_sequencial
                  INNER JOIN usuarios u ON ls.nr_seq_usercadastro = u.nr_sequencial
                  INNER JOIN colaboradores c ON u.nr_seq_colaborador = c.nr_sequencial
                  INNER JOIN pagamentos p ON ls.nr_sequencial = p.nr_seq_lead
                  WHERE ls.nr_seq_situacao = 1
                  AND p.dt_parcela = '$data'
                  $v_sql
                  ORDER BY ls.dt_contratada";

          //echo "<pre>$SQL</pre>";
          $RSS = mysqli_query($conexao, $SQL);
          while ($linha = mysqli_fetch_row($RSS)) {
            $nr_seq_lead = $linha[0];
            $vl_considerado = $linha[1];
            $valor_considerado = number_format($vl_considerado, 2, ',', '.');
            $dt_contratada = date('d/m/Y', strtotime($linha[2]));
            $ds_segmento = $linha[3];
            $ds_grupo = $linha[4];
            $ds_cota = $linha[5];
            $nr_parcela = $linha[6];
            $vl_comissao = $linha[7];
            $vl_parcela = $linha[8];
            $valor_parcela = number_format($vl_parcela, 2, ',', '.');
            $dt_pagamento = $linha[9];
            $total_parcelas = $linha[10];
            $descricao_parcela = "Parcela $nr_parcela de $total_parcelas";

            // Acumulando os totais
            $total_considerado += $vl_considerado;
            $total_comissao += $vl_comissao;
            $total_parcela += $vl_parcela;
            
            ?>

            <tr>
              <td><?php echo $valor_considerado; ?></td>
              <td><?php echo $dt_contratada; ?></td>
              <td><?php echo $ds_grupo; ?></td>
              <td><?php echo $ds_cota; ?></td>
              <td><?php echo $ds_segmento; ?></td>
              <td><?php echo $descricao_parcela; ?></td>
              <td><?php echo $vl_comissao; ?></td>
              <td><?php echo $valor_parcela; ?></td>
              <td><input type="date" id="dataagenda" name="dataagenda" class="form-control" onchange="AlterarPagamento(this.value, <?php echo $nr_seq_lead; ?>, <?php echo $nr_parcela; ?>);" value="<?php echo $dt_pagamento; ?>"></td>
            </tr>

            <?php
          }
        ?>

        <tr style="font-weight:bold; background-color:#f2f2f2;">
          <td><?php echo number_format($total_considerado, 2, ',', '.'); ?></td>
          <td colspan="5" style="text-align:center;">TOTAIS</td>
          <td><?php echo number_format($total_comissao, 2, ',', '.'); ?></td>
          <td><?php echo number_format($total_parcela, 2, ',', '.'); ?></td>
          <td></td>
        </tr>

      </table>

  </body>
</html> 

<script language="javascript">

    window.parent.document.getElementById('dvAguarde').style.display = 'none';

    function AlterarPagamento(data, lead, parcela) {

      window.open('relatorios/comissao/acao.php?Tipo=PAGAMENTO&lead=' + lead + '&data=' + data + '&parcela=' + parcela, "acao");

    }

      

</script>