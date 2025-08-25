<?php

session_start();
require 'config.php';
require '../conexao.php';

// 🚩 Verifica retorno do Facebook
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // 1️⃣ Troca code por short-lived token
    $url = "https://graph.facebook.com/v19.0/oauth/access_token?" . http_build_query([
        'client_id' => APP_ID,
        'redirect_uri' => REDIRECT_URI,
        'client_secret' => APP_SECRET,
        'code' => $code
    ]);
    $response = json_decode(file_get_contents($url), true);

    if (!isset($response['access_token'])) {
        header("Location: https://conectasys.com/dashboard.php?form=facebook/index.php&id_menu=3&ds_men=Api%20Facebook&ds_mod=CRM&id_smenu=14");
        exit;
    }
    
    $shortToken = $response['access_token'];

    // 2️⃣ Troca por long-lived token
    $urlLong = "https://graph.facebook.com/v19.0/oauth/access_token?" . http_build_query([
        'grant_type' => 'fb_exchange_token',
        'client_id' => APP_ID,
        'client_secret' => APP_SECRET,
        'fb_exchange_token' => $shortToken
    ]);
    $responseLong = json_decode(file_get_contents($urlLong), true);

    if (!isset($responseLong['access_token'])) {
        header("Location: https://conectasys.com/dashboard.php?form=facebook/index.php&id_menu=3&ds_men=Api%20Facebook&ds_mod=CRM&id_smenu=14");
        exit;
    }
    
    $accessToken = $responseLong['access_token'];

    // 3️⃣ Busca ID do usuário Facebook
    $userInfo = json_decode(file_get_contents("https://graph.facebook.com/me?access_token={$accessToken}"), true);
    $idFb = $userInfo['id'] ?? null;

    if (!$idFb) {
        header("Location: https://conectasys.com/dashboard.php?form=facebook/index.php&id_menu=3&ds_men=Api%20Facebook&ds_mod=CRM&id_smenu=14");
        exit;
    }

    // 4️⃣ Calcula data de expiração (~60 dias)
    $dtExpiracao = date('Y-m-d', strtotime('+55 days')); // margem de segurança

    // 5️⃣ Insere ou atualiza token
    $idFbEsc = mysqli_real_escape_string($conexao, $idFb);
    $tokenEsc = mysqli_real_escape_string($conexao, $accessToken);
    $dtExpEsc = mysqli_real_escape_string($conexao, $dtExpiracao);

    $sqlCheck = "SELECT nr_sequencial FROM fb_tokens WHERE nr_seq_user = {$_SESSION["CD_USUARIO"]} LIMIT 1";
    $result = mysqli_query($conexao, $sqlCheck);

    if (mysqli_num_rows($result) > 0) {
        $sqlUpdate = "UPDATE fb_tokens 
                      SET id_fb = '$idFbEsc', ds_token = '$tokenEsc', dt_expiracao = '$dtExpEsc', dt_cadastro = NOW() 
                      WHERE nr_seq_user = {$_SESSION["CD_USUARIO"]}";
        mysqli_query($conexao, $sqlUpdate);
    } else {
        $sqlInsert = "INSERT INTO fb_tokens (nr_seq_user, id_fb, ds_token, dt_expiracao, dt_cadastro)
                      VALUES ({$_SESSION["CD_USUARIO"]}, '$idFbEsc', '$tokenEsc', '$dtExpEsc', NOW())";
        mysqli_query($conexao, $sqlInsert);
    }
}

// ✅ Busca token para sincronização
$query = "SELECT ds_token, dt_expiracao FROM fb_tokens WHERE nr_seq_user = {$_SESSION["CD_USUARIO"]} LIMIT 1";
$res = mysqli_query($conexao, $query);
$row = mysqli_fetch_assoc($res);

if (!$row) {
    header("Location: https://conectasys.com/dashboard.php?form=facebook/index.php&id_menu=3&ds_men=Api%20Facebook&ds_mod=CRM&id_smenu=14");
    exit;
}

