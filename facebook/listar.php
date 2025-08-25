<?php
/**
 * listar_leads.php
 * Busca automaticamente os `leadgen_id` dos formulários configurados em suas tabelas locais
 * e exibe os campos preenchidos pelo usuário.
 */

require '../conexao.php';

$version = 'v19.0';

echo "<h2>Listagem de Leads por Página e Formulário</h2>";

$queryPaginas = "SELECT nr_sequencial, ds_token, id_pagina FROM fb_paginas";
$resPaginas = mysqli_query($conexao, $queryPaginas);

if (mysqli_num_rows($resPaginas) > 0) {
    while ($pagina = mysqli_fetch_assoc($resPaginas)) {
        $nr_seq_pagina = $pagina['nr_sequencial'];
        $pageToken = $pagina['ds_token'];
        $pageId = $pagina['id_pagina'];

        echo "<h3>📄 Página ID: {$pageId}</h3>";

        $queryForms = "SELECT id_formulario, ds_formulario FROM fb_formularios WHERE nr_seq_pagina = '$nr_seq_pagina'";
        $resForms = mysqli_query($conexao, $queryForms);

        if (mysqli_num_rows($resForms) > 0) {
            while ($form = mysqli_fetch_assoc($resForms)) {
                $formId = $form['id_formulario'];
                $formName = $form['ds_formulario'];

                echo "<strong>📝 Formulário:</strong> {$formName} (ID: {$formId})<br>";

                $url = "https://graph.facebook.com/{$version}/{$formId}/leads?access_token={$pageToken}";

                $response = @file_get_contents($url);
                if ($response === false) {
                    echo "<span style='color:red;'>❌ Erro ao buscar leads (verifique o token ou permissões)</span><br><br>";
                    continue;
                }

                $data = json_decode($response, true);

                if (isset($data['data']) && count($data['data']) > 0) {
                    foreach ($data['data'] as $lead) {
                        echo "<div style='background:#f9f9f9;border:1px solid #ddd;padding:10px;margin:5px 0;'>";
                        echo "✅ <strong>Lead ID:</strong> {$lead['id']}<br>";
                        echo "🕒 <strong>Criado em:</strong> {$lead['created_time']}<br>";

                        if (isset($lead['field_data'])) {
                            echo "<strong>📋 Campos preenchidos:</strong><br>";
                            foreach ($lead['field_data'] as $field) {
                                $fieldName = htmlspecialchars($field['name']);
                                $fieldValues = htmlspecialchars(implode(', ', $field['values']));
                                echo "- <strong>{$fieldName}:</strong> {$fieldValues}<br>";
                            }
                        }
                        echo "</div>";
                    }
                } else {
                    echo "<span style='color:orange;'>⚠️ Nenhum lead encontrado neste formulário.</span><br><br>";
                }
            }
        } else {
            echo "<span style='color:orange;'>⚠️ Nenhum formulário encontrado para esta página.</span><br><br>";
        }
    }
} else {
    echo "<span style='color:red;'>❌ Nenhuma página cadastrada em fb_paginas.</span>";
}
?>
