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
    $v_sql .= " AND ls.nr_seq_administradora = $administradora";
  }

  $segmento = $_GET['segmento'];
  if ($segmento != 0) {
    $v_sql .= " AND ls.nr_seq_segmento = $segmento";
  }

  $grupo = $_GET['grupo'];
  if ($grupo != "") {
    $v_sql .= " AND ls.ds_grupo = $grupo";
  }

  $cota = $_GET['cota'];
  if ($cota != "") {
    $v_sql .= " AND ls.nr_cota = $cota";
  }
  
  $status = $_GET['status'];
  if ($status == 'P') {
    $v_sql .= " AND p.st_status = 'P'"; //PAGO VENDEDOR
  } else if($status == 'S'){
    $v_sql .= " AND p.st_status = 'T'"; //PENDENTE CLIENTE
  } else if($status == 'C'){
    $v_sql .= " AND p.st_status = 'C'"; //CANCELADO
  } else if($status == 'E'){
    $v_sql .= " AND p.st_status = 'E'"; //ESTORNO
  } else if($status == ''){
    $v_sql .= " AND p.st_status = ''"; //AGUARDANDO
  } else if($status == 'A'){
    $v_sql .= " AND p.st_status = 'A'"; //RATEIO
  } else {
    $v_sql .= " AND p.st_status != 'C'"; //NÃO EXIBE CANCELADOS
  }

  $mes = $_GET['mes'];
  $ano = $_GET['ano'];
  $dia = 10;

  $data = "$ano-$mes-$dia";

  if($_SESSION["ST_ADMIN"] == 'G'){
      $disabled = "";
      $v_filtro_empresa = "AND ls.nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "";
      $v_filtro_colaborador = "";
  } else if ($_SESSION["ST_ADMIN"] == 'C') {
      $disabled = "disabled";
      $v_filtro_empresa = "AND ls.nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "";
      $v_filtro_colaborador = "AND ls.nr_seq_usercadastro = " . $_SESSION["CD_USUARIO"] . "";
  } else {
      $disabled = "";
      $v_filtro_empresa = "";
      $v_filtro_colaborador = "";
  }

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
      
      <table width="100%" class="table table-bordered table-striped">
        <thead>
          <tr style="background-color: RGB(116, 187, 207);">
              <td align="center">Dispon&iacute;vel Em: 
                  <a onClick="javascript: Pdf();" title="Exportar para PDF" alt="Exportar para PDF" class="fa fa-file-pdf-o" style="color: green;cursor:pointer; font-size: 16px;"></a>
              </td>
          </tr>
        </thead>
      </table> 

      <table width="100%" class="table table-bordered table-striped modern-table">
        <tr>
          <th style="vertical-align:middle;">COLABORADOR</th>
          <th style="vertical-align:middle;">ADMINISTRADORA</th>
          <th style="vertical-align:middle;">SEGMENTO</th>
          <th style="vertical-align:middle;">GRUPO</th>
          <th style="vertical-align:middle;">COTA</th>
          <th style="vertical-align:middle;">REALIZADO</th>
          <th style="vertical-align:middle;">PARCELAS</th>
          <th style="vertical-align:middle;">CONTRATADO</th>
          <th style="vertical-align:middle;">COMISSÃO</th>
          <th style="vertical-align:middle;">VALOR</th>
          <th style="vertical-align:middle;">DATA</th>
          <th style="vertical-align:middle;">STATUS</th></th>
          <th style="vertical-align:middle;">AÇÃO</th></th>
        </tr>

        <?php

          $total_considerado = 0;
          $total_comissao = 0;
          $total_parcela = 0;
          $total_estorno = 0;
          $total_percentual = 0;
          
          $SQL = "SELECT ls.nr_sequencial, ls.vl_considerado, ls.dt_contratada, s.ds_segmento, ls.ds_grupo, ls.nr_cota,
                  p.nr_parcela, p.vl_comissao, p.vl_parcela, p.dt_status, p.nr_sequencial, a.ds_administradora,
                  (SELECT COUNT(*) FROM pagamentos p2 WHERE p2.nr_seq_lead = ls.nr_sequencial AND p2.tp_tipo = 'N') AS total_parcelas,
                  (SELECT COUNT(*) FROM pagamentos p3 WHERE p3.nr_seq_lead = ls.nr_sequencial AND p3.tp_tipo = 'N' AND p3.nr_parcela <= p.nr_parcela) AS ordem_parcela,
                  p.st_status, c.ds_colaborador, c.nr_sequencial, a.nr_sequencial,
                  CASE 
                      WHEN p.st_status = 'T' THEN 'PENDENTE CLIENTE'
                      WHEN p.st_status = 'P' THEN 'PAGO AO VENDEDOR'
                      WHEN p.st_status = 'E' THEN 'ESTORNO'
                      WHEN p.st_status = 'C' THEN 'CANCELADO'
                      WHEN p.st_status = 'A' THEN 'RATEIO'
                      ELSE 'AGUARDANDO'
                  END AS ds_status
                  FROM lead ls
                  INNER JOIN segmentos s ON ls.nr_seq_segmento = s.nr_sequencial
                  INNER JOIN usuarios u ON ls.nr_seq_usercadastro = u.nr_sequencial
                  INNER JOIN colaboradores c ON u.nr_seq_colaborador = c.nr_sequencial
                  INNER JOIN pagamentos p ON ls.nr_sequencial = p.nr_seq_lead
                  INNER JOIN administradoras a ON ls.nr_seq_administradora = a.nr_sequencial
                  WHERE ls.nr_seq_situacao = 1
                  AND p.tp_tipo = 'N'
                  AND p.dt_parcela = '$data'
                  "  . $v_sql . "
                  "  . $v_filtro_empresa . "
                  "  . $v_filtro_colaborador . "
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
            $dt_status = $linha[9];
            if ($dt_status != "") {
                $dt_status = date('d/m/Y', strtotime($dt_status));
            }
            $nr_seq_pagamento = $linha[10];
            $ds_administradora = $linha[11];
            $total_parcelas = $linha[12];
            $ordem_parcela = $linha[13];
            $st_status = $linha[14];
            $ds_colaborador = $linha[15];
            $nr_seq_colaborador = $linha[16];
            $nr_seq_administradora = $linha[17];
            $ds_status = $linha[18];
            $descricao_parcela = "Parcela $ordem_parcela de $total_parcelas";
            
            if($st_status == 'T' OR $st_status == 'C' OR $st_status == 'E'){
              $v_tachado = "<s>";
              $v_tachado2 = "</s>";
            } else {
              $v_tachado = "";
              $v_tachado2 = "";
            }

            if($st_status == 'E'){
              $total_desconsiderado += $vl_considerado;
            }

            // Acumulando os totais
            if ($st_status != 'T' AND $st_status != 'C' AND $st_status != 'E') {
              $total_comissao += $vl_comissao;
              $total_parcela += $vl_parcela;
              $total_considerado += $vl_considerado;
            }
            
            $v_pendentes = 0;
            $SQL1 = "SELECT COUNT(*)
                    FROM pagamentos
                    WHERE st_status in ('C','E','T')
                    AND nr_seq_lead = $nr_seq_lead";
            $RES1 = mysqli_query($conexao, $SQL1);
            while($lin1=mysqli_fetch_row($RES1)){
                $v_pendentes = $lin1[0];
            }
            
            $btn_class = ($v_pendentes > 0) ? 'btn-info' : 'btn-success';
            $icon_class = 'glyphicon-new-window';
            
            ?>

            <tr>
              <td><?php echo $v_tachado . $ds_colaborador . $v_tachado2; ?></td>
              <td><?php echo  $v_tachado . $ds_administradora . $v_tachado2; ?></td>
              <td><?php echo  $v_tachado . $ds_segmento . $v_tachado2; ?></td> 
              <td><?php echo  $v_tachado . $ds_grupo . $v_tachado2; ?></td>
              <td><?php echo  $v_tachado . $ds_cota . $v_tachado2; ?></td>
              <td align="center"><?php echo  $v_tachado . $dt_contratada . $v_tachado2; ?></td>
              <td><?php echo  $v_tachado . $descricao_parcela . $v_tachado2; ?></td>
              <td><?php echo $v_tachado . $valor_considerado . $v_tachado2; ?></td>
              <td align="center"><?php echo  $v_tachado . $vl_comissao . $v_tachado2; ?></td>
              <td align="center"><?php echo  $v_tachado . $valor_parcela . $v_tachado2; ?></td>
              <td align="center"><?php echo  $v_tachado . $dt_status . $v_tachado2; ?></td>
              <td align="center"><?php echo  $v_tachado . $ds_status . $v_tachado2; ?></td>
              <td align="center">
                <button type="button" class="btn <?php echo $btn_class; ?>" onclick="AbrirModal('relatorios/comissao/parcelas.php?lead=<?php echo $nr_seq_lead; ?>&parcela=<?php echo $nr_parcela; ?>&colaborador=<?php echo $nr_seq_colaborador; ?>&administradora=<?php echo $nr_seq_administradora; ?>');">
                    <span class="glyphicon <?php echo $icon_class; ?>"></span>
                </button>
              </td>
            </tr>

            <!-- Busca parcelas de estorno para exibir-->
            <?php

              $SQLE = "SELECT nr_sequencial, nr_parcela, vl_percentual, vl_estorno, dt_status, dt_parcela, 
                        CASE WHEN st_status = 'R' THEN 'RECEBIDO' ELSE 'AGUARDANDO' END AS ds_status,
                        (SELECT COUNT(*) FROM pagamentos p2 WHERE p2.nr_seq_lead = $nr_seq_lead AND p2.tp_tipo = 'E') AS total_parcelas
                        FROM pagamentos
                        WHERE nr_seq_lead = $nr_seq_lead
                        AND dt_parcela = '$data'
                        AND tp_tipo = 'E'
                        ORDER BY dt_parcela";
              //echo "<pre>$SQLE</pre>";
              $RSSE = mysqli_query($conexao, $SQLE);
              while ($linhae = mysqli_fetch_row($RSSE)) {
                $nr_seq_estorno = $linhae[0];
                $nr_parcela_estorno = $linhae[1];
                $vl_percentual = $linhae[2];
                $valor_percentual = number_format($vl_percentual, 2, ',', '.');
                $vl_estorno  = $linhae[3];
                $valor_estorno = number_format($vl_estorno, 2, ',', '.');
                $dt_estorno = $linhae[4];
                if($dt_status_estorno != ""){ $dt_status_estorno = date('d/m/Y', strtotime($dt_estorno[5]));}
                $dt_parcela_estorno = date('d/m/Y', strtotime($linhae[5]));
                $ds_status_estorno  = $linhae[6];
                $total_parcelas_estorno  = $linhae[7];
                $ds_parcela_estorno = "Parcela $nr_parcela_estorno de $total_parcelas_estorno";
                $total_percentual += $vl_percentual;
                $total_estorno += $vl_estorno;

                ?>

                <tr style="color: red;">
                  <td></td>
                  <td></td>
                  <td></td> 
                  <td></td>
                  <td></td>
                  <td></td>
                  <td><?php echo $ds_parcela_estorno; ?></td>
                  <td></td>
                  <td align="center">-<?php echo $valor_percentual; ?></td>
                  <td align="center">-<?php echo  $valor_estorno; ?></td>
                  <td align="center"><?php echo  $dt_status_estorno; ?></td>
                  <td align="center" style="color: black;"><?php echo  $ds_status_estorno; ?></td>
                  <td></td>
                </tr>
                <?php

              }

            ?>


            <?php
          }
        ?>

        <tr style="font-weight:bold; background-color: #f2f2f2;">
          <td colspan="7" style="text-align:left;">Total Comissões</td>
          <td style="color: black;"><?php echo number_format($total_considerado, 2, ',', '.'); ?></td>
          <td style="color: black;"><?php echo number_format($total_comissao, 2, ',', '.'); ?></td>
          <td style="color: black;"><?php echo number_format($total_parcela, 2, ',', '.'); ?></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr style="font-weight:bold; background-color: #f2f2f2;">
          <td colspan="7" style="text-align:left;">Total Estornos</td>
          <td style="color: black;"><?php echo number_format($total_desconsiderado, 2, ',', '.'); ?></td>
          <td style="color: black;"><?php echo number_format($total_percentual, 2, ',', '.'); ?></td>
          <td style="color: black;"><?php echo number_format($total_estorno, 2, ',', '.'); ?></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr style="font-weight: bold; background-color: #f2f2f2;">
          <td colspan="7" style="text-align:left;">Total Líquido</td>
          <td></td>
          <td colspan="2" align="center"><?php echo number_format($total_parcela - $total_estorno, 2, ',', '.'); ?></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </table>
  </body>
</html> 

<script language="javascript">

    window.parent.document.getElementById('dvAguarde').style.display = 'none';

</script>