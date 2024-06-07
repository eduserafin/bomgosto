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
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'NOME');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'VALOR');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'CIDADE');
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
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'PRODUTO');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'TIPO');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'STATUS');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'MENSAGEM');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'DATA|HORA COMENTÁRIO');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$coluna++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, 'COMENTÁRIOS');
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($coluna)->setAutoSize(true);
$ultimaColuna = PHPExcel_Cell::stringFromColumnIndex($coluna);

    if ($nome != "") {
        $v_sql .= " AND ls.ds_nome like UPPER('%" . $nome . "%')";
    }

    if ($credito != "") {
        $v_sql .= " AND ls.vl_valor = $credito";
    }

    if ($cidade != 0) {
        $v_sql .= " AND ls.nr_seq_cidade = $cidade";
    }

    if ($status != "") {
        $v_sql .= " AND ls.st_situacao = '$status'";
    }

    if ($tipo != "") {
        $v_sql .= " AND ls.tp_tipo = $tipo";
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

    $SQL = "SELECT ls.nr_sequencial, ls.ds_nome, ls.vl_valor, ls.dt_cadastro, ps.ds_produto,
            CONCAT(ls.nr_whatsapp, ' - ', ls.nr_telefone) AS contato, 
            CONCAT(m.ds_municipioibge, ' - ', m.sg_estado) AS municipio_estado,
            ls.tp_tipo, ls.st_situacao, ls.ds_email, ls.ds_mensagem, ls.dt_agenda
            FROM lead_site ls
            INNER JOIN municipioibge m ON m.cd_municipioibge = ls.nr_seq_cidade
            LEFT JOIN produtos_site ps ON ls.nr_seq_produto = ps.nr_sequencial
            WHERE 1 = 1  
            $v_sql
            ORDER BY ls.nr_sequencial DESC";
    //echo "<pre>$SQL</pre>";
    $RSS = mysqli_query($conexao, $SQL);
    while ($linha1 = mysqli_fetch_row($RSS)) {
        $nr_sequencial = $linha1[0];
        $ds_nome = $linha1[1];
        $vl_valor = $linha1[2]; 
        $valor = number_format($vl_valor / 100, 2, ',', '.');
        $dt_cadastro = date('d/m/Y', strtotime($linha1[3]));
        $ds_produto = $linha1[4];
        $contato = $linha1[5];
        $municipio_estado = $linha1[6];
        $tp_tipo = $linha1[7];
        $st_situacao = $linha1[8];
        $ds_email = $linha1[9];
        $ds_mensagem = $linha1[10];
        $dt_agenda = $linha1[11];
        if($dt_agenda != ""){ $dt_agenda = date('d/m/Y', strtotime($dt_agenda));}

        $dstipo = '';
        if($tp_tipo == 'S'){
            $dstipo = 'SIMULAÇÃO';
        } else if ($tp_tipo == 'C'){
            $dstipo = 'CONTATO';
        } else {
            $dstipo = '';
        }

        $dsstatus = '';
        if($st_situacao == 'N'){
            $dsstatus = 'NOVO';
        } else if ($st_situacao == 'C'){
            $dsstatus = 'CONTATO';
        } else if ($st_situacao == 'P'){
            $dsstatus = 'PERDIDA';
        } else if ($st_situacao == 'E'){
            $dsstatus = 'EM ANDAMENTO';
        } else if ($st_situacao == 'T'){
            $dsstatus = 'CONTRATADA';
        } else {
            $dsstatus = '';
        }

        if ($corlinha == "FFFFFF") {
            $corlinha = "DDDDDD";
        } else {
            $corlinha = "FFFFFF";
        }

        $linha++;
        $coluna = 0;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_nome);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $vl_valor);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $municipio_estado);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $contato);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_email);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $dt_cadastro);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $dt_agenda);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_produto);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $dstipo);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $dsstatus);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $ds_mensagem);
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, '');
        $coluna++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, '');
        $coluna++;

        $SQL0 = "SELECT UPPER(ds_comentario), dt_cadastro, ds_arquivo
                    FROM lead_anexos  
                WHERE nr_seq_lead = $nr_sequencial
                ORDER BY nr_sequencial ASC"; //echo $SQL0;
        $RS0 = mysqli_query($conexao, $SQL0);
        while ($linha_comentario = mysqli_fetch_row($RS0)) {
            $ds_comentario = $linha_comentario[0];
            $dt_comentario = $linha_comentario[1];
            $ds_anexo = $linha_comentario[2];
            if($dt_comentario != "") { $dt_comentario = date('d/m/Y H:i', strtotime($dt_comentario)); }
    
            $comentario = "";
            if($ds_comentario == ""){
                $comentario = $ds_anexo;
            } else {
                $comentario = $ds_comentario;
            }

            $linha++;
            $coluna = 0;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, '');
            $coluna++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, '');
            $coluna++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, '');
            $coluna++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, '');
            $coluna++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, '');
            $coluna++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, '');
            $coluna++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, '');
            $coluna++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, '');
            $coluna++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, '');
            $coluna++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, '');
            $coluna++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, '');
            $coluna++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $dt_comentario);
            $coluna++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($coluna, $linha, $comentario);
            $coluna++;

        }
    

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