<?php

    if($_SESSION["ST_ADMIN"] == 'G'){
        $v_filtro_empresa = "AND l.nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "";
        $v_filtro_colaborador = "";
    } else if ($_SESSION["ST_ADMIN"] == 'C') {
        $v_filtro_empresa = "AND l.nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "";
        $v_filtro_colaborador = "AND l.nr_seq_usercadastro = " . $_SESSION["CD_USUARIO"] . "";
    } else {
        $v_filtro_empresa = "";
        $v_filtro_colaborador = "";
    }

    // Funil de vendas por situação
    $funil = [["Situação", "Quantidade"]];
    $sql1 = "SELECT s.ds_situacao, COUNT(*) AS total 
            FROM lead l 
            JOIN situacoes s ON l.nr_seq_situacao = s.nr_sequencial 
            WHERE 1 = 1
            "  . $v_filtro_empresa . "
            "  . $v_filtro_colaborador . "
            GROUP BY s.ds_situacao ORDER BY total DESC";
    $res1 = $conexao->query($sql1);
    while ($row = $res1->fetch_assoc()) {
        $funil[] = [$row['ds_situacao'], (int)$row['total']];
    }


    // Vendas por segmento
    $segmento = [["Segmento", "Valor"]];
    $sql2 = "SELECT s.ds_segmento, SUM(vl_contratado) AS valor
            FROM lead l 
            JOIN segmentos s ON l.nr_seq_segmento = s.nr_sequencial 
            WHERE l.nr_seq_situacao = 1
            "  . $v_filtro_empresa . "
            "  . $v_filtro_colaborador . "
            GROUP BY s.ds_segmento ORDER BY valor DESC";
    $res2 = $conexao->query($sql2);
    while ($row2 = $res2->fetch_assoc()) {
        $segmento[] = [$row2['ds_segmento'], (int)$row2['valor']];
    }

?>

<!-- GRAFICO DE BARRAS FUNIL DE VENDAS -->
<div class="col-md-6">
    <div id="graficoFunil" style="height: 400px;"></div>
</div>

<!-- GRAFICO DE PIZZA VENDAS POR SEGMENTO -->
<div class="col-md-6">
    <div id="graficoSegmento" style="height: 400px;"></div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChartFunil);
    google.charts.setOnLoadCallback(drawChartSegmento);

    function drawChartFunil() {
        var data = google.visualization.arrayToDataTable([
            <?php
            foreach ($funil as $i => $linha) {
                echo json_encode($linha);
                echo $i < count($funil) - 1 ? "," : "";
            }
            ?>
        ]);

        var options = {
            title: 'Funil de Vendas',
            legend: { position: 'none' }
        };

        var chart = new google.visualization.BarChart(document.getElementById('graficoFunil'));
        chart.draw(data, options);
    }

    function drawChartSegmento() {
        var data = google.visualization.arrayToDataTable([
            <?php
            foreach ($segmento as $i => $linha) {
                echo json_encode($linha);
                echo $i < count($segmento) - 1 ? "," : "";
            }
            ?>
        ]);

        var options = {
            title: 'Vendas por Segmentos',
            legend: { position: 'right' } // geralmente em gráfico de pizza a legenda fica melhor à direita
        };

        var chart = new google.visualization.PieChart(document.getElementById('graficoSegmento'));
        chart.draw(data, options);
    }
</script>
