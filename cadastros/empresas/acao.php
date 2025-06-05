<?php
foreach ($_GET as $key => $value) {
    $$key = $value;
}
?>

<?php

session_start();
include "../../conexao.php";
date_default_timezone_set('America/sao_paulo');

//============================= CARREGA DADOS NO FORMULARIO ================================================

if ($Tipo == "D") {
    $SQL = "SELECT *
            FROM empresas
            WHERE nr_sequencial = " . $Codigo;
    //echo $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] == $Codigo) {
        $ds_cadastro = $RS["ds_colaborador"] . " em " . date('d/m/Y H:i', strtotime($RS["dt_cadastro"]));
        echo "<script language='javascript'>
              window.parent.document.getElementById('cd_empresa').value='" . $RS["nr_sequencial"] . "';
                window.parent.document.getElementById('txtempresa').value='" . $RS["ds_empresa"] . "';
                window.parent.document.getElementById('txtnome').value='" . $RS["ds_nome"] . "';
                window.parent.document.getElementById('txtcnpj').value='" . $RS["nr_cnpj"] . "';
                window.parent.document.getElementById('txtie').value='" . $RS["nr_ie"] . "';
                window.parent.document.getElementById('txtlogradouro').value='" . $RS["ds_logradouro"] . "';
                window.parent.document.getElementById('txtbairro').value='" . $RS["ds_bairro"] . "';
                window.parent.document.getElementById('txtnumero').value='" . $RS["nr_endereco"] . "';
                window.parent.document.getElementById('txtcomplemento').value='" . $RS["ds_complemento"] . "';
                window.parent.document.getElementById('txtcep').value='" . $RS["nr_cep"] . "';
                window.parent.document.getElementById('txtestado').value='" . $RS["nr_seq_estado"] . "';
                window.parent.document.getElementById('txtmunicipio').value='" . $RS["nr_seq_cidade"] . "';
                window.parent.document.getElementById('txtemail').value='" . $RS["ds_email"] . "';
                window.parent.document.getElementById('txttelefone').value='" . $RS["nr_telefone"] . "';
                window.parent.document.getElementById('txtstatus').value='" . $RS["st_status"] . "';
                window.parent.listaAnexos('" . $RS["nr_sequencial"] . "');
                window.parent.document.getElementById('txtnome').focus();
            </script>";
    }
}

//============================== INCLUSAO DOS DADOS ======================================================

if ($Tipo == "I") {

    $nome = mb_strtoupper($nome, 'UTF-8');
    $empresa = mb_strtoupper($empresa, 'UTF-8');
   
    $SQL = "SELECT nr_sequencial  
          		FROM empresas  
          		WHERE nr_cnpj='" . $cnpj . "'  
          		LIMIT 1";
    $RSS = mysqli_query($conexao, $SQL);
    if (pg_num_rows($RSS) > 0) {

        echo "<script language='javascript'>
                window.parent.Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'J\u00e1 tem uma empresa cadastrado com esse CNPJ! Verifique.'
                });
            </script>";

    } else {

        $insert = "INSERT INTO empresas (ds_nome, ds_empresa, nr_cnpj, nr_ie, ds_logradouro, ds_bairro, nr_endereco, ds_complemento, nr_cep, nr_seq_cidade, nr_seq_estado, nr_seq_usercadastro, ds_email, nr_telefone, st_status) 
                        VALUES ('" . $nome . "', '" . $empresa . "', '$cnpj', '$ie', '" . $logradouro . "', '" . $bairro . "', '$numero', '" . $complemento . "', '$cep', $municipio, $estado, " . $_SESSION["CD_USUARIO"] . ", '$email', '$telefone', '$status')";
        $rss_insert = mysqli_query($conexao, $insert); //echo $insert;

        // Valida se deu certo
        if ($rss_insert) {

            echo "<script language='JavaScript'>
                    window.parent.Swal.fire({
                        icon: 'success',
                        title: 'Show...',
                        text: 'Empresa cadastrada com sucesso!'
                    });
                    window.parent.executafuncao('new');
                    window.parent.consultar(0);
                </script>";

        } else {

            echo "<script language='JavaScript'>
                    window.parent.Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Problemas ao gravar!'
                    });
                 </script>";
        }
    }
}

//=================================== ALTERACAO DOS DADOS ===============================================

if ($Tipo == "A") {

    $nome = mb_strtoupper($nome, 'UTF-8');
    $empresa = mb_strtoupper($empresa, 'UTF-8');

    $SQL = "SELECT nr_sequencial 
              FROM empresas 
             WHERE nr_cnpj = '" . $cnpj . "'
               AND nr_sequencial <> " . $codigo . " 
             LIMIT 1";
    $RSS = mysqli_query($conexao, $SQL);
    if (pg_num_rows($RSS) > 0) {

        echo "<script language='javascript'>
                window.parent.Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'J\u00e1 tem uma empresa cadastrado com esse CNPJ! Verifique.'
                });
            </script>";

    } else {

        $update = "UPDATE empresas   
                      SET ds_nome = '" . $nome . "', 
                        ds_empresa = '" . $empresa . "', 
                        nr_cnpj = '$cnpj', 
                        nr_ie = '$ie',
                        ds_logradouro = '" . $logradouro . "', 
                        ds_bairro = '" . $bairro . "', 
                        nr_endereco = '$numero', 
                        ds_complemento = '" . $complemento . "', 
                        nr_cep = '$cep', 
                        nr_seq_cidade = $municipio, 
                        nr_seq_estado = $estado, 
                        nr_seq_useralterado = " . $_SESSION["CD_USUARIO"] . ", 
                        dt_alterado = CURRENT_TIMESTAMP,
                        nr_telefone = '$telefone',
                        ds_email = '$email',
                        st_status = '$status'
                    WHERE nr_sequencial = " . $codigo;
        //echo"<pre> $update</pre>";
        $rss_update = mysqli_query($conexao, $update);

        // Valida se deu certo
        if ($rss_update) {

            echo "<script language='JavaScript'>
                    window.parent.Swal.fire({
                        icon: 'success',
                        title: 'Show...',
                        text: 'Empresa alterada com sucesso!'
                    });
                    window.parent.executafuncao('new');
                    window.parent.consultar(0);
                </script>";

        } else {

            echo "<script language='JavaScript'>
                    window.parent.Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Problemas ao gravar!'
                    });
                 </script>";
        }
    }

}

//==================================-CARREGAR ANEXOS-======================================================

if ($Tipo == 'enviarArquivo') {

    if (!$_FILES) {
        response_json('400', array('message' => 'Nenhum arquivo enviado'));
    }

    include '../../inc/upload_helper.php';

    $values = [];
    foreach ($_FILES as $file) {
        $resultadoUpload = fileUpload($file, './arquivos/');
        if ($resultadoUpload['error'] == true) {
            continue;
        }

        $arquivo = $resultadoUpload['filename'];

        $values[] = "($codigo, '$arquivo', NOW(), $_SESSION[CD_USUARIO])";
    }

    $sql = "INSERT INTO anexos_empresa (nr_seq_empresa, ds_arquivo, dt_cadastro, nr_seq_usercadastro)
        VALUES " . join(', ', $values);

    $rss = mysqli_query($conexao, $sql);

    $response = [];
    $response['mensagem'] = sizeof($values) . " arquivos enviados";

    response_json('200', $resultadoUpload);
}

//==================================-EXCLUI ANEXOS-======================================================

elseif ($Tipo == 'removerArquivo') {

    if (!isset($arquivo)) {
        response_json('400', '');
    }

    if (unlink("./arquivos/$arquivo")) {
        $sql = "DELETE FROM anexos_empresa WHERE nr_sequencial = $nr_sequencial";
        mysqli_query($conexao, $sql);
        response_json('200', '');
    } else {
        response_json('500', array('message' => 'falha ao apagar o arquivo'));
    }
}

?>