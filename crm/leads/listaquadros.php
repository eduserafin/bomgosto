<?php

foreach($_GET as $key => $value){
    $$key = $value;
}

if ($consulta == "sim") {
    require_once '../../conexao.php';
}

$v_sql = "";
 
$nome = $_GET['nome'];
$nome = mb_strtoupper($nome, 'UTF-8');
if ($nome != "") {
    $v_sql .= " AND ls.ds_nome like '%" . $nome . "%'";
}

$cidade = $_GET['cidade'];
if ($cidade != 0) {
    $v_sql .= " AND ls.nr_seq_cidade = $cidade";
}

$status = $_GET['status'];
if ($status != 0) {
    $v_sql .= " AND ls.nr_seq_situacao = $status";
}

$codigo = $_GET['codigo'];
if ($codigo != 0) {
    $v_sql .= " AND ls.nr_sequencial = $codigo";
}

$segmento = $_GET['segmento'];
if ($segmento != 0) {
    $v_sql .= " AND ls.nr_seq_segmento = $segmento";
}

$data1 = $_GET['data1'];
if ($data1 != "") {
    $v_sql .= " AND DATE(ls.dt_cadastro) >= '$data1'";
}

$data2 = $_GET['data2'];
if ($data2 != "") {
    $v_sql .= " AND DATE(ls.dt_cadastro) <= '$data2'";
}

$dataagenda1 = $_GET['dataagenda1'];
if ($dataagenda1 != "") {
    $v_sql .= " AND ls.dt_agenda >= '$dataagenda1'";
}

$dataagenda2 = $_GET['dataagenda2'];
if ($dataagenda2 != "") {
    $v_sql .= " AND ls.dt_agenda <= '$dataagenda2'";
}

if ($_SESSION["ST_ADMIN"] == 'G') {
    $v_filtro_empresa = "AND ls.nr_seq_empresa = " . $_SESSION["CD_EMPRESA"];
    $v_filtro_colaborador = "";
} elseif ($_SESSION["ST_ADMIN"] == 'C') {
    $v_filtro_empresa = "AND ls.nr_seq_empresa = " . $_SESSION["CD_EMPRESA"];
    $v_filtro_colaborador = "AND ls.nr_seq_usercadastro = " . $_SESSION["CD_USUARIO"];
} else {
    $v_filtro_empresa = "";
    $v_filtro_colaborador = "";
}
  function formatarTelefone($numero) {
    // Remove tudo que não é número
    $numero = preg_replace('/\D/', '', $numero);

    // Remove o 55 do início se existir
    if (substr($numero, 0, 2) === '55') {
        $numero = substr($numero, 2);
    }

    // Se tiver 11 dígitos: 9 dígitos + DDD
    if (strlen($numero) === 11) {
        return sprintf("(%s) %s-%s",
            substr($numero, 0, 2),
            substr($numero, 2, 5),
            substr($numero, 7, 4)
        );
    }
    // Se tiver 10 dígitos: 8 dígitos + DDD
    elseif (strlen($numero) === 10) {
        return sprintf("(%s) %s-%s",
            substr($numero, 0, 2),
            substr($numero, 2, 4),
            substr($numero, 6, 4)
        );
    }
    // Se tiver 9 dígitos (sem DDD): celular
    elseif (strlen($numero) === 9) {
        return sprintf("%s-%s",
            substr($numero, 0, 5),
            substr($numero, 5, 4)
        );
    }
    // Se tiver 8 dígitos (sem DDD): fixo
    elseif (strlen($numero) === 8) {
        return sprintf("%s-%s",
            substr($numero, 0, 4),
            substr($numero, 4, 4)
        );
    }
    // Caso não caiba em nenhum caso acima, retorna como está
    return $numero;
}

// Busca os status disponíveis
$SQL_STATUS = "SELECT nr_sequencial, ds_situacao FROM situacoes ORDER BY nr_ordem ASC";
$RS_STATUS = mysqli_query($conexao, $SQL_STATUS);
while ($row = mysqli_fetch_assoc($RS_STATUS)) {
    $status_list[$row['nr_sequencial']] = $row['ds_situacao'];
}

// Busca as leads separadas por status
$SQL_LEADS = "SELECT ls.nr_sequencial, ls.ds_nome, ls.vl_valor, ls.nr_seq_situacao, ls.nr_telefone, ls.dt_cadastro,
              ls.nr_seq_administradora, ls.ds_grupo, ls.nr_cota, ls.vl_contratado
              FROM lead ls
              WHERE 1=1
              "  . $v_sql . "
              "  . $v_filtro_empresa . "
              "  . $v_filtro_colaborador . "
              ORDER BY ls.dt_cadastro DESC";
$RS_LEADS = mysqli_query($conexao, $SQL_LEADS);

while ($row = mysqli_fetch_assoc($RS_LEADS)) {
    $leads_por_status[$row['nr_seq_situacao']][] = $row;
}

$status_colors = [
    'NOVA' => '#4a90e2',
    'AGENDADA' => '#8e44ad',
    'ANDAMENTO' => '#e67e22',
    'PERDIDA' => '#e74c3c',
    'CONTRATADO' => '#27ae60'
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Kanban Leads</title>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    body {
        margin: 0;
        font-family: "Segoe UI", sans-serif;
        background-color: #f2f4f8;
        color: #333;
    }
    .kanban-board {
        display: flex;
        overflow-x: auto;
        gap: 16px;
        padding: 20px;
        scroll-behavior: smooth;
    }
    .kanban-board::-webkit-scrollbar { height: 8px; }
    .kanban-board::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.2); border-radius: 4px; }
    .kanban-column {
        background: #ffffff;
        border-radius: 10px;
        min-width: 280px;
        max-width: 300px;
        display: flex;
        flex-direction: column;
        max-height: 85vh;
        overflow-y: auto;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .kanban-header {
        text-align: center;
        color: white;
        padding: 10px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        font-size: 15px;
        letter-spacing: 0.5px;
    }
    .kanban-list { padding: 10px; flex-grow: 1; }
    .kanban-item {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 10px;
        cursor: pointer;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: transform 0.1s ease, box-shadow 0.1s ease;
        font-size: 14px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .kanban-item:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    .kanban-nome { font-weight: 600; font-size: 15px; color: #333; }
    .kanban-telefone { font-weight: 500; color: #555; }
    .kanban-valor { font-weight: 500; color: #2e7d32; }
    .kanban-data { font-size: 12px; color: #888; }
</style>
</head>
<body>
<div class="kanban-board">
<?php foreach ($status_list as $status_id => $status_nome): 
    $color = $status_colors[strtoupper($status_nome)] ?? '#4a90e2'; ?>
    <div class="kanban-column">
        <div class="kanban-header" style="background: <?= $color ?>;">
            <?= htmlspecialchars($status_nome) ?> (<?= isset($leads_por_status[$status_id]) ? count($leads_por_status[$status_id]) : 0 ?>)
        </div>
        <div id="status-<?= $status_id ?>" class="kanban-list">
            <?php if (!empty($leads_por_status[$status_id])):
                foreach ($leads_por_status[$status_id] as $lead):
                $data_cadastro = date('d/m/Y H:i', strtotime($lead['dt_cadastro'])); ?>
                <div class="kanban-item" data-id="<?= $lead['nr_sequencial'] ?>" onclick="abrirLead(<?= $lead['nr_sequencial'] ?>)">
                    <div class="kanban-nome"><?= htmlspecialchars($lead['ds_nome']) ?></div>
                    <div class="kanban-telefone">📞 <?= htmlspecialchars(formatarTelefone($lead['nr_telefone'])) ?></div>
                    <div class="kanban-valor">💰 R$ <?= number_format($lead['vl_valor'], 2, ',', '.') ?></div>
                    <div class="kanban-data">📅 <?= $data_cadastro ?></div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
<?php endforeach; ?>
</div>
<script>
// Carregar campos obrigatórios para validação local
const leadsCamposObrigatorios = {};
<?php
foreach ($leads_por_status as $status_id => $leads_array) {
    foreach ($leads_array as $lead) {
        $id = $lead['nr_sequencial'];
        $nr_seq_administradora = json_encode($lead['nr_seq_administradora']);
        $ds_grupo = json_encode($lead['ds_grupo']);
        $nr_cota = json_encode($lead['nr_cota']);
        $vl_contratado = json_encode($lead['vl_contratado']);
        echo "leadsCamposObrigatorios[$id] = {nr_seq_administradora: $nr_seq_administradora, ds_grupo: $ds_grupo, nr_cota: $nr_cota, vl_contratado: $vl_contratado};\n";
    }
}
?>

window.parent.document.getElementById('dvAguarde').style.display = 'none';
document.querySelectorAll('.kanban-list').forEach(list => {
    new Sortable(list, {
        group: 'leads',
        animation: 150,
        onEnd: function (evt) {
            let leadId = evt.item.dataset.id;
            let newStatusId = evt.to.id.replace('status-', '');

            if (newStatusId == "3") {
                Swal.fire({
                    title: 'Informe a data de agendamento',
                    input: 'date',
                    inputAttributes: { required: true },
                    showCancelButton: true,
                    confirmButtonText: 'Salvar',
                    cancelButtonText: 'Cancelar',
                    preConfirm: (dataAgenda) => {
                        if (!dataAgenda) {
                            Swal.showValidationMessage('Informe a data');
                        }
                        return dataAgenda;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let dataAgenda = result.value;
                        atualizarStatusLead(leadId, newStatusId, dataAgenda);
                    } else {
                        evt.from.insertBefore(evt.item, evt.from.children[evt.oldIndex]);
                    }
                });
            } else if (newStatusId == "1") {
                let campos = leadsCamposObrigatorios[leadId];
                if (campos && campos.nr_seq_administradora && campos.ds_grupo && campos.nr_cota && campos.vl_contratado) {
                    atualizarStatusLead(leadId, newStatusId);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Campos obrigatórios faltando',
                        text: 'Antes de contratar, preencha: Administradora, Grupo, Cota e Valor Contratado.'
                    });
                    evt.from.insertBefore(evt.item, evt.from.children[evt.oldIndex]);
                }
            } else {
                atualizarStatusLead(leadId, newStatusId);
            }
        }
    });
});

function atualizarStatusLead(leadId, statusId, dataAgenda = "") {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "crm/leads/acao.php?Tipo=Q", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    let params = "id=" + encodeURIComponent(leadId) + "&status=" + encodeURIComponent(statusId);
    if (dataAgenda) {
        params += "&data_agenda=" + encodeURIComponent(dataAgenda);
    }
    xhr.send(params);
    xhr.onload = function() {
        if (xhr.status == 200) {
            console.log("Status atualizado:", xhr.responseText);
        } else {
            alert("Erro ao atualizar status!");
        }
    }
}

function abrirLead(id) {
    window.parent.document.getElementById('tabgeral').click();
    window.open("crm/leads/acao.php?Tipo=D&Codigo=" + id, "acao");
}
</script>
</body>
</html>
