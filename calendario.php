<?php

if($_SESSION["ST_ADMIN"] == 'G'){
    $v_filtro_empresa = "AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "";
    $v_filtro_colaborador = "";
} else if ($_SESSION["ST_ADMIN"] == 'C') {
    $v_filtro_empresa = "AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "";
    $v_filtro_colaborador = "AND nr_seq_usercadastro = " . $_SESSION["CD_USUARIO"] . "";
} else {
    $v_filtro_empresa = "";
    $v_filtro_colaborador = "";
}

// Busca as datas no banco
$SQL = "SELECT dt_agenda 
        FROM lead 
        WHERE nr_seq_situacao = 6
        " . $v_filtro_empresa . "
        " . $v_filtro_colaborador . "";
//echo "<pre>$SQL</pre>";
$RSS = mysqli_query($conexao, $SQL);
$datas = [];
while ($linha = mysqli_fetch_row($RSS)) {
    $datas[] = $linha[0];  // dt_agenda
}

// Converte para JSON
$datas_json = json_encode($datas);
?>

<head>
    <meta charset="UTF-8">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    
    <style>
       #calendar {
            background-color: #fff;
            margin: 20px auto;
            font-size: 0.8rem;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .fc .fc-daygrid-event {
            font-size: 1.5rem;
            font-weight: bold; 
        }

        .fc .fc-daygrid-day-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
        }

        .fc .fc-daygrid-day {
            background-color: #fdfdfd;
        }

        .fc .fc-day-sun, .fc .fc-day-sat {
            background-color: #f0f8ff;
        }

        .fc .fc-day-today {
            background-color: #ffeeba;
        }

        .fc .fc-col-header-cell-cushion {
            font-size: 1.5rem; 
            font-weight: bold; 
            color: #007bff;
        }

        .fc-toolbar-title {
            font-size: 2rem !important;
            color: #007bff !important;
            font-weight: bold;
        }

    </style>

</head>
<body>

    <div id="calendar"></div>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var datas = <?php echo $datas_json; ?>;

            var eventos = datas.map(function(data) {
                return {
                    title: 'Agendada',
                    start: data
                };
            });

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                height: 'auto',            
                contentHeight: 400,         
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: ''           
                },
                events: eventos
            });

            calendar.render();
        });
    </script>

</body>
