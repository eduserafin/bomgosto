<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<?php
session_start(); 
include "../../conexao.php";
//=======================		CARREGA DADOS NO FORMULARIO
if ($Tipo == "D") {
    $SQL = "SELECT c.cnpj, c.razaosocial, c.inscestadual, c.tributacao, c.endereco, c.bairro, c.complemento,
                   c.cep, c.idcidade, c.responsavel, c.emailcli, c.responsavel, c.emailcli, c.idcontabilidade,
                   c.emailcont, c.fone1, c.fone2, e.obsprop, e.obscte, c.sistema, c.nmbasepri, c.gxml,
                   e.autenvio, e.enviospeed, e.enviofat, c.idcliente, c.tp_cert, c.dt_certificado, c.data1, c.data2, c.status,
                   c.averbacao, c.usuarioaverba, c.senhaaverba, c.atm, c.obsatm, ds_arquivo_contrato, COALESCE(c.nr_diaenvio,0) as nr_diaenvio,
                   COALESCE(c.cli_bloqueado, 'N') as cli_bloqueado, COALESCE(c.integra_ats, 'N') as integra_ats, ds_arquivo_certificado
		FROM tab_clientes c left join tab_emissaocte e on c.idcliente = e.idcliente 
    WHERE c.idcliente=" . $Codigo;
    
    $RSS = pg_query($conexao, $SQL);
    $RS = pg_fetch_assoc($RSS);
    if ($RS["idcliente"] == $Codigo) { 
      echo "|" . $RS["integra_ats"] . "|";
        echo "<script language='javascript'>
          window.parent.document.getElementById('txtcnpj').value = '" . $RS["cnpj"] . "';
          window.parent.document.getElementById('txtcnpj').disabled = true;
          window.parent.document.getElementById('txtnome').value = '" . $RS["razaosocial"] . "';
          window.parent.document.getElementById('txtie').value = '" . $RS["inscestadual"] . "';
          window.parent.document.getElementById('txttributacao').value = '" . $RS["tributacao"] . "';
          window.parent.document.getElementById('txtendereco').value = '" . $RS["endereco"] . "';
          window.parent.document.getElementById('txtbairro').value = '" . $RS["bairro"] . "';
          window.parent.document.getElementById('txtcomplemento').value = '" . $RS["complemento"] . "';
          window.parent.document.getElementById('txtcep').value = '" . $RS["cep"] . "';
          window.parent.document.getElementById('txtcidade').value = '" . $RS["idcidade"] . "';
          window.parent.document.getElementById('txtresponsavel').value = '" . $RS["responsavel"] . "';
          window.parent.document.getElementById('txtemail').value = '" . $RS["emailcli"] . "';
          window.parent.document.getElementById('txtcontabilidade').value = '" . $RS["idcontabilidade"] . "';
          window.parent.document.getElementById('txtemailcontabilidade').value = '" . $RS["emailcont"] . "';
          window.parent.document.getElementById('txttelefone').value = '" . $RS["fone1"] . "';
          window.parent.document.getElementById('txttelefone2').value = '" . $RS["fone2"] . "';
          window.parent.document.getElementById('txtobs2').value = '" . $RS["obscte"] . "';
          window.parent.document.getElementById('txtobs1').value = '" . $RS["obsprop"] . "';
          window.parent.document.getElementById('txtservico').value = '" . $RS["sistema"] . "';
          window.parent.document.getElementById('txtbase').value = '" . $RS["nmbasepri"] . "';
          window.parent.document.getElementById('txtgxml').value = '" . $RS["gxml"] . "';
          window.parent.document.getElementById('txtenvio').value = '" . $RS["autenvio"] . "';
          window.parent.document.getElementById('txtplacas').value = '" . $RS["enviofat"] . "';
          window.parent.document.getElementById('txtsped').value = '" . $RS["enviospeed"] . "';
          window.parent.document.getElementById('txtcertificado').value = '" . $RS["tp_cert"] . "';
          window.parent.document.getElementById('txtvencimento').value = '" . $RS["dt_certificado"] . "';
          window.parent.document.getElementById('txtdata').value = '" . $RS["data1"] . "';
          window.parent.document.getElementById('txtdata2').value = '" . $RS["data2"] . "';
          window.parent.document.getElementById('txtstatus').value = '" . $RS["status"] . "';
          window.parent.document.getElementById('cd_cliente').value = '" . $RS["idcliente"] . "';
          window.parent.document.getElementById('txtaverbacao').value = '" . $RS["averbacao"] . "';
          window.parent.document.getElementById('txtusuarioaverba').value = '" . $RS["usuarioaverba"] . "';
          window.parent.document.getElementById('txtsenhaaverba').value = '" . $RS["senhaaverba"] . "';
          window.parent.document.getElementById('txtatm').value = '" . $RS["atm"] . "';
          window.parent.document.getElementById('txtobsaverba').value = '" . $RS["obsatm"] . "';
          window.parent.document.getElementById('seldia').value = '" . $RS["nr_diaenvio"] . "';
          window.parent.document.getElementById('txtintegracao').value = '" . $RS["integra_ats"] . "';
          window.parent.document.getElementById('txtbloqueado').value = '" . $RS["cli_bloqueado"] . "';
          window.parent.document.getElementById('linkContrato').innerHTML = '" . $RS["ds_arquivo_contrato"] . "';
          window.parent.document.getElementById('linkContrato').setAttribute('href', 'admin/clientes/documentos/" . $RS["ds_arquivo_contrato"] . "');
          window.parent.document.getElementById('btnExcluirContrato').classList.add('hidden');
          window.parent.document.getElementById('dsArquivo').value = '" . $RS["ds_arquivo_contrato"] . "';

          window.parent.document.getElementById('linkCertificado').innerHTML = '" . $RS["ds_arquivo_certificado"] . "';
          window.parent.document.getElementById('linkCertificado').setAttribute('href', 'admin/clientes/certificados/" . $RS["ds_arquivo_certificado"] . "');
          window.parent.document.getElementById('btnExcluirCertificado').classList.add('hidden');
          window.parent.document.getElementById('dsCertificado').value = '" . $RS["ds_arquivo_certificado"] . "';

          window.parent.document.getElementById('txtnome').focus();
        </script>";

        if(strlen($RS["ds_arquivo_contrato"]) > 0){
          echo "<script>window.parent.document.getElementById('btnExcluirContrato').classList.remove('hidden');</script>";
        }

        if(strlen($RS["ds_arquivo_certificado"]) > 0){
          echo "<script>window.parent.document.getElementById('btnExcluirCertificado').classList.remove('hidden');</script>";
        }
    }
}
//=======================		INCLUSAO DOS DADOS
if ($Tipo == "I") {
  
    $SQL = "SELECT idcliente 
		FROM tab_clientes 
		WHERE cnpj='" . $cnpj . "'
		LIMIT 1";
    $RSS = pg_query($conexao, $SQL);
    if (pg_num_rows($RSS) > 0) {
        echo "<script language='JavaScript'>alert('Cliente ja cadastrado! Verifique.');</script>";
    } else {

        if ($data == ''){ $data = "NULL"; } else { $data = "'" . $data . "'"; }
        if ($data2 == ''){ $data2 = "NULL"; } else { $data2 = "'" . $data2 . "'"; }
        if ($contabilidade == '0' or $contabilidade == ''){ $contabilidade = "NULL"; } else { $contabilidade = "'" . $contabilidade . "'"; }
        if ($seldia == '0' or $seldia == ''){ $seldia = "NULL"; }
        if ($vencimento == ''){ $vencimento = "NULL"; } else { $vencimento = "'" . $vencimento . "'"; }

        //Instancia o valor padrao para o campo de arquivo
        $txtarquivo_contrato = 'NULL';
        $txtarquivo_certificado = 'NULL';

        //Verifica se $_FILES está setado, isto é, foi enviado um arquivo
        if($_FILES){
          //Inclui o helper que faz upload
          include '../../inc/upload_helper.php';

          if ($_FILES['contrato'] != ""){
            //Chama a função do helper que faz upload, passando o arquivo como primeiro parâmetro, e a pasta destino como segundo, gravando o retorno da função na variável
            $resultadoUpload = fileUpload($_FILES['contrato'], './documentos/');

            //Verifica se houve erro ao fazer upload
            if($resultadoUpload['error'] == true){
              header("Content-Type: application/json"); //Seta o retorno para tipo JSON, para ser mais fácil tratar no javascript
              header("HTTP/1.0 400 Bad Request");  //Seta o retorno como código 400, erro
              echo json_encode($resultadoUpload); //Imprime o resultado
              exit(); //Para a execução
            }

            //Se não parou a execução, dá sequencia

            $ds_arquivo_contrato = $resultadoUpload['filename']; //Pega o nome do arquivo enviado

            $txtarquivo_contrato = "'$ds_arquivo_contrato'"; //Seta a string que fará a atualização do campo contrato
          }

          if ($_FILES['certificado'] != ""){
            //28/03/2020: Jean C. Klein
            //Parte abaixo é igual a de cima, porém adicionando o certificado digital

            //Chama a função do helper que faz upload, passando o arquivo como primeiro parâmetro, e a pasta destino como segundo, gravando o retorno da função na variável
            $resultadoUpload2 = fileUpload($_FILES['certificado'], './certificados/');

            //Verifica se houve erro ao fazer upload
            if($resultadoUpload2['error'] == true){
              header("Content-Type: application/json"); //Seta o retorno para tipo JSON, para ser mais fácil tratar no javascript
              header("HTTP/1.0 400 Bad Request");  //Seta o retorno como código 400, erro
              echo json_encode($resultadoUpload2); //Imprime o resultado
              exit(); //Para a execução
            }

            //Se não parou a execução, dá sequencia

            $ds_arquivo_certificado = $resultadoUpload2['filename']; //Pega o nome do arquivo enviado

            $txtarquivo_certificado = "'$ds_arquivo_certificado'"; //Seta a string que fará a atualização do campo contrato
          }
        }

        $insert = "INSERT INTO tab_clientes (cnpj, razaosocial, inscestadual, tributacao, endereco, bairro, 
        complemento, cep, responsavel, emailcli, idcontabilidade, emailcont, fone1, fone2, sistema, nmbasepri, gxml, 
        tp_cert, dt_certificado, data1, data2, status, idcidade, averbacao, usuarioaverba, senhaaverba, atm, obsatm, nr_diaenvio, cli_bloqueado, integra_ats, ds_arquivo_contrato, ds_arquivo_certificado) 
      VALUES (LPAD('" . $cnpj . "',14,'0'), UPPER('$nome'), '" . $ie . "', '" . $tributacao . "', '" . $endereco . "', '" . $bairro . "',
      '" . $complemento . "', '" . $cep . "', '" . $responsavel . "', '" . $email . "', " . $contabilidade . ",
      '" . $emailcontabilidade . "', '" . $telefone . "', '" . $telefone2 . "', '" . $servico . "', '" . $base . "', '" . $gxml . "',
      '" . $certificado . "', " . $vencimento . ", " . $data . ", " . $data2 . ", '" . $status . "', " . $cidade . ",
      '" . $txtaverbacao . "', '" . $txtusuarioaverba . "','" . $txtsenhaaverba . "','" . $txtatm . "','" . $txtobsaverba . "', $seldia, '$txtbloqueado', '$txtintegracao', $txtarquivo_contrato, $txtarquivo_certificado) 
      RETURNING idcliente";
      echo "INSERT: $insert";
        $rss_insert = pg_query($conexao, $insert);

        while ($linha = pg_fetch_row($rss_insert)) {
            $id_cliente = $linha[0];

            $insert2 = "INSERT INTO tab_emissaocte (idcliente, obscte, obsprop, autenvio, enviofat, enviospeed) 
                      VALUES ('" . $id_cliente . "', '$obs2', '" . $obs . "', '" . $envio . "', '" . $placas . "', '" . $sped . "')";
echo "<pre>" . $insert2 . "</pre>";
            pg_query($conexao, $insert2);
        }

        if ($id_cliente != '') {
            echo "<script language='JavaScript'>
                    alert('Cliente cadastrado com sucesso!');
                    window.parent.executafuncao('new');
                    window.parent.consultar(0);
                  </script>";
        } else {
            echo "<script language='JavaScript'>alert('Problemas ao gravar!');</script>";
        }
    }
}
//=======================		ALTERACAO DOS DADOS
if ($Tipo == "A") {
    $SQL = "SELECT idcliente 
		FROM tab_clientes 
		WHERE cnpj='" . $cnpj . "' 
			AND idcliente<>" . $codigo . "  
    LIMIT 1";
    
    $RSS = pg_query($conexao, $SQL);
    if (pg_num_rows($RSS) > 0) {
        echo "<script language='JavaScript'>alert('Cliente ja cadastrado! Verifique.');</script>";
    } else {
      if ($data == ''){ $data = "NULL"; } else { $data = "'" . $data . "'"; }
      if ($data2 == ''){ $data2 = "NULL"; } else { $data2 = "'" . $data2 . "'"; }
      if ($contabilidade == '0' or $contabilidade == ''){ $contabilidade = "NULL"; } else { $contabilidade = "'" . $contabilidade . "'"; }
      if ($vencimento == ''){ $vencimento = "NULL"; } else { $vencimento = "'" . $vencimento . "'"; }
      if ($seldia == '0' or $seldia == ''){ $seldia = "NULL"; }

      //Instancia a variável que vai ser incluida no meio do SQL para atualizar o campo arquivo
      $setArquivoContrato = '';
      $setArquivoCertificado = '';

      //Verifica se $_FILES está setado, isto é, foi enviado um arquivo
      if($_FILES){
        //Inclui o helper que faz upload
        include '../../inc/upload_helper.php';

        if ($_FILES['contrato'] != ""){
          //Chama a função do helper que faz upload, passando o arquivo como primeiro parâmetro, e a pasta destino como segundo, gravando o retorno da função na variável
          $resultadoUpload = fileUpload($_FILES['contrato'], './documentos/');

          //Verifica se houve erro ao fazer upload
          if($resultadoUpload['error'] == true){
            header("Content-Type: application/json"); //Seta o retorno para tipo JSON, para ser mais fácil tratar no javascript
            header("HTTP/1.0 400 Bad Request");  //Seta o retorno como código 400, erro
            echo json_encode($resultadoUpload); //Imprime o resultado
            exit(); //Para a execução
          }

          //Se não parou a execução, dá sequencia

          $ds_arquivo_contrato = $resultadoUpload['filename']; //Pega o nome do arquivo enviado

          $setArquivoContrato = ", ds_arquivo_contrato = '$ds_arquivo_contrato'"; //Seta a string que fará a atualização do campo contrato
        }

        if ($_FILES['certificado'] != ""){
          //28/03/2020: Jean C. Klein
          //Chama a função do helper que faz upload, passando o arquivo como primeiro parâmetro, e a pasta destino como segundo, gravando o retorno da função na variável
          $resultadoUpload2 = fileUpload($_FILES['certificado'], './certificados/');

          //Verifica se houve erro ao fazer upload
          if($resultadoUpload2['error'] == true){
            header("Content-Type: application/json"); //Seta o retorno para tipo JSON, para ser mais fácil tratar no javascript
            header("HTTP/1.0 400 Bad Request");  //Seta o retorno como código 400, erro
            echo json_encode($resultadoUpload2); //Imprime o resultado
            exit(); //Para a execução
          }

          //Se não parou a execução, dá sequencia

          $ds_arquivo_certificado = $resultadoUpload2['filename']; //Pega o nome do arquivo enviado

          $setArquivoCertificado = ", ds_arquivo_certificado = '$ds_arquivo_certificado'"; //Seta a string que fará a atualização do campo contrato
        }
      }

      $update = "UPDATE tab_clientes SET 
                          razaosocial = UPPER('$nome'), 
                          inscestadual = '" . $ie . "', 
                          tributacao = '" . $tributacao . "', 
                          endereco = '" . $endereco . "', 
                          bairro = '" . $bairro . "', 
                          complemento = '" . $complemento . "', 
                          cep = '" . $cep . "', 
                          responsavel = '" . $responsavel . "', 
                          emailcli = '" . $email . "', 
                          idcontabilidade = " . $contabilidade . ",
                          emailcont = '" . $emailcontabilidade . "', 
                          fone1 = '" . $telefone . "', 
                          fone2 = '" . $telefone2 . "', 
                          sistema = '" . $servico . "', 
                          nmbasepri = '" . $base . "', 
                          gxml = '" . $gxml . "', 
                          tp_cert = '" . $certificado . "', 
                          dt_certificado = " . $vencimento . ", 
                          data1 = " . $data . ", 
                          data2 = " . $data2 . ", 
                          status = '" . $status . "', 
                          idcidade = " . $cidade . ",
                          averbacao='" . $txtaverbacao . "', 
                          usuarioaverba='" . $txtusuarioaverba . "', 
                          senhaaverba='" . $txtsenhaaverba . "', 
                          atm='" . $txtatm . "', 
                          obsatm='" . $txtobsaverba . "',
                          nr_diaenvio=$seldia,
                          cli_bloqueado='$txtbloqueado',
                          integra_ats='$txtintegracao'
                          $setArquivoContrato
                          $setArquivoCertificado
                    WHERE idcliente = $codigo";

        $resultado = pg_query($conexao, $update);
        if(!$resultado){
          header("HTTP/1.0 400 Bad Request");
          exit();
        }

        $update2 = "UPDATE tab_emissaocte SET
                          obscte = '$obs2', 
                          obsprop = '" . $obs . "', 
                          autenvio = '" . $envio . "', 
                          enviofat = '" . $placas . "', 
                          enviospeed = '" . $sped . "'
                    WHERE idcliente = $codigo";

        pg_query($conexao, $update2);

        return true;
    }
}

//=======================		EXCLUI O ARQUIVO DO CONTRATO
if ($Tipo == "excluirArquivo") {
  if(strlen($arquivo) == 0){
    exit();
  }

  if (file_exists("./documentos/$arquivo")) {
    unlink("./documentos/$arquivo");
    echo "Excluiu";
  }

  if(strlen($codigo) > 0){
    $SELECT = "UPDATE tab_clientes SET ds_arquivo_contrato = NULL WHERE idcliente = $codigo";
    echo "Atualizou";
    $RSS = pg_query($conexao, $SELECT);
  }
}

//=======================		EXCLUI O ARQUIVO DO CERTIFICADO
if ($Tipo == "excluirCertificado") {
  if(strlen($arquivo) == 0){
    exit();
  }

  if (file_exists("./certificados/$arquivo")) {
    unlink("./certificados/$arquivo");
    echo "Excluiu";
  }

  if(strlen($codigo) > 0){
    $SELECT = "UPDATE tab_clientes SET ds_arquivo_certificado = NULL WHERE idcliente = $codigo";
    echo "Atualizou";
    $RSS = pg_query($conexao, $SELECT);
  }
}


?>