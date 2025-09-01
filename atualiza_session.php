<?php
session_start();
include 'conexao.php';

$response = ['success' => false];

if (isset($_POST['periodo']) && isset($_POST['usuario']) && $_POST['usuario'] != "") {

    $periodo = $_POST['periodo'];
    $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);

    $SQL = "SELECT u.nr_sequencial, u.nr_seq_empresa, c.ds_colaborador, u.ds_login, u.ds_senha, u.st_admin, e.ds_empresa
            FROM usuarios u
            INNER JOIN colaboradores c ON c.nr_sequencial = u.nr_seq_colaborador
            INNER JOIN empresas e ON e.nr_sequencial = u.nr_seq_empresa
            WHERE u.nr_sequencial = $usuario";
            
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_array($RSS);

    if ($RS) {
        $_SESSION["CD_USUARIO"] = $RS["nr_sequencial"];
        $_SESSION["DS_USUARIO"] = strtoupper($RS["ds_login"]);
        $_SESSION["NM_USUARIO"] = strtoupper($RS["ds_colaborador"]);
        $_SESSION["ST_ADMIN"] = strtoupper($RS["st_admin"]);
        $_SESSION["CD_EMPRESA"] = $RS["nr_seq_empresa"];
        $_SESSION["DS_EMPRESA"] = strtoupper($RS["ds_empresa"]);
        $_SESSION["ST_PERIODO"] = strtoupper($periodo);

        $response['success'] = true;
    } else {
        error_log('Nenhum resultado encontrado para o usuário selecionado.');
    }
} else {
    error_log('Usuário ou período não encontrado.');
}

header('Content-Type: application/json');
echo json_encode($response);
?>
