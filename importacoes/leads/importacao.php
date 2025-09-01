<?php
session_start();
require '../../vendor/autoload.php';
include "../../conexao.php";
use PhpOffice\PhpSpreadsheet\IOFactory;

// Função para normalizar texto
function normalizarTexto($texto) {
    $texto = mb_strtoupper($texto, 'UTF-8');
    $texto = strtr($texto, [
        'Á'=>'A','À'=>'A','Â'=>'A','Ã'=>'A','Ä'=>'A',
        'É'=>'E','È'=>'E','Ê'=>'E','Ë'=>'E',
        'Í'=>'I','Ì'=>'I','Î'=>'I','Ï'=>'I',
        'Ó'=>'O','Ò'=>'O','Ô'=>'O','Õ'=>'O','Ö'=>'O',
        'Ú'=>'U','Ù'=>'U','Û'=>'U','Ü'=>'U',
        'Ç'=>'C'
    ]);
    return trim($texto);
}

// Função para log
function log_sql($mensagem) {
    $arquivo = 'log_sql.txt';
    $data = date('Y-m-d H:i:s');
    file_put_contents($arquivo, "[$data] $mensagem\n", FILE_APPEND);
}

// Verifica se o arquivo foi enviado
if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {
    $arquivo_tmp = $_FILES['arquivo']['tmp_name'];

    if (empty($_POST['selempresa']) || $_POST['selempresa'] == "") {
        die("Selecione uma empresa!");
    }

    $nr_seq_empresa = $_POST['selempresa'];

    // Carregar planilha
    $spreadsheet = IOFactory::load($arquivo_tmp);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    // Remove cabeçalho
    array_shift($rows);

    $contadorInseridos = 0;
    $contadorDuplicados = 0;
    $contadorErro = 0;

    foreach ($rows as $row) {

        // Ignora linha vazia
        if (count(array_filter($row)) === 0) {
            continue;
        }

        $vendedor = normalizarTexto($row[0]);
        $cliente = mysqli_real_escape_string($conexao, $row[1]);
        $telefone = mysqli_real_escape_string($conexao, $row[2]);
        $estadoCidade = $row[3];
        $administradora = normalizarTexto($row[4]);
        $grupo = mysqli_real_escape_string($conexao, $row[5]);
        $cota = mysqli_real_escape_string($conexao, $row[6]);
        $contrato = mysqli_real_escape_string($conexao, $row[7]);
        $dtVenda = date('Y-m-d', strtotime(str_replace('/', '-', $row[8])));
        $segmento = normalizarTexto($row[10]);
        $vlrBem = str_replace(['R$', '.', ','], ['', '', '.'], $row[11]);

        // Encontra o vendedor
        $nr_seq_usuario = null;
        $sel_usuario = "SELECT u.nr_sequencial
                        FROM usuarios u
                        LEFT JOIN colaboradores c ON u.nr_seq_colaborador = c.nr_sequencial
                        WHERE (u.ds_login COLLATE utf8mb4_unicode_ci LIKE '%$vendedor%'
                        OR c.ds_colaborador COLLATE utf8mb4_unicode_ci LIKE '%$vendedor%')
                        AND u.nr_seq_empresa = $nr_seq_empresa
                        LIMIT 1";
        //log_sql("SELECT usuário: $sel_usuario");
        $res_usuario = mysqli_query($conexao, $sel_usuario);
        if (!$res_usuario) log_sql("ERRO MySQL: " . mysqli_error($conexao));

        if ($lin_usuario = mysqli_fetch_row($res_usuario)) {
            $nr_seq_usuario = $lin_usuario[0];
        }

        // Se não encontrar, busca gerente
        if($nr_seq_usuario == null){
            $sel_gerente = "SELECT u.nr_sequencial
                            FROM usuarios u
                            WHERE u.st_admin = 'G'
                            AND u.nr_seq_empresa = $nr_seq_empresa
                            LIMIT 1";
            //log_sql("SELECT gerente: $sel_gerente");
            $res_gerente = mysqli_query($conexao, $sel_gerente);
            if (!$res_gerente) log_sql("ERRO MySQL: " . mysqli_error($conexao));

            if ($lin_gerente = mysqli_fetch_row($res_gerente)) {
                $nr_seq_usuario = $lin_gerente[0];
            }
        }

        // Administradora
        $nr_seq_administradora = null;
        $sel_adm = "SELECT nr_sequencial 
                    FROM administradoras 
                    WHERE ds_administradora COLLATE utf8mb4_unicode_ci LIKE '%$administradora%'
                    AND nr_seq_empresa = $nr_seq_empresa";
        //log_sql("SELECT administradora: $sel_adm");
        $res_adm = mysqli_query($conexao, $sel_adm);
        if (!$res_adm) log_sql("ERRO MySQL: " . mysqli_error($conexao));

        while($lin_adm = mysqli_fetch_row($res_adm)){
            $nr_seq_administradora = $lin_adm[0];
        }

        // Cidade e estado
        $cidade = '';
        $estado = '';
        if (strpos($estadoCidade, '/') !== false) {
            list($cidade, $estado) = explode('/', $estadoCidade);
        }
        $cidade = normalizarTexto($cidade);
        $estado = normalizarTexto($estado);

        $nr_seq_cidade = "NULL";
        $nr_seq_estado = null;

        $sel_estado = "SELECT nr_sequencial 
                        FROM estados 
                        WHERE UPPER(sg_estado) = '$estado'
                        LIMIT 1";
        //log_sql("SELECT estado: $sel_estado");
        $res_estado = mysqli_query($conexao, $sel_estado);
        if (!$res_estado) log_sql("ERRO MySQL: " . mysqli_error($conexao));

        if ($lin_estado = mysqli_fetch_row($res_estado)) {
            $nr_seq_estado = $lin_estado[0];

            $sel_cidade = "SELECT nr_sequencial 
                            FROM cidades 
                            WHERE nr_seq_estado = $nr_seq_estado
                            AND UPPER(ds_municipio) = '$cidade'
                            LIMIT 1";
            //log_sql("SELECT cidade: $sel_cidade");
            $res_cidade = mysqli_query($conexao, $sel_cidade);
            if (!$res_cidade) log_sql("ERRO MySQL: " . mysqli_error($conexao));

            if ($lin_cidade = mysqli_fetch_row($res_cidade)) {
                $nr_seq_cidade = $lin_cidade[0];
            }
        }

        // Segmento
        $nr_seq_segmento = null;
        $sel_segmento = "SELECT nr_sequencial 
                            FROM segmentos 
                            WHERE ds_segmento COLLATE utf8mb4_unicode_ci LIKE '%$segmento%'
                            AND nr_seq_empresa = $nr_seq_empresa";
        //log_sql("SELECT segmento: $sel_segmento");
        $res_segmento = mysqli_query($conexao, $sel_segmento);
        if (!$res_segmento) log_sql("ERRO MySQL: " . mysqli_error($conexao));

        while($lin_segmento = mysqli_fetch_row($res_segmento)){
            $nr_seq_segmento = $lin_segmento[0];
        }

        $nr_seq_situacao = 2; //NOVA

        // Verifica duplicidade
        $sqlCheck = "SELECT nr_sequencial
                        FROM lead 
                        WHERE nr_seq_administradora = $nr_seq_administradora
                        AND nr_seq_empresa = $nr_seq_empresa
                        AND ds_grupo = '$grupo'
                        AND nr_cota = '$cota'
                        LIMIT 1";
        //log_sql("SELECT duplicidade: $sqlCheck");
        $resCheck = mysqli_query($conexao, $sqlCheck);
        if (!$resCheck) log_sql("ERRO MySQL: " . mysqli_error($conexao));

        if (mysqli_num_rows($resCheck) == 0) {
            // Inserir no banco
            $insert = "INSERT INTO `lead`(nr_seq_empresa, nr_seq_administradora, nr_seq_cidade, nr_seq_usercadastro, nr_seq_segmento, nr_seq_situacao, ds_nome, nr_telefone, ds_grupo, nr_cota, nr_contrato, dt_contratada, vl_contratado, vl_considerado, vl_valor)
                        VALUES ($nr_seq_empresa, $nr_seq_administradora, $nr_seq_cidade, $nr_seq_usuario, $nr_seq_segmento, $nr_seq_situacao, '$cliente', '$telefone', '$grupo', '$cota', '$contrato', '$dtVenda', '$vlrBem', '$vlrBem', '$vlrBem')";

            if (mysqli_query($conexao, $insert)) {
                $contadorInseridos++;
            } else {
                log_sql("INSERT gerado: $insert");
                log_sql("ERRO MySQL no INSERT: " . mysqli_error($conexao));
                $contadorErro++;
            }
        } else {
            $contadorDuplicados++;
        }
    }
}

// Mensagem final
$msg_js = json_encode(
    "Inseridos: $contadorInseridos\nDuplicados ignorados: $contadorDuplicados\nNão inseridos por erro: $contadorErro"
);
$icon = 'success';
$title = 'Importação concluída!';

echo "<script>
    parent.Swal.fire({
        icon: '$icon',
        title: " . json_encode($title) . ",
        text: `$msg_js`,
        confirmButtonColor: '#28a745',
        width: 600
    });
</script>";
