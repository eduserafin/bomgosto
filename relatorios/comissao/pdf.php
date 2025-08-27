<?php
session_start();
include "../../conexao.php";

// Força charset UTF-8 na saída
header('Content-Type: text/html; charset=utf-8');

require __DIR__ . '/../../vendor/autoload.php';
use Dompdf\Dompdf;

// ==========================
// Entrada de parâmetros
// ==========================
foreach ($_GET as $key => $value) {
    $$key = $value;
}

$v_sql = "";
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


// ==========================
// Nome do colaborador
// ==========================
$nome = "";
$sql = "SELECT ds_colaborador FROM colaboradores WHERE nr_sequencial = $colaborador";
$res = mysqli_query($conexao, $sql);
if ($lin = mysqli_fetch_row($res)) {
    $nome = $lin[0];
}

// ==========================
// Montagem do HTML
// ==========================

$html = "<html>
<head>
<meta charset='utf-8'>
<style>
body { font-family: DejaVu Sans, sans-serif; font-size: 8px; }
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid #000; padding: 3px; text-align: center; }
th { background-color: #f2f2f2; }
h3 { text-align: center; }
</style>
<title>RELATÓRIO DE COMISSÃO</title>
</head>
<body>
<h3>RELATÓRIO DE COMISSÃO - {$nome}</h3>
<table>
<tr>
<th>COLABORADOR</th>
<th>ADMINISTRADORA</th>
<th>SEGMENTO</th>
<th>GRUPO</th>
<th>COTA</th>
<th>REALIZADO</th>
<th>PARCELAS</th>
<th>CONTRATADO</th>
<th>COMISSÃO</th>
<th>VALOR</th>
<th>DATA</th>
<th>STATUS</th>
</tr>";

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

$RSS = mysqli_query($conexao, $SQL);
while ($linha = mysqli_fetch_row($RSS)) {
    list($nr_seq_lead, $vl_considerado, $dt_contratada, $ds_segmento, $ds_grupo, $ds_cota, $nr_parcela, $vl_comissao, $vl_parcela, $dt_status, $nr_seq_pagamento, 
    $ds_administradora, $total_parcelas, $ordem_parcela, $st_status, $ds_colaborador, $nr_seq_colaborador, $nr_seq_administradora, $ds_status) = $linha;

    $valor_considerado = number_format($vl_considerado, 2, ',', '.');
    $dt_contratada_fmt = date('d/m/Y', strtotime($dt_contratada));
    $dt_status_fmt = $dt_status ? date('d/m/Y', strtotime($dt_status)) : '';
    $valor_parcela_fmt = number_format($vl_parcela, 2, ',', '.');
    $valor_comissao_fmt = number_format($vl_comissao, 2, ',', '.');
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

    $html .= "<tr>
                <td>" . $v_tachado . $ds_colaborador . $v_tachado2 . "</td>
                <td>" . $v_tachado . $ds_administradora . $v_tachado2 . "</td>
                <td>" . $v_tachado . $ds_segmento . $v_tachado2 . "</td>
                <td>" . $v_tachado . $ds_grupo . $v_tachado2 . "</td>
                <td>" . $v_tachado . $ds_cota . $v_tachado2 . "</td>
                <td>" . $v_tachado . $dt_contratada_fmt . $v_tachado2 . "</td>
                <td>" . $v_tachado . $descricao_parcela . $v_tachado2 . "</td>
                <td align='right'>" . $v_tachado . $valor_considerado . $v_tachado2 . "</td>
                <td align='right'>" . $v_tachado . $valor_comissao_fmt . $v_tachado2 . "</td>
                <td align='right'>" . $v_tachado . $valor_parcela_fmt . $v_tachado2 . "</td>
                <td>" . $v_tachado . $dt_status_fmt . $v_tachado2 . "</td>
                <td>" . $v_tachado . $ds_status . $v_tachado2 . "</td>
            </tr>";

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

        $html .= "<tr style='color: red;'>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align='right'>" . $ds_parcela_estorno . "</td>
                    <td></td>
                    <td align='right'>" . $valor_percentual . "</td>
                    <td align='right'>" . $valor_estorno . "</td>
                    <td align='right'>" . $dt_status_estorno . "</td>
                    <td align='right' style='color: black;'>" . $ds_status_estorno . "</td>
                </tr>";

    }
}

$html .= "<tr style='font-weight:bold; background-color:#d9d9d9;'>
            <td colspan='7' style='text-align:left;'>Total Comissões</td>
            <td align='right'>" . number_format($total_considerado, 2, ',', '.') . "</td>
            <td align='right'>" . number_format($total_comissao, 2, ',', '.') . "</td>
            <td align='right'>" . number_format($total_parcela, 2, ',', '.') . "</td>
            <td></td>
            <td></td>
        </tr>";

$html .= "<tr style='font-weight:bold; background-color:#d9d9d9;'>
            <td colspan='7' style='text-align:left;'>Total Estornos</td>
            <td align='right'>" . number_format($total_desconsiderado, 2, ',', '.') . "</td>
            <td align='right'>" . number_format($total_percentual, 2, ',', '.') . "</td>
            <td align='right'>" . number_format($total_estorno, 2, ',', '.') . "</td>
            <td></td>
            <td></td>
        </tr>";

$html .= "<tr style='font-weight:bold; background-color:#d9d9d9;'>
            <td colspan='7' style='text-align:left;'>Total Líquido</td>
            <td></td>
            <td align='right' colspan='2'>" . number_format($total_parcela - $total_estorno, 2, ',', '.') . "</td>
            <td></td>
            <td></td>
        </tr>";

$html .= "</table>
<br><br><br>
<table width='100%' style='border:0;'>
<tr>
    <td style='border:0; text-align:center;'>
        ___________________________________<br>
        {$nome}
    </td>
</tr>
</table>
</body>
</html>";

// ==========================
// Gerar PDF com DomPDF Novo
// ==========================
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("comissoes_" . preg_replace("/[^a-zA-Z0-9]/", "_", $nome) . ".pdf", ["Attachment" => 0]);

exit;
?>
