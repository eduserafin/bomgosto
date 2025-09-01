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
    
    // Vendas por colaboradores
    $colaboradores = [];
    $sql4 = "SELECT c.ds_colaborador, SUM(l.vl_contratado) AS total 
            FROM lead l 
            JOIN usuarios u ON l.nr_seq_usercadastro = u.nr_sequencial 
            JOIN colaboradores c ON u.nr_seq_colaborador = c.nr_sequencial 
            WHERE l.nr_seq_situacao = 1
            "  . $v_filtro_contratada . "
            "  . $v_filtro_empresa . "
            "  . $v_filtro_colaborador . "
            GROUP BY c.ds_colaborador 
            ORDER BY total DESC";
    
    $res4 = $conexao->query($sql4);
    while ($row4 = $res4->fetch_assoc()) {
        $colaboradores[] = [$row4['ds_colaborador'], (int)$row4['total']];
    }
    
    // Reordena para que o maior fique no centro
    $ranking = [];
    $left = true;
    foreach ($colaboradores as $i => $c) {
        if ($i === 0) {
            $ranking[] = $c; // Maior no centro
        } else {
            if ($left) {
                array_unshift($ranking, $c);
            } else {
                array_push($ranking, $c);
            }
            $left = !$left;
        }
    }
    
    //Comparativo mês
   $sql5 = "SELECT 
            DATE_FORMAT(l.dt_contratada, '%M/%Y') AS mes_nome,
            COUNT(*) AS quantidade_vendas,
            SUM(l.vl_contratado) AS valor_total
            FROM lead l
            WHERE l.nr_seq_situacao = 1
            "  . $v_filtro_contratada . "
            "  . $v_filtro_empresa . "
            AND l.dt_contratada >= DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH, '%Y-%m-01')
            GROUP BY DATE_FORMAT(l.dt_contratada, '%Y-%m')
            ORDER BY MIN(l.dt_contratada)";
    //echo "<pre>$sql5</pre>";  
    $res5 = mysqli_query($conexao, $sql5);
    
    $comparativo = [];
    while ($row5 = mysqli_fetch_assoc($res5)) {
        $comparativo[] = [
            $row5['mes_nome'], 
            (int)$row5['quantidade_vendas'], 
            (float)$row5['valor_total']
        ];
    }

    // Funil de vendas por situação
    $funil = [["Situação", "Quantidade"]];
    $sql1 = "SELECT s.ds_situacao, COUNT(*) AS total 
            FROM lead l 
            JOIN situacoes s ON l.nr_seq_situacao = s.nr_sequencial 
            WHERE 1 = 1
            "  . $v_filtro_cadastro . "
            "  . $v_filtro_empresa . "
            "  . $v_filtro_colaborador . "
            GROUP BY s.ds_situacao ORDER BY total DESC";
    $res1 = $conexao->query($sql1);
    while ($row = $res1->fetch_assoc()) {
        $funil[] = [$row['ds_situacao'], (int)$row['total']];
    }

?>

<div class="col-md-12">    
    <!-- GRAFICO DE BARRAS VENDAS POR COLABORADOR -->
    <div class="col-md-4">
        <div id="graficoColaboradores" style="height: 400px;"></div>
    </div>

    <!-- GRAFICO COMPARATIVO MÊS -->
    <div class="col-md-4">
        <div id="graficoComparativo" style="height: 400px;"></div>
    </div>

    <!-- GRAFICO DE BARRAS FUNIL DE VENDAS -->
    <div class="col-md-4">
        <div id="graficoFunil" style="height: 400px;"></div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChartColaborador);
    google.charts.setOnLoadCallback(drawChartComparativo);
    google.charts.setOnLoadCallback(drawChartFunil);
    
    function drawChartColaborador() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Colaborador');
        data.addColumn('number', 'Quantidade');
    
        data.addRows(<?php echo json_encode($ranking); ?>);
    
        var options = {
            title: 'Ranking de Vendas por Colaboradores',
            legend: { position: 'none' },
            bars: 'horizontal',
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out'
            }
        };
    
        var chart = new google.visualization.BarChart(document.getElementById('graficoColaboradores'));
        chart.draw(data, options);
    }
    
    function drawChartComparativo() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Mês');
        data.addColumn('number', 'Quantidade');
        data.addColumn('number', 'Valor');
    
        data.addRows(<?php echo json_encode($comparativo); ?>);
    
        var options = {
            title: 'Comparativo de Vendas (Mês Anterior x Atual)',
            legend: { position: 'top' },
            bars: 'vertical',
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out'
            },
            vAxes: {
                0: {title: 'Quantidade', minValue: 0},
                1: {title: 'Valor (R$)', minValue: 0}
            },
            series: {
                0: {targetAxisIndex: 0}, // Quantidade usa eixo 0
                1: {targetAxisIndex: 1}  // Valor usa eixo 1
            }
        };
    
        var chart = new google.visualization.ColumnChart(document.getElementById('graficoComparativo'));
        chart.draw(data, options);
    }

     //Grafico barras funil de vendas (status)
    function drawChartFunil() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Situação');
        data.addColumn('number', 'Quantidade');
        data.addColumn({type: 'string', role: 'style'});

        <?php
        $cores_status = [
            'NOVA' => '#4a90e2',
            'AGENDADA' => '#8e44ad',
            'ANDAMENTO' => '#e67e22',
            'PERDIDA' => '#e74c3c',
            'CONTRATADO' => '#27ae60'
        ];

        foreach ($funil as $i => $linha) {
            if ($i === 0) continue; // pula cabeçalho
            $nome = strtoupper($linha[0]);
            $quantidade = $linha[1];
            $cor = isset($cores_status[$nome]) ? $cores_status[$nome] : '#7f8c8d';
            echo "data.addRow(['{$linha[0]}', {$quantidade}, 'color: {$cor}']);";
        }
        ?>

        var options = {
            title: 'Funil de Vendas',
            legend: { position: 'none' },
            bar: { groupWidth: "60%" },
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out'
            }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('graficoFunil'));
        chart.draw(data, options);
    }

</script>

