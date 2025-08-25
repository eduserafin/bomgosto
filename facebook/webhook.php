<?php
session_start();
require 'config.php';
require '../conexao.php';

file_put_contents('log_fb_raw.txt', file_get_contents('php://input') . PHP_EOL, FILE_APPEND);

define('LOG_FILE', 'log_fb.txt');
function logFb($msg) {
    file_put_contents(LOG_FILE, "[" . date('Y-m-d H:i:s') . "] " . $msg . PHP_EOL, FILE_APPEND);
}

// Função segura para buscar dados do lead usando cURL
function getLeadData($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        logFb("Erro cURL: " . curl_error($ch));
        curl_close($ch);
        return false;
    }
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($httpCode != 200) {
        logFb("Erro HTTP ao buscar lead: Código $httpCode");
        return false;
    }
    return $response;
}

// Verificação do token de webhook (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['hub_verify_token']) && $_GET['hub_verify_token'] === VERIFY_TOKEN) {
        echo $_GET['hub_challenge'];
        exit;
    } else {
        echo 'Token inválido';
        logFb("Token de verificação inválido: " . ($_GET['hub_verify_token'] ?? 'NÃO INFORMADO'));
        exit;
    }
}

// Recebendo o payload (POST)
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (isset($data['entry'][0]['changes'][0]['value']['leadgen_id'])) {
    $leadId = $data['entry'][0]['changes'][0]['value']['leadgen_id'];
    $formId = $data['entry'][0]['changes'][0]['value']['form_id'] ?? '';
    $pageId = $data['entry'][0]['id'];

    $pageIdEsc = mysqli_real_escape_string($conexao, $pageId);
    $query = "SELECT nr_sequencial, nr_seq_user, ds_token FROM fb_paginas WHERE id_pagina = '$pageIdEsc' LIMIT 1";
    $res = mysqli_query($conexao, $query);

    if ($res && mysqli_num_rows($res) > 0) {
        $rowPage = mysqli_fetch_assoc($res);
        $nr_seq_fb_pagina = intval($rowPage['nr_sequencial']);
        $nr_seq_user = intval($rowPage['nr_seq_user']);
        $pageToken = $rowPage['ds_token'];

        $nr_seq_empresa = 0;
        $queryEmpresa = "SELECT nr_seq_empresa FROM usuarios WHERE nr_sequencial = $nr_seq_user LIMIT 1";
        $resEmpresa = mysqli_query($conexao, $queryEmpresa);
        if ($resEmpresa && mysqli_num_rows($resEmpresa) > 0) {
            $rowEmpresa = mysqli_fetch_assoc($resEmpresa);
            $nr_seq_empresa = intval($rowEmpresa['nr_seq_empresa']);
        } else {
            logFb("Empresa NÃO encontrada para usuário $nr_seq_user. Usando empresa padrão 0.");
        }

        $nr_seq_fb_formulario = "NULL";
        if (!empty($formId)) {
            $formIdEsc = mysqli_real_escape_string($conexao, $formId);
            $queryForm = "SELECT nr_sequencial FROM fb_formularios WHERE id_formulario = '$formIdEsc' LIMIT 1";
            $resForm = mysqli_query($conexao, $queryForm);
            if ($resForm && mysqli_num_rows($resForm) > 0) {
                $rowForm = mysqli_fetch_assoc($resForm);
                $nr_seq_fb_formulario = intval($rowForm['nr_sequencial']);
            }
        }

        $leadUrl = "https://graph.facebook.com/v19.0/{$leadId}?access_token={$pageToken}";
        $leadResponse = getLeadData($leadUrl);

        if ($leadResponse !== false) {
            $leadData = json_decode($leadResponse, true);

            if (isset($leadData['field_data'])) {
                $fields = [];
                foreach ($leadData['field_data'] as $field) {
                    $fields[strtolower($field['name'])] = $field['values'][0] ?? '';
                }

                $ds_nome = mysqli_real_escape_string($conexao, $fields['full_name'] ?? $fields['nome'] ?? '');
                $ds_email = mysqli_real_escape_string($conexao, $fields['email'] ?? '');
                $nr_telefone = mysqli_real_escape_string($conexao, $fields['phone'] ?? $fields['phone_number'] ?? $fields['telefone'] ?? '');

                $nr_seq_segmento = "NULL";
                $nr_seq_cidade = "NULL";
                $nr_seq_situacao = 2;
                $nr_seq_usercadastro = $nr_seq_user;

                $sqlInsert = "INSERT INTO lead 
                    (ds_nome, ds_email, nr_telefone, nr_seq_usercadastro, nr_seq_empresa, nr_seq_segmento, nr_seq_situacao, nr_seq_cidade, nr_seq_pagina, nr_seq_formulario) 
                    VALUES ('$ds_nome', '$ds_email', '$nr_telefone', $nr_seq_usercadastro, $nr_seq_empresa, $nr_seq_segmento, $nr_seq_situacao, $nr_seq_cidade, $nr_seq_fb_pagina, $nr_seq_fb_formulario)";

                if (!mysqli_query($conexao, $sqlInsert)) {
                    logFb("Erro ao inserir lead: " . mysqli_error($conexao));
                }
            } else {
                logFb("Lead retornado sem 'field_data'. Lead ID: {$leadId}");
            }
        } else {
            logFb("Falha ao buscar dados do lead no Facebook. Lead ID: {$leadId}");
        }
    } else {
        logFb("Página não encontrada no banco para Page ID: {$pageId}");
    }
} else {
    logFb("Payload sem leadgen_id recebido: " . $input);
}

http_response_code(200);
echo 'EVENT_RECEIVED';
exit;
