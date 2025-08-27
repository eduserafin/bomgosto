<?php

foreach ($_GET as $key => $value) {
    $$key = $value;
}

session_start();
include '../../conexao.php';

/** Include PHPExcel */
require_once '../../Excel/Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()
    ->setTitle("CHAMADOS")
    ->setSubject("CHAMADOS")
    ->setDescription("CHAMADOS")
    ->setKeywords("CHAMADOS")
    ->setCategory("CHAMADOS");

$linha = 1;
$coluna = 0;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'EMPRESA');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'CATEGORIA');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'PRIORIDADE');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'STATUS');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'DATA ABERTURA');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'DATA FECHAMENTO');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'TÍTULO');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'DESCRIÇÃO');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$ultimaColuna = PHPExcel_Cell::stringFromColumnIndex($coluna);

    $v_sql = "";

    if ($empresa != 0) {
        $v_sql .= " AND c.nr_seq_empresa = $empresa";
    }

    $titulo = mb_strtoupper($titulo, 'UTF-8');
    if ($titulo != "") {
        $v_sql .= " AND c.ds_titulo like '%" . $titulo . "%'";
    }

    if ($categoria != "") {
        $v_sql .= " AND c.st_categoria = '$categoria'";
    }

    if ($prioridade != "") {
        $v_sql .= " AND c.st_prioridade = '$prioridade'";
    }

    if ($status != "") {
        $v_sql .= " AND c.st_status = '$status'";
    }

    if ($abertura != "") {
        $v_sql .= " AND c.dt_abertura >= '$abertura'";
    }

    if ($fechamento != "") {
        $v_sql .= " AND c.dt_fechamento <= '$fechamento'";
    }

    $SQL = "SELECT c.nr_sequencial, e.ds_empresa, c.dt_abertura, c.dt_fechamento, c.ds_titulo, c.ds_descricao,
            CASE 
                WHEN c.st_status = 'A' THEN 'ABERTO'
                WHEN c.st_status = 'E' THEN 'EM ANDAMENTO'
                WHEN c.st_status = 'P' THEN 'PARADO'
                WHEN c.st_status = 'C' THEN 'CONCLUÍDO'
                ELSE 'INDEFINIDO'
            END AS ds_status,
            CASE
                WHEN c.st_categoria = 'I' THEN 'IDEIA'
                WHEN c.st_categoria = 'C' THEN 'CORREÇÃO'
                WHEN c.st_categoria = 'O' THEN 'SOLICITAÇÃO'
                WHEN c.st_categoria = 'S' THEN 'SUPORTE'
                ELSE 'INDEFINIDO'
            END AS ds_categoria,
            CASE
                WHEN c.st_prioridade = 'A' THEN 'ALTA'
                WHEN c.st_prioridade = 'M' THEN 'MÉDIA'
                WHEN c.st_prioridade = 'B' THEN 'BAIXA'
                ELSE 'INDEFINIDO'
            END AS ds_prioridade
            FROM chamados c
            INNER JOIN empresas e ON c.nr_seq_empresa = e.nr_sequencial
            WHERE 1 = 1 
            " . $v_sql . "
            ORDER BY c.nr_sequencial DESC";
    echo "<pre>$SQL</pre>";
    $RSS = mysqli_query($conexao, $SQL);
    while ($lin = mysqli_fetch_row($RSS)) {
        $nr_sequencial = $lin[0];
        $ds_empresa = $lin[1];
        $dt_abertura = $lin[2];
        if($dt_abertura != "") { $dt_abertura = date('d/m/Y', strtotime($dt_abertura)); }
        $dt_fechamento = $lin[3];
        if($dt_fechamento != "") { $dt_fechamento = date('d/m/Y', strtotime($dt_fechamento)); }
        $ds_titulo = $lin[4];
        $ds_descricao = $lin[5];
        $ds_status = $lin[6];
        $ds_categoria = $lin[7];
        $ds_prioridade = $lin[8];

        if ($corlinha == "FFFFFF") {
            $corlinha = "DDDDDD";
        } else {
            $corlinha = "FFFFFF";
        }
        
        $linha++;
        $coluna = 0;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_empresa);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_categoria);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_prioridade);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_status);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $dt_abertura);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $dt_fechamento);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_titulo);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_descricao);
        $coluna++;
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $ultimaColuna . $linha)->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => $corlinha)
                ),
            )
        );
    }

$objPHPExcel->getActiveSheet()->setTitle('CHAMADOS');

for($lin_pl=0;$lin_pl<=$linha;$lin_pl++){
    $objPHPExcel->getActiveSheet()->getStyle('C' . $lin_pl)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
}

$objPHPExcel->getActiveSheet()->getStyle('A1:' . $ultimaColuna . '1')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '354C61')
        ),
    )
);
$phpColor = new PHPExcel_Style_Color();
$phpColor->setRGB('FFFFFF');
$objPHPExcel->getActiveSheet()->getStyle('A1:' . $ultimaColuna . '1')->getFont()->setColor($phpColor);
$objPHPExcel->getActiveSheet()->getStyle('A1:' . $ultimaColuna . '1')->getFont()->setBold(true);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


$nome = "REL//CHAMADOS" . date("d_m_Y_h_i_s") . ".xlsx";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($nome);
echo "<meta http-equiv=refresh content=0;url=$nome>";

?>
</body>

</html>

<script language="javascript">
    window.parent.document.getElementById('dvAguarde').style.display = 'none';
</script>