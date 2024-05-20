<?php

  foreach($_GET as $key => $value){
    $$key = $value;
  }

  require_once '../conexao.php';

  if($codigo != ""){

    $SQL0 = "SELECT cor_principal, cor_secundaria, ds_titulo_produto, ds_conteudo_produto
              FROM configuracao_site
            WHERE nr_sequencial = $codigo";
    //echo "<pre>$SQL0</pre>";
    $RSS0 = mysqli_query($conexao, $SQL0);
    while($linha0 = mysqli_fetch_row($RSS0)){
      $cor_principal = $linha0[0];
      $cor_secundaria = $linha0[1];
      $ds_titulo = $linha0[2];
      $ds_conteudo = $linha0[3];
    }

    $ds_arquivo1 = "";
    $SQL1 = "SELECT ds_arquivo
              FROM upload
            WHERE nr_seq_configuracao = $codigo
            AND nr_seq_categoria = 1";
    $RSS1 = mysqli_query($conexao, $SQL1);
    while($linha1 = mysqli_fetch_row($RSS1)){
      $ds_arquivo1 = $linha1[0];
    }

    $v_marcas = 0;
    $SQLM = "SELECT COUNT(*)
              FROM upload
            WHERE nr_seq_configuracao = $codigo
            AND nr_seq_categoria = 3";
    $RSSM = mysqli_query($conexao, $SQLM);
    while($linham = mysqli_fetch_row($RSSM)){
      $v_marcas = $linham[0];
    }

    $v_produto = 0;
    $SQLP = "SELECT COUNT(nr_sequencial)
                FROM produtos_site
              WHERE nr_seq_configuracao = $codigo
              AND st_ativo = 'A'";
    $RSSP = mysqli_query($conexao, $SQLP);
    while($linhap = mysqli_fetch_row($RSSP)){
      $v_produto = $linhap[0];
    }

  }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $ds_nome; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <!-- Ionicons CSS-->
    <link rel="stylesheet" href="css/ionicons.min.css">
    <!-- Device mockups CSS-->
    <link rel="stylesheet" href="css/device-mockups.css">
    <!-- Google fonts - Source Sans Pro-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <!-- Swiper sLider-->
    <link rel="stylesheet" href="vendor/swiper/css/swiper.min.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="../gerenciador/site/imagens/<?php echo $ds_arquivo1; ?>">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

        <style>
           /* Estilos para o footer */
          .footer {
            background-color: <?php echo $cor_principal; ?>; /* Cor de fundo do footer */
            color: #fff; /* Cor do texto dentro do footer */
            padding: 20px 0; /* Espaçamento interno do footer */
          }
          
          .social-link {
            color: #fff; /* Cor dos ícones sociais */
            text-decoration: none; /* Remover sublinhado dos links */
          }
          
          .social-link:hover {
            color: <?php echo $cor_secundaria; ?>;; /* Cor dos ícones sociais ao passar o mouse */
          }
          
          .copyrights-text {
            margin-top: 10px; /* Espaçamento acima do texto de direitos autorais */
          }

          .btn-primary-simulador {
            transition: background-color 0.3s ease; /* Adiciona um efeito de transição de cor */
            background-color: <?php echo $cor_principal; ?>;
            border-color: <?php echo $cor_principal; ?>; /* Adicionando a mesma cor para a borda */
            height: 45px; /* Defina o tamanho desejado para a altura */
            color: #FFFFFF;
          }

          .btn-primary-simulador:hover {
            background-color: <?php echo $cor_secundaria; ?>; /* Escurecendo um pouco ao passar o mouse */
            border-color: <?php echo $cor_secundaria; ?>; /* Também escurecendo a borda ao passar o mouse */
            color: #FFFFFF;
          }

          a {
            color: <?php echo $cor_principal; ?>;
            text-decoration: none;
            -webkit-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
            outline: none;
          }

          a:hover {
            color: <?php echo $cor_secundaria; ?>;
            text-decoration: none;
            -webkit-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
            outline: none;
          }

          .icon {
            font-size: 1rem; /* Defina o tamanho desejado para o ícone maior */
          }

          .detalhamento {
            font-family: Arial, sans-serif;
            font-size: 16px;
            color: #333;
            padding: 10px;
            border-radius: 5px;
            line-height: 1.6;
            margin: 10px 0;
            text-align: justify;
          }

          .titulo{
            color: <?php echo $cor_principal; ?>
          }

          .titulo1{
            color: #FFFFFF;
          }

          .p-branco{
            color: #FFFFFF;
          }


        </style>

  </head>
  <body>
    <!-- navbar-->
    <header class="header">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <!-- Navbar brand--><a href="index.php" class="navbar-brand font-weight-bold"><img src="../gerenciador/site/imagens/<?php echo $ds_arquivo1; ?>" alt="..." class="img-fluid"></a>
          <!-- Navbar toggler button-->
          <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right">Menu<i class="icon ion-md-list ml-2"></i></button>
          <div id="navbarSupportedContent" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto ml-auto">
                  <!-- Link-->
                  <li class="nav-item"> <a href="index.php?codigo=<?php echo $codigo; ?>" class="nav-link">Home</a></li>
                  <!-- Link-->
                  <?php if($v_produto > 0){ ?>
                    <li class="nav-item"> <a href="produtos.php?codigo=<?php echo $codigo; ?>" class="nav-link">Consórcios</a></li>
                  <?php } ?>
                  <!-- Link-->
                  <li class="nav-item"> <a href="sobre.php?codigo=<?php echo $codigo; ?>" class="nav-link">Sobre</a></li>
                  <!-- Link-->
                  <li class="nav-item"> <a href="contato.php?codigo=<?php echo $codigo; ?>&tipo=C" class="nav-link">Contato</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </header> 
    <iframe name="acao" width="0" height="0" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>
    <div class="page-holder">   
      <!-- Hero Section-->
      <section class="hero shape-1 shape-1-sm">
        <div class="container">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 pl-0">
              <li class="breadcrumb-item"><a href="index.html" class="animsition-link">Home</a></li>
              <li aria-current="page" class="breadcrumb-item active">Consórcios</li>
            </ol>
          </nav>
          <h2 class="hero-heading titulo"><?php echo $ds_titulo; ?></h2>
          <div class="row">
            <div class="col-lg-8">
              <p class="lead font-weight-light"><?php echo $ds_conteudo; ?></p>
            </div>
          </div>
          <!-- Platforms-->
          <?php if($v_marcas > 0) { ?>
            <div class="platforms mt-4 d-none d-lg-block"><span class="platforms-title">Compatible with</span>
              <ul class="platforms-list list-inline">
                <li class="list-inline-item"><img src="img/netflix.svg" alt="" class="platform-image img-fluid"></li>
                <li class="list-inline-item"><img src="img/apple.svg" alt="" class="platform-image img-fluid"></li>
                <li class="list-inline-item"><img src="img/android.svg" alt="" class="platform-image img-fluid"></li>
                <li class="list-inline-item"><img src="img/windows.svg" alt="" class="platform-image img-fluid"></li>
                <li class="list-inline-item"><img src="img/synology.svg" alt="" class="platform-image img-fluid"></li>
              </ul>
            </div>
          <?php } ?>
        </div>
      </section>
      <!-- Schedule Section-->
      <section class="schedule shape-2">
        <div class="container">
          <div class="schedule-table">
            <div id="nav-tabContent" class="tab-content">
              <?php 

              if($produto != ""){
                $v_filtro = "AND p.nr_sequencial = $produto";
              }

                $SQLP = "SELECT p.nr_sequencial, p.ds_produto, p.ds_imagem, p.ds_detalhamento, c.ds_categoria 
                          FROM produtos_site p 
                          INNER JOIN categoria_produtos c ON c.nr_sequencial = p.nr_seq_categoria 
                          WHERE p.nr_seq_configuracao = $codigo 
                          AND p.st_ativo = 'A'
                          " . $v_filtro . "";
                $RSSP = mysqli_query($conexao, $SQLP);
                while($linhap = mysqli_fetch_row($RSSP)){
                  $nr_produto = $linhap[0];
                  $ds_produto = $linhap[1];
                  $ds_imagem = $linhap[2];
                  $ds_detalhamento = $linhap[3];
                  $ds_categoria = $linhap[4];

                  ?>

                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="../gerenciador/site/imagens/<?php echo $ds_imagem; ?>" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9">
                        <h3 class="schedule-item-name"><?php echo $ds_produto; ?> 
                          <a href="javascript:void(0);" class="btn btn-primary-simulador" data-toggle="modal" data-target="#modalSimulador" data-produto="<?php echo $nr_produto; ?>">Simule agora <i class="icon ion-md-arrow-round-forward"></i></a>
                        </h3>
                        <p class="detalhamento"><?php echo $ds_detalhamento; ?></p>
                        </div>
                      </div>
                    </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- modal simulador -->
    <div class="modal fade" id="modalSimulador" tabindex="-1" role="dialog" aria-labelledby="modalSimuladorLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <div class="col-md-12" style="background-color: <?php echo $cor_principal; ?>;">
                    <div id="simuladorProduto">
                      <h2 class="hero-heading titulo1 mt-5" style="text-align: center;">Simule seu consórcio</h2>
                      <div class="col-md-12 mt-5">
                        <p class="p-branco" style="text-align: center; font-size: 25px;">Selecione uma categoria</p>
                        <?php
                          $SQLP = "SELECT nr_sequencial, ds_imagem
                                    FROM produtos_site 
                                    WHERE nr_seq_configuracao = $codigo 
                                    AND st_ativo = 'A'";
                          $RSSP = mysqli_query($conexao, $SQLP);
                          while($linhap = mysqli_fetch_row($RSSP)){
                            $nr_produto = $linhap[0];
                            $ds_imagem = $linhap[1];
                            ?>
                              
                            <img src="../gerenciador/site/imagens/<?php echo $ds_imagem; ?>" class="img-fluid produto-imagem-produto" produto-data-produto="<?php echo $nr_produto; ?>" style="width: 90px; height: auto;">
                            <?php 
                          }
                        ?>
                      </div>

                      <div class="col-md-12 mt-5">
                        <p class="p-branco" style="text-align: center; font-size: 25px;">Informe o valor do consórcio</p>
                        <input type="text" name="txtvalorproduto" id="txtvalorproduto" style="text-align: center; font-size: 30px;" class="form-control" onkeypress="return formatar_moeda_produto(this,'.',',',event);" placeholder="0,00" required>
                      </div>

                      <div class="col-md-12 mt-5" style="text-align: center;">
                        <button type="button" class="btn btn-primary-proximo" style="text-align: center; font-size: 20px;" onClick="javascript: mostrarFormularioProduto();">Próximo</button>
                      </div>
                    </div>

                    <div id="formularioProduto" style="display: none;">
                      <p class="p-branco mt-3" style="text-align: center; font-size: 25px;">Preencha os campos abaixo para ver sua simulação!</p>
                    
                      <div class="form-group mt-5">
                          <input type="text" name="txtnomeproduto" id="txtnomeproduto" class="form-control" placeholder="Nome" required>
                      </div>
                      <div class="form-group">
                          <input type="email" name="txtemailproduto" id="txtemailproduto" class="form-control" placeholder="E-mail" required>
                      </div>
                      <div class="form-group">
                          <input type="number" name="txttelefoneproduto" id="txttelefoneproduto" class="form-control" placeholder="Telefone" required>
                      </div>
                      <div class="form-group">          
                          <select id="txtcidadeproduto" class="form-control">
                              <option value='0'>Selecione uma cidade</option>
                              <?php
                              $sql = "SELECT cd_municipioibge, CONCAT(ds_municipioibge, ' - ', sg_estado) AS municipio_estado
                                        FROM municipioibge
                                        WHERE ds_municipioibge NOT LIKE '%TRIAL%'
                                      ORDER BY ds_municipioibge, sg_estado;";
                              $res = mysqli_query($conexao, $sql);
                              while($lin=mysqli_fetch_row($res)){
                                  $cdg = $lin[0];
                                  $desc = $lin[1];

                                  echo "<option value='$cdg'>$desc</option>";
                              }
                              ?>
                          </select>
                      </div>
                      <div class="col-md-12 mt-5" style="text-align: center;">
                        <button type="button" class="btn btn-primary-proximo" style="text-align: center; font-size: 20px;" onClick="javascript: enviarSimulacaoProduto();">Ver Resultado</button>
                      </div>
                    </div>
                    <br><br>
                </div>
              </div>
              <div class="modal-body">
                  <div id="detalhesSimulador"></div>
              </div>
          </div>
      </div>
    </div>

    <footer class="footer">
      <div class="container text-center">
        <!-- Copyrights-->
        <div class="copyrights">
          <!-- Social menu-->
          <ul class="social list-inline-item">
            <?php 
              $SQL = "SELECT r.ds_link, rs.ds_icone
                          FROM redes_site r
                          INNER JOIN redes_sociais rs ON rs.nr_sequencial = r.nr_seq_rede
                      WHERE nr_seq_configuracao = $codigo
                      AND r.st_ativo = 'A'
                      ORDER BY rs.ds_rede ASC";
              //echo $SQL;
              $RSS = mysqli_query($conexao, $SQL);
              while ($linha = mysqli_fetch_row($RSS)) {
                $ds_link = $linha[0];
                $ds_icone = $linha[1];

                ?>
                <li class="list-inline-item"><a href="<?php echo $ds_link; ?>" target="_blank" class="social-link"><i class="<?php echo $ds_icone; ?>" style="font-size: 50px;"></i></a></li>
            <?php } ?>
          </ul>
          <p class="copyrights-text mb-0">Copyright © 2024 Csimulador. Todos os direitos reservados.</p>
        </div>
      </div>
    </footer>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/swiper/js/swiper.min.js"></script>
    <script src="js/front.js"></script>
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID.-->
    <!---->
    <script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='//www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      ga('create','UA-XXXXX-X');ga('send','pageview');
    </script>

    <script>
      // Variável global para armazenar o produto selecionado
      var produtoSelecionado = null;

      // Função para definir o produto selecionado no modal
      function setProdutoNoModal(produto) {
        produtoSelecionado = produto;
        document.querySelectorAll('.produto-imagem-produto').forEach(function(img) {
          if (img.getAttribute('produto-data-produto') === produto) {
            img.style.border = '2px solid white';  // Seleciona a imagem do produto
          } else {
            img.style.border = 'none';  // Desmarca as outras imagens
          }
        });
      }

      // Adicionar o evento de clique aos botões "Simule agora"
      document.querySelectorAll('.btn-primary-simulador').forEach(function(button) {
        button.addEventListener('click', function() {
          var produto = this.getAttribute('data-produto');
          setProdutoNoModal(produto);
        });
      });

      function formatar_moeda_produto(campo, separador_milhar, separador_decimal, tecla) {
        var sep = 0;
        var key = '';
        var i = j = 0;
        var len = len2 = 0;
        var strCheck = '0123456789';
        var aux = aux2 = '';
        var whichCode = (window.Event) ? tecla.which : tecla.keyCode;

        if (whichCode == 13) return true; // Tecla Enter
        if (whichCode == 8) return true; // Tecla Delete
        key = String.fromCharCode(whichCode); // Pegando o valor digitado
        if (strCheck.indexOf(key) == -1) return false; // Valor inválido (não inteiro)
        len = campo.value.length;
        for (i = 0; i < len; i++)
            if ((campo.value.charAt(i) != '0') && (campo.value.charAt(i) != separador_decimal)) break;
        aux = '';
        for (; i < len; i++)
            if (strCheck.indexOf(campo.value.charAt(i)) != -1) aux += campo.value.charAt(i);
        aux += key;
        len = aux.length;
        if (len == 0) campo.value = '';
        if (len == 1) campo.value = '0' + separador_decimal + '0' + aux;
        if (len == 2) campo.value = '0' + separador_decimal + aux;

        if (len > 2) {
            aux2 = '';

            for (j = 0, i = len - 3; i >= 0; i--) {
                if (j == 3) {
                    aux2 += separador_milhar;
                    j = 0;
                }
                aux2 += aux.charAt(i);
                j++;
            }

            campo.value = '';
            len2 = aux2.length;
            for (i = len2 - 1; i >= 0; i--)
                campo.value += aux2.charAt(i);
            campo.value += separador_decimal + aux.substr(len - 2, len);
        }

        return false;
      }

      function mostrarFormularioProduto() {
        var valor = document.getElementById("txtvalorproduto").value;
        if (produtoSelecionado !== null) {
          var produto = produtoSelecionado;
        } else {
          alert('Selecione uma categoria para simular o consórcio!');
          return; // Adicionei um return para parar a execução se não houver produto selecionado
        }

        if (valor == "") {
          alert('Informe o valor para simular seu consórcio!');
          document.getElementById('txtvalorproduto').focus();
        } else {
          // Oculta o conteúdo atual
          var simulador = document.getElementById('simuladorProduto');
          if (simulador) {
            simulador.style.display = 'none';
          }
          // Mostra o formulário
          var formulario = document.getElementById('formularioProduto');
          if (formulario) {
            formulario.style.display = 'block';
          }
        }
      }


      function enviarSimulacaoProduto() {
        var tipo = 'S';
        var modal = 'S';
        var valor = document.getElementById("txtvalorproduto").value;
        if (produtoSelecionado !== null) {
          var produto = produtoSelecionado;
        } else {
          alert('Categoria não selecionada!');
          return; // Adicionei um return para parar a execução se não houver produto selecionado
        }
        var nome = document.getElementById('txtnomeproduto').value;
        var email = document.getElementById("txtemailproduto").value;
        var telefone = document.getElementById('txttelefoneproduto').value;
        var cidade = document.getElementById('txtcidadeproduto').value;

        if (nome == "") {
          alert('Informe o seu Nome!');
          document.getElementById('txtnomeproduto').focus();
        } else if (cidade == 0) {
          alert('Informe a sua Cidade!');
          document.getElementById('txtcidadeproduto').focus();
        } else if (email == '' && telefone == '') {
          alert('Preencha pelo menos um dos campos de contato (Email ou Telefone)!');
          if (email == '') {
            document.getElementById("txtemailproduto").focus();
          } else if (telefone == '') {
            document.getElementById('txttelefoneproduto').focus();
          }
        } else {
          window.open('acao.php?Tipo=SL&tipo=' + tipo + '&nome=' + nome + '&email=' + email + '&telefone=' + telefone + '&cidade=' + cidade + '&valor=' + valor + '&produto=' + produto + '&modal=' + modal, "acao");
        }
      }


      function fecharModalSimulador() {
        $('#modalSimulador').modal('hide');
      }

    </script>
   
  </body>
</html>