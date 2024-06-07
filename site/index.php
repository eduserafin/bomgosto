<?php

  foreach($_GET as $key => $value){
    $$key = $value;
  }

  require_once '../conexao.php';

  $ip = $_SERVER['REMOTE_ADDR']; // Obtém o endereço IP do visitante

  // Verifica se o IP já foi registrado recentemente (por exemplo, nas últimas 24 horas)
  $ip_count = 0;
  $sql = "SELECT COUNT(*) AS ip_count FROM acessos WHERE ip = '$ip' AND data >= NOW() - INTERVAL 1 DAY";
  $rss = mysqli_query($conexao, $sql);
  while ($linha = mysqli_fetch_row($rss)){
    $ip_count = $linha[0];
  }

  if ($ip_count == 0) {
      // Insere um novo registro de acesso
      $insert = "INSERT INTO acessos (data, ip) VALUES (CURRENT_TIMESTAMP, '$ip')";
      $rss_insert = mysqli_query($conexao, $insert);
  } 

  $SQL = "SELECT ds_nome, ds_secao1, ds_subsecao1, ds_secao2, ds_subsecao2, ds_secao3, ds_subsecao3,
            ds_secao4, ds_subsecao4, ds_secao5, ds_subsecao5, nr_sequencial, cor_principal, cor_secundaria
            FROM configuracao_site
          WHERE st_status = 'A'
          ORDER BY nr_sequencial LIMIT 1";
  $RSS = mysqli_query($conexao, $SQL);
  while ($linha = mysqli_fetch_row($RSS)){
    $ds_nome = $linha[0];
    $ds_secao1 = $linha[1];
    $ds_subsecao1 = $linha[2];
    $ds_secao2 = $linha[3];
    $ds_subsecao2 = $linha[4];
    $ds_secao3 = $linha[5];
    $ds_subsecao3 = $linha[6];
    $ds_secao4 = $linha[7];
    $ds_subsecao4 = $linha[8];
    $ds_secao5 = $linha[9];
    $ds_subsecao5 = $linha[10];
    $codigo = $linha[11];
    $cor_principal = $linha[12];
    $cor_secundaria = $linha[13];
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

  if($ds_arquivo1 == ""){
    $caminho1 = "img/Csimulador.png";
  } else {
    $caminho1 = "../gerenciador/site/imagens/$ds_arquivo1";
  }

  $ds_arquivo2 = "";
  $SQL2 = "SELECT ds_arquivo
            FROM upload
          WHERE nr_seq_configuracao = $codigo
          AND nr_seq_categoria = 2";
  $RSS2 = mysqli_query($conexao, $SQL2);
  while($linha2 = mysqli_fetch_row($RSS2)){
    $ds_arquivo2 = $linha2[0];
  }

  if($ds_arquivo2 == ""){
    $caminho2 = "img/Csimulador.png";
  } else {
    $caminho2 = "../gerenciador/site/imagens/$ds_arquivo2";
  }

  $ds_arquivo3 = "";
  $SQL3 = "SELECT ds_arquivo
            FROM upload
          WHERE nr_seq_configuracao = $codigo
          AND nr_seq_categoria = 4";
  $RSS3 = mysqli_query($conexao, $SQL3);
  while($linha3 = mysqli_fetch_row($RSS3)){
    $ds_arquivo3 = $linha3[0];
  }

  if($ds_arquivo3 == ""){
    $caminho3 = "img/Csimulador.png";
  } else {
    $caminho3 = "../gerenciador/site/imagens/$ds_arquivo3";
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

  $v_marcas = 0;
  $SQLM = "SELECT COUNT(*)
            FROM upload
          WHERE nr_seq_configuracao = $codigo
          AND nr_seq_categoria = 3";
  $RSSM = mysqli_query($conexao, $SQLM);
  while($linham = mysqli_fetch_row($RSSM)){
    $v_marcas = $linham[0];
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
    <link rel="shortcut icon" href="<?php echo $caminho1; ?>">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

        <style>
          /* Estilos personalizados */
          .card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
            background-color: #f8f9fa; /* Cor de fundo cinza */
          }
          .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            background-color: <?php echo $cor_secundaria; ?>; /* Cor de fundo cinza escuro quando passar o mouse */
          }

          .btn-with-icon {
            position: relative; /* Para alinhar o ícone corretamente */
          }

          .icon {
            font-size: 2rem; /* Defina o tamanho desejado para o ícone maior */
          }

          .small-icon {
            font-size: 1rem; /* Defina o tamanho desejado para o ícone pequeno */
          }

          .btn-primary {
            transition: background-color 0.3s ease; /* Adiciona um efeito de transição de cor */
            background-color: <?php echo $cor_principal; ?>;
            border-color: <?php echo $cor_principal; ?>; /* Adicionando a mesma cor para a borda */
            height: 50px; /* Defina o tamanho desejado para a altura */
          }

          .btn-primary:hover {
            background-color: <?php echo $cor_secundaria; ?>; /* Escurecendo um pouco ao passar o mouse */
            border-color: <?php echo $cor_secundaria; ?>; /* Também escurecendo a borda ao passar o mouse */
          }

          .btn-primary-proximo {
            transition: background-color 0.3s ease; /* Adiciona um efeito de transição de cor */
            background-color: <?php echo $cor_secundaria; ?>;
            border-color: <?php echo $cor_secundaria; ?>; /* Adicionando a mesma cor para a borda */
            height: 50px; /* Defina o tamanho desejado para a altura */
            color: #FFFFFF;
          }

          .btn-primary-proximo:hover {
            background-color: <?php echo $cor_principal; ?>; /* Escurecendo um pouco ao passar o mouse */
            border-color: <?php echo $cor_principal; ?>; /* Também escurecendo a borda ao passar o mouse */
            color: #FFFFFF;
          }

          .gradient-icon {
            border-radius: 0.8rem;
            width: 3.5rem;
            height: 3.5rem;
            color: #fff;
            background-color: <?php echo $cor_principal; ?> !important;
            line-height: 3.5rem;
            text-align: center;
            display: inline-block;
            margin-bottom: 1rem;
            font-size: 1.4rem;
          }

          .gradient-1 {
            background: linear-gradient(150deg, <?php echo $cor_principal; ?>, <?php echo $cor_principal; ?>) !important;
            -webkit-box-shadow: 0 2px 4px rgba(36, 8, 128, 0.2);
            box-shadow: 0 2px 4px rgba(36, 8, 128, 0.2);
          }

          .card-title {
            color: #333;
          }
          .card-text {
            color: #666;
          }

          /* Reduzindo o padding da seção de assinatura */
          .subscription {
              padding-top: 10px; /* Ajuste conforme necessário */
              padding-bottom: 10px; /* Ajuste conforme necessário */
          }

          /* Reduzindo as margens superior e inferior da primeira seção */
          .app-showcase {
              margin-bottom: 10px; /* Ajuste conforme necessário */
          }

          /* Se necessário, também pode ajustar o padding interno da div container dentro da seção de assinatura */
          .subscription .container {
              padding-top: 10px; /* Ajuste conforme necessário */
              padding-bottom: 10px; /* Ajuste conforme necessário */
          }

          /* Estilos para o footer */
          .footer {
            background-color: <?php echo $cor_principal; ?>;/* Cor de fundo do footer */
            color: #fff; /* Cor do texto dentro do footer */
            padding: 20px 0; /* Espaçamento interno do footer */
          }
          
          .social-link {
            color: #fff; /* Cor dos ícones sociais */
            text-decoration: none; /* Remover sublinhado dos links */
          }
          
          .social-link:hover {
            color: <?php echo $cor_secundaria; ?> /* Cor dos ícones sociais ao passar o mouse */
          }
          
          .copyrights-text {
            margin-top: 10px; /* Espaçamento acima do texto de direitos autorais */
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

          .container {
            max-width: 1200px; /* Ajuste o valor conforme necessário para definir a largura máxima */
            margin: 0 auto; /* Centraliza o container na tela */
          }

        </style>

  </head>
  <body>
    <iframe name="acao" width="0" height="0" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>
    <!-- navbar-->
    <header class="header">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
        <a href="index.php" class="navbar-brand font-weight-bold"><img src="<?php echo $caminho1; ?>" class="img-fluid"></a>
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
    <div class="page-holder">
      <!-- SEÇÃO 1-->
      <section class="hero shape-1">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-8">
              <h2 class="hero-heading titulo"><?php echo $ds_secao1; ?></h2>
              <p class="lead mt-2 font-weight-light"><?php echo $ds_subsecao1; ?></p>
              <div class="screen"><img src="<?php echo $caminho3; ?>" alt="..." class="img-fluid"></div>
              <?php if($v_marcas > 0) { ?>
                <div class="platforms d-none d-lg-block"><span class="platforms-title">Marcas Parceiras</span>
                  <ul class="platforms-list list-inline">
                    <?php 
                      $marca = "";
                      $SQLM = "SELECT ds_arquivo
                                FROM upload
                              WHERE nr_seq_configuracao = $codigo
                              AND nr_seq_categoria = 3";
                      $RSSM = mysqli_query($conexao, $SQLM);
                      while($linham = mysqli_fetch_row($RSSM)){
                        $marca = $linham[0];

                        ?>
                          <li class="list-inline-item"><img src="../gerenciador/site/imagens/<?php echo $marca; ?>" alt="" class="platform-image img-fluid"></li>
                        <?php 
                      }
                    ?>
                  </ul>
                </div>
              <?php } ?>
            </div>
            <div class="col-md-4" style="background-color: <?php echo $cor_principal; ?>;">
              <div id="simulador">
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
                        
                      <img src="../gerenciador/site/imagens/<?php echo $ds_imagem; ?>" class="img-fluid produto-imagem" data-produto="<?php echo $nr_produto; ?>" style="width: 70px; height: auto;">
                      <?php 
                    }
                  ?>
                </div>

                <div class="col-md-12 mt-5">
                  <p class="p-branco" style="text-align: center; font-size: 25px;">Informe o valor do crédito</p>
                  <input type="text" name="txtvalorindex" id="txtvalorindex" style="text-align: center; font-size: 30px;" class="form-control" onkeypress="return formatar_moeda(this,'.',',',event);" placeholder="0,00" required>
                </div>

                <div class="col-md-12 mt-5" style="text-align: center;">
                  <button type="button" class="btn btn-primary-proximo" style="text-align: center; font-size: 20px;" onClick="javascript: mostrarFormulario();">Próximo</button>
                </div>
              </div>

              <div id="formulario" style="display: none;">
                <p class="p-branco mt-3" style="text-align: center; font-size: 25px;">Preencha os campos abaixo para ver sua simulação!</p>
              
                <div class="form-group mt-5">
                    <input type="text" name="txtnomeindex" id="txtnomeindex" class="form-control" placeholder="Nome" required>
                </div>
                <div class="form-group">
                    <input type="email" name="txtemailindex" id="txtemailindex" class="form-control" placeholder="E-mail" required>
                </div>
                <div class="form-group">
                    <input type="number" name="txttelefoneindex" id="txttelefoneindex" class="form-control" placeholder="Telefone" required>
                </div>
                <div class="form-group">          
                    <select id="txtcidadeindex" class="form-control">
                        <option value='0'>Selecione uma cidade</option>
                        <?php
                        $sql = "SELECT cd_municipioibge, CONCAT(ds_municipioibge, ' - ', sg_estado) AS municipio_estado
                                  FROM municipioibge
                                  WHERE ds_municipioibge NOT LIKE '%TRIAL%'
                                ORDER BY ds_municipioibge, sg_estado";
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
                  <button type="button" class="btn btn-primary-proximo" style="text-align: center; font-size: 20px;" onClick="javascript: enviarSimulacao();">Ver Resultado</button>
                </div>
              </div>
              <br><br>
          </div>
        </div>
      </section>

      <!-- SEÇÃO 2-->
      <section class="app-showcase pb-big">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6 order-lg-last"> <!-- Mudança na ordem da coluna para dispositivos grandes -->
              <img src="<?php echo $caminho2; ?>" alt="..." style="max-width: 100%;"> <!-- Adição de style para limitar a largura máxima -->
            </div>
            <div class="col-lg-6">
              <h2 class="mb-10 text-center titulo"><?php echo $ds_secao2; ?></h2><br> <!-- Alinhamento do texto à direita -->
              <p class="lead text-left"><?php echo $ds_subsecao2; ?></p> <!-- Alinhamento do texto à direita -->
              <div class="form-group"><br>
                <a href="sobre.php?codigo=<?php echo $codigo; ?>" class="btn btn-primary">Conheça Nossa Empresa</a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <?php 
      $v_existe_produto = 0;
      $SQL5 = "SELECT COUNT(nr_sequencial)
                  FROM produtos_site
                WHERE nr_seq_configuracao = $codigo
                AND st_ativo = 'A'";
      $RSS5 = mysqli_query($conexao, $SQL5);
      while($linha5 = mysqli_fetch_row($RSS5)){
        $v_existe_produto = $linha5[0];
      }
      
      if($v_existe_produto != 0){ ?>
        <!-- SEÇÃO 3-->
        <section class="features shape-2">         
          <div class="container">
            <div class="section-header text-center"><span class="section-header-title"></span>
              <h2 class="h2 titulo"><?php echo $ds_secao3; ?></h2>
              <div class="row">
                <div class="col-lg-8 mx-auto">
                  <p class="lead"><?php echo $ds_subsecao3; ?></p>
                </div>
              </div>
            </div>
            <div class="container mt-5">
              <div class="row">
                <?php
                $SQLP = "SELECT p.nr_sequencial, p.ds_produto, p.ds_imagem, p.ds_detalhamento, c.ds_categoria 
                            FROM produtos_site p 
                            INNER JOIN categoria_produtos c ON c.nr_sequencial = p.nr_seq_categoria 
                            WHERE p.nr_seq_configuracao = $codigo 
                            AND p.st_ativo = 'A'";
                  $RSSP = mysqli_query($conexao, $SQLP);
                  while($linhap = mysqli_fetch_row($RSSP)){
                    $nr_produto = $linhap[0];
                    $ds_produto = $linhap[1];
                    $ds_imagem = $linhap[2];
                    $ds_detalhamento = $linhap[3];
                    $ds_categoria = $linhap[4];

                    ?>
                    <div class="col-md-3">
                      <div class="row align-items-center">
                        <div class="col-lg-12"><a href="produtos.php?codigo=<?php echo $codigo; ?>&produto=<?php echo $nr_produto; ?>" class="schedule-item-image"><img src="../gerenciador/site/imagens/<?php echo $ds_imagem; ?>" class="img-fluid"></a></div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
            </div>
        </section>
      <?php } ?>
     
      <?php 
      $v_existe_campanha = 0;
      $SQL3 = "SELECT COUNT(nr_sequencial)
                FROM campanhas_site
              WHERE nr_seq_configuracao = $codigo
              AND st_ativo = 'A'";
      $RSS3 = mysqli_query($conexao, $SQL3);
      while($linha3 = mysqli_fetch_row($RSS3)){
        $v_existe_campanha = $linha3[0];
      }
    
      if($v_existe_campanha != 0){ ?>
        <!-- SEÇÃO 4-->
        <section class="app-showcase pb-big mt-5">
          <div class="container">
              <div class="row align-items-center">
                  <div class="col-lg-8">
                      <h2 class="mb-4 titulo"><?php echo $ds_secao4; ?></h2>
                      <p class="lead"><?php echo $ds_subsecao4; ?></p>
                      <div class="row mt-5">
                          <div class="col-lg-8">
                              <div id="v-pills-tab" role="tablist" aria-orientation="vertical" class="nav flex-column nav-pills showcase-nav">
                                  <?php
                                  $SQL4 = "SELECT nr_sequencial, ds_campanha, ds_icone, ds_imagem, ds_detalhamento
                                          FROM campanhas_site
                                          WHERE nr_seq_configuracao = $codigo
                                          AND st_ativo = 'A'";
                                  $RSS4 = mysqli_query($conexao, $SQL4);
                                  $i = 0;
                                  while($linha4 = mysqli_fetch_assoc($RSS4)){
                                      $nr_seq_campanha = $linha4['nr_sequencial'];
                                      $ds_campanha = $linha4['ds_campanha'];
                                      $ds_icone_campanha = $linha4['ds_icone'];
                                      $ds_imagem_campanha = $linha4['ds_imagem'];
                                      $ds_detalhamento_campanha = $linha4['ds_detalhamento'];
                                      ?>

                                      <a id="card<?php echo $i; ?>" data-toggle="pill" href="#div<?php echo $i; ?>" role="tab" aria-controls="div<?php echo $i; ?>" aria-selected="true" class="nav-link <?php echo ($i == 0 ? 'active' : ''); ?> showcase-link" data-campanha="<?php echo htmlspecialchars($ds_campanha, ENT_QUOTES, 'UTF-8'); ?>" data-detalhamento="<?php echo htmlspecialchars($ds_detalhamento_campanha, ENT_QUOTES, 'UTF-8'); ?>">
                                          <div class="gradient-icon gradient-1">
                                              <i class="icon <?php echo $ds_icone_campanha; ?>" style="color: white;"></i>
                                          </div>
                                          <?php echo $ds_campanha; ?>
                                      </a>

                                      <?php
                                      $i++;
                                  }
                                  ?>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4">
                      <div id="v-pills-tabContent" class="tab-content showcase-content">
                      </div>
                  </div>
              </div>
          </div>
        </section>

        <!-- modal para detalhes das campanhas -->
        <div class="modal fade" id="modalDetalhes" tabindex="-1" role="dialog" aria-labelledby="modalDetalhesLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDetalhesLabel">Detalhes</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="detalhesCampanha"></div>
                    </div>
                </div>
            </div>
        </div>

      <?php } ?>
     
       <!-- SEÇÃO 5-->
      <section class="subscription padding-big">
        <div class="container text-center">
          <div class="section-header text-center"><span class="section-header-title"></span>
            <h2 class="h2 titulo"><?php echo $ds_secao5; ?></h2>
            <div class="row">
              <div class="col-lg-8 mx-auto">
                <p class="lead"><?php echo $ds_subsecao5; ?></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-10 mx-auto">
              <form action="#" class="subscription-form">
                <div class="form-group">
                  <input type="email" name="email" id="email" placeholder="seu@email.com" class="form-control">
                  <button type="button" class="btn btn-primary btn-with-icon" onClick="javascript: SalvarEmail();">
                      Receber Novidades
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
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

    <script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='//www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      ga('create','UA-XXXXX-X');ga('send','pageview');
    </script>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var campanhaLinks = document.querySelectorAll('.showcase-link');
        campanhaLinks.forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                var campanha = link.getAttribute('data-campanha');
                var detalhamento = link.getAttribute('data-detalhamento');

                document.getElementById('detalhesCampanha').innerHTML = '<h5>' + campanha + '</h5><p>' + detalhamento + '</p>';
                
                $('#modalDetalhes').modal('show');
            });
        });
      });

      var produtoSelecionado = null;

      // Função para alternar a seleção da imagem
      document.querySelectorAll('.produto-imagem').forEach(function(img) {
          img.addEventListener('click', function() {
              var produto = this.getAttribute('data-produto');
              if (produto === produtoSelecionado) {
                  // Se o produto clicado já estiver selecionado, desmarque-o
                  produtoSelecionado = null;
                  this.style.border = 'none';
              } else {
                  // Desmarque a imagem anteriormente selecionada, se houver
                  if (produtoSelecionado !== null) {
                      document.querySelector('.produto-imagem[data-produto="' + produtoSelecionado + '"]').style.border = 'none';
                  }
                  // Selecione o novo produto clicado
                  produtoSelecionado = produto;
                  this.style.border = '2px solid white';
              }
          });
      });

      function SalvarEmail(){

        var email = document.getElementById("email").value;

        if (email == "") {
          alert('Informe o seu E-mail!');
          document.getElementById('email').focus();
        } else {

          window.open('acao.php?Tipo=EMAIL&email=' + email, "acao");

        }

      }

      function formatar_moeda(campo, separador_milhar, separador_decimal, tecla) {
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

      function mostrarFormulario() {

        var valor = document.getElementById("txtvalorindex").value;
        if (produtoSelecionado !== null) {
            var produto = produtoSelecionado;
        } else {
          alert('Selecione uma categoria para simular o consórcio!');
        }

        if (valor == "") {
          alert('Informe o valor para simular seu consórcio!');
          document.getElementById('txtvalorindex').focus();
        } else {
          // Oculta o conteúdo atual
          var simulador = document.getElementById('simulador');
          if (simulador) {
              simulador.style.display = 'none';
          }
          // Mostra o formulário
          var formulario = document.getElementById('formulario');
          if (formulario) {
              formulario.style.display = 'block';
          }
        }
      }

      function enviarSimulacao(){

        var tipo = 'S';
        var valor = document.getElementById("txtvalorindex").value;
        if (produtoSelecionado !== null) {
            var produto = produtoSelecionado;
        } else {
          alert('Categoria não selecionada!');
        }
        var nome = document.getElementById('txtnomeindex').value;
        var email = document.getElementById("txtemailindex").value;
        var telefone = document.getElementById('txttelefoneindex').value;
        var cidade = document.getElementById('txtcidadeindex').value;
     

        if (nome == "") {
          alert('Informe o seu Nome!');
          document.getElementById('txtnomeindex').focus();
        } else if (cidade == 0) {
          alert('Informe a sua Cidade!');
          document.getElementById('txtcidadeindex').focus();
        } else if (email == '' && telefone == '') {
          alert('Preencha pelo menos um dos campos de contato (Email ou Telefone)!');
          if (email == '') {
              document.getElementById("txtemailindex").focus();
          } else if (telefone == '') {
              document.getElementById('txttelefoneindex').focus();
          }
        } else {

          window.open('acao.php?Tipo=SL&tipo=' + tipo + '&nome=' + nome + '&email=' + email + '&telefone=' + telefone + '&cidade=' + cidade + '&valor=' + valor + '&produto=' + produto, "acao");

        }
      }

      function recarregarPagina() {
        location.reload();
      }

      </script>
      
  </body>
</html>