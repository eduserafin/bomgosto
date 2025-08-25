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
    ->setTitle("ASSINATURAS")
    ->setSubject("ASSINATURAS")
    ->setDescription("ASSINATURAS")
    ->setKeywords("ASSINATURAS")
    ->setCategory("ASSINATURAS");

$linha = 1;
$coluna = 0;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'EMPRESA');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'FORMA');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'VALOR');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'INÍCIO');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'FIM');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'OBSERVAÇÃO');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'STATUS');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$ultimaColuna = PHPExcel_Cell::stringFromColumnIndex($coluna);

$v_sql = "";

if ($empresa != 0) {
    $v_sql .= " AND a.nr_seq_empresa = $empresa";
}

if ($status != "") {
    $v_sql .= " AND a.st_status = '$status'";
}

if ($datai != "") {
    $v_sql .= " AND a.dt_cadastro >= '$datai'";
}

if ($dataf != "") {
    $v_sql .= " AND a.dt_cadastro <= '$dataf'";
}

    $SQL = "SELECT a.nr_sequencial, a.dt_inicio,
            a.dt_fim, a.vl_valor, a.ds_observacoes, e.ds_empresa,
            CASE 
                WHEN a.st_status = 'A' THEN 'ATIVO'
                WHEN a.st_status = 'I' THEN 'INATIVO'
                WHEN a.st_status = 'P' THEN 'PENDENTE'
                WHEN a.st_status = 'C' THEN 'CANCELADO'
                WHEN a.st_status = 'T' THEN 'TESTE'
                ELSE 'INDEFINIDO'
            END AS ds_status,
            CASE
                WHEN a.tp_forma = 'D' THEN 'DINHEIRO'
                WHEN a.tp_forma = 'P' THEN 'PIX'
                WHEN a.tp_forma = 'C' THEN 'CARTÃO'
                WHEN a.tp_forma = 'B' THEN 'BOLETO'
                ELSE 'INDEFINIDO'
            END AS ds_forma
            FROM assinaturas a
            INNER JOIN empresas e ON a.nr_seq_empresa = e.nr_sequencial
            WHERE 1 = 1 
            " . $v_sql . "
            ORDER BY a.nr_sequencial DESC";
    //echo "<pre>$SQL</pre>";
    $RSS = mysqli_query($conexao, $SQL);
    while ($lin = mysqli_fetch_row($RSS)) {
        $nr_sequencial = $lin[0];
        $dt_inicio = date('d/m/Y', strtotime($lin[1]));
        $dt_fim = date('d/m/Y', strtotime($lin[2]));
        $vl_valor = $lin[3];
        $ds_observacao = $lin[4];
        $ds_empresa = $lin[5];
        $ds_status = $lin[6];
        $ds_forma = $lin[7];

        if ($corlinha == "FFFFFF") {
            $corlinha = "DDDDDD";
        } else {
            $corlinha = "FFFFFF";
        }
        
        $linha++;
        $coluna = 0;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_empresa);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_forma);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $vl_valor);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $dt_inicio);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $dt_fim);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_observacao);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_status);
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

$objPHPExcel->getActiveSheet()->setTitle('ASSINATURAS');

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


$nome = "REL//ASSINATURAS" . date("d_m_Y_h_i_s") . ".xlsx";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($nome);
echo "<meta http-equiv=refresh content=0;url=$nome>";

?>
</body>

</html>

<script language="javascript">
    window.parent.document.getElementById('dvAguarde').style.display = 'none';
</script>