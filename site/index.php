<?php

  foreach($_GET as $key => $value){
    $$key = $value;
  }

  require_once '../conexao.php';

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
            font-size: 3rem; /* Defina o tamanho desejado para o ícone maior */
          }

          .small-icon {
            font-size: 2rem; /* Defina o tamanho desejado para o ícone pequeno */
          }

          .btn-primary {
            transition: background-color 0.3s ease; /* Adiciona um efeito de transição de cor */
            background-color: <?php echo $cor_principal; ?>;
            border-color: <?php echo $cor_principal; ?>; /* Adicionando a mesma cor para a borda */
            height: 65px; /* Defina o tamanho desejado para a altura */
          }

          .btn-primary:hover {
            background-color: <?php echo $cor_secundaria; ?>; /* Escurecendo um pouco ao passar o mouse */
            border-color: <?php echo $cor_secundaria; ?>; /* Também escurecendo a borda ao passar o mouse */
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

        </style>

  </head>
  <body>
    <iframe name="acao" width="0" height="0" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>
    <!-- navbar-->
    <header class="header">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <!-- Navbar brand--><a href="index.php" class="navbar-brand font-weight-bold"><img src="<?php echo $caminho1; ?>" alt="..." class="img-fluid"></a>
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
              <li class="nav-item"> <a href="contato.php?codigo=<?php echo $codigo; ?>" class="nav-link">Contato</a></li>
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
              <h2 class="hero-heading"><?php echo $ds_secao1; ?></h2>
              <p class="lead mt-5 font-weight-light"><?php echo $ds_subsecao1; ?></p>
              <!-- Subscription form-->
              <form action="#" class="subscription-form mt-5">
                <div class="form-group">
                  <a href="contato.php?codigo=<?php echo $codigo; ?>" class="btn btn-primary">SAIBA MAIS <i class="icon ion-ios-log-in small-icon"></i></a>
                </div>
              </form> 
              <!-- Platforms-->
              <?php if($v_marcas > 0) { ?>
                <div class="platforms d-none d-lg-block"><span class="platforms-title">Marcas Parceiras</span>
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
            <div class="col-lg-6 d-none d-lg-block">
              <div class="device-wrapper mx-auto">
                <!--<div data-device="iPhone7" data-orientation="portrait" data-color="black" class="device">
                  <div class="screen"><img src="img/logo.jpeg" alt="..." class="img-fluid"></div>
                </div>-->
              </div>
            </div>
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
              <h2 class="mb-10 text-center"><?php echo $ds_secao2; ?></h2><br> <!-- Alinhamento do texto à direita -->
              <p class="lead text-left"><?php echo $ds_subsecao2; ?></p> <!-- Alinhamento do texto à direita -->
              <div class="form-group"><br>
                <a href="sobre.php?codigo=<?php echo $codigo; ?>" class="btn btn-primary">CONHEÇA NOSSA EMPRESA <i class="icon ion-ios-log-in small-icon"></i></a>
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
              <h2 class="h2"><?php echo $ds_secao3; ?></h2>
              <div class="row">
                <div class="col-lg-8 mx-auto">
                  <p class="lead"><?php echo $ds_subsecao3; ?></p>
                </div>
              </div>
            </div>
            <div class="container mt-2">
              <div class="row mt-2">
                <?php
                  $SQL6 = "SELECT nr_sequencial, ds_produto, ds_icone, nr_seq_categoria
                            FROM produtos_site
                          WHERE nr_seq_configuracao = $codigo
                          AND st_ativo = 'A'
                          ORDER BY nr_sequencial ASC LIMIT 3";
                  $RSS6 = mysqli_query($conexao, $SQL6);
                  while($linha6 = mysqli_fetch_row($RSS6)){
                    $nr_seq_produto = $linha6[0];
                    $ds_produto = $linha6[1];
                    $ds_icone_produto = $linha6[2];
                    $categoria = $linha6[3];

                    ?>

                    <div class="col-md-4">
                      <a href="produtos.php?codigo=<?php echo $codigo; ?>&categoria=<?php echo $categoria; ?>" class="card-link">
                          <div class="card text-center">
                              <div class="card-body">
                                  <div class="gradient-icon gradient-1"><i class="icon <?php echo $ds_icone_produto; ?>"></i></div>
                                  <h4 class="card-title"><?php echo $ds_produto; ?></h4>
                                  <p class="card-text">Clique para ver detalhes  <i class="icon ion-ios-arrow-round-forward small-icon"></i></p>
                              </div>
                          </div>
                      </a>
                    </div>
                  <?php } ?>
              </div>
          </div>
          <div class="form-group text-center"><br>
            <a href="produtos.php?codigo=<?php echo $codigo; ?>" class="btn btn-primary">CONSÓRCIOS <i class="icon ion-ios-log-in small-icon"></i></a>
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
        <section class="app-showcase pb-big">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-lg-8">
                <h2 class="mb-4"><?php echo $ds_secao4; ?></h2>
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
  
                          <a id="card<?php echo $i; ?>" data-toggle="pill" href="#div<?php echo $i; ?>" role="tab" aria-controls="div<?php echo $i; ?>" aria-selected="true" class="nav-link <?php echo ($i == 0 ? 'active' : ''); ?> showcase-link">
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
                  <?php
                    // Reinicie o índice do array de resultados
                    mysqli_data_seek($RSS4, 0);
                    $i = 0;
                    while($linha4 = mysqli_fetch_assoc($RSS4)){
                      // Adicione as imagens dinamicamente com base nos dados do banco de dados
                      echo '<div id="div'.$i.'" role="tabpanel" aria-labelledby="card'.$i.'" class="tab-pane fade '.($i == 0 ? 'show active' : '').'">
                              <div class="showcase-image-holder">
                                <div class="device-wrapper">
                                  <div class="screen"><img src="../gerenciador/site/imagens/'.$linha4['ds_imagem'].'" alt="..." class="img-fluid"></div>
                                  <a href="#" class="btn btn-primary btn-detalhes btn-block" data-toggle="modal" data-target="#modalDetalhes" data-campanha="'.$linha4['ds_detalhamento'].'">Detalhes</a>
                                </div>
                              </div>
                            </div>';
                      $i++;
                    }
                  ?>
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
                        <h5 class="modal-title" id="modalDetalhesLabel">Detalhes da Campanha</h5>
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
          <div class="section-header">
            <div class="row">
              <div class="col-lg-8 mx-auto"><span class="section-header-title"></span>
                <h2 class="h2"><?php echo $ds_secao5; ?></h2>
                <p class="lead"><?php echo $ds_subsecao5; ?></p>
              </div>
              <div class="container mt-2">
                <div class="row mt-2">
                  <div class="col-md-6">
                      <a href="contato.php?codigo=<?php echo $codigo; ?>" class="card-link">
                          <div class="card text-center">
                              <div class="card-body">
                                  <div class="gradient-icon gradient-1"><i class="icon ion-ios-call"></i></div>
                                  <h4 class="card-title">Entre em Contato</h4>
                                  <p class="card-text">Entre em contato conosco para obter suporte ou tirar dúvidas.</p>
                              </div>
                          </div>
                      </a> <!-- Tag de fechamento adicionada -->
                  </div>
                  <div class="col-md-6">
                      <a href="contato.php?codigo=<?php echo $codigo; ?>" class="card-link">
                          <div class="card text-center">
                              <div class="card-body">
                                  <div class="gradient-icon gradient-1"><i class="icon ion-ios-person"></i></div>
                                  <h4 class="card-title">Seja um Parceiro</h4>
                                  <p class="card-text">Deseja se tornar um parceiro? Entre em contato.</p>
                              </div>
                          </div>
                      </a>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-12 mx-auto">
                    <!-- Subscription form-->
                    <form action="#" class="subscription-form mt-5">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="email" placeholder="seu@email.com" class="form-control">
                        <button type="button" class="btn btn-primary btn-with-icon" onClick="javascript: SalvarEmail();">
                            RECEBER NOVIDADES
                        </button>
                      </div>
                    </form>
                  </div>
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

      $(document).ready(function(){
          // Quando um botão de detalhes é clicado
          $('.btn-detalhes').click(function(){
              // Obtém o ID da campanha associada ao botão clicado
              var campanhaID = $(this).data('campanha');

              // Aqui você pode fazer uma solicitação AJAX para obter os detalhes da campanha com base no ID
              // Por enquanto, vamos apenas exibir o ID da campanha no modal
              $('#detalhesCampanha').text(campanhaID);
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

      </script>
      
  </body>
</html>