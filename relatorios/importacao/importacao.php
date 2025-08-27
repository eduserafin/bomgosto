<?php
session_start(); 

require 'vendor/autoload.php';
include '../../conexao.php';

$usuario = $_SESSION["CD_USUARIO"];
$empresa = $_SESSION["CD_EMPRESA"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $administradora = $_POST['seladministradora'];

    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {
        $arquivo = $_FILES['arquivo']['tmp_name'];

        // Ler PDF
        $parser = new \Smalot\PdfParser\Parser();
        $pdf    = $parser->parseFile($arquivo);
        $texto  = $pdf->getText();

        // Transformar o texto em linhas
        $linhas = preg_split('/\r\n|\r|\n/', $texto);

        $registrosInseridos = 0;

        foreach ($linhas as $linha) {
            if (trim($linha) == '') continue;

            // Supondo que os campos estão separados por ";"
            $campos = explode(';', $linha);

            $ds_grupo   = mysqli_real_escape_string($conexao, trim($campos[0]));
            $nr_cota    = mysqli_real_escape_string($conexao, trim($campos[1]));
            $nr_parcela = mysqli_real_escape_string($conexao, trim($campos[2]));
            $dt_parcela = mysqli_real_escape_string($conexao, trim($campos[3]));
            $vl_parcela = mysqli_real_escape_string($conexao, str_replace(',', '.', trim($campos[4])));

            // Verifica duplicidade
            $check = "SELECT 1 FROM importacao 
                        WHERE ds_grupo='$ds_grupo' 
                        AND nr_cota='$nr_cota' 
                        AND nr_parcela='$nr_parcela' 
                        AND nr_seq_administradora='$admin'";
            $res = mysqli_query($conexao, $check);

            if (mysqli_num_rows($res) == 0) {
                // Insere registro
                $sql = "INSERT INTO importacao (ds_grupo, nr_cota, nr_seq_administradora, nr_parcela, dt_parcela, vl_parcela, nr_seq_empresa, nr_seq_usercadastro)
                        VALUES ('$ds_grupo', $nr_cota, $administradora, $nr_parcela, '$dt_parcela', $vl_parcela, $empresa, $usuario)";
                mysqli_query($conexao, $sql);
                $registrosInseridos++;
            }
        }

        echo "<p><b>Importação concluída!</b> Foram inseridos $registrosInseridos registros.</p>";
    }
}
?>