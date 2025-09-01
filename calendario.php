<?php

if($_SESSION["ST_ADMIN"] == 'G'){
    $v_filtro_empresa = "AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"];
    $v_filtro_colaborador = "";
} else if ($_SESSION["ST_ADMIN"] == 'C') {
    $v_filtro_empresa = "AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"];
    $v_filtro_colaborador = "AND nr_seq_usercadastro = " . $_SESSION["CD_USUARIO"];
} else {
    $v_filtro_empresa = "";
    $v_filtro_colaborador = "";
}


$SQL = "SELECT nr_sequencial, dt_agenda 
        FROM lead 
        WHERE nr_seq_situacao = 3
        " . $v_filtro_empresa . "
        " . $v_filtro_colaborador;

$RSS = mysqli_query($conexao, $SQL);

$datas = [];
while ($linha = mysqli_fetch_assoc($RSS)) {
    $datas[] = [
        'nr_sequencial' => $linha['nr_sequencial'],
        'dt_agenda' => $linha['dt_agenda']
    ];
}

$datas_json = json_encode($datas);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Calendário de Agendamentos</title>

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">

    <style>
       #calendar {
            background-color: #fff;
            margin: 0px auto;
            font-size: 0.8rem;
            border: 0px solid #ddd;
            padding: 0px;
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
        function detalharLead(nr_sequencial) {
            const url = "https://conectasys.com/dashboard.php?form=crm/leads/index.php&id_menu=3&ds_men=Leads&ds_mod=CRM&id_smenu=11&codigo=" 
                + encodeURIComponent(nr_sequencial) + "&tab=lista";
            window.open(url, '_blank');
        }

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var datas = <?php echo $datas_json; ?>;

            var eventos = datas.map(function(item) {
                return {
                    title: 'Agenda',
                    start: item.dt_agenda,
                    id: item.nr_sequencial
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
                events: eventos,
                eventClick: function(info) {
                    detalharLead(info.event.id);
                },
                eventContent: function(arg) {
                    return { 
                        html: '<div style="background-color: red; color: white; font-weight: bold; padding: 2px 4px; border-radius: 3px;">Agenda</div>' 
                    };
                }
            });

            calendar.render();
        });
    </script>

</body>
</html>
