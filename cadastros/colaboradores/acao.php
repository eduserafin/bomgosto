<?php
foreach($_GET as $key => $value){
	$$key = $value;
}

session_start(); 
include "../../conexao.php";

//=======================		CARREGA DADOS NO FORMULARIO
if ($Tipo == "D") {
    $SQL = "SELECT * 
            FROM colaboradores 
            WHERE nr_sequencial=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] == $Codigo) {
        echo "<script language='javascript'>window.parent.document.getElementById('cd_colab').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').value='" . $RS["ds_colaborador"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('sexo').value='" . $RS["tp_sexo"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txcpf').value='" . $RS["nr_cpf"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtrg').value='" . $RS["nr_rg"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('selfuncao').value='" . $RS["nr_seq_funcao"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtdataadm').value='" . $RS["dt_admissao"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtdatadem').value='" . $RS["dt_demissao"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtstatus').value='" . $RS["st_status"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txttelefone').value='" . $RS["nr_telefone"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtemail').value='" . $RS["ds_email"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtendereco').value='" . $RS["ds_endereco"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnrendereco').value='" . $RS["nr_endereco"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtbairro').value='" . $RS["ds_bairro"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtdscomplemento').value='" . $RS["ds_complemento"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('seluf').value='" . $RS["nr_seq_estado"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('selcidade').value='" . $RS["nr_seq_cidade"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtcep').value='" . $RS["nr_cep"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').focus();</script>";
    }
}

//=======================		INCLUSAO DOS DADOS
if ($Tipo == "I") {

    $SQL = "SELECT nr_sequencial 
            FROM colaboradores
            WHERE UPPER(ds_colaborador) = UPPER('" . $nome . "') 
            AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "
            LIMIT 1"; //echo  $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] !='') {

      echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Colaborador já cadastrado! Verifique.'
            });
        </script>";

    } else {

      $insert = "INSERT INTO colaboradores (ds_colaborador, tp_sexo, nr_cpf, nr_rg, nr_seq_funcao, dt_admissao, dt_demissao, st_status, nr_telefone, ds_email, ds_endereco, nr_endereco, ds_bairro, ds_complemento, nr_seq_estado, nr_seq_cidade, nr_cep, nr_seq_usercadastro, nr_seq_empresa) 
                  VALUES (UPPER('" . $nome . "'), '" . $sexo . "', '" . $cpf . "', '" . $rg . "', " . $funcao . ", '" . $dataadm . "' ,'" . $datadem . "', '" . $status . "', '" . $telefone . "', '" . $email . "', '" . $endereco . "', '" . $nrendereco . "', '" . $bairro . "', '" . $complemento . "', " . $estado . ", " . $cidade . ", '" . $cep . "' , " . $_SESSION["CD_USUARIO"] . ", " . $_SESSION["CD_EMPRESA"] . ")";
      $rss_insert = mysqli_query($conexao, $insert); //echo  $insert;

      // Valida se deu certo
      if ($rss_insert) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Colaborador cadastrado com sucesso!'
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

    $SQL = "SELECT nr_sequencial 
            FROM colaboradores
            WHERE UPPER(ds_colaborador) = UPPER('" . $nome . "')
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
                text: 'Colaborador já cadastrado! Verifique.'
            });
        </script>";

    } else {

      $update = "UPDATE colaboradores 
                SET ds_colaborador = UPPER('" . $nome . "'), 
                    tp_sexo = '" . $sexo . "', 
                    nr_cpf = '" . $cpf . "', 
                    nr_rg = '" . $rg . "', 
                    nr_seq_funcao = " . $funcao . ", 
                    dt_admissao = '" . $dataadm . "', 
                    dt_demissao = '" . $datadem . "', 
                    st_status = '" . $status . "', 
                    nr_telefone = '" . $telefone . "', 
                    ds_email = '" . $email . "', 
                    ds_endereco = '" . $endereco . "', 
                    nr_endereco = '" . $nrendereco . "', 
                    ds_bairro = '" . $bairro . "', 
                    ds_complemento = '" . $complemento . "', 
                    nr_seq_estado = '" . $estado . "', 
                    nr_seq_cidade = '" . $cidade . "', 
                    nr_cep = '" . $cep . "',
                    nr_seq_useralterado = " . $_SESSION["CD_USUARIO"] . ",
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
                    text: 'Colaborador alterado com sucesso!'
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

  $v_existe = 0;
  $SQL = "SELECT COUNT(*)  
          FROM usuarios
          WHERE nr_seq_colaborador = $codigo";
  $RSS = mysqli_query($conexao, $SQL);
  while ($line = mysqli_fetch_row($RSS)) {
    $v_existe = $line[0];
  }

  if ($v_existe > 0) {

    echo "<script language='javascript'>
            window.parent.Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Não é possível excluir o registro, colaborador está vinculado a um usuario!'
            });
        </script>";
        exit;

  } else {

    $delete = "DELETE FROM colaboradores WHERE nr_sequencial=" . $codigo;
    $result = mysqli_query($conexao, $delete);

    if ($result) {
    
      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Colaborador excluído com sucesso!'
              });
              window.parent.executafuncao('new');
              window.parent.consultar(0);
            </script>";

    } else {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Problemas ao excluir o colaborador. Verifique!'
              });
            </script>";

    }

  }

}
?>