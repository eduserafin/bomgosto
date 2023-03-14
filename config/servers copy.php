<?php
//SE NENHUMA SESSÃO FOI INICIADA
if (session_id() == '') {
    session_start();
}

$protocolo = 'http';
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === "on") {
    $protocolo = 'https';
}

$host = $_SERVER['HTTP_HOST'];
if(strtoupper(substr($host, 0, 4)) == 'WWW.'){
    $host = substr($host, 4);
}

switch ($host) {
    case 'coopercarga.ginfo.inovess.com.br':
        DEFINE('EMPRESA_PADRAO', 'COOPERCARGA');
        DEFINE('EMPRESA_PADRAO_CURTO', 'COOPERCARGA');
        DEFINE('LOGO_PADRAO', 'logo.png');
        DEFINE('ALIAS_EMPRESA', 'COOPERCARGA');
        DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        DEFINE('GINFOV3_URL', 'https://coopercarga.app.ginfo.inovess.com.br');
        break;
    
    case 'nelog.ginfo.inovess.com.br':
        DEFINE('EMPRESA_PADRAO', 'N&LOG TRANSPORTES E LOGISTICA LTDA');
        DEFINE('EMPRESA_PADRAO_CURTO', 'N&LOG');
        DEFINE('LOGO_PADRAO', 'logo_ne.jpeg');
        DEFINE('ALIAS_EMPRESA', 'NELOG');
        DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        DEFINE('GINFOV3_URL', 'https://nelog.app.ginfo.inovess.com.br');
        break;
    
    case 'teste.nelog.ginfo.inovess.com.br':
        DEFINE('EMPRESA_PADRAO', 'N&LOG TRANSPORTES E LOGISTICA LTDA');
        DEFINE('EMPRESA_PADRAO_CURTO', 'N&LOG');
        DEFINE('LOGO_PADRAO', 'logo.png');
        DEFINE('ALIAS_EMPRESA', 'TESTE_NELOG');
        DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        break;

    case 'eb.ginfo.inovess.com.br':
        DEFINE('EMPRESA_PADRAO', 'EB TRANSPORTES');
        DEFINE('EMPRESA_PADRAO_CURTO', 'EB TRANSPORTES');
        DEFINE('LOGO_PADRAO', 'logo_eb.jpg');
        DEFINE('ALIAS_EMPRESA', 'EB');
        DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        break;

    case 'log20.ginfo.inovess.com.br':
    case 'bkp.log20.ginfo.i9ss.com.br':
        DEFINE('EMPRESA_PADRAO', 'LOG20 LOGÍSTICA');
        DEFINE('EMPRESA_PADRAO_CURTO', 'LOG20');
        DEFINE('ALIAS_EMPRESA', 'LOG20');
        DEFINE('LOGO_PADRAO', 'log20_2.jpg');
        DEFINE('LOGO_PADRAO_SECUNDARIO', 'log20_1.jpg');
        DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        DEFINE('GINFOV3_URL', 'https://log20.app.ginfo.inovess.com.br');
        break;

    case 'logforte.ginfo.inovess.com.br':
        DEFINE('EMPRESA_PADRAO', 'LOGFORTE LOGÍSTICA');
        DEFINE('EMPRESA_PADRAO_CURTO', 'LOGFORTE');
        DEFINE('ALIAS_EMPRESA', 'LOGFORTE');
        DEFINE('LOGO_PADRAO', '');
        DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        break;

    case 'teste.log20.ginfo.inovess.com.br':
        DEFINE('EMPRESA_PADRAO', 'TESTE LOG20');
        DEFINE('EMPRESA_PADRAO_CURTO', 'TESTE LOG20');
        DEFINE('ALIAS_EMPRESA', 'TESTE_LOG20');
        DEFINE('LOGO_PADRAO', 'teste_2.jpg');
        DEFINE('LOGO_PADRAO_SECUNDARIO', 'teste_1.jpg');
        DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        DEFINE('GINFOV3_URL', 'https://teste.log20.app.ginfo.inovess.com.br');
        break;

    case 'teste.coopercarga.ginfo.inovess.com.br':
        DEFINE('EMPRESA_PADRAO', 'TESTE COOPERCARGA');
        DEFINE('EMPRESA_PADRAO_CURTO', 'TESTE COOPERCARGA');
        DEFINE('ALIAS_EMPRESA', 'TESTE_COOPERCARGA');
        DEFINE('LOGO_PADRAO', 'teste_2.jpg');
        DEFINE('LOGO_PADRAO_SECUNDARIO', 'teste_1.jpg');
        DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        break;

    case 'realcenter.ginfo.inovess.com.br':
        DEFINE('EMPRESA_PADRAO', 'REAL CENTER');
        DEFINE('EMPRESA_PADRAO_CURTO', 'REALCENTER');
        DEFINE('ALIAS_EMPRESA', 'REALCENTER');
        DEFINE('LOGO_PADRAO', 'teste_2.jpg');
        DEFINE('LOGO_PADRAO_SECUNDARIO', 'teste_1.jpg');
        DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        break;

    case 'i9.ginfo.inovess.com.br':
        DEFINE('EMPRESA_PADRAO', 'INOVE');
        DEFINE('EMPRESA_PADRAO_CURTO', 'INOVE');
        DEFINE('ALIAS_EMPRESA', 'I9');
        DEFINE('LOGO_PADRAO', 'teste_2.jpg');
        DEFINE('LOGO_PADRAO_SECUNDARIO', 'teste_1.jpg');
        DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        break;

    case 'ginfo.i9ss.com.br':
        $current_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        if(strpos($current_url, 'ginfo.i9ss.com.br/teste') !== false){
            DEFINE('EMPRESA_PADRAO', 'COOPERCARGA');
            DEFINE('EMPRESA_PADRAO_CURTO', 'COOPERCARGA');
            DEFINE('LOGO_PADRAO', 'logo.png');
            DEFINE('ALIAS_EMPRESA', 'COOPERCARGA');
            DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]/teste");
        }else{
            DEFINE('EMPRESA_PADRAO', 'LOG20 LOGÍSTICA');
            DEFINE('EMPRESA_PADRAO_CURTO', 'LOG20');
            DEFINE('ALIAS_EMPRESA', 'LOG20');
            DEFINE('LOGO_PADRAO', 'log20_2.jpg');
            DEFINE('LOGO_PADRAO_SECUNDARIO', 'log20_1.jpg');
            DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        }
        break;

    case 'ginfo.inovess.com.br':
    case 'localhost':
        DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]/ginfo");
    case '127.0.0.1':
    case '::1':
    default:
        if(isset($_SESSION['ALIAS_EMPRESA'])){
            switch (strtoupper($_SESSION['ALIAS_EMPRESA'])) {
                case 'COOPERCARGA':
                    DEFINE('EMPRESA_PADRAO', 'COOPERCARGA');
                    DEFINE('LOGO_PADRAO', 'logo.png');
                    DEFINE('EMPRESA_PADRAO_CURTO', 'COOPERCARGA');
                    break;
                case 'LOG20':
                    DEFINE('EMPRESA_PADRAO', 'LOG20 LOGÍSTICA');
                    DEFINE('LOGO_PADRAO', 'log20_2.jpg');
                    DEFINE('EMPRESA_PADRAO_CURTO', 'LOG20');
                    DEFINE('GINFOV3_URL', 'http://localhost:8080');
                    break;
                case 'EB':
                    DEFINE('EMPRESA_PADRAO', 'EB TRANSPORTES');
                    DEFINE('LOGO_PADRAO', 'log20_2.jpg');
                    DEFINE('EMPRESA_PADRAO_CURTO', 'EB TRANSPORTES');
                    break;
                
                default:
                    DEFINE('EMPRESA_PADRAO', null);
                    DEFINE('LOGO_PADRAO', 'log20_2.jpg');
                    DEFINE('EMPRESA_PADRAO_CURTO', null);
                    break;
            }

            DEFINE('ALIAS_EMPRESA', strtoupper($_SESSION['ALIAS_EMPRESA']));
        }else{
            DEFINE('EMPRESA_PADRAO', null);
            DEFINE('EMPRESA_PADRAO_CURTO', null);
            DEFINE('LOGO_PADRAO', 'log20_2.jpg');
        }

        if(!defined('BASE_URL')){
            DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        }
        break;
}

if(defined('ALIAS_EMPRESA') && !isset($_SESSION['ALIAS_EMPRESA'])){
    $_SESSION['ALIAS_EMPRESA'] = ALIAS_EMPRESA;
}