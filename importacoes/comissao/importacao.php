<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require '../../vendor/autoload.php';
include "../../conexao.php";

use Smalot\PdfParser\Parser;

// Verifica se veio arquivo e administradora
if (!isset($_FILES['arquivo']) || $_FILES['arquivo']['error'] !== UPLOAD_ERR_OK) {
    die("Erro no upload do arquivo!");
}

if (empty($_POST['seladministradora']) || $_POST['seladministradora'] == "") {
    die("Selecione uma administradora!");
}

$adminsitradora = $_POST['seladministradora'];

$sel = "SELECT nr_sequencial, ds_administradora 
        FROM administradoras 
        WHERE nr_sequencial = $adminsitradora";
$res = mysqli_query($conexao, $sel);
while($lin = mysqli_fetch_row($res)){
    $nr_seq_administradora = $lin[0];
    $ds_administradora = $lin[1];
}

if($ds_administradora == 'MAGGI'){

    // Salva o PDF temporariamente
    $tmpName = $_FILES['arquivo']['tmp_name'];
    $nomeFinal = __DIR__ . "/uploads/" . uniqid() . ".pdf"; 
    move_uploaded_file($tmpName, $nomeFinal);

    // Parser do PDF
    $parser = new Parser();
    $pdf = $parser->parseFile($nomeFinal);
    $text = $pdf->getText();
    $lines = preg_split("/\r\n|\n|\r/", $text);

    // Variáveis fixas
    $nr_seq_empresa = $_SESSION["CD_EMPRESA"];
    $nr_seq_usercadastro = $_SESSION["CD_USUARIO"];

    // Variáveis temporárias
    $grupo = $cota = $parcela = $data_pagto = $valor = null;

    $contadorInseridos = 0;
    $contadorDuplicados = 0;
    $erros = [];

    // Loop pelas linhas do PDF
    foreach ($lines as $line) {
        // Captura Grupo e Cota
        if (preg_match('/^(\d+)\s+([\d\.]+)/', $line, $matches)) {
            $grupo = $matches[1];
            $cota  = str_replace('.', '', $matches[2]); 
        }

        // Captura das parcelas
        if (preg_match('/([\d\.\,]+)Parcela\s+(\d+)\s+de\s+\d+\s+Pago\s+(\d{2}\/\d{2}\/\d{4})/', $line, $matches)) {
            $valor = str_replace(['.', ','], ['', '.'], $matches[1]); 
            $parcela = $matches[2];
            $data_pagto = DateTime::createFromFormat('d/m/Y', $matches[3])->format('Y-m-d');

            // Verifica se já existe o registro
            $sqlCheck = "SELECT 1 FROM importacao 
                        WHERE nr_seq_administradora = $nr_seq_administradora
                        AND nr_seq_empresa = $nr_seq_empresa
                        AND ds_grupo = '$grupo'
                        AND nr_cota = '$cota'
                        LIMIT 1";
            $resCheck = mysqli_query($conexao, $sqlCheck);

            if (mysqli_num_rows($resCheck) == 0) {
                // Só insere se não existir
                $sql = "INSERT INTO importacao (ds_grupo, nr_cota, nr_seq_administradora, nr_parcela, dt_parcela, vl_parcela, nr_seq_empresa, nr_seq_usercadastro) 
                        VALUES ('$grupo', '$cota', '$nr_seq_administradora', '$parcela', '$data_pagto', '$valor', '$nr_seq_empresa', '$nr_seq_usercadastro')";
                if (mysqli_query($conexao, $sql)) {

                    $contadorInseridos++;

                     // Verifica se jexiste grupo e cota cadastrado
                    $sql_lead = "SELECT nr_sequencial
                                FROM lead
                                WHERE nr_seq_administradora = $nr_seq_administradora
                                AND nr_seq_empresa = $nr_seq_empresa
                                AND ds_grupo = '$grupo'
                                AND nr_cota = '$cota'
                                LIMIT 1";
                    $res_lead = mysqli_query($conexao, $sql_lead);
                    while($lin_lead = mysqli_fetch_row($res_lead)){
                        $nr_seq_lead = $lin_lead[0];
                    }

                    // Atualiza pagamentos se existir o mesmo grupo, cota, administradora e parcela
                    $updatePagamentos = "UPDATE pagamentos
                                        SET st_importacao = 'S'
                                        WHERE nr_seq_lead = $nr_seq_lead
                                        AND nr_parcela = '$parcela'";
                    mysqli_query($conexao, $updatePagamentos);

                } else {

                    $erros[] = "Grupo $grupo / Cota $cota: " . mysqli_error($conexao);

                }

            } else {

                $contadorDuplicados++;

            }
        }
    }

    // Exclui o arquivo após o processamento
    if (file_exists($nomeFinal)) {
        unlink($nomeFinal);
    }

    $msg = "Inseridos: $contadorInseridos\\n";
    $msg .= "Duplicados ignorados: $contadorDuplicados\\n";

    if (!empty($erros)) {
        $msg .= "Erros: " . count($erros) . "\\n";
        $msg .= "Detalhes:\\n" . implode("\\n", $erros);
        $icon = 'error';
        $title = 'Importação concluída com erros!';
    } else {
        $icon = 'success';
        $title = 'Importação concluída!';
    }

    echo "<script>
        parent.Swal.fire({
            icon: '$icon',
            title: '$title',
            text: '$msg',
            confirmButtonColor: '#28a745',
            width: 400
        });
    </script>";

} else {

    //Layout de importação não encontrado
    echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Não foi encontrado o layout de importação para essa administradora.'
            });
        </script>";

}
