<?php
header("Content-Type: application/json");
include "../conexao.php";

// 1. Valida token
$headers = apache_request_headers();
if (!isset($headers['Authorization'])) {
    http_response_code(401);
    echo json_encode(["erro" => "Token não enviado"]);
    exit;
}

$token = str_replace("Bearer ", "", $headers['Authorization']);
$sql = "SELECT id FROM empresas WHERE api_token = '$token'";
$result = $conexao->query($sql);
if ($result->num_rows == 0) {
    http_response_code(403);
    echo json_encode(["erro" => "Token inválido"]);
    exit;
}

$empresa = $result->fetch_assoc();
$empresa_id = $empresa['id'];

// 2. Recebe dados do lead
$data = json_decode(file_get_contents("php://input"), true);
$nome = $conexao->real_escape_string($data['nome']);
$telefone = $conexao->real_escape_string($data['telefone']);
$email = $conexao->real_escape_string($data['email']);
$status = $conexao->real_escape_string($data['status']);

// 3. Valida duplicidade
$check = $conexao->query("SELECT id FROM leads WHERE empresa_id='$empresa_id' AND (email='$email' OR telefone='$telefone')");
if ($check->num_rows > 0) {
    echo json_encode(["status" => "erro", "mensagem" => "Lead já existe para esta empresa"]);
    exit;
}

// 4. Insere lead
$sql = "INSERT INTO leads (empresa_id, nome, telefone, email, status, origem)
        VALUES ('$empresa_id', '$nome', '$telefone', '$email', '$status', 'SDR')";
if ($conexao->query($sql)) {
    echo json_encode(["status" => "sucesso", "lead_id" => $conexao->insert_id, "mensagem" => "Lead cadastrado com sucesso"]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao cadastrar lead"]);
}
