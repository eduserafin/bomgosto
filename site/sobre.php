<?php

  foreach($_GET as $key => $value){
    $$key = $value;
  }

  require_once '../conexao.php';

  if($codigo != ""){

    $SQL = "SELECT ds_titulo, ds_conteudo, ds_titulo1, ds_conteudo1, ds_titulo2, ds_conteudo2
              FROM sobre_site
            WHERE nr_seq_configuracao = $codigo";
    //echo "<pre>$SQL</pre>";
    $RSS = mysqli_query($conexao, $SQL);
    while($linha = mysqli_fetch_row($RSS)){
      $ds_titulo = $linha[0];
      $ds_conteudo = $linha[1];
      $ds_titulo1 = $linha[2];
      $ds_conteudo1 = $linha[3];
      $ds_titulo2 = $linha[4];
      $ds_conteudo2 = $linha[5];
    }

  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sobre</title>
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
    <link rel="shortcut icon" href="img/favicon.png">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

      <style>
        
        #whatsapp-icon {
          font-size: 5em; /* Altere o valor conforme necessário para aumentar o ícone */
        }

        /* Estilos para o footer */
        .footer {
          background-color: #6a5acd; /* Cor de fundo do footer */
          color: #fff; /* Cor do texto dentro do footer */
          padding: 20px 0; /* Espaçamento interno do footer */
        }
        
        .social-link {
          color: #fff; /* Cor dos ícones sociais */
          text-decoration: none; /* Remover sublinhado dos links */
        }
        
        .social-link:hover {
          color: #ccc; /* Cor dos ícones sociais ao passar o mouse */
        }
        
        .copyrights-text {
          margin-top: 10px; /* Espaçamento acima do texto de direitos autorais */
        }

    </style>
  </head>
  <body>
    <!-- navbar-->
    <header class="header">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <!-- Navbar brand--><a href="index.php" class="navbar-brand font-weight-bold"><img src="img/logo.jpeg" alt="..." class="img-fluid"></a>
          <!-- Navbar toggler button-->
          <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right">Menu<i class="icon ion-md-list ml-2"></i></button>
          <div id="navbarSupportedContent" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto ml-auto">
                  <li class="nav-item"> <a href="index.php?codigo=<?php echo $codigo; ?>" class="nav-link">Home</a></li>
                  <!-- Link-->
                  <li class="nav-item"> <a href="produtos.php?codigo=<?php echo $codigo; ?>" class="nav-link">Produtos</a></li>
                  <!-- Link-->
                  <li class="nav-item"> <a href="sobre.php?codigo=<?php echo $codigo; ?>" class="nav-link">Sobre</a></li>
                  <!-- Link-->
                  <li class="nav-item"> <a href="contato.php?codigo=<?php echo $codigo; ?>" class="nav-link">Contato</a></li>
              <li class="nav-item dropdown"><a id="pages" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Abas</a>
                <div class="dropdown-menu">
                  <a href="index.php" class="dropdown-item">Home</a>
                  <a href="produtos.php?codigo=<?php echo $codigo; ?>" class="dropdown-item">Produtos</a>
                  <a href="sobre.php?codigo=<?php echo $codigo; ?>" class="dropdown-item">Sobre</a>
                  <a href="contato.php?codigo=<?php echo $codigo; ?>" class="dropdown-item">Contato</a>
                </div>
              </li>
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
              <li class="breadcrumb-item"><a href="index.php" class="animsition-link">Home</a></li>
              <li aria-current="page" class="breadcrumb-item active">Sobre</li>
            </ol>
          </nav>
          <h1><?php echo $ds_titulo; ?></h1>
          <div class="row">
            <div class="col-lg-8">
              <p class="lead font-weight-light"><?php echo $ds_conteudo; ?></p>
              <p><img src="img/logo.jpeg" alt="..." class="img-fluid"></p>
            </div>
          </div>
        </div>
      </section>
      <section class="shape-2 pb-big">
        <div class="container">
          <div class="row">
            <div class="col-lg-8">
              <h2 class="mb-3"><?php echo $ds_titulo1; ?></h2>
              <blockquote class="blockquote mb-5"><?php echo $ds_conteudo1; ?></blockquote>
              <h3 class="mb-5"><?php echo $ds_titulo2; ?></h3>
              <p class="mb-5"><?php echo $ds_conteudo2; ?></p>
              <p><img src="img/logo.jpeg" alt="..." class="img-fluid"></p>
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
  </body>
</html>