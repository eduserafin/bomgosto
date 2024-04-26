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

          .btn-primary {
            transition: background-color 0.3s ease; /* Adiciona um efeito de transição de cor */
            background-color: <?php echo $cor_principal; ?>;
            border-color: <?php echo $cor_principal; ?>; /* Adicionando a mesma cor para a borda */
            height: 45px; /* Defina o tamanho desejado para a altura */
          }

          .btn-primary:hover {
            background-color: <?php echo $cor_secundaria; ?>; /* Escurecendo um pouco ao passar o mouse */
            border-color: <?php echo $cor_secundaria; ?>; /* Também escurecendo a borda ao passar o mouse */
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
          <h1><?php echo $ds_titulo; ?></h1>
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
            <nav>
              <div id="nav-tab" role="tablist" class="nav nav-tabs schedule-nav nav-fill">
                <!-- PHP loop to generate category tabs -->
                <?php 

                  // Verifica se a variável $categoria está vazia
                  if (empty($categoria)) {
                    // Se estiver vazia, define $primeiraCategoriaAtiva como true para ativar a primeira categoria
                    $primeiraCategoriaAtiva = true;
                  }

                  $SQLC = "SELECT nr_sequencial, ds_categoria 
                              FROM categoria_produtos 
                            WHERE nr_seq_configuracao = $codigo 
                            AND st_ativo = 'A'";
                  //echo "<pre>$SQLC</pre>";
                  $RSSC = mysqli_query($conexao, $SQLC);
                  while($linhac = mysqli_fetch_row($RSSC)){
                    $nr_categoria = $linhac[0];
                    $ds_categoria = $linhac[1];
                    $classeAtiva = ''; // Inicializa a classe como vazia

                    // Se a variável $categoria estiver vazia e for a primeira categoria, define a classe como 'active'
                    if (empty($categoria) && $primeiraCategoriaAtiva) {
                        $classeAtiva = 'active';
                        $primeiraCategoriaAtiva = false; // Define como false após a primeira iteração
                    } elseif ($categoria == $nr_categoria) {
                        $classeAtiva = 'active';
                    }
                    ?>

                    <a data-categoria="<?php echo $nr_categoria; ?>" data-toggle="tab" href="#nav-<?php echo strtolower($ds_categoria); ?>" role="tab" aria-controls="nav-<?php echo strtolower($ds_categoria); ?>" aria-selected="false" class="nav-item nav-link schedule-nav-link <?php echo $classeAtiva; ?>"><?php echo $ds_categoria; ?></a>

                <?php } ?>
              </div>
            </nav>
            <div id="nav-tabContent" class="tab-content">
              <!-- PHP loop to generate product tabs for each category -->
              <?php 
                $RSSC = mysqli_query($conexao, $SQLC);
                while($linhac = mysqli_fetch_row($RSSC)){
                  $nr_categoria = $linhac[0];
                  $ds_categoria = $linhac[1];
                  $classeAtiva = ($primeiraCategoriaAtiva) ? 'show active' : ''; // Define a classe 'show active' para a primeira categoria
                
                  ?>

                    <div id="nav-<?php echo strtolower($ds_categoria); ?>" role="tabpanel" class="tab-pane fade <?php echo $classeAtiva; ?>">

                    <?php 

                      $SQLP = "SELECT p.nr_sequencial, p.ds_produto, p.ds_imagem, p.ds_detalhamento, c.ds_categoria FROM produtos_site p INNER JOIN categoria_produtos c ON c.nr_sequencial = p.nr_seq_categoria WHERE p.nr_seq_configuracao = $codigo AND p.nr_seq_categoria = $nr_categoria AND p.st_ativo = 'A'";
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
                              <a href="contato.php?codigo=<?php echo $codigo; ?>&produto=<?php echo $nr_produto; ?>&tipo=P" class="btn btn-primary">ENTRE EM CONTATO <i class="icon ion-md-arrow-round-forward"></i></a>
                              <h3 class="schedule-item-name"><?php echo $ds_produto; ?></h3>
                              <p class="schedule-item-description"><?php echo $ds_detalhamento; ?></p>
                            </div>
                          </div>
                        </div>
                    <?php } ?>
                  </div>
                  <?php 
                  $primeiraCategoriaAtiva = false;  // Define para false após a primeira iteração
                } ?>
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
      $(document).ready(function() {
          // Adiciona um ouvinte de evento para a mudança de aba
          $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
              // Remove a classe 'show' de todas as abas
              $('.tab-pane').removeClass('show');
              // Adiciona a classe 'show' à aba que está prestes a ser exibida
              $($(e.target).attr('href')).addClass('show');
          });
          
          // Seleciona a primeira aba e a exibe
          $('a[data-toggle="tab"]').first().tab('show');
      });

    </script>
  </body>
</html>