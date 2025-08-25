<?php
/**
 * test_webhook.php
 * Envia uma requisição POST simulada para o seu webhook do Facebook Lead Ads
 * para testar se está recebendo e processando corretamente.
 */

// URL do seu webhook
$webhookUrl = 'https://conectasys.com/facebook/webhook.php';

// Payload de teste
$payload = [
    "entry" => [[
        "id" => "631194586754602", // PAGE_ID fictício ou real
        "changes" => [[
            "value" => [
                "leadgen_id" => "1468300474543420", // Substitua por um lead_id real se tiver
                "form_id" => "1088059263213759"     // Substitua por um form_id real se tiver
            ]
        ]]
    ]]
];

// Inicia cURL
$ch = curl_init($webhookUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

// Executa
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);

curl_close($ch);

// Exibe resultado
echo "<h3>Resultado do Teste do Webhook</h3>";
echo "<strong>Status HTTP:</strong> {$httpCode}<br>";
echo "<strong>Resposta:</strong> {$response}<br>";
if ($error) {
    echo "<strong>Erro cURL:</strong> {$error}<br>";
} else {
    echo "<strong>Requisição enviada com sucesso.</strong>";
}