$accessToken = $row['ds_token'];
$dtExpiracao = $row['dt_expiracao'];

// 🚩 Valida expiração
if (strtotime($dtExpiracao) < strtotime('today')) {
    header("Location: https://conectasys.com/dashboard.php?form=facebook/index.php&id_menu=3&ds_men=Api%20Facebook&ds_mod=CRM&id_smenu=14");
    exit;
}

// ✅ Sincroniza páginas e formulários (mantido igual ao seu)
$pagesUrl = "https://graph.facebook.com/v19.0/me/accounts?access_token={$accessToken}";
$response = file_get_contents($pagesUrl);
$pagesData = json_decode($response, true);

if (!isset($pagesData['data'])) {
    header("Location: https://conectasys.com/dashboard.php?form=facebook/index.php&id_menu=3&ds_men=Api%20Facebook&ds_mod=CRM&id_smenu=14");
    exit;
}

foreach ($pagesData['data'] as $page) {
    $idPagina = mysqli_real_escape_string($conexao, $page['id']);
    $dsPagina = mysqli_real_escape_string($conexao, $page['name']);
    $pageToken = mysqli_real_escape_string($conexao, $page['access_token']);

    $check = "SELECT id_pagina FROM fb_paginas WHERE nr_seq_user = {$_SESSION["CD_USUARIO"]} AND id_pagina = '$idPagina'";
    $resCheck = mysqli_query($conexao, $check);

    if (mysqli_num_rows($resCheck) > 0) {
        $update = "UPDATE fb_paginas 
                   SET ds_pagina = '$dsPagina',
                       ds_token = '$pageToken',
                       dt_cadastro = NOW()
                   WHERE nr_seq_user = {$_SESSION["CD_USUARIO"]} AND id_pagina = '$idPagina'";
        mysqli_query($conexao, $update);
    } else {
        $insert = "INSERT INTO fb_paginas (nr_seq_user, id_pagina, ds_pagina, ds_token, dt_cadastro)
                   VALUES ({$_SESSION["CD_USUARIO"]}, '$idPagina', '$dsPagina', '$pageToken', NOW())";
        mysqli_query($conexao, $insert);
    }

    $selectPg = "SELECT nr_sequencial FROM fb_paginas WHERE id_pagina = '$idPagina' LIMIT 1";
    $resPg = mysqli_query($conexao, $selectPg);
    $rowPg = mysqli_fetch_assoc($resPg);
    $nr_seq_pagina = $rowPg['nr_sequencial'];

    $formUrl = "https://graph.facebook.com/v19.0/{$idPagina}/leadgen_forms?access_token={$pageToken}";
    $forms = json_decode(file_get_contents($formUrl), true);

    if (isset($forms['data'])) {
        foreach ($forms['data'] as $form) {
            $idForm = mysqli_real_escape_string($conexao, $form['id']);
            $dsForm = mysqli_real_escape_string($conexao, $form['name']);

            $checkForm = "SELECT id_formulario FROM fb_formularios WHERE nr_seq_pagina = '$nr_seq_pagina' AND id_formulario = '$idForm'";
            $resForm = mysqli_query($conexao, $checkForm);

            if (mysqli_num_rows($resForm) > 0) {
                $updateForm = "UPDATE fb_formularios 
                               SET ds_formulario = '$dsForm',
                                   dt_cadastro = NOW()
                               WHERE nr_seq_pagina = '$nr_seq_pagina' AND id_formulario = '$idForm'";
                mysqli_query($conexao, $updateForm);
            } else {
                $insertForm = "INSERT INTO fb_formularios (nr_seq_pagina, id_formulario, ds_formulario, dt_cadastro)
                               VALUES ('$nr_seq_pagina', '$idForm', '$dsForm', NOW())";
                mysqli_query($conexao, $insertForm);
            }
        }
    }
}

// ✅ Redireciona para dashboard
header("Location: https://conectasys.com/dashboard.php?form=facebook/index.php&id_menu=3&ds_men=Api%20Facebook&ds_mod=CRM&id_smenu=14");
exit;

?>
