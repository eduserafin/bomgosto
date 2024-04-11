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
                FROM configuracao_site
              WHERE nr_sequencial=" . $Codigo;
      $RSS = mysqli_query($conexao, $SQL);
      $RS = mysqli_fetch_assoc($RSS);

      if ($RS["nr_sequencial"] == $Codigo) {

        echo "<script language='javascript'>window.parent.document.getElementById('cd_configuracao').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').value='" . $RS["ds_nome"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtsecao1').value='" . $RS["ds_secao1"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtsubsecao1').value='" . $RS["ds_subsecao1"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtsecao2').value='" . $RS["ds_secao2"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtsubsecao2').value='" . $RS["ds_subsecao2"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtsecao3').value='" . $RS["ds_secao3"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtsubsecao3').value='" . $RS["ds_subsecao3"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtsecao4').value='" . $RS["ds_secao4"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtsubsecao4').value='" . $RS["ds_subsecao4"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtsecao5').value='" . $RS["ds_secao5"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtsubsecao5').value='" . $RS["ds_subsecao5"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtstatus').value='" . $RS["st_status"] . "';</script>";
        echo "<script language='javascript'>window.parent.CarregarLoad('gerenciador/site/sobre.php?consultar=sim&codigo=" . $RS["nr_sequencial"] . "','sobre')</script>";
        echo "<script language='javascript'>window.parent.CarregarLoad('gerenciador/site/contato.php?consultar=sim&codigo=" . $RS["nr_sequencial"] . "','contato')</script>";
        echo "<script language='javascript'>window.parent.CarregarLoad('gerenciador/site/redes.php?consultar=sim&codigo=" . $RS["nr_sequencial"] . "','redes')</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').focus();</script>";
      
      }

  }

  //==========================================-INCLUSAO DOS DADOS-========================================

  if ($Tipo == "I") {

    $insert = "INSERT INTO configuracao_site (ds_nome, ds_secao1, ds_secao2, ds_secao3, ds_secao4, ds_secao5, ds_subsecao1, ds_subsecao2, ds_subsecao3, ds_subsecao4, ds_subsecao5, st_status, cd_usercadastro) 
              VALUES ('" . $nome . "', '" . $secao1 . "',  '" . $secao2 . "', '" . $secao3 . "', '" . $secao4 . "', '" . $secao5 . "', '" . $subsecao1 . "', '" . $subsecao2 . "', '" . $subsecao3 . "', '" . $subsecao4 . "', '" . $subsecao5 . "', '" . $status . "', " . $_SESSION["CD_USUARIO"] . ")";
    //echo $insert;
    $rss_insert = mysqli_query($conexao, $insert);

    if ($rss_insert) {
      // Registro gravado com sucesso

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Prazo cadastrado com sucesso!'
              }); 
              window.parent.executafuncao('new');
              window.parent.consultar(0);  
            </script>";


    } else {

      // Erro ao gravar o registro
      //echo "Erro ao gravar o registro: " . mysqli_error($conexao);

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Problemas ao gravar!'
              });
            </script>";

      }
    
  }

  //==================================-ALTERACAO DOS DADOS-===============================================

  if ($Tipo == "A") {
    
      $update = "UPDATE configuracao_site
                    SET ds_nome = '" . $nome . "',
                        ds_secao1 = '" . $secao1 . "', 
                        ds_secao2 = '" . $secao2 . "', 
                        ds_secao3 = '" . $secao3 . "', 
                        ds_secao4 = '" . $secao4 . "', 
                        ds_secao5 = '" . $secao5 . "', 
                        ds_subsecao1 = '" . $subsecao1 . "', 
                        ds_subsecao2 = '" . $subsecao2 . "', 
                        ds_subsecao3 = '" . $subsecao3 . "', 
                        ds_subsecao4 = '" . $subsecao4 . "', 
                        ds_subsecao5 = '" . $subsecao5 . "', 
                        st_status = '" . $status . "', 
                        cd_useralterado = " . $_SESSION["CD_USUARIO"] . ", 
                        dt_alterado = CURRENT_TIMESTAMP   
                  WHERE nr_sequencial=" . $codigo;
        mysqli_query($conexao, $update);

        if (mysqli_affected_rows($conexao) > 0) {
        
          echo "<script language='JavaScript'>
                  window.parent.Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Configuração alterada com sucesso!'
                  }); 
                  window.parent.executafuncao('new');
                  window.parent.consultar(0);  
                </script>";

        } else {

          echo "<script language='JavaScript'>
                  window.parent.Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Problemas ao alterar configuração. Verifique!'
                  });
                </script>";

        }

       
    }


  //==================================-EXCLUSÃO DOS DADOS-===============================================

  if ($Tipo == "E") {

    $v_existe = 0;
    $SQL = "SELECT COUNT(nr_sequencial)  
              FROM configuracao_site 
            WHERE st_status = 'A'
            AND nr_sequencial <> $codigo";
    $RSS = mysqli_query($conexao, $SQL);
    while ($line = mysqli_fetch_row($RSS)) {$v_existe = $line[0];}

    if ($v_existe > 0) {

      $delete = "DELETE FROM configuracao_site WHERE nr_sequencial=" . $codigo;
      $result = mysqli_query($conexao, $delete);

      if ($result) {
      
        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                  icon: 'success',
                  title: 'Show...',
                  text: 'Configuração excluída com sucesso!'
                });
                window.parent.executafuncao('new');
                window.parent.consultar(0);
              </script>";

      } else {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Problemas ao excluir a configuração. Verifique!'
                });
              </script>";

      }

	  } else {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Não é possível excluir a configuração, não tem outra configuração ativa. Verifique!'
              });
            </script>";

    }

  }

  //==================================-CADASTRO SOBRE-===============================================

  if ($Tipo == "S") {

    $delete = "DELETE FROM sobre_site WHERE nr_seq_configuracao=" . $codigo;
    $result = mysqli_query($conexao, $delete);

    if ($result) {

      $insert_sobre = "INSERT INTO sobre_site (nr_seq_configuracao, ds_titulo, ds_conteudo, ds_titulo1, ds_conteudo1, ds_titulo2, ds_conteudo2) 
                      VALUES (" . $codigo . ", '" . $titulo . "',  '" . $conteudo . "', '" . $titulo1 . "', '" . $conteudo1 . "', '" . $titulo2 . "', '" . $conteudo2 . "')";
      //echo $insert_sobre;
      $rss_insert = mysqli_query($conexao, $insert_sobre);

      if ($rss_insert) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                  icon: 'success',
                  title: 'Show...',
                  text: 'Informações cadastrado com sucesso!'
                }); 
                window.parent.executafuncao('new');
                window.parent.consultar(0);  
              </script>";

      } else {

        // Erro ao gravar o registro
        echo "Erro ao gravar o registro: " . mysqli_error($conexao);

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Problemas ao gravar!'
                });
              </script>";
  
      }

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

  //==================================-CADASTRO CONTATO-===============================================

  if ($Tipo == "C") {

    $delete = "DELETE FROM contato_site WHERE nr_seq_configuracao=" . $codigo;
    $result = mysqli_query($conexao, $delete);

    if ($result) {

      $insert_contato = "INSERT INTO contato_site (nr_seq_configuracao, ds_titulo, ds_conteudo, nr_telefone, nr_whatsapp, ds_email) 
                      VALUES (" . $codigo . ", '" . $titulo . "',  '" . $conteudo . "', '" . $telefone . "', '" . $whatsapp . "', '" . $email . "')";
      //echo $insert_contato;
      $rss_insert = mysqli_query($conexao, $insert_contato);

      if ($rss_insert) {

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                  icon: 'success',
                  title: 'Show...',
                  text: 'Informações cadastrado com sucesso!'
                }); 
                window.parent.executafuncao('new');
                window.parent.consultar(0);  
              </script>";

      } else {

        // Erro ao gravar o registro
        echo "Erro ao gravar o registro: " . mysqli_error($conexao);

        echo "<script language='JavaScript'>
                window.parent.Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Problemas ao gravar!'
                });
              </script>";
  
      }

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

  //==================================-CADASTRO REDES SOCIAIS-===============================================

  if ($Tipo == "R") {

    $delete = "DELETE FROM redes_site WHERE nr_seq_rede = $rede AND nr_seq_configuracao=" . $codigo;
    $result = mysqli_query($conexao, $delete);

    $insert_rede = "INSERT INTO redes_site (nr_seq_configuracao, nr_seq_rede, ds_link, st_ativo) 
                    VALUES (" . $codigo . ", " . $rede . ",  '" . $link . "', '" . $status . "')";
    echo $insert_rede;
    $rss_insert = mysqli_query($conexao, $insert_rede);

    if ($rss_insert) {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Informações cadastrado com sucesso!'
              }); 
              window.parent.executafuncao('new');
              window.parent.consultar(0);
              window.parent.CarregarLoad('gerenciador/site/redes.php?consultar=sim&codigo=" . $codigo . "','redes')  
            </script>";

    } else {

      // Erro ao gravar o registro
      echo "Erro ao gravar o registro: " . mysqli_error($conexao);

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Problemas ao gravar!'
              });
            </script>";

    }

  } 

   //==================================- EXCLUIR CADASTRO REDES SOCIAIS-===============================================

   if ($Tipo == "ER") {

    $delete = "DELETE FROM redes_site WHERE nr_sequencial = " . $codigo . "";
    $result = mysqli_query($conexao, $delete);

    if ($result) {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Rede social excluida com sucesso!'
              }); 
              window.parent.executafuncao('new');
              window.parent.consultar(0);
              window.parent.CarregarLoad('gerenciador/site/redes.php?consultar=sim&codigo=" . $codigo . "','redes')  
            </script>";

    } else {

      // Erro ao gravar o registro
      echo "Erro ao gravar o registro: " . mysqli_error($conexao);

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Problemas ao excluir!'
              });
            </script>";

    }

  } 


  if ($Tipo == "produtos") {

  $del = "DELETE FROM produtos_site WHERE nr_seq_configuracao = $configuracao";
  mysqli_query($conexao, $del);

  $campo = array();
  $dados = array();
  $campo = explode("|", $produtos);

  for($i=0;$i<$qtdprodutos;$i++){

      $dados = explode(";", $campo[$i]);
      $produto = $dados[0];
      $icone = $dados[1];
      $descricao = $dados[2];

      if($qtdprodutos > 0){

        $insert_produto = "INSERT INTO produtos_site (nr_seq_configuracao, nr_ordem, ds_produto, ds_icone, ds_descricao) 
                          VALUES (" . $configuracao . ", " . $i . ",  '" . $produto . "', '" . $icone . "', '" . $descricao . "')";
        //echo $insert_produto;
        $rss_insert_produto = mysqli_query($conexao, $insert_produto);

      }
  }

  $del = "DELETE FROM campanhas_site WHERE nr_seq_configuracao = $configuracao";
  mysqli_query($conexao, $del);

  $campo1 = array();
  $dados1 = array();
  $campo1 = explode("|", $campanhas);

  for($i=0;$i<$qtdcampanhas;$i++){

    $dados1 = explode(";", $campo1[$i]);
    $campanha = $dados1[0];
    $icone = $dados1[1];

    if($qtdcampanhas > 0){

      $insert_campanha = "INSERT INTO campanhas_site (nr_seq_configuracao, nr_ordem, ds_campanha, ds_icone) 
                        VALUES (" . $configuracao . ", " . $i . ",  '" . $campanha . "', '" . $icone . "')";
      //echo $insert_campanha;
      $rss_insert_campanha = mysqli_query($conexao, $insert_campanha);

    }

  }

}
?>