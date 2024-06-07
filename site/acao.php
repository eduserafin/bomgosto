<?php

session_start(); 
include "../conexao.php";

// Sanitizar e validar entradas
foreach($_GET as $key => $value){
    $$key = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

// Validação básica
function validate($data, $type) {
    switch ($type) {
        case 'email':
            return filter_var($data, FILTER_VALIDATE_EMAIL);
        case 'int':
            return filter_var($data, FILTER_VALIDATE_INT);
        case 'float':
            return filter_var($data, FILTER_VALIDATE_FLOAT);
        default:
            return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
}

// Validar entradas específicas
$tipo = validate($tipo, 'string');
$nome = validate($nome, 'string');
$email = validate($email, 'email');
$telefone = validate($telefone, 'string');
$whatsapp = validate($whatsapp, 'string');
$cidade = validate($cidade, 'int');
$mensagem = validate($mensagem, 'string');
$produto = $produto == "" ? null : validate($produto, 'int');
$valor = $valor == "" ? null : str_replace([",", "."], "", $valor);
$modal = validate($modal, 'string');

//==========================================-CADASTRAR LEAD-========================================

if ($Tipo == "SL") {

    // Construir a consulta SQL para depuração
    $insert_query = "INSERT INTO lead_site (tp_tipo, ds_nome, ds_email, nr_telefone, nr_whatsapp, nr_seq_cidade, ds_mensagem, nr_seq_produto, vl_valor, st_situacao) 
                     VALUES (?, UPPER(?), ?, ?, ?, ?, ?, ?, ?, 'N')";
    echo "<pre>SQL Query: " . htmlspecialchars($insert_query) . "</pre>";

    $stmt = $conexao->prepare($insert_query);
    $stmt->bind_param("sssssiisi", $tipo, $nome, $email, $telefone, $whatsapp, $cidade, $mensagem, $produto, $valor);

    if ($stmt->execute()) {
        // Registro gravado com sucesso
        if($modal == 'S' || $tipo == 'S'){
            echo "<script language='JavaScript'>
                    alert('Informações gravadas com sucesso! Sua proposta está sendo gerada e em breve retornaremos seu contato.');   
                  </script>";
            if($modal == 'S'){
                echo "<script language='JavaScript'>
                        window.parent.fecharModalSimulador(); 
                      </script>";
            } else {
                echo "<script language='JavaScript'>
                        window.parent.recarregarPagina();    
                      </script>";
            }
        } else {
            echo "<script language='JavaScript'>
                    alert('Informações gravadas com sucesso, em breve retornaremos o contato!');
                    window.parent.recarregarPagina();  
                  </script>";
        }
    } else {
        echo "<script language='JavaScript'>
                alert('Problemas ao gravar informações, tente novamente!');
              </script>";
    }

    $stmt->close();
}

//==========================================-CADASTRAR EMAIL-========================================

if ($Tipo == "EMAIL") {

    $v_existe = 0;
    $stmt = $conexao->prepare("SELECT COUNT(nr_sequencial) FROM emails WHERE ds_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($v_existe);
    $stmt->fetch();
    $stmt->close();

    if ($v_existe == 0) {
        $insert_query = "INSERT INTO emails (ds_email) VALUES (?)";
        echo "<pre>SQL Query: " . htmlspecialchars($insert_query) . "</pre>";

        $stmt = $conexao->prepare($insert_query);
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            echo "<script language='JavaScript'>
                    alert('E-mail cadastrado com sucesso!');
                    window.parent.recarregarPagina();    
                  </script>";
        } else {
            echo "<script language='JavaScript'>
                    alert('Problemas ao gravar, tente novamente!');
                  </script>";
        }

        $stmt->close();
    } else {
        echo "<script language='JavaScript'>
                alert('E-mail já cadastrado!');
              </script>";
    }
}

$conexao->close();
?>
