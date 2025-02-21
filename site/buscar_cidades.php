<?php
include '../conexao.php'; // Arquivo de conexão com o banco

$term = isset($_GET['term']) ? $_GET['term'] : '';

$sql = "SELECT cd_municipioibge, CONCAT(ds_municipioibge, ' - ', sg_estado) AS municipio_estado
        FROM municipioibge
        WHERE ds_municipioibge LIKE ? 
        ORDER BY ds_municipioibge LIMIT 20";

$stmt = mysqli_prepare($conexao, $sql);
$searchTerm = "%".$term."%";
mysqli_stmt_bind_param($stmt, "s", $searchTerm);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$cidades = [];
while ($row = mysqli_fetch_assoc($result)) {
    $cidades[] = [
        "id" => $row['cd_municipioibge'],
        "text" => $row['municipio_estado']
    ];
}

echo json_encode($cidades);
?>
