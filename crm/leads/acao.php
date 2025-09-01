<?php

    foreach($_GET as $key => $value){
        $$key = $value;
    }

    session_start(); 
    include "../../conexao.php";

?>

<?php

  //=====================================-CARREGA DADOS NO FORMULARIO-=========================================

if ($Tipo == "D") {

        $SQL = "SELECT * 
                    FROM lead
                    WHERE nr_sequencial=" . $Codigo;
        $RSS = mysqli_query($conexao, $SQL);
        $RS = mysqli_fetch_assoc($RSS);
        if ($RS["nr_sequencial"] == $Codigo) {

            $valor_formatado = number_format($RS["vl_valor"], 2, ',', '.');
            echo "<script language='javascript'>window.parent.document.getElementById('cd_lead').value='" . $RS["nr_sequencial"] . "';</script>";
            echo "<script language='javascript'>window.parent.document.getElementById('txtnome').value='" . $RS["ds_nome"] . "';</script>";
            echo "<script language='javascript'>window.parent.document.getElementById('txtcontato').value='" . $RS["nr_telefone"] . "';</script>";
            echo "<script language='javascript'>window.parent.document.getElementById('txtmunicipio').value='" . $RS["nr_seq_cidade"] . "';</script>";
            echo "<script language='javascript'>window.parent.document.getElementById('txtvendedor').value='" . $RS["nr_seq_usercadastro"] . "';</script>";
            echo "<script language='javascript'>window.parent.document.getElementById('txtvalor').value='" . $valor_formatado . "';</script>";
            echo "<script language='javascript'>window.parent.document.getElementById('txtsegmento').value='" . $RS["nr_seq_segmento"] . "';</script>";
            echo "<script language='javascript'>window.parent.document.getElementById('txtemail').value='" . $RS["ds_email"] . "';</script>";
            echo "<script language='javascript'>window.parent.buscaComercial('".$RS["nr_sequencial"]."');</script>";
            echo "<script language='javascript'>window.parent.document.getElementById('txtnome').focus();</script>";
        
        }

} 

  //=======================		INCLUSAO DOS DADOS
if ($Tipo == "I") {

    $nome = mb_strtoupper($nome, 'UTF-8');

    $SQL = "SELECT nr_sequencial 
            FROM lead
            WHERE ds_nome = '" . $nome . "' 
            AND vl_valor = " . $valor . "
            AND nr_seq_segmento = " . $segmento . "
            AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "
            LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] !='') {

        echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Lead já cadastrada! Verifique.'
            });
        </script>";

    } else {
        
        $empresa = $_SESSION["CD_EMPRESA"];
        $situacao = 2; //Quando insere um novo registro grava situacao 2 (NOVA)
        $nome = mysqli_real_escape_string($conexao, $nome);
        $contato = mysqli_real_escape_string($conexao, $contato);
        $email = mysqli_real_escape_string($conexao, $email);
        if ($cidade == 0 || $cidade === "" || $cidade === null) {
            $cidade = "NULL";
        }
        if ($valor == 0 || $valor === "" || $valor === null) {
            $valor = "NULL";
        }
        if ($segmento == 0 || $segmento === "" || $segmento === null) {
            $segmento = "NULL";
        }

        if ($vendedor == 0 || $vendedor == "") {
            $vendedor = $_SESSION["CD_USUARIO"];
        }


        $insert = "INSERT INTO lead (nr_seq_situacao, ds_nome, nr_telefone, nr_seq_cidade, vl_valor, nr_seq_segmento, ds_email, nr_seq_usercadastro, nr_seq_empresa) 
                    VALUES (" .  $situacao . ", UPPER('" . $nome . "'), '" . $contato . "', " . $cidade . ", " . $valor . ", " . $segmento . ", '" . $email . "', " . $vendedor . ", " . $empresa . ")";
        $rss_insert = mysqli_query($conexao, $insert); echo  $insert;
    
        // Valida se deu certo
        if ($rss_insert) {
    
            echo "<script language='JavaScript'>
                    window.parent.Swal.fire({
                        icon: 'success',
                        title: 'Show...',
                        text: 'Lead cadastrada com sucesso!'
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

//=======================		ALTERACAO DOS DADOS
if ($Tipo == "A") {

    $nome = mb_strtoupper($nome, 'UTF-8');

    $SQL = "SELECT nr_sequencial 
            FROM lead
            WHERE ds_nome = '" . $nome . "' 
            AND vl_valor = " . $valor . "
            AND nr_seq_segmento = " . $segmento . "
            AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "
            AND nr_sequencial <> " . $codigo . "  
            LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] !='') {

        echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Lead já cadastrada! Verifique.'
            });
        </script>";

    } else {
        
        $usuario = $_SESSION["CD_USUARIO"];
        $empresa = $_SESSION["CD_EMPRESA"];
        $nome = mysqli_real_escape_string($conexao, $nome);
        $contato = mysqli_real_escape_string($conexao, $contato);
        $email = mysqli_real_escape_string($conexao, $email);
        if ($cidade == 0 || $cidade === "" || $cidade === null) {
            $cidade = "NULL";
        }
        if ($valor == 0 || $valor === "" || $valor === null) {
            $valor = "NULL";
        }
        if ($segmento == 0 || $segmento === "" || $segmento === null) {
            $segmento = "NULL";
        }

        if ($vendedor == 0 || $vendedor == "") {
            $vendedor = $_SESSION["CD_USUARIO"];
        }

        $update = "UPDATE lead 
                    SET ds_nome = '" . $nome . "', 
                        nr_telefone = '" . $contato . "',
                        nr_seq_cidade = " . $cidade . ",
                        vl_valor = " . $valor . ",
                        nr_seq_segmento = " . $segmento . ",
                        ds_email = '" . $email . "',
                        nr_seq_empresa = " . $empresa . ",
                        nr_seq_useralterado = " . $usuario . ",
                        nr_seq_usercadastro = " . $vendedor . ",
                        dt_alterado = CURRENT_TIMESTAMP
                WHERE nr_sequencial = " . $codigo;
        //echo"<pre> $update</pre>";
        $rss_update = mysqli_query($conexao, $update);

        // Valida se deu certo
        if ($rss_update) {

            echo "<script language='JavaScript'>
                    window.parent.Swal.fire({
                        icon: 'success',
                        title: 'Show...',
                        text: 'Lead alterada com sucesso!'
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

//==================================-EXCLUSÃO DOS DADOS-===============================================

if ($Tipo == "E") {
    
    $delete1 = "DELETE FROM anexos_lead WHERE nr_seq_lead=" . $codigo;
    $result1 = mysqli_query($conexao, $delete1);

    $delete = "DELETE FROM lead WHERE nr_sequencial=" . $codigo;
    $result = mysqli_query($conexao, $delete);

    if ($result) {
    
        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Lead excluído com sucesso!'
                });
                window.parent.executafuncao('new');
                window.parent.consultar(0);
            </script>";

    } else {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Problemas ao excluir a lead. Verifique!'
                });
            </script>";

    }


}

   //=====================================-ALTERA STATUS LEAD-=========================================

if ($Tipo == "STATUS") {

    $update = "UPDATE lead SET nr_seq_situacao = $status WHERE nr_sequencial = $codigo";
    $rss_update = mysqli_query($conexao, $update);

    if ($rss_update) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Status alterado com sucesso!'
                });
                window.parent.buscaComercial($codigo);
                window.parent.consultar(0);
            </script>";

    } else {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Problemas ao alterar o status!'
                });
            </script>";

    }

}

//=====================================-ALTERA VALOR CONTRATADO LEAD-=========================================

if ($Tipo == "CONTRATAR") {

    if($percentual == "") { $percentual = "NULL"; }
      $status = 1; //Altera o status para CONTRATADO

        $update = "UPDATE lead 
                    SET nr_seq_segmento = " . $segmento . ",
                    nr_seq_cidade = " . $cidade . ",
                    nr_seq_situacao = " . $status . ",
                    ds_grupo = '" . $grupo . "', 
                    nr_seq_administradora = " . $administratadora . ",
                    nr_cota = " . $cota . ",
                    pc_reduzido = " . $percentual . ",
                    vl_contratado = " . $valorcontratado . ",
                    vl_considerado = " . $valorfinal . ",
                    nr_contrato = '" . $contrato . "',
                    nr_seq_useralterado = " . $_SESSION["CD_USUARIO"] . ",
                    dt_alterado = CURRENT_TIMESTAMP, 
                    dt_contratada = CURRENT_TIMESTAMP
                WHERE nr_sequencial = " . $codigo;
        echo"<pre> $update</pre>";
        $rss_update = mysqli_query($conexao, $update);

        if ($rss_update) {

            $delete = "DELETE FROM pagamentos WHERE nr_seq_lead=" . $codigo;
            $result = mysqli_query($conexao, $delete);

            $mes_atual = date('m');
            $ano_atual = date('Y');

            //BUSCA O CÓDIGO DO COLABORADOR
            $nr_seq_colaborador = "";
            $SQLU = "SELECT nr_seq_colaborador
                    FROM usuarios
                    WHERE nr_sequencial = " . $_SESSION["CD_USUARIO"] . "";
            //echo "<pre>$SQLU</pre>";
            $RSSU = mysqli_query($conexao, $SQLU);
            while ($linhau = mysqli_fetch_row($RSSU)) {
                $nr_seq_colaborador = $linhau[0];
            }

            $SQLC = "SELECT pc.nr_parcela, pc.vl_comissao
                    FROM parcelas_comissoes pc
                    INNER JOIN comissoes c ON c.nr_sequencial = pc.nr_seq_comissao
                    WHERE c.nr_seq_colaborador = $nr_seq_colaborador
                    AND c.nr_seq_administradora = $administratadora
                    ORDER BY pc.nr_parcela ASC";
            echo "<pre>$SQLC</pre>";
            $RSSC = mysqli_query($conexao, $SQLC);
            while ($linhac = mysqli_fetch_row($RSSC)) {
                $nr_parcela = $linhac[0];
                $vl_comissao = $linhac[1];

                //calcula o valor da parcela
                $vl_parcela = ($vl_comissao / 100) * $valorfinal;

                // Calcula o mês e ano da parcela
                $data_parcela = new DateTime();
                $data_parcela->setDate($ano_atual, $mes_atual, 10); // sempre dia 10 do mês atual
                $data_parcela->modify("+".($nr_parcela)." months");

                $dt_parcela = $data_parcela->format("Y-m-d"); // formato para salvar no banco

                $insert = "INSERT INTO pagamentos (nr_seq_lead, nr_parcela, vl_comissao, vl_parcela, dt_parcela) 
                            VALUES (" . $codigo . ", " . $nr_parcela . ", " . $vl_comissao . ", " . $vl_parcela . ", '" . $dt_parcela . "')";
                $rss_insert = mysqli_query($conexao, $insert); echo $insert;

            }

            echo "<script language='JavaScript'>
                    window.parent.Swal.fire({
                        icon: 'success',
                        title: 'Show...',
                        text: 'Gravado com sucesso!'
                    });
                    window.parent.buscaComercial($codigo);
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

//=====================================-ALTERA DATA AGENDA-=========================================

if ($Tipo == "AGENDA") {

    if($data=="") { $data = "NULL"; }
    else { $data = "'$data'"; } 

    $update = "UPDATE lead SET dt_agenda = $data, nr_seq_situacao = 3 WHERE nr_sequencial = $codigo";
    $rss_update = mysqli_query($conexao, $update); 

    if ($rss_update) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Data alterada com sucesso!'
                });
                window.parent.buscaComercial($codigo);
                window.parent.consultar(0);
            </script>";

    } else {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Problemas ao alterar a data!'
                });
            </script>";

    }

}

//==================================-ATUALIZA OS STATUS NO FORMATO KAMBAM-======================================================

if ($_GET['Tipo'] == 'Q') {

    $id = intval($_POST['id']);
    $status = intval($_POST['status']);
    $data_agenda = isset($_POST['data_agenda']) ? trim($_POST['data_agenda']) : '';
    
    if ($data_agenda === '') {
        $data_agenda = "NULL";
    } else {
        $data_agenda = "'$data_agenda)'";
    }
    
    // Se quiser, valide se a lead pertence ao usuário ou empresa antes
    $sql = "UPDATE lead SET nr_seq_situacao = $status, dt_agenda = $data_agenda WHERE nr_sequencial = $id";
    echo "<pre>$sql</pre>";

    if (mysqli_query($conexao, $sql)) {
        
        echo "<script language='JavaScript'>
                window.parent.consultar(0);
            </script>";

    } else {
        
        echo "<script language='JavaScript'>
            window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Problemas ao alterar o status!'
            });
        </script>";
    }
    
    exit;
}

//==================================-GRAVAR COMENTÁRIOS-======================================================

if($Tipo == 'enviaComentario'){

    $arquivo = '';
    $insert = "INSERT INTO anexos_lead (nr_seq_lead, ds_comentario, ds_arquivo, dt_cadastro)
            VALUES ($codigo, '$comentario', '$arquivo', NOW())";
    //echo $insert;
    $rss_insert = mysqli_query($conexao, $insert);

    if ($rss_insert) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Comentário gravado com sucesso!'
                });
                window.parent.buscaComercial($codigo);
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

//==================================-CARREGAR ANEXOS-======================================================

if ($Tipo == 'enviarArquivo') {

    header('Content-Type: application/json');
    ob_clean();  // limpa qualquer saída antes do JSON

    if (empty($_FILES)) {
        echo json_encode([
            'status' => 'error',
            'mensagem' => 'Nenhum arquivo enviado!'
        ]);
        exit;
    }

    include '../../inc/upload_helper.php';

    $values = [];
    foreach ($_FILES as $file) {
        $resultadoUpload = fileUpload($file, './arquivos/');
        if ($resultadoUpload['error'] === true) {
            continue;
        }

        $arquivo = $resultadoUpload['filename'];
        $values[] = "($codigo, '', '$arquivo', NOW())";
    }

    if (empty($values)) {
        echo json_encode([
            'status' => 'error',
            'mensagem' => 'Nenhum arquivo válido enviado!'
        ]);
        exit;
    }

    $sql = "INSERT INTO anexos_lead (nr_seq_lead, ds_comentario, ds_arquivo, dt_cadastro)
            VALUES " . join(', ', $values);
    $rss = mysqli_query($conexao, $sql);

    if ($rss) {
        echo json_encode([
            'status' => 'success',
            'mensagem' => sizeof($values) . " arquivo(s) enviado(s) com sucesso!",
            'codigo' => $codigo
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'mensagem' => 'Problemas ao gravar no banco: ' . mysqli_error($conexao)
        ]);
    }

    exit;
}


//==================================-EXCLUI ANEXOS-======================================================

elseif($Tipo == 'removerArquivo'){

    if(!isset($arquivo)){
        response_json('400', '');
    }

    if(unlink("./arquivos/$arquivo")){
        $sql = "DELETE FROM anexos_lead WHERE nr_sequencial = $nr_sequencial";
        mysqli_query($conexao, $sql);
        response_json('200', '');
    }else{
        response_json('500', array('message' => 'falha ao apagar o arquivo'));
    }
}

?>