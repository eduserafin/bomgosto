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
        echo "<script language='javascript'>window.parent.document.getElementById('txtcorprincipal').value='" . $RS["cor_principal"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtcorsecundaria').value='" . $RS["cor_secundaria"] . "';</script>";
        echo "<script language='javascript'>window.parent.atualizarCoresSelecionadas();</script>";
        echo "<script language='javascript'>window.parent.CarregarLoad('gerenciador/site/sobre.php?consultar=sim&codigo=" . $RS["nr_sequencial"] . "','sobre')</script>";
        echo "<script language='javascript'>window.parent.CarregarLoad('gerenciador/site/contato.php?consultar=sim&codigo=" . $RS["nr_sequencial"] . "','contato')</script>";
        echo "<script language='javascript'>window.parent.CarregarLoad('gerenciador/site/redes.php?consultar=sim&codigo=" . $RS["nr_sequencial"] . "','redes')</script>";
        echo "<script language='javascript'>window.parent.CarregarLoad('gerenciador/site/upload.php?consultar=sim&codigo=" . $RS["nr_sequencial"] . "','upload')</script>";
        echo "<script language='javascript'>window.parent.CarregarLoad('gerenciador/site/campanhas.php?consultar=sim&codigo=" . $RS["nr_sequencial"] . "','campanha')</script>";
        echo "<script language='javascript'>window.parent.CarregarLoad('gerenciador/site/produtos.php?consultar=sim&codigo=" . $RS["nr_sequencial"] . "','produto')</script>";
        echo "<script language='javascript'>window.parent.CarregarLoad('gerenciador/site/categorias.php?consultar=sim&codigo=" . $RS["nr_sequencial"] . "','categoria')</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').focus();</script>";
      
      }

  }

  //==========================================-INCLUSAO DOS DADOS-========================================

  if ($Tipo == "I") {

    // Substituir a letra 'X' de volta pelo caractere '#'
    $corprincipal = str_replace('X', '#', $corprincipal);
    $corsecundaria = str_replace('X', '#', $corsecundaria);

    $insert = "INSERT INTO configuracao_site (ds_nome, ds_secao1, ds_secao2, ds_secao3, ds_secao4, ds_secao5, ds_subsecao1, ds_subsecao2, ds_subsecao3, ds_subsecao4, ds_subsecao5, st_status, cor_principal, cor_secundaria, nr_seq_usercadastro) 
              VALUES ('" . $nome . "', '" . $secao1 . "',  '" . $secao2 . "', '" . $secao3 . "', '" . $secao4 . "', '" . $secao5 . "', '" . $subsecao1 . "', '" . $subsecao2 . "', '" . $subsecao3 . "', '" . $subsecao4 . "', '" . $subsecao5 . "', '" . $status . "', '" . $corprincipal . "', '" . $corsecundaria . "', " . $_SESSION["CD_USUARIO"] . ")";
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

    // Substituir a letra 'X' de volta pelo caractere '#'
    $corprincipal = str_replace('X', '#', $corprincipal);
    $corsecundaria = str_replace('X', '#', $corsecundaria);
    
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
                        cor_principal = '" . $corprincipal . "', 
                        cor_secundaria = '" . $corsecundaria . "', 
                        nr_seq_useralterado = " . $_SESSION["CD_USUARIO"] . ", 
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
    //echo $insert_rede;
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
              window.parent.CarregarLoad('gerenciador/site/redes.php?consultar=sim&codigo=" . $configuracao . "','redes')  
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

  //==================================- CADASTRAR CAMPANHAS-===============================================

  if ($Tipo == "CA") {

    $insert_campanha = "INSERT INTO campanhas_site (nr_seq_configuracao, ds_campanha, ds_icone, ds_imagem, st_ativo, ds_detalhamento) 
                    VALUES (" . $codigo . ", UPPER('" . $nome . "'), '" . $icone . "', '" . $imagem . "', '" . $status . "', '" . $detalhamento . "')";
    //echo $insert_campanha;
    $rss_insert = mysqli_query($conexao, $insert_campanha);

    if ($rss_insert) {

      echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Campanha cadastrada com sucesso!'
              }); 
              window.parent.executafuncao('new');
              window.parent.consultar(0);
              window.parent.CarregarLoad('gerenciador/site/campanhas.php?consultar=sim&codigo=" . $codigo . "','campanha')  
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

//==================================- EXCLUIR CAMPANHAS-===============================================

if ($Tipo == "ECA") {

  $delete = "DELETE FROM campanhas_site WHERE nr_sequencial = " . $codigo . "";
  $result = mysqli_query($conexao, $delete);

  if ($result) {

    echo "<script language='JavaScript'>
            window.parent.Swal.fire({
              icon: 'success',
              title: 'Show...',
              text: 'Campanha excluida com sucesso!'
            }); 
            window.parent.executafuncao('new');
            window.parent.consultar(0);
            window.parent.CarregarLoad('gerenciador/site/campanhas.php?consultar=sim&codigo=" . $configuracao . "','campanha')  
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

//==================================- CADASTRAR PRODUTOS-===============================================

if ($Tipo == "P") {

  $insert_produto = "INSERT INTO produtos_site (nr_seq_configuracao, ds_produto, ds_icone, ds_imagem, st_ativo, ds_detalhamento, nr_seq_categoria) 
                  VALUES (" . $codigo . ", UPPER('" . $nome . "'), '" . $icone . "', '" . $imagem . "', '" . $status . "', '" . $detalhamento . "', " . $categoria . ")";
  //echo $insert_produto;
  $rss_insert = mysqli_query($conexao, $insert_produto);

  if ($rss_insert) {

    echo "<script language='JavaScript'>
            window.parent.Swal.fire({
              icon: 'success',
              title: 'Show...',
              text: 'Produto cadastrado com sucesso!'
            }); 
            window.parent.executafuncao('new');
            window.parent.consultar(0);
            window.parent.CarregarLoad('gerenciador/site/produtos.php?consultar=sim&codigo=" . $codigo . "','produto')  
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

//==================================- CADASTRAR CONTEUDO PRODUTO-===============================================

if ($Tipo == "PC") {

  $update = "UPDATE configuracao_site
              SET ds_titulo_produto = '" . $titulo . "',
                  ds_conteudo_produto = '" . $conteudo . "',
                  nr_seq_useralterado = " . $_SESSION["CD_USUARIO"] . ", 
                  dt_alterado = CURRENT_TIMESTAMP   
            WHERE nr_sequencial=" . $codigo;
  mysqli_query($conexao, $update);

  if (mysqli_affected_rows($conexao) > 0) {
        
    echo "<script language='JavaScript'>
            window.parent.Swal.fire({
              icon: 'success',
              title: 'Show...',
              text: 'Configuração salva com sucesso!'
            }); 
            window.parent.executafuncao('new');
            window.parent.consultar(0);  
          </script>";

  } else {

    echo "<script language='JavaScript'>
            window.parent.Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Problemas ao salvar. Verifique!'
            });
          </script>";

  }

}

//==================================- EXCLUIR PRODUTOS-===============================================

if ($Tipo == "EP") {

  $delete = "DELETE FROM produtos_site WHERE nr_sequencial = " . $codigo . "";
  $result = mysqli_query($conexao, $delete);

  if ($result) {

    echo "<script language='JavaScript'>
            window.parent.Swal.fire({
              icon: 'success',
              title: 'Show...',
              text: 'Produto excluido com sucesso!'
            }); 
            window.parent.executafuncao('new');
            window.parent.consultar(0);
            window.parent.CarregarLoad('gerenciador/site/produtos.php?consultar=sim&codigo=" . $configuracao . "','produto')  
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

//==================================- CADASTRAR CATEGORIAS DE PRODUTOS-===============================================

if ($Tipo == "CAT") {

  $insert_categoria = "INSERT INTO categoria_produtos (nr_seq_configuracao, ds_categoria, st_ativo) 
                  VALUES (" . $codigo . ", UPPER('" . $categoria . "'), '" . $status . "')";
  //echo $insert_produto;
  $rss_insert = mysqli_query($conexao, $insert_categoria);

  if ($rss_insert) {

    echo "<script language='JavaScript'>
            window.parent.Swal.fire({
              icon: 'success',
              title: 'Show...',
              text: 'Categoria cadastrada com sucesso!'
            }); 
            window.parent.executafuncao('new');
            window.parent.consultar(0);
            window.parent.CarregarLoad('gerenciador/site/categorias.php?consultar=sim&codigo=" . $codigo . "','categoria')  
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

//==================================- EXCLUIR CATEGORIAS-===============================================

if ($Tipo == "ECAT") {

  $delete = "DELETE FROM categoria_produtos WHERE nr_sequencial = " . $codigo . "";
  $result = mysqli_query($conexao, $delete);

  if ($result) {

    echo "<script language='JavaScript'>
            window.parent.Swal.fire({
              icon: 'success',
              title: 'Show...',
              text: 'Categoria excluido com sucesso!'
            }); 
            window.parent.executafuncao('new');
            window.parent.consultar(0);
            window.parent.CarregarLoad('gerenciador/site/categorias.php?consultar=sim&codigo=" . $configuracao . "','categoria')  
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

//==================================- EXCLUIR IMAGENS-===============================================

if($Tipo == "ExcluirImagem"){
  
  $select = "SELECT ds_arquivo FROM upload WHERE nr_sequencial = $cdarquivo";
  $res = mysqli_query($conexao, $select);
  while($lin=mysqli_fetch_row($res)){ $ds_arquivo = $lin[0]; }

  $delete = "DELETE FROM upload WHERE nr_sequencial = $cdarquivo";
  mysqli_query($conexao, $delete); //echo $delete;

  unlink("imagens/" . $ds_arquivo);

  echo "<script language='JavaScript'>
      alert('Imagem excluida com sucesso!');
      window.parent.CarregarLoad('gerenciador/site/upload.php?consultar=sim&codigo=".$codigo."', 'upload');
  </script>";

}

//==================================- CADASTRAR IMAGENS-===============================================

if($Tipo == "AdicionarImagem"){


  $imagem = 'NULL';

  //Verifica se $_FILES está setado, isto é, foi enviado um arquivo
  if($_FILES){
      //Inclui o helper que faz upload
      include '../../inc/upload_helper.php';

      //Chama a função do helper que faz upload, passando o arquivo como primeiro parâmetro, e a pasta destino como segundo, gravando o retorno da função na variável
      $resultadoUpload = fileUpload($_FILES['imagem'], 'imagens/');

      //Verifica se houve erro ao fazer upload
      if($resultadoUpload['error'] == true){
          header("Content-Type: application/json"); //Seta o retorno para tipo JSON, para ser mais fácil tratar no javascript
          header("HTTP/1.0 400 Bad Request");  //Seta o retorno como código 400, erro
          echo json_encode($resultadoUpload); //Imprime o resultado
          exit(); //Para a execução
      }

      //Se não parou a execução, dá sequencia

      $ds_arquivo = $resultadoUpload['filename']; //Pega o nome do arquivo enviado

      $imagem = "'$ds_arquivo'"; //Seta a string 
  }

  $insert_imagem = "INSERT INTO upload (nr_seq_categoria, nr_seq_configuracao, ds_descricao, nr_seq_usuario, ds_arquivo)
          VALUES ($categoria, $codigo, '$descricao', ".$_SESSION["CD_USUARIO"].",  $imagem)";
  //echo $insert_imagem;
  $res_imagem = mysqli_query($conexao, $insert_imagem);

}


?>