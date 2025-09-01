<?php
//require_once '../../config/servers.php';

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
    ->setTitle("LEADS")
    ->setSubject("LEADS")
    ->setDescription("LEADS")
    ->setKeywords("LEADS")
    ->setCategory("LEADS");

$linha = 1;
$coluna = 0;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'VENDEDOR');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'CLIENTE');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'CIDADE');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'ESTADO');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'CONTATO');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'EMAIL');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'DATA LEAD');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'DATA AGENDA');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'SEGMENTO');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'STATUS');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'GRUPO');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'COTA');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'ADMINISTRADORA');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'VALOR CONTRATADO');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, '% CRÉDITO REDUZIDO');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'VALOR FINAL');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'VALOR SOLICITADO');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$ultimaColuna = PHPExcel_Cell::stringFromColumnIndex($coluna);

    if ($nome != "") {
        $v_sql .= " AND ls.ds_nome like UPPER('%" . $nome . "%')";
    }

    if ($cidade != 0) {
        $v_sql .= " AND ls.nr_seq_cidade = $cidade";
    }

    if ($status != 0) {
        $v_sql .= " AND ls.nr_seq_situacao = $status";
    }

    if ($segmento != 0) {
        $v_sql .= " AND ls.nr_seq_segmento = $segmento";
    }

    if ($data1 != "") {
        $v_sql .= " AND ls.dt_cadastro >= '$data1'";
    }

    if ($data2 != "") {
        $v_sql .= " AND ls.dt_cadastro <= '$data2'";
    }

    if ($dataagenda1 != "") {
        $v_sql .= " AND ls.dt_agenda >= '$dataagenda1'";
    }

    if ($dataagenda2 != "") {
        $v_sql .= " AND ls.dt_agenda <= '$dataagenda2'";
    }

    if($_SESSION["ST_ADMIN"] == 'G'){
        $v_filtro_empresa = "AND ls.nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "";
        $v_filtro_colaborador = "";
    } else if ($_SESSION["ST_ADMIN"] == 'C') {
        $v_filtro_empresa = "AND ls.nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "";
        $v_filtro_colaborador = "AND ls.nr_seq_usercadastro = " . $_SESSION["CD_USUARIO"] . "";
    } else {
        $v_filtro_empresa = "";
        $v_filtro_colaborador = "";
    }

    $SQL = "SELECT ls.nr_sequencial, ls.ds_nome, ls.vl_valor, ls.dt_cadastro, s.ds_segmento, ls.nr_telefone, 
            c.ds_municipio, e.sg_estado, st.ds_situacao, ls.ds_email, ls.dt_agenda, a.ds_administradora, ls.ds_grupo,
            ls.nr_cota, ls.pc_reduzido, ls.vl_contratado, ls.vl_considerado, co.ds_colaborador
            FROM lead ls
            INNER JOIN usuarios u ON u.nr_sequencial = ls.nr_seq_usercadastro
            INNER JOIN colaboradores co ON u.nr_seq_colaborador = co.nr_sequencial
            LEFT JOIN cidades c ON c.nr_sequencial = ls.nr_seq_cidade
            LEFT JOIN estados e ON c.nr_seq_estado = e.nr_sequencial
            LEFT JOIN segmentos s ON ls.nr_seq_segmento = s.nr_sequencial
            LEFT JOIN situacoes st ON ls.nr_seq_situacao = s.nr_sequencial
            LEFT JOIN administradoras a ON ls.nr_seq_administradora = a.nr_sequencial
            WHERE 1 = 1 
            "  . $v_sql . "
            "  . $v_filtro_empresa . "
            "  . $v_filtro_colaborador . "
            ORDER BY ls.nr_sequencial DESC";
    echo "<pre>$SQL</pre>";
    $RSS = mysqli_query($conexao, $SQL);
    while ($lin = mysqli_fetch_row($RSS)) {
        $nr_sequencial = $lin[0];
        $ds_nome = $lin[1];
        $vl_valor = $lin[2]; 
        $dt_cadastro = date('d/m/Y', strtotime($lin[3]));
        $ds_segmento = $lin[4];
        $contato = $lin[5];
        $municipio = $lin[6];
        $estado = $lin[7];
        $ds_situacao = $lin[8];
        $ds_email = $lin[9];
        $dt_agenda = $lin[10];
        $ds_administradora = $lin[11];
        $ds_grupo = $lin[12];
        $nr_cota = $lin[13];
        $pc_reduzido = $lin[14];
        if($pc_reduzido == "") { $pc_reduzido = 0; }
        $vl_contratado = $lin[15];
        $vl_considerado = $lin[16];
        $ds_colaborador = $lin[17];

        if($vl_contratado == ""){
            $valor = $vl_valor;
        } else {
            $valor = $vl_contratado;
        }

        if ($corlinha == "FFFFFF") {
            $corlinha = "DDDDDD";
        } else {
            $corlinha = "FFFFFF";
        }
        
        $linha++;
        $coluna = 0;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_colaborador);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_nome);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $municipio);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $estado);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $contato);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_email);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $dt_cadastro);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $dt_agenda);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_segmento);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_situacao);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_grupo);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $nr_cota);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_administradora);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $vl_contratado);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $pc_reduzido);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $vl_considerado);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $vl_valor);
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

$objPHPExcel->getActiveSheet()->setTitle('LEADS');

for($lin_pl=0;$lin_pl<=$linha;$lin_pl++){
    $objPHPExcel->getActiveSheet()->getStyle('M' . $lin_pl)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    $objPHPExcel->getActiveSheet()->getStyle('O' . $lin_pl)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    $objPHPExcel->getActiveSheet()->getStyle('P' . $lin_pl)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
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

for($lin_pl=0;$lin_pl<=$linha;$lin_pl++){
    $objPHPExcel->getActiveSheet()->getStyle('B' . $lin_pl)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
}

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


$nome = "REL//LEADS" . date("d_m_Y_h_i_s") . ".xlsx";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($nome);
echo "<meta http-equiv=refresh content=0;url=$nome>";

?>
</body>

</html>

<script language="javascript">
    window.parent.document.getElementById('dvAguarde').style.display = 'none';
</script>