<?php
function getMailConfigs($type){
    $mailConfig = array();
    
    $mailConfig['default'] = array();
    
    $mailConfig['default']['host'] = 'zimbra.i9ss.com.br'; // Endere�o do servidor SMTP (Autentica��o, utilize o host smtp.seudom�nio.com.br)
    $mailConfig['default']['smtp_auth']   = true;  // Usar autentica��o SMTP (obrigat�rio para smtp.seudom�nio.com.br)
    $mailConfig['default']['port']       = 587; //  Usar 587 porta SMTP
    $mailConfig['default']['username'] = 'cte@i9ss.com.br'; // Usu�rio do servidor SMTP (endere�o de email)
    $mailConfig['default']['address'] = 'cte@i9ss.com.br'; // Usu�rio do servidor SMTP (endere�o de email)
    $mailConfig['default']['name'] = 'INOVE - Emissão de CT-e'; // Usu�rio do servidor SMTP (endere�o de email)
    $mailConfig['default']['password'] = 'inove@TOPinove@TOP'; // Senha do servidor SMTP (senha do email usado)

    return $mailConfig[$type];
}


