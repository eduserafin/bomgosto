<?php
$consulta = '';
$equipamento = '';
$nome = '';
$data = '';
$pg = '';
foreach($_GET as $key => $value){
	$$key = $value;
}

if ($consulta == "sim") {
    require_once '../conexao.php';
    $ant = "../";
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



$rodada = $_GET['rodada'];  
if ($rodada != "") {
    $v_sql = " AND c.nr_rodada = $rodada";
}

$data = $_GET['data'];
if ($data != '') {
 $v_sql = " AND c.dt_cadastro = '$data'";
}


?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
    <table width="100%" class="table table-bordered table-striped">
        <tr>
            <th><strong>RODADA</strong></th>
            <th><strong>VENCEDOR</strong></th>
            <th><strong>PONTOS</strong></th>
            <th><strong>RECEBEU</strong></th>
            <th><strong>PAGADOR1</strong></th>
            <th><strong>PONTOS</strong></th>
            <th><strong>PAGOU</strong></th>
            <th><strong>PAGADOR2</strong></th>
            <th><strong>PONTOS</strong></th>
            <th><strong>PAGOU</strong></th>
            <th><strong>PAGADOR3</strong></th>
            <th><strong>PONTOS</strong></th>
            <th><strong>PAGOU</strong></th>
            <th><strong>PAGADOR4</strong></th>
            <th><strong>PONTOS</strong></th>
            <th><strong>PAGOU</strong></th>
            <th><strong>PAGADOR5</strong></th>
            <th><strong>PONTOS</strong></th>
            <th><strong>PAGOU</strong></th>
            <th colspan=3 style="vertical-align:middle; text-align:center">A&Ccedil;&Otilde;ES</th>
            
        </tr>
        <?php
        
                $SQL = "SELECT c.nr_sequencial, t.ds_time, c.nr_pontos, t1.ds_time, c.nr_pontos1, 
                t2.ds_time, c.nr_pontos2, t3.ds_time, c.nr_pontos3, t4.ds_time, c.nr_pontos4, c.nr_rodada, 
                c.dt_cadastro, c.dt_recebimento, c.st_pagou1, c.st_pagou2, c.st_pagou3, c.st_pagou4,
                c.st_recebeu, c.dt_pagamento1, c.dt_pagamento2, c.dt_pagamento3, c.dt_pagamento4,
                c.dt_pagamento5, c.st_pagou5, c.nr_pontos5, t5.ds_time
                        FROM cartola c
                        INNER JOIN cartola_times t ON t.nr_sequencial = c.nr_seq_time_vencedor
                        LEFT JOIN cartola_times t1 ON t1.nr_sequencial = c.nr_seq_time_pagador1
                        LEFT JOIN cartola_times t2 ON t2.nr_sequencial = c.nr_seq_time_pagador2
                        LEFT JOIN cartola_times t3 ON t3.nr_sequencial = c.nr_seq_time_pagador3
                        LEFT JOIN cartola_times t4 ON t4.nr_sequencial = c.nr_seq_time_pagador4
                        LEFT JOIN cartola_times t5 ON t5.nr_sequencial = c.nr_seq_time_pagador5
                        WHERE 1 = 1 $v_sql 
                        ORDER BY c.nr_sequencial ASC LIMIT $porpagina offset $inicio";
                //echo $SQL;
                $RSS = mysqli_query($conexao, $SQL);
                while ($linha = mysqli_fetch_row($RSS)) {
                    $nr_sequencial = $linha[0];
                    $ds_time_vencedor = $linha[1];
                    $nr_pontos = number_format($linha[2], 2, ",", ".");
                    $ds_time_pagador1 = $linha[3];
                    $nr_pontos1 = number_format($linha[4], 2, ",", ".");
                    $ds_time_pagador2 = $linha[5];
                    $nr_pontos2 = number_format($linha[6], 2, ",", ".");
                    $ds_time_pagador3 = $linha[7];
                    $nr_pontos3 = number_format($linha[8], 2, ",", ".");
                    $ds_time_pagador4 = $linha[9];
                    $nr_pontos4 = number_format($linha[10], 2, ",", ".");
                    $nr_rodada = number_format($linha[11], 0, ",", ".");
                    $dt_cadastro = date('d/m/Y', strtotime($linha[12]));
                    $dt_recebimento = date('d/m/Y', strtotime($linha[13]));
                    $st_pagou1 = $linha[14];
                    $st_pagou2 = $linha[15];
                    $st_pagou3 = $linha[16];
                    $st_pagou4 = $linha[17];
                    $st_recebeu = $linha[18];
                    $dt_pagamento1 = date('d/m/Y', strtotime($linha[19]));
                    $dt_pagamento2 = date('d/m/Y', strtotime($linha[20]));
                    $dt_pagamento3 = date('d/m/Y', strtotime($linha[21]));
                    $dt_pagamento4 = date('d/m/Y', strtotime($linha[22]));
                    $dt_pagamento5 = date('d/m/Y', strtotime($linha[23]));
                    $st_pagou5 = $linha[24];
                    $nr_pontos5 = number_format($linha[25], 2, ",", ".");
                    $ds_time_pagador5 = $linha[26];

                    ?>
                    <tr>
                        <td><?php echo $nr_rodada; ?></td>
                        <td><?php echo $ds_time_vencedor; ?></td>
                        <td><?php echo $nr_pontos; ?></td>
                        <?php
                          if($st_recebeu == ''){
                            ?>
                            <td width="3%" align="center"> <button type="button" class="btn btn-success" onclick="javascript: executafuncao2('R', <?php echo $nr_sequencial; ?>);" title="RECEBER" alt="RECEBER"><span class="glyphicon glyphicon-ok"></span></button></td>
                            <?php
                          } 
                          else {
                             ?>
                            <td><?php echo $dt_recebimento; ?></td>
                            <?php
                          }
                          ?>
                        <td><?php echo $ds_time_pagador1; ?></td>
                        <td><?php echo $nr_pontos1; ?></td>
                        <?php
                            if($st_pagou1 == ''){
                            ?>
                            <td width="3%" align="center"> <button type="button" class="btn btn-success" onclick="javascript: executafuncao2('P1', <?php echo $nr_sequencial; ?>);" title="PAGAR" alt="PAGAR1"><span class="glyphicon glyphicon-ok"></span></button></td>
                            <?php
                          }
                          else {
                             ?>
                            <td><?php echo $dt_pagamento1; ?></td>
                            <?php
                          }
                          ?>
                        <td><?php echo $ds_time_pagador2; ?></td>
                        <td><?php echo $nr_pontos2; ?></td>
                          <?php
                            if($st_pagou2 == ''){
                            ?>
                            <td width="3%" align="center"> <button type="button" class="btn btn-success" onclick="javascript: executafuncao2('P2', <?php echo $nr_sequencial; ?>);" title="PAGAR" alt="PAGAR2"><span class="glyphicon glyphicon-ok"></span></button></td>
                            <?php
                          }
                          else {
                             ?>
                            <td><?php echo $dt_pagamento2; ?></td>
                            <?php
                          }
                          ?>
                        <td><?php echo $ds_time_pagador3; ?></td>
                        <td><?php echo $nr_pontos3; ?></td>
                          <?php
                            if($st_pagou3 == ''){
                            ?>
                            <td width="3%" align="center"> <button type="button" class="btn btn-success" onclick="javascript: executafuncao2('P3', <?php echo $nr_sequencial; ?>);" title="PAGAR" alt="PAGAR3"><span class="glyphicon glyphicon-ok"></span></button></td>
                            <?php
                          }
                          else {
                             ?>
                            <td><?php echo $dt_pagamento3; ?></td>
                            <?php
                          }
                          ?>
                        <td><?php echo $ds_time_pagador4; ?></td>
                        <td><?php echo $nr_pontos4; ?></td>
                          <?php
                            if($st_pagou4 == ''){
                            ?>
                            <td width="3%" align="center"> <button type="button" class="btn btn-success" onclick="javascript: executafuncao2('P4', <?php echo $nr_sequencial; ?>);" title="PAGAR" alt="PAGAR4"><span class="glyphicon glyphicon-ok"></span></button></td>
                            <?php
                          }
                          else {
                             ?>
                            <td><?php echo $dt_pagamento4; ?></td>
                            <?php
                          }
                          ?> 
                          <td><?php echo $ds_time_pagador5; ?></td>
                        <td><?php echo $nr_pontos5; ?></td>
                          <?php
                            if($st_pagou5 == ''){
                            ?>
                            <td width="3%" align="center"> <button type="button" class="btn btn-success" onclick="javascript: executafuncao2('P5', <?php echo $nr_sequencial; ?>);" title="PAGAR" alt="PAGAR4"><span class="glyphicon glyphicon-ok"></span></button></td>
                            <?php
                          }
                          else {
                             ?>
                            <td><?php echo $dt_pagamento5; ?></td>
                            <?php
                          }
                          ?> 
                        <td width="3%" align="center"><?php include $ant."inc/btn_editar.php";?></td>
                        <td width="3%" align="center"><?php include $ant."inc/btn_excluir.php";?></td>
                    </tr>
                    <?php
                }
                ?>
    </table>
    <br>
    <?php include $ant."inc/paginacao.php";?>
  </body>
</html>   
<script language="javascript">
    function executafuncao2(tipo, id) {
      if (tipo == 'ED'){
        document.getElementById('tabgeral').click();
        window.open("cartola/acao.php?Tipo=D&Codigo=" + id, "acao");
      }
      else if (tipo == 'R'){
        document.getElementById('tabgeral').click();
        window.open("cartola/acao.php?Tipo=R&Codigo=" + id, "acao");
        }
        else if (tipo == 'P1'){
        document.getElementById('tabgeral').click();
        window.open("cartola/acao.php?Tipo=P1&Codigo=" + id, "acao");
        } 
        else if (tipo == 'P2'){
        document.getElementById('tabgeral').click();
        window.open("cartola/acao.php?Tipo=P2&Codigo=" + id, "acao");
        } 
        else if (tipo == 'P3'){
        document.getElementById('tabgeral').click();
        window.open("cartola/acao.php?Tipo=P3&Codigo=" + id, "acao");
        } 
        else if (tipo == 'P4'){
        document.getElementById('tabgeral').click();
        window.open("cartola/acao.php?Tipo=P4&Codigo=" + id, "acao");
        }  
        else if (tipo == 'P5'){
        document.getElementById('tabgeral').click();
        window.open("cartola/acao.php?Tipo=P5&Codigo=" + id, "acao");
        }  
      else if (tipo == 'EX'){
        if (!confirm("Deseja excluir o registro selecionado?")) {
          return false;
        } 
      else {
          window.open("cartola/acao.php?Tipo=E&Codigo=" + id, "acao");
        }
      }
    }
  
</script>