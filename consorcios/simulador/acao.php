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
                FROM consorcio
              WHERE nr_sequencial=" . $Codigo;
      $RSS = mysqli_query($conexao, $SQL);
      $RS = mysqli_fetch_assoc($RSS);

      if ($RS["nr_sequencial"] == $Codigo) {

        echo "<script language='javascript'>window.parent.document.getElementById('cd_proposta').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').value='" . $RS["ds_nome"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtcredito').value='" . $RS["vl_credito_total"] . "';</script>";
        echo "<script language='javascript'> window.parent.document.getElementById('inicio').style='display: none;';</script>";
        echo "<script language='javascript'>window.parent.simulador('" . $RS["nr_sequencial"] . "');</script>";
        echo "<script language='javascript'>window.parent.cotas('" . $RS["nr_sequencial"] . "');</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').focus();</script>";
      
      }

  } 

  //=====================================-EDITAR SIMULAÇÃO-==============================================

  if ($Tipo == "ED") {

    $SQL = "SELECT * 
        FROM consorcio_propostas
      WHERE nr_sequencial=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);

    if ($RS["nr_sequencial"] == $Codigo) {
      
      echo "<script language='javascript'>window.parent.document.getElementById('cd_simulacao').value='" . $RS["nr_sequencial"] . "';</script>";
      echo "<script language='javascript'>window.parent.document.getElementById('txtcreditocota').value='" . $RS["vl_credito"] . "';</script>";
      echo "<script language='javascript'>window.parent.document.getElementById('selmes').value='" . $RS["nr_seq_mes"] . "';</script>";
      echo "<script language='javascript'>window.parent.document.getElementById('selprazo').value='" . $RS["nr_seq_prazo"] . "';</script>";
      echo "<script language='javascript'>window.parent.document.getElementById('txttaxa').value='" . $RS["pc_taxa"] . "';</script>";
      echo "<script language='javascript'>window.parent.document.getElementById('selplano').value='" . $RS["nr_seq_plano"] . "';</script>";
      echo "<script language='javascript'>window.parent.document.getElementById('txtseguro').value='" . $RS["pc_seguro"] . "';</script>";
      echo "<script language='javascript'>window.parent.document.getElementById('txtlance').value='" . $RS["pc_embutido"] . "';</script>";
      echo "<script language='javascript'>window.parent.document.getElementById('txtconvertidadas').value='" . $RS["nr_convertidas"] . "';</script>";
      echo "<script language='javascript'>window.parent.document.getElementById('txtreduzida').value='" . $RS["nr_seq_reduzida"] . "';</script>";
      echo "<script language='javascript'>window.parent.document.getElementById('txttipo').value='" . $RS["nr_seq_tipo"] . "';</script>";
      echo "<script language='javascript'>window.parent.document.getElementById('txtcotas').value='" . $RS["nr_cotas"] . "';</script>";
      echo "<script language='javascript'>window.parent.parcelas('" . $RS["nr_seq_plano"] . "');</script>";
      echo "<script language='javascript'>window.parent.cotas('" . $RS["nr_seq_proposta"] . "');</script>";
      echo "<script language='javascript'>window.parent.document.getElementById('txtcreditocota').focus();</script>";

    }

  }

  //==========================================-INCLUSAO DOS DADOS-========================================

  if ($Tipo == "I") {
  

    $insert = "INSERT INTO consorcio (ds_nome, vl_credito_total, cd_usercadastro) 
                VALUES (UPPER('" . $nome . "'), " . $credito . ", ". $_SESSION["CD_USUARIO"] . ") ";
    //echo $insert;

    if ($conexao->query($insert) === TRUE) {
        $resultado = $conexao->insert_id;

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                  icon: 'success',
                  title: 'Show...',
                  text: 'Simulação iniciada!'
                }); 
                window.parent.document.getElementById('inicio').style='display: none;';
                window.parent.simulador($resultado);
                window.parent.consultar(0);  
              </script>";
        
    } else {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Problemas ao iniciar simulação!'
              });
            </script>";
    }

  }

  //==================================-SIMULAR PROPOSTA-===============================================

  if ($Tipo == "S") {

    if($reduzida == "") {$reduzida = "NULL";}
    if($tipo == "") {$tipo = "NULL";}

    $insert_simulacao = "INSERT INTO consorcio_propostas (nr_seq_proposta, vl_credito, nr_cotas, nr_seq_mes, nr_seq_prazo, pc_taxa, nr_seq_plano, pc_seguro, vl_parcela1, vl_parcela2, pc_embutido, nr_convertidas, nr_seq_reduzida, nr_seq_tipo, cd_usercadastro) 
                            VALUES (" . $codigo . ", " . $credito . ", " . $cotas . ", " . $mes . ", " . $prazo . ", " . $taxa . ", " . $plano . ", " . $seguro . ", " . $parcela1 . ", " . $parcela2 . ", " . $lance . ", " . $convertidada . ", " . $reduzida . ", " . $tipo . ", ". $_SESSION["CD_USUARIO"] . ") ";
    //echo $insert_simulacao;

    if ($conexao->query($insert_simulacao) === TRUE) {
      $id_simulacao = $conexao->insert_id;

      $SQL = "SELECT nr_quantidade
                FROM consorcio_quantidade_mes
              WHERE nr_sequencial = $mes"; //echo $SQL;
      $RES = mysqli_query($conexao, $SQL);
      while($linhames=mysqli_fetch_row($RES)){
        $qtd_mes= $linhames[0];

      }

      $pc_lance = $lance / 100; // Transforma o lance em porcentagem 
      $lance_embutido = $credito * $pc_lance; //Calcula lance embutido
      $credito_liquido = $credito - $lance_embutido; //Calcula credito liquido

      if($plano == 1) { // Se for plano DEGRAU

        if($convertidada <= 60) { // Se as parcelas convertidas for < 60

          //Calcula o valor de recurso proprio necessario
          $vl_proprio = $convertidada * $parcela2; 
          $vl_proprio_final = $vl_proprio - $lance_embutido;

        } else if ($convertidada > 60) { // Se as parcelas convertidas for > 60

          //Calcula a soma das parcelas de ambos grupos
          $vl_proprio1 = 60 * $parcela2;
          $diferenca = $convertidada - 60;
          $vl_proprio2 = $diferenca * $parcela1;

          //Calcula o valor de recurso proprio necessario
          $vl_proprio = $vl_proprio1 + $vl_proprio2;
          $vl_proprio_final = $vl_proprio - $lance_embutido;

        }

      } else if($plano == 2) { // Se for plano LINEAR

        //Calcula o valor de recurso proprio necessario
        $vl_proprio = $convertidada * $parcela1;
        $vl_proprio_final = $vl_proprio - $lance_embutido;
        $parcela2 = 0;

      }

      $pc_taxa = $taxa / 100; // Converte taxa em porcentagem
      $taxa_adm = $pc_taxa * $credito; // calcula o valor da taxa

      $seguro_prestamista = $seguro * $qtd_mes; // calcula o seguro conforme a quantidade de meses

      $credito_taxa = $credito + $taxa_adm; // Soma o credito + a taxa calculada

      $seguro_operacao = ($seguro_prestamista / 100) * $credito_taxa; // calcula o seguro da operação 

      $credito_taxa_seguro = $credito_taxa + $seguro_operacao; // Calcula o valor da operação, credito + taxa calculada + seguro da operação

      $vl_saldo_devedor = $lance_embutido + $vl_proprio_final; // Calcula o saldo devedor + lance embutido + recurso proprio

      $parcela_apos1 = $credito_taxa_seguro - $vl_saldo_devedor; // Calcula a soma da operação - saldo devedor 

      $parcelas_finais1 = $parcela_apos1 / $qtd_mes - 1; // Calcula o valor da parcela apos contemplação - primeiro grupo

      $dif_parcela = $parcela1 - $parcelas_finais1;  // calcula a diferença de valor do grupo 1 para aplicar no grupo 2

      $parcelas_finais2=  $parcela2 - $dif_parcela; // Calcula o valor da parcela apos contemplação - Segundo grupo

      $insert_cotas = "INSERT INTO consorcio_propostas_cotas (nr_seq_simulacao, nr_seq_proposta, vl_credito, nr_cotas, vl_embutido, vl_liquido, vl_proprio, vl_parcela1, vl_parcela2, vl_parcela_final1, vl_parcela_final2, cd_usercadastro) 
            VALUES (" . $id_simulacao . ", " . $codigo . ", " . $credito . ", " . $cotas . ", " . $lance_embutido . ", " . $credito_liquido . ", " . $vl_proprio_final . ", " . $parcela1 . ", " . $parcela2 . ", " . $parcelas_finais1 . ", " . $parcelas_finais2 . ", ". $_SESSION["CD_USUARIO"] . ") ";
      //echo $insert_cotas;

      if ($conexao->query($insert_cotas) === TRUE) {
        $id_cota = $conexao->insert_id;

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                  icon: 'success',
                  title: 'Show...',
                  text: 'Simulação gravada com sucesso!'
                }); 
                window.parent.document.getElementById('inicio').style='display: none;';
                window.parent.simulador($codigo);
                window.parent.cotas($codigo);
                window.parent.consultar(0);  
              </script>";

      } else {

        $delete = "DELETE FROM consorcio_propostas WHERE nr_sequencial=" . $id_simulacao;
        mysqli_query($conexao, $delete); //echo $delete;

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Problemas ao simular, verifique os campos preenchidos no formulário!'
                });
              </script>";

      }

    } else {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Problemas ao simular, verifique os campos preenchidos no formulário!'
              });
            </script>";

    }

  }

  //==================================-EDITAR PROPOSTA-===============================================

  if ($Tipo == "ES") {

    if($reduzida == "") {$reduzida = "NULL";}
    if($tipo == "") {$tipo = "NULL";}

    $update = "UPDATE consorcio_propostas
                  SET vl_credito=" . $credito . ", 
                      nr_cotas=" . $cotas . ", 
                      nr_seq_mes=" . $mes . ", 
                      nr_seq_prazo=" . $prazo . ", 
                      pc_taxa=" . $taxa . ", 
                      nr_seq_plano=" . $plano . ", 
                      pc_seguro=" . $seguro . ", 
                      vl_parcela1=" . $parcela1 . ",
                      vl_parcela2=" . $parcela2 . ",
                      pc_embutido=" . $lance . ",
                      nr_convertidas=" . $convertidada . ",
                      nr_seq_reduzida=" . $reduzida . ", 
                      nr_seq_tipo=" . $tipo . ",
                      cd_useralterado=" . $_SESSION["CD_USUARIO"] . ", 
                      dt_alterado=CURRENT_TIMESTAMP   
                WHERE nr_sequencial=" . $simulacao;
      mysqli_query($conexao, $update); //echo $update;

      $delete = "DELETE FROM consorcio_propostas_cotas WHERE nr_seq_simulacao = $simulacao";
      mysqli_query($conexao, $delete); //echo $delete;
      
      $SQL = "SELECT nr_quantidade
                FROM consorcio_quantidade_mes
              WHERE nr_sequencial = $mes"; //echo $SQL;
      $RES = mysqli_query($conexao, $SQL);
      while($linhames=mysqli_fetch_row($RES)){
        $qtd_mes= $linhames[0];

      }

      $pc_lance = $lance / 100; // Transforma o lance em porcentagem 
      $lance_embutido = $credito * $pc_lance; //Calcula lance embutido
      $credito_liquido = $credito - $lance_embutido; //Calcula credito liquido

      if($plano == 1) { // Se for plano DEGRAU

        if($convertidada <= 60) { // Se as parcelas convertidas for < 60

          //Calcula o valor de recurso proprio necessario
          $vl_proprio = $convertidada * $parcela2; 
          $vl_proprio_final = $vl_proprio - $lance_embutido;

        } else if ($convertidada > 60) { // Se as parcelas convertidas for > 60

          //Calcula a soma das parcelas de ambos grupos
          $vl_proprio1 = 60 * $parcela2;
          $diferenca = $convertidada - 60;
          $vl_proprio2 = $diferenca * $parcela1;

          //Calcula o valor de recurso proprio necessario
          $vl_proprio = $vl_proprio1 + $vl_proprio2;
          $vl_proprio_final = $vl_proprio - $lance_embutido;

        }

      } else if($plano == 2) { // Se for plano LINEAR

        //Calcula o valor de recurso proprio necessario
        $vl_proprio = $convertidada * $parcela1;
        $vl_proprio_final = $vl_proprio - $lance_embutido;
        $parcela2 = 0;

      }

      $pc_taxa = $taxa / 100; // Converte taxa em porcentagem
      $taxa_adm = $pc_taxa * $credito; // calcula o valor da taxa

      $seguro_prestamista = $seguro * $qtd_mes; // calcula o seguro conforme a quantidade de meses

      $credito_taxa = $credito + $taxa_adm; // Soma o credito + a taxa calculada

      $seguro_operacao = ($seguro_prestamista / 100) * $credito_taxa; // calcula o seguro da operação 

      $credito_taxa_seguro = $credito_taxa + $seguro_operacao; // Calcula o valor da operação, credito + taxa calculada + seguro da operação

      $vl_saldo_devedor = $lance_embutido + $vl_proprio_final; // Calcula o saldo devedor + lance embutido + recurso proprio

      $parcela_apos1 = $credito_taxa_seguro - $vl_saldo_devedor; // Calcula a soma da operação - saldo devedor 

      $parcelas_finais1 = $parcela_apos1 / $qtd_mes - 1; // Calcula o valor da parcela apos contemplação - primeiro grupo

      $dif_parcela = $parcela1 - $parcelas_finais1;  // calcula a diferença de valor do grupo 1 para aplicar no grupo 2

      $parcelas_finais2=  $parcela2 - $dif_parcela; // Calcula o valor da parcela apos contemplação - Segundo grupo

      $insert_cotas = "INSERT INTO consorcio_propostas_cotas (nr_seq_simulacao, nr_seq_proposta, vl_credito, nr_cotas, vl_embutido, vl_liquido, vl_proprio, vl_parcela1, vl_parcela2, vl_parcela_final1, vl_parcela_final2, cd_usercadastro) 
            VALUES (" . $simulacao . ", " . $codigo . ", " . $credito . ", " . $cotas . ", " . $lance_embutido . ", " . $credito_liquido . ", " . $vl_proprio_final . ", " . $parcela1 . ", " . $parcela2 . ", " . $parcelas_finais1 . ", " . $parcelas_finais2 . ", ". $_SESSION["CD_USUARIO"] . ") ";

      if ($conexao->query($insert_cotas) === TRUE) {
        $id_cota = $conexao->insert_id;

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                  icon: 'success',
                  title: 'Show...',
                  text: 'Simulação alterada com sucesso!'
                }); 
                window.parent.document.getElementById('inicio').style='display: none;';
                window.parent.document.getElementById('cd_simulacao').value='';
                window.parent.simulador($codigo);
                window.parent.cotas($codigo);
                window.parent.consultar(0);  
              </script>";

      } else {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Problemas ao editar simulação, verifique os campos preenchidos no formulário!'
                });
              </script>";

      }

  }

  //==================================-EXCLUSÃO SIMULAÇÃO-===============================================

  if ($Tipo == "EX") {

    $delete_cotas = "DELETE FROM consorcio_propostas_cotas WHERE nr_seq_simulacao=" . $Codigo;
    mysqli_query($conexao, $delete_cotas); //echo $delete_cotas;

    $delete_simulacao = "DELETE FROM consorcio_propostas WHERE nr_sequencial=" . $Codigo;
    mysqli_query($conexao, $delete_simulacao); //echo $delete_simulacao;
    
    echo "<script language='JavaScript'>
            window.parent.Swal.fire({
              icon: 'success',
              title: 'Show...',
              text: 'Simulação excluída com sucesso!'
            });
            window.parent.document.getElementById('inicio').style='display: none;';
            window.parent.simulador($proposta);
            window.parent.cotas($proposta);
            window.parent.consultar(0);
          </script>";
  }

  //==================================-EXCLUSÃO PROPOSTA-===============================================

  if ($Tipo == "E") {

    
    $delete_cotas = "DELETE FROM consorcio_propostas_cotas WHERE nr_seq_proposta=" . $codigo;
    mysqli_query($conexao, $delete_cotas); //echo $delete_cotas;

    $delete_simulacao = "DELETE FROM consorcio_propostas WHERE nr_seq_proposta=" . $codigo;
    mysqli_query($conexao, $delete_simulacao); //echo $delete_simulacao;

    $delete_proposta = "DELETE FROM consorcio WHERE nr_sequencial=" . $codigo;
    mysqli_query($conexao, $delete_proposta); //echo $delete_proposta;
    
    echo "<script language='JavaScript'>
            window.parent.Swal.fire({
              icon: 'success',
              title: 'Show...',
              text: 'Proposta excluída com sucesso!'
            });
            window.parent.executafuncao('new');
            window.parent.consultar(0);
          </script>";

  }

?>