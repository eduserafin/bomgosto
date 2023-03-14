<?php
//SE NENHUMA SESSÃO FOI INICIADA
if (session_id() == '') {
    session_start();
}

$nomeempresa = $_POST['nomeempresa'];

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
        DEFINE('LOGO_PADRAO', 'COOPERCARGA_PADRAO.png'); // logo_cooper.png
        DEFINE('ALIAS_EMPRESA', 'COOPERCARGA');
        DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        DEFINE('GINFOV3_URL', 'https://coopercarga.app.ginfo.inovess.com.br');
        break;

    case 'carrefour.ginfo.inovess.com.br':
        DEFINE('EMPRESA_PADRAO', 'OP. DEDICADAS');
        DEFINE('EMPRESA_PADRAO_CURTO', 'OP. DEDICADAS');
        DEFINE('LOGO_PADRAO', 'OP. DEDICADAS_PADRAO.png'); //logo_cooper.png
        DEFINE('ALIAS_EMPRESA', 'OP. DEDICADAS');
        DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        DEFINE('GINFOV3_URL', 'https://carrefour.app.ginfo.inovess.com.br');
        break;
    
    case 'nelog.ginfo.inovess.com.br':
        DEFINE('EMPRESA_PADRAO', 'N&LOG TRANSPORTES E LOGISTICA LTDA');
        DEFINE('EMPRESA_PADRAO_CURTO', 'N&LOG');
        DEFINE('LOGO_PADRAO', 'NELOG_PADRAO.jpeg'); //logo_ne.jpeg
        DEFINE('ALIAS_EMPRESA', 'NELOG');
        DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        DEFINE('GINFOV3_URL', 'https://nelog.app.ginfo.inovess.com.br');
        break;
    
    case 'log20.ginfo.inovess.com.br':
        DEFINE('EMPRESA_PADRAO', 'LOG20 LOGÍSTICA');
        DEFINE('EMPRESA_PADRAO_CURTO', 'LOG20');
        DEFINE('ALIAS_EMPRESA', 'LOG20');
        DEFINE('LOGO_PADRAO', 'LOG20_PADRAO.jpg'); //logo_log20_2
        DEFINE('LOGO_PADRAO_SECUNDARIO', 'LOG20_PADRAO_SECUNDARIO.jpg'); //logo_log20_1
        DEFINE('LOGO_ORDEM_COLETA', 'LOG20_ORDEM_COLETA.jpg');
        DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        DEFINE('GINFOV3_URL', 'https://log20.app.ginfo.inovess.com.br');
        break;

    case 'grupot2p.ginfo.inovess.com.br':
        DEFINE('EMPRESA_PADRAO', 'GRUPO T2P');
        DEFINE('EMPRESA_PADRAO_CURTO', 'GRUPOT2P');
        DEFINE('ALIAS_EMPRESA', 'GRUPOT2P');
        DEFINE('LOGO_PADRAO', 'GRUPOT2P_PADRAO.jpg'); //logo_t2p.jpg
        DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        break;

    case 'realcenter.ginfo.inovess.com.br':
        DEFINE('EMPRESA_PADRAO', 'REAL CENTER');
        DEFINE('EMPRESA_PADRAO_CURTO', 'REALCENTER');
        DEFINE('ALIAS_EMPRESA', 'REALCENTER');
        DEFINE('LOGO_PADRAO', 'REALCENTER_PADRAO.jpg');
        DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        break;

    case 'i9.ginfo.inovess.com.br':
        DEFINE('EMPRESA_PADRAO', 'INOVE');
        DEFINE('EMPRESA_PADRAO_CURTO', 'INOVE');
        DEFINE('ALIAS_EMPRESA', 'I9');
        DEFINE('LOGO_PADRAO', 'I9_PADRAO.jpg');
        DEFINE('LOGO_PADRAO_SECUNDARIO', 'I9_PADRAO_SECUNDARIO.jpg');
        DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        break;
/*
    case 'bkp.ginfo.i9ss.com.br':
        if(strtoupper($nomeempresa) == "INOVE"){
            DEFINE('EMPRESA_PADRAO', 'INOVE');
            DEFINE('EMPRESA_PADRAO_CURTO', 'INOVE');
            DEFINE('ALIAS_EMPRESA', 'I9');
            DEFINE('LOGO_PADRAO', 'teste_2.jpg');
            DEFINE('LOGO_PADRAO_SECUNDARIO', 'teste_1.jpg');
            DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        }
        if(strtoupper($nomeempresa) == "COOPERCARGA"){
            DEFINE('EMPRESA_PADRAO', 'COOPERCARGA');
            DEFINE('EMPRESA_PADRAO_CURTO', 'COOPERCARGA');
            DEFINE('LOGO_PADRAO', 'logo_cooper.png');
            DEFINE('ALIAS_EMPRESA', 'COOPERCARGA');
            DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
            DEFINE('GINFOV3_URL', 'https://coopercarga.app.ginfo.inovess.com.br');
        }
        break;
*/
    case '31.220.61.89':
        DEFINE('BASE_URL', "https://ginfo.inovess.com.br/");

    case 'ginfo.inovess.com.br':
        DEFINE('BASE_URL', "https://ginfo.inovess.com.br/");
        if(strtoupper($nomeempresa) == "CONLOG"){
            DEFINE('EMPRESA_PADRAO', 'CONLOG');
            DEFINE('EMPRESA_PADRAO_CURTO', 'CONLOG');
            DEFINE('ALIAS_EMPRESA', 'CONLOG');
            DEFINE('LOGO_PADRAO', 'CONLOG_PADRAO.jpg');
            DEFINE('LOGO_PADRAO_SECUNDARIO', 'CONLOG_PADRAO_SECUNDARIO.jpg');
            DEFINE('BASE_URL', "https://ginfo.inovess.com.br/");
            break;
        }

        if(strtoupper($nomeempresa) == "RODOAVES"){
            DEFINE('EMPRESA_PADRAO', 'RODOAVES');
            DEFINE('EMPRESA_PADRAO_CURTO', 'RODOAVES');
            DEFINE('ALIAS_EMPRESA', 'RODOAVES');
            DEFINE('LOGO_PADRAO', 'RODOAVES_PADRAO.jpg');
            DEFINE('LOGO_PADRAO_SECUNDARIO', 'RODOAVES_PADRAO_SECUNDARIO.jpg');
            DEFINE('BASE_URL', "https://ginfo.inovess.com.br/");
            break;
        }

        if(strtoupper($nomeempresa) == "NORDESTE"){
            DEFINE('EMPRESA_PADRAO', 'NORDESTE');
            DEFINE('EMPRESA_PADRAO_CURTO', 'NORDESTE');
            DEFINE('ALIAS_EMPRESA', 'NORDESTE');
            DEFINE('LOGO_PADRAO', 'NORDESTE_PADRAO.jpg');
            DEFINE('LOGO_PADRAO_SECUNDARIO', 'NORDESTE_PADRAO_SECUNDARIO.jpg');
            DEFINE('BASE_URL', "https://ginfo.inovess.com.br/");
            break;
        }

        if(strtoupper($nomeempresa) == "SPRINTBR"){
            DEFINE('EMPRESA_PADRAO', 'SPRINTBR');
            DEFINE('EMPRESA_PADRAO_CURTO', 'SPRINTBR');
            DEFINE('ALIAS_EMPRESA', 'SPRINTBR');
            DEFINE('LOGO_PADRAO', 'SPRINTBR_PADRAO.jpg');
            DEFINE('LOGO_PADRAO_SECUNDARIO', 'SPRINTBR_PADRAO_SECUNDARIO.jpg');
            DEFINE('LOGO_ORDEM_COLETA', 'SPRINTBR_ORDEM_COLETA.jpg');
            DEFINE('BASE_URL', "https://ginfo.inovess.com.br/");
            break;
        }

        if(strtoupper($nomeempresa) == "LOG20"){
            DEFINE('EMPRESA_PADRAO', 'LOG20 LOGÍSTICA');
            DEFINE('EMPRESA_PADRAO_CURTO', 'LOG20');
            DEFINE('ALIAS_EMPRESA', 'LOG20');
            DEFINE('LOGO_PADRAO', 'LOG20_PADRAO.jpg'); //logo_log20_2
            DEFINE('LOGO_PADRAO_SECUNDARIO', 'LOG20_PADRAO_SECUNDARIO.jpg'); //logo_log20_1
            DEFINE('LOGO_ORDEM_COLETA', 'LOG20_ORDEM_COLETA.jpg');
            DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
            break;
        }

        if(strtoupper($nomeempresa) == "COOPERCARGA"){
            DEFINE('EMPRESA_PADRAO', 'COOPERCARGA');
            DEFINE('EMPRESA_PADRAO_CURTO', 'COOPERCARGA');
            DEFINE('LOGO_PADRAO', 'COOPERCARGA_PADRAO.png'); // logo_cooper.png
            DEFINE('ALIAS_EMPRESA', 'COOPERCARGA');
            DEFINE('BASE_URL', "https://ginfo.inovess.com.br/");
        }
        
        if(strtoupper($nomeempresa) == "OP. DEDICADAS"){
            DEFINE('EMPRESA_PADRAO', 'OP. DEDICADAS');
            DEFINE('EMPRESA_PADRAO_CURTO', 'OP. DEDICADAS');
            DEFINE('LOGO_PADRAO', 'OP. DEDICADAS_PADRAO.jpg'); //logo_cooper.png
            DEFINE('ALIAS_EMPRESA', 'OP. DEDICADAS');
            DEFINE('BASE_URL', "https://ginfo.inovess.com.br/");
        }
            
        if(strtoupper($nomeempresa) == "NELOG"){
            DEFINE('EMPRESA_PADRAO', 'N&LOG TRANSPORTES E LOGISTICA LTDA');
            DEFINE('EMPRESA_PADRAO_CURTO', 'N&LOG');
            DEFINE('LOGO_PADRAO', 'NELOG_PADRAO.jpeg'); //logo_ne.jpeg
            DEFINE('ALIAS_EMPRESA', 'NELOG');
            DEFINE('BASE_URL', "https://ginfo.inovess.com.br/");
        }
            
        if(strtoupper($nomeempresa) == "GRUPOT2P"){
            DEFINE('EMPRESA_PADRAO', 'GRUPO T2P');
            DEFINE('EMPRESA_PADRAO_CURTO', 'GRUPOT2P');
            DEFINE('ALIAS_EMPRESA', 'GRUPOT2P');
            DEFINE('LOGO_PADRAO', 'GRUPOT2P_PADRAO.jpg'); //logo_t2p.jpg
            DEFINE('BASE_URL', "https://ginfo.inovess.com.br/");
        }
        
        if(strtoupper($nomeempresa) == "REALCENDER"){
            DEFINE('EMPRESA_PADRAO', 'REAL CENTER');
            DEFINE('EMPRESA_PADRAO_CURTO', 'REALCENTER');
            DEFINE('ALIAS_EMPRESA', 'REALCENTER');
            DEFINE('LOGO_PADRAO', 'REALCENTER_PADRAO.jpg');
            DEFINE('BASE_URL', "https://ginfo.inovess.com.br/");
        }

        if(strtoupper($nomeempresa) == "TSV"){
            DEFINE('EMPRESA_PADRAO', 'TSV');
            DEFINE('EMPRESA_PADRAO_CURTO', 'TSV');
            DEFINE('ALIAS_EMPRESA', 'TSV');
            DEFINE('LOGO_PADRAO', 'TSV_PADRAO.jpg');
            DEFINE('BASE_URL', "https://ginfo.inovess.com.br/");
        }
        
    case 'localhost':
        DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]/ginfo");
    case '127.0.0.1':
    case '::1':
    default:
        if(isset($_SESSION['ALIAS_EMPRESA'])){
            switch (strtoupper($_SESSION['ALIAS_EMPRESA'])) {
                case 'COOPERCARGA':
                    DEFINE('EMPRESA_PADRAO', 'COOPERCARGA');
                    DEFINE('EMPRESA_PADRAO_CURTO', 'COOPERCARGA');
                    DEFINE('LOGO_PADRAO', 'COOPERCARGA_PADRAO.png');
                    break;

                case 'OP. DEDICADAS':
                    DEFINE('EMPRESA_PADRAO', 'OP. DEDICADAS');
                    DEFINE('EMPRESA_PADRAO_CURTO', 'OP. DEDICADAS');
                    DEFINE('LOGO_PADRAO', 'OP. DEDICADAS_PADRAO.png');
                    break;

                case 'NELOG':
                    DEFINE('EMPRESA_PADRAO', 'N&LOG TRANSPORTES E LOGISTICA LTDA');
                    DEFINE('EMPRESA_PADRAO_CURTO', 'N&LOG');
                    DEFINE('LOGO_PADRAO', 'NELOG_PADRAO.jpeg');
                
                case 'LOG20':
                    DEFINE('EMPRESA_PADRAO', 'LOG20 LOGÍSTICA');
                    DEFINE('EMPRESA_PADRAO_CURTO', 'LOG20');
                    DEFINE('LOGO_PADRAO', 'LOG20_PADRAO.jpg'); //logo_log20_2
                    DEFINE('LOGO_PADRAO_SECUNDARIO', 'LOG20_PADRAO_SECUNDARIO.jpg'); //logo_log20_1
                    DEFINE('LOGO_ORDEM_COLETA', 'LOG20_ORDEM_COLETA.jpg');
                    break;

                case 'GRUPOT2P':
                    DEFINE('EMPRESA_PADRAO', 'GRUPO T2P');
                    DEFINE('EMPRESA_PADRAO_CURTO', 'GRUPOT2P');
                    DEFINE('LOGO_PADRAO', 'GRUPOT2P_PADRAO.jpg');
                    break;

                case 'REALCENTER':
                    DEFINE('EMPRESA_PADRAO', 'REAL CENTER');
                    DEFINE('EMPRESA_PADRAO_CURTO', 'REALCENTER');
                    DEFINE('LOGO_PADRAO', 'REAL_PADRAO.jpg');
                    break;

                case 'I9':
                    DEFINE('EMPRESA_PADRAO', 'INOVE');
                    DEFINE('EMPRESA_PADRAO_CURTO', 'INOVE');
                    DEFINE('LOGO_PADRAO', 'teste_2.jpg');
                    break;

                case 'SPRINTBR':
                    DEFINE('EMPRESA_PADRAO', 'SPRINTBR');
                    DEFINE('EMPRESA_PADRAO_CURTO', 'SPRINTBR');
                    DEFINE('LOGO_PADRAO', 'SPRINTBR_PADRAO.jpg'); //logo_log20_2
                    DEFINE('LOGO_PADRAO_SECUNDARIO', 'SPRINTBR_PADRAO_SECUNDARIO.jpg'); //logo_log20_1
                    DEFINE('LOGO_ORDEM_COLETA', 'SPRINTBR_ORDEM_COLETA.jpg');
                    break;

                default:
                    DEFINE('EMPRESA_PADRAO', null);
                    DEFINE('LOGO_PADRAO', 'teste_2.jpg');
                    DEFINE('EMPRESA_PADRAO_CURTO', null);
                    break;
            }

            DEFINE('ALIAS_EMPRESA', strtoupper($_SESSION['ALIAS_EMPRESA']));
        }else{
            DEFINE('EMPRESA_PADRAO', null);
            DEFINE('EMPRESA_PADRAO_CURTO', null);
            DEFINE('LOGO_PADRAO', 'teste_2.jpg');
        }

        if(!defined('BASE_URL')){
            DEFINE('BASE_URL', "$protocolo://$_SERVER[HTTP_HOST]");
        }
        break;
}

if(defined('ALIAS_EMPRESA') && !isset($_SESSION['ALIAS_EMPRESA'])){
    $_SESSION['ALIAS_EMPRESA'] = ALIAS_EMPRESA;
}