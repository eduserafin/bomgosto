<?php
// === CONFIGURAÇÕES ===
$accessToken = 'EAAHieHnBgMsBPM64qVMobXhAl2RXxEfUwOcJloZBCwJLgBoN7YqKnrbjPSDtUGcQNoyh9z9VuGbD0cpEfynS6XoCIsRWpZAIE1H9qe7ZBJd2P0l7ij4PR4qpU0fNjG3JChb2gPq5WjHEfUceGhrMzyeHshnrwO9Q9dXjXsjaterqfNqD0Cpsosgyc3RETZBJhCbKDokhwoUnorL7';
$adAccountId = 'act_1229872965290033'; // Substitua pelo ID real da conta de anúncios
$logFile = __DIR__ . '/log_ads_api.txt'; // Caminho do log

// === MONTA A URL ===
$url = "https://graph.facebook.com/v18.0/{$adAccountId}/campaigns?fields=id,name,status,effective_status&access_token={$accessToken}";

// === FAZ A CHAMADA CURL ===
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$erroCurl = curl_error($ch);
curl_close($ch);

// === TRATA A RESPOSTA ===
$data = json_decode($response, true);
$timestamp = date('Y-m-d H:i:s');

// === INICIA LOG ===
$logMsg = "[$timestamp] Status HTTP: $httpCode\n";

// === RESULTADO ===
if ($erroCurl) {
    $logMsg .= "Erro cURL: $erroCurl\n\n";
} elseif (isset($data['error'])) {
    $logMsg .= "Erro API: {$data['error']['message']}\n\n";
} elseif (!empty($data['data'])) {
    $logMsg .= "Campanhas encontradas: " . count($data['data']) . "\n";
    foreach ($data['data'] as $campanha) {
        $logMsg .= "- {$campanha['id']} | {$campanha['name']} | Status: {$campanha['status']}\n";
    }
    $logMsg .= "\n";
} else {
    $logMsg .= "Nenhuma campanha retornada.\n\n";
}

// === ESCREVE NO ARQUIVO DE LOG ===
file_put_contents($logFile, $logMsg, FILE_APPEND);

// === EXIBE NA TELA (opcional) ===
echo nl2br($logMsg);
?>
