<?php

    $mes = date('m'); 
    $ano = date('Y'); 

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

    if($_SESSION["ST_PERIODO"] == 'M'){
        $v_filtro_cadastro = "AND MONTH(l.dt_cadastro) = $mes";
        $v_filtro_contratada = "AND MONTH(l.dt_contratada) = $mes";
    } else if ($_SESSION["ST_PERIODO"] == 'N') {
        $v_filtro_cadastro = "AND YEAR(l.dt_cadastro) = $ano";
        $v_filtro_contratada = "AND YEAR(l.dt_contratada) = $ano";
    } else {
        $v_filtro_cadastro = "";
        $v_filtro_contratada = "";
    }
    
    // Função para gerar paleta de cores aleatórias
    function gerarCores($quantidade) {
        $cores = [];
        for ($i = 0; $i < $quantidade; $i++) {
            $cores[] = sprintf("#%06X", mt_rand(0, 0xFFFFFF));
        }
        return $cores;
    }

    // Vendas por estado
    $vendasEstado = [];
    $sqlEstado = "SELECT e.ds_estado, SUM(vl_contratado) AS total_vendas
                FROM lead l
                JOIN cidades c ON l.nr_seq_cidade = c.nr_sequencial
                JOIN estados e ON c.nr_seq_estado = e.nr_sequencial
                WHERE l.nr_seq_situacao = 1
                " . $v_filtro_contratada . "
                " . $v_filtro_empresa . "
                " . $v_filtro_colaborador . "
                GROUP BY e.ds_estado
                ORDER BY total_vendas DESC";
    //echo "<pre>$sqlEstado</pre>"; 
    $resEstado = $conexao->query($sqlEstado);
    while ($row = $resEstado->fetch_assoc()) {
        $vendasEstado[] = [$row['ds_estado'], (int)$row['total_vendas']];
    }

    $coresEstado = gerarCores(count($vendasEstado));

    // Vendas por segmento
    $segmento = [["Segmento", "Valor"]];
    $sql2 = "SELECT s.ds_segmento, SUM(vl_contratado) AS valor
            FROM lead l 
            JOIN segmentos s ON l.nr_seq_segmento = s.nr_sequencial 
            WHERE l.nr_seq_situacao = 1
            "  . $v_filtro_contratada . "
            "  . $v_filtro_empresa . "
            "  . $v_filtro_colaborador . "
            GROUP BY s.ds_segmento ORDER BY valor DESC";
    $res2 = $conexao->query($sql2);
    while ($row2 = $res2->fetch_assoc()) {
        $segmento[] = [$row2['ds_segmento'], (int)$row2['valor']];
    }
    
    $coresSegmento = gerarCores(count($segmento) - 1);
    
    // Vendas por administradoras
    $adm = [["Administradora", "Valor"]];
    $sql3 = "SELECT a.ds_administradora, SUM(vl_contratado) AS valor
            FROM lead l 
            JOIN administradoras a ON l.nr_seq_administradora = a.nr_sequencial 
            WHERE l.nr_seq_situacao = 1
            "  . $v_filtro_contratada . "
            "  . $v_filtro_empresa . "
            "  . $v_filtro_colaborador . "
            GROUP BY a.ds_administradora ORDER BY valor DESC";
    //echo "<pre> $sql3</pre>";
    $res3 = $conexao->query($sql3);
    while ($row3 = $res3->fetch_assoc()) {
        $adm[] = [$row3['ds_administradora'], (int)$row3['valor']];
    }
    
    $coresAdministradora = gerarCores(count($adm) - 1);

?>


<div class="col-md-12"><br>
    <!-- GRAFICO DE VENDAS POR ESTADO -->
    <div class="col-md-4">
        <div id="graficoEstado" style="height: 400px;"></div>
    </div>
    
    <!-- GRAFICO DE BARRAS VENDAS POR COLABORADOR -->
    <div class="col-md-4">
        <div id="graficoAdministradora" style="height: 400px;"></div>
    </div>
    
    <!-- GRAFICO DE PIZZA VENDAS POR SEGMENTO -->
    <div class="col-md-4">
        <div id="graficoSegmento" style="height: 400px;"></div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChartSegmento);
    google.charts.setOnLoadCallback(drawChartAdministradora);
    google.charts.setOnLoadCallback(drawChartEstado);
    //Grafico pizza vendas por segmentos
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
            legend: { position: 'right' },
            pieHole: 0.3,
            colors: <?php echo json_encode($coresSegmento); ?>,
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out'
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('graficoSegmento'));
        chart.draw(data, options);
    }
    
    //Grafico pizza vendas por segmentos
    function drawChartAdministradora() {
        var data = google.visualization.arrayToDataTable([
            <?php
            foreach ($adm as $i => $linha) {
                echo json_encode($linha);
                echo $i < count($adm) - 1 ? "," : "";
            }
            ?>
        ]);

         var options = {
            title: 'Vendas por Administradora',
            legend: { position: 'right' },
            pieHole: 0.3,
            colors: <?php echo json_encode($coresAdministradora); ?>,
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out'
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('graficoAdministradora'));
        chart.draw(data, options);
    }

    function drawChartEstado() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Estado');
        data.addColumn('number', 'Vendas');

        data.addRows(<?php echo json_encode($vendasEstado); ?>);

        var options = {
            title: 'Vendas por Estado',
            pieHole: 0.4, // pizza "donut"
            legend: { position: 'right' },
            colors: <?php echo json_encode($coresEstado); ?>, // <-- cores aleatórias
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out'
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('graficoEstado'));
        chart.draw(data, options);
    }

</script>

