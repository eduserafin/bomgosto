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

    $SQL0 = "SELECT cor_principal, cor_secundaria
                FROM configuracao_site
            WHERE nr_sequencial = $codigo";
    //echo "<pre>$SQL0</pre>";
    $RSS0 = mysqli_query($conexao, $SQL0);
    while($linha0 = mysqli_fetch_row($RSS0)){
      $cor_principal = $linha0[0];
      $cor_secundaria = $linha0[1];
    }

    $ds_arquivo = "";
    $SQL1 = "SELECT ds_arquivo
              FROM upload
            WHERE nr_seq_configuracao = $codigo
            AND nr_seq_categoria = 6";
    $RSS1 = mysqli_query($conexao, $SQL1);
    while($linha1 = mysqli_fetch_row($RSS1)){
      $ds_arquivo = $linha1[0];
    }

    if($ds_arquivo == ""){
      $caminho = "img/Csimulador.png";
    } else {
      $caminho = "../gerenciador/site/imagens/$ds_arquivo";
    }

    $ds_arquivo1 = "";
    $SQL2 = "SELECT ds_arquivo
              FROM upload
            WHERE nr_seq_configuracao = $codigo
            AND nr_seq_categoria = 1";
    $RSS2 = mysqli_query($conexao, $SQL2);
    while($linha2 = mysqli_fetch_row($RSS2)){
      $ds_arquivo1 = $linha2[0];
    }

    if($ds_arquivo1 == ""){
      $caminho1 = "img/Csimulador.png";
    } else {
      $caminho1 = "../gerenciador/site/imagens/$ds_arquivo1";
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
    <link rel="shortcut icon" href="<?php echo $caminho1; ?>">
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

        .titulo{
          color: <?php echo $cor_principal; ?>
        }

    </style>
  </head>
  <body>
    <!-- navbar-->
    <header class="header">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <!-- Navbar brand--><a href="index.php" class="navbar-brand font-weight-bold"><img src="<?php echo $caminho1; ?>" alt="..." class="img-fluid"></a>
          <!-- Navbar toggler button-->
          <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right">Menu<i class="icon ion-md-list ml-2"></i></button>
          <div id="navbarSupportedContent" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto ml-auto">
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
              <li class="breadcrumb-item"><a href="index.php" class="animsition-link">Home</a></li>
              <li aria-current="page" class="breadcrumb-item active">Sobre</li>
            </ol>
          </nav>

          <div class="container">
            <h2 class="hero-heading titulo"><?php echo $ds_titulo; ?></>
            <div class="row">
              <div class="col-lg-12">
                <p class="lead font-weight-light"><?php echo $ds_conteudo; ?></p>
              </div>
            </div>
          </div>

          <div class="container mt-5">
            <h2 class="hero-heading titulo"><?php echo $ds_titulo1; ?></>
            <div class="row">
              <div class="col-lg-12">
                <p class="lead font-weight-light"><?php echo $ds_conteudo1; ?></p>
              </div>
            </div>
          </div>

          <div class="container mt-5">
            <h2 class="hero-heading titulo"><?php echo $ds_titulo2; ?></>
            <div class="row">
              <div class="col-lg-12">
                <p class="lead font-weight-light"><?php echo $ds_conteudo2; ?></p>
              </div>
            </div>
          </div>
          
          <?php if($ds_arquivo != ""){ ?>
            <div class="container">
              <div class="row justify-content-center">
                  <div class="col-lg-4 text-center">
                      <img src="<?php echo $caminho; ?>" class="img-fluid" style="width: 100%; height: auto;">
                  </div>
              </div>
            </div>
          <?php } ?>
        </div>

        <div class="container">
          <div class="row">
            <div class="col-md-6">
                <a href="contato.php?codigo=<?php echo $codigo; ?>&tipo=C" class="card-link">
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
                <a href="contato.php?codigo=<?php echo $codigo; ?>&tipo=P" class="card-link">
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