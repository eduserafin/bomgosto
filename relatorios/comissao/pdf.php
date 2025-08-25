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

$status = $_GET['status'];
if ($status == 'P') {
    $v_sql .= " AND p.st_status = 'P'";
} else if($status == 'S'){
    $v_sql .= " AND p.st_status = 'S'";
}

$mes = $_GET['mes'];
$ano = $_GET['ano'];
$dia = 10;
$data = "$ano-$mes-$dia";

// ==========================
// Controle de perfil
// ==========================
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
body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
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
<th>VALOR</th>
<th>DATA CONTRATADA</th>
<th>ADMINISTRADORA</th>
<th>GRUPO</th>
<th>COTA</th>
<th>SEGMENTO</th>
<th>PARCELAS</th>
<th>COMISSÃO PARCELA</th>
<th>VALOR PARCELA</th>
<th>DATA PAGAMENTO</th>
</tr>";

$total_considerado = 0;
$total_comissao = 0;
$total_parcela = 0;

$SQL = "SELECT ls.nr_sequencial, ls.vl_considerado, ls.dt_contratada, s.ds_segmento, ls.ds_grupo, ls.nr_cota,
        p.nr_parcela, p.vl_comissao, p.vl_parcela, p.dt_pagamento, p.st_status, a.ds_administradora,
        (SELECT COUNT(*) FROM pagamentos p2 WHERE p2.nr_seq_lead = ls.nr_sequencial) AS total_parcelas,
         CASE 
            WHEN p.st_status = 'S' THEN 'PAGO AO VENDEDOR'
            WHEN p.st_status = 'P' THEN 'PENDENTE CLIENTE'
            ELSE 'AGUARDANDO'
        END AS ds_status
        FROM lead ls
        INNER JOIN segmentos s ON ls.nr_seq_segmento = s.nr_sequencial
        INNER JOIN usuarios u ON ls.nr_seq_usercadastro = u.nr_sequencial
        INNER JOIN colaboradores c ON u.nr_seq_colaborador = c.nr_sequencial
        INNER JOIN pagamentos p ON ls.nr_sequencial = p.nr_seq_lead
        INNER JOIN administradoras a ON ls.nr_seq_administradora = a.nr_sequencial
        WHERE ls.nr_seq_situacao = 1
        AND p.dt_parcela = '$data'
        $v_sql
        $v_filtro_empresa
        $v_filtro_colaborador
        ORDER BY ls.dt_contratada";

$RSS = mysqli_query($conexao, $SQL);
while ($linha = mysqli_fetch_row($RSS)) {
    list($nr_seq_lead, $vl_considerado, $dt_contratada, $ds_segmento, $ds_grupo, $ds_cota,
         $nr_parcela, $vl_comissao, $vl_parcela, $dt_pagamento, $st_status, $ds_administradora, $total_parcelas, $ds_status) = $linha;

    $valor_considerado = number_format($vl_considerado, 2, ',', '.');
    $dt_contratada_fmt = date('d/m/Y', strtotime($dt_contratada));
    $dt_pagamento_fmt = $dt_pagamento ? date('d/m/Y', strtotime($dt_pagamento)) : '';
    $valor_parcela_fmt = number_format($vl_parcela, 2, ',', '.');
    $valor_comissao_fmt = number_format($vl_comissao, 2, ',', '.');
    $descricao_parcela = "Parcela $nr_parcela de $total_parcelas";

    $v_tachado = "";
    $v_tachado2 = "";
    if($st_status == 'P'){
      $v_tachado = "<s>";
      $v_tachado2 = "</s>";
    } else {
      $v_tachado = "";
      $v_tachado2 = "";
    }

      $total_considerado += $vl_considerado;

    // Acumulando os totais
    if ($st_status != 'P') {
      $total_comissao += $vl_comissao;
      $total_parcela += $vl_parcela;
    }

    $html .= "<tr>
                <td align='right'>" . $v_tachado . $valor_considerado . $v_tachado2 . "</td>
                <td>" . $v_tachado . $dt_contratada_fmt . $v_tachado2 . "</td>
                <td>" . $v_tachado . $ds_administradora . $v_tachado2 . "</td>
                <td>" . $v_tachado . $ds_grupo . $v_tachado2 . "</td>
                <td>" . $v_tachado . $ds_cota . $v_tachado2 . "</td>
                <td>" . $v_tachado . $ds_segmento . $v_tachado2 . "</td>
                <td>" . $v_tachado . $descricao_parcela . $v_tachado2 . "</td>
                <td align='right'>" . $v_tachado . $valor_comissao_fmt . $v_tachado2 . "</td>
                <td align='right'>" . $v_tachado . $valor_parcela_fmt . $v_tachado2 . "</td>
                <td>" . $v_tachado . $dt_pagamento_fmt . $v_tachado2 . "</td>
            </tr>";
}

$html .= "<tr style='font-weight:bold; background-color:#d9d9d9;'>
    <td align='right'>" . number_format($total_considerado, 2, ',', '.') . "</td>
    <td colspan='6'>TOTAIS DE COMISSÕES PAGAS</td>
    <td align='right'>" . number_format($total_comissao, 2, ',', '.') . "</td>
    <td align='right'>" . number_format($total_parcela, 2, ',', '.') . "</td>
    <td></td>
</tr>";

$html .= "</table>";

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
