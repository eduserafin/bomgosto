<?php

require 'config.php';

$loginUrl = "https://www.facebook.com/v19.0/dialog/oauth?" . http_build_query([
    'client_id' => APP_ID,
    'redirect_uri' => REDIRECT_URI,
    'scope' => 'public_profile,pages_read_engagement,pages_manage_metadata,leads_retrieval,pages_show_list'
]);

//pages_manage_ads,business_management

$status = "Desconectado";
$idFb = "-";
$tokenMsg = "";
$tokenDias = "-";

if (isset($_SESSION["CD_USUARIO"])) {
    $sql = "SELECT id_fb, ds_token, dt_expiracao FROM fb_tokens WHERE nr_seq_user = " . $_SESSION["CD_USUARIO"] . " LIMIT 1";
    $res = mysqli_query($conexao, $sql);
    if ($res && $row = mysqli_fetch_assoc($res)) {
        $status = "Conectado";
        $idFb = htmlspecialchars($row['id_fb']);
        
        if (!empty($row['dt_expiracao'])) {
            $hoje = new DateTime();
            $expira = new DateTime($row['dt_expiracao']);
            $diff = $hoje->diff($expira);
            $diasRestantes = (int)$diff->format("%r%a");

            if ($diasRestantes >= 0) {
                $tokenDias = "{$diasRestantes} dia(s)";
                if ($diasRestantes <= 5) {
                    $tokenMsg = "<span style='color: #e65100; font-weight:600;'>⚠️ Seu token expira em {$diasRestantes} dia(s). Refaça a conexão para evitar interrupções.</span>";
                }
            } else {
                $tokenDias = "Expirado";
                $tokenMsg = "<span style='color: #c62828; font-weight:600;'>❌ Token expirado, clique em Conectar novamente.</span>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Dashboard Facebook Leads</title>
<style>
    .fb-dashboard-body {
        background: #f5f7fa;
        font-family: 'Segoe UI', sans-serif;
        color: #333;
        margin: 0;
        padding: 20px;
    }
    
    .fb-dashboard-container {
        width: 100%;
        max-width: 1700px;
        margin: 0 auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        padding: 30px;
    }
    
    .fb-dashboard-btn {
        background: linear-gradient(90deg, #1877f2, #0043a6);
        color: #fff !important;
        padding: 12px 26px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 16px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(24, 119, 242, 0.4);
        transition: background 0.3s, transform 0.2s;
        text-decoration: none;
    }
    
    .fb-dashboard-btn:hover {
        background: linear-gradient(90deg, #0043a6, #1877f2);
        transform: translateY(-3px);
    }
    
    .fb-dashboard-panels {
        display: flex;
        gap: 15px;
        margin-top: 20px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    
    .fb-dashboard-panel {
        flex: 1 1 45%;
        background: #fafafa;
        border-radius: 10px;
        padding: 18px;
        text-align: center;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
    }
    
    .fb-dashboard-panel:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    
    .fb-dashboard-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .fb-dashboard-subtitle {
        font-size: 14px;
        word-break: break-word;
        font-weight: 600;
    }
    
    .fb-dashboard-status-connected {
        color: #2e7d32;
    }
    
    .fb-dashboard-status-disconnected {
        color: #c62828;
    }
    
    .fb-dashboard-section-title {
        font-size: 20px;
        font-weight: 700;
        color: #1877f2;
        border-left: 5px solid #1877f2;
        padding-left: 10px;
        margin: 25px 0 15px;
    }
    
    .fb-dashboard-filtros {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: flex-start;
        margin-bottom: 25px;
    }
    
    .fb-dashboard-filtro-group {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }
    
    /* Campo Páginas */
    .fb-dashboard-filtro-group:nth-child(1) {
        flex: 1 1 220px;
        max-width: 250px;
        min-width: 200px;
    }
    
    /* Campo Formulários */
    .fb-dashboard-filtro-group:nth-child(2) {
        flex: 2 1 400px;
        max-width: 450px;
        min-width: 300px;
    }
    
    /* Campo Data Inicial e Data Final */
    .fb-dashboard-filtro-group:nth-child(3),
    .fb-dashboard-filtro-group:nth-child(4) {
        flex: 0 1 150px;
        max-width: 160px;
        min-width: 120px;
    }
    
    /* Botão Consultar */
    .fb-dashboard-filtro-group:nth-child(5) {
        flex: 0 0 auto;
    }
    
    .btn-info {
        background-color: #5bc0de !important;
        border-color: #46b8da !important;
        color: #fff !important;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 600;
        transition: background-color 0.3s, transform 0.2s;
    }
    
    .fb-dashboard-filtro-group label {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 5px;
    }
    
    .fb-dashboard-filtro-group select,
    .fb-dashboard-filtro-group input[type="date"] {
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 14px;
        background: #f9f9f9;
        transition: border-color 0.2s, box-shadow 0.2s;
        width: 100%;
        box-sizing: border-box;
    }
    
    .fb-dashboard-filtro-group select:focus,
    .fb-dashboard-filtro-group input[type="date"]:focus {
        border-color: #1877f2;
        box-shadow: 0 0 0 3px rgba(24, 119, 242, 0.2);
        outline: none;
    }
    
    .fb-dashboard-botao-consultar {
        padding: 12px 20px;
        background: linear-gradient(90deg, #1877f2, #0043a6);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s, transform 0.2s;
    }
    
    .fb-dashboard-botao-consultar:hover {
        background: linear-gradient(90deg, #0043a6, #1877f2);
        transform: translateY(-3px);
    }
    
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.6);
    }
    
    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        width: 90%;
        max-width: 500px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.3);
        font-family: Arial, sans-serif;
    }
    
    .modal-content h3 {
        margin-top: 0;
        font-size: 18px;
        color: #333;
    }
    
    .modal-content label {
        font-size: 14px;
        color: #333;
    }
    
    .modal-buttons {
        margin-top: 20px;
        text-align: right;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    
    button.modal-btn {
        padding: 8px 16px;
        font-size: 14px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    
    button.cancelar {
        background-color: #ccc;
        color: #333;
    }
    
    button.cancelar:hover {
        background-color: #b3b3b3;
    }
    
    button.prosseguir {
        background-color: #1877F2;
        color: #fff;
    }
    
    button.prosseguir:hover {
        background-color: #0f66d0;
    }
    
    button:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    .mensagem-erro {
        color: #d93025;
        font-size: 13px;
        margin-top: 6px;
    }
    
    @media (max-width: 1024px) {
        .fb-dashboard-filtro-group:nth-child(2) {
            flex: 1 1 100%;
            max-width: 100%;
        }
    }
    
    @media (max-width: 768px) {
        .fb-dashboard-panel {
            flex: 1 1 100%;
        }
        .fb-dashboard-filtro-group {
            flex: 1 1 100% !important;
            max-width: 100% !important;
        }
    }

</style>
</head>
<body class="fb-dashboard-body">
    
<div class="fb-dashboard-container">
    <div style="text-align: center; margin-bottom: 15px;">
        <button type="button" class="fb-dashboard-btn" onclick="prosseguirComFacebook()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="20" height="20">
                <path fill="#1877F2" d="M24 4C12.95 4 4 12.95 4 24c0 9.9 7.17 18.08 16.5 19.75V29.5h-5v-5.5h5v-4c0-5 3-7.75 7.5-7.75 2.18 0 4.5.4 4.5.4v5h-2.54c-2.5 0-3.46 1.54-3.46 3.12v3.23h5.75l-.92 5.5h-4.83V43.75C36.83 42.08 44 33.9 44 24c0-11.05-8.95-20-20-20z"/>
                <path fill="#FFF" d="M30.5 29.5l.92-5.5h-5.75v-3.23c0-1.58.96-3.12 3.46-3.12H31v-5s-2.32-.4-4.5-.4c-4.5 0-7.5 2.75-7.5 7.75v4h-5v5.5h5v14.25c1.02.17 2.07.25 3.13.25s2.11-.08 3.12-.25V29.5h4.83z"/>
            </svg>
            Conectar com Facebook
        </button>
    </div>
    <?php if ($status === "Conectado") : ?>
        <?php if (!empty($tokenMsg)) : ?>
            <div style="text-align:center; margin-top:10px; font-size: 16px;">
                <?= $tokenMsg ?>
            </div>
        <?php endif; ?>
        <div style="text-align:center; margin-top:10px;">
            <a href="facebook/desconectar.php" class="fb-dashboard-btn" style="background: linear-gradient(90deg,#c62828,#8e0000);">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#fff" viewBox="0 0 24 24"><path d="M16 13v-2H7V8l-5 4 5 4v-3zM19 3H9c-1.1 0-2 .9-2 2v4h2V5h10v14H9v-4H7v4c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/></svg>
                Desconectar do Facebook
            </a>
        </div>
    <?php endif; ?>

    <div class="fb-dashboard-panels">
        <div class="fb-dashboard-panel">
            <div class="fb-dashboard-title">Status de Conexão</div>
            <?php $statusClass = ($status === "Conectado") ? "fb-dashboard-status-connected" : "fb-dashboard-status-disconnected"; ?>
            <div class="fb-dashboard-subtitle <?= $statusClass ?>"><?= $status ?></div>
        </div>
        <div class="fb-dashboard-panel">
            <div class="fb-dashboard-title">ID Facebook</div>
            <div class="fb-dashboard-subtitle"><?= $idFb ?></div>
        </div>
        <div class="fb-dashboard-panel">
            <div class="fb-dashboard-title">Expiração do Token</div>
            <?php
                if ($tokenDias === "Expirado") {
                    $tokenClass = "fb-dashboard-status-disconnected";
                } else {
                    $tokenClass = ($status === "Conectado") ? "fb-dashboard-status-connected" : "fb-dashboard-status-disconnected";
                }
            ?>
            <div class="fb-dashboard-subtitle <?= $tokenClass ?>"><?= $tokenDias ?></div>
        </div>
    </div>

    <div class="fb-dashboard-section-title">Páginas e Formulários Conectados</div>
    <div class="fb-dashboard-filtros">
        <div class="fb-dashboard-filtro-group">
            <label for="pesquisapagina">Páginas:</label>
            <select id="pesquisapagina"
                    onchange="formularios(this.value);">
                <option value='0'>Selecione uma página</option>
                <?php
                    $sql = "SELECT nr_sequencial, ds_pagina
                            FROM fb_paginas
                            WHERE nr_seq_user = " . $_SESSION["CD_USUARIO"] . "
                            ORDER BY ds_pagina";
                    $res = mysqli_query($conexao, $sql);
                    while($lin=mysqli_fetch_row($res)){
                        $cdg = $lin[0];
                        $desc = $lin[1];
                        echo "<option value='$cdg'>$desc</option>";
                    }
                ?>
            </select>
        </div>
    
        <div class="fb-dashboard-filtro-group" id="divformulario">
            <?php include 'formularios.php'; ?>
        </div>
    
        <div class="fb-dashboard-filtro-group">
            <label for="pesquisadata1">Data Inicial:</label>
            <input type="date" id="pesquisadata1">
        </div>
    
        <div class="fb-dashboard-filtro-group">
            <label for="pesquisadata2">Data Final:</label>
            <input type="date" id="pesquisadata2">
        </div>
    
        <div class="fb-dashboard-filtro-group" style="flex: 0 0 auto;">
            <label>&nbsp;</label>
            <?php include "inc/botao_consultar.php"; ?>
        </div>
    </div>
    
    <?php include "inc/aguarde.php"; ?>
    
    <div id="rslistaleads">
        <?php include "facebook/listadados.php";?>
    </div>

</div>
    
<script type="text/javascript">
    
    function prosseguirComFacebook() {
        window.location.href = "<?= $loginUrl ?>";
    }

    function consultar(pg) {
        Buscar( 
                document.getElementById('pesquisapagina').value,
                document.getElementById('pesquisaformulario').value,
                document.getElementById('pesquisadata1').value,
                document.getElementById('pesquisadata2').value,
                pg);
    }
    
    function Buscar(pagina, formulario, data1, data2, pg) {
        document.getElementById('pgatual').value = '';
        document.getElementById('pgatual').value = parseInt(pg)+1;
        document.getElementById('dvAguarde').style.display = 'block';
        var url = 'facebook/listadados.php?consulta=sim&pg=' + pg + '&pagina=' + pagina + '&formulario=' + formulario + '&data1=' + data1 + '&data2=' + data2;
        $.get(url, function (dataReturn) {
            $('#rslistaleads').html(dataReturn);
        });
    }

    function formularios(pagina){
        var url = 'facebook/formularios.php?consulta=sim&pagina=' + pagina;
        $.get(url, function(dataReturn) {
            $('#divformulario').html(dataReturn);
        });
    }

</script>   

</body>
</html>