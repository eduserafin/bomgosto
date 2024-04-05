<?php

  foreach($_GET as $key => $value){
    $$key = $value;
  }

  require_once '../conexao.php';

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

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Contato</title>
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
          /* Estilos personalizados */
          .contact-form {
              padding-top: 50px; /* Adiciona espaço acima do formulário */
          }
          .description {
              text-align: center;
              margin-bottom: 20px; /* Reduz o espaço abaixo da descrição */
              margin-top: 50px; /* Adiciona margem superior à descrição */
          }
          .description h3 {
              font-size: 32px;
              margin-bottom: 20px;
          }
          .description p {
              font-size: 18px;
              color: #777;
          }
          .whatsapp-button {
              text-align: center;
          }
          .whatsapp-button a {
              display: inline-block;
              background-color: #25d366;
              color: #fff;
              padding: 10px 20px;
              border-radius: 5px;
              text-decoration: none;
          }
          .whatsapp-button a:hover {
              background-color: #128c7e;
          }
      </style>
  </head>
  <body>
    <!-- navbar-->
    <header class="header">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <!-- Navbar brand--><a href="index.php" class="navbar-brand font-weight-bold"><img src="img/logo.png" alt="..." class="img-fluid"></a>
          <!-- Navbar toggler button-->
          <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right">Menu<i class="icon ion-md-list ml-2"></i></button>
          <div id="navbarSupportedContent" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto ml-auto">
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
            <!--<ul class="navbar-nav">
              <li class="nav-item"><a href="#" data-toggle="modal" data-target="#login" class="nav-link font-weight-bold mr-3">Login</a></li>
              <li class="nav-item"><a href="#" class="navbar-btn btn btn-primary">Get Started</a></li>
            </ul>-->
          </div>
        </div>
      </nav>
    </header>
    <!-- Login Modal-->
    <div id="login" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade bd-example-modal-lg">
      <div role="document" class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body p-4 p-lg-5">
            <form action="#" class="login-form text-left">
              <div class="form-group mb-4">
                <label>Email address</label>
                <input type="email" name="email" placeholder="name@company.com" class="form-control">
              </div>
              <div class="form-group mb-4">
                <label>Password</label>
                <input type="password" name="password" placeholder="Min 8 characters" class="form-control">
              </div>
              <div class="form-group">
                <input type="submit" value="Login" class="btn btn-primary">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="page-holder">   
    <section class="contact-form">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-md-6">
                    <div class="description">
                        <h2>FALE COM A ZENATTI CONSÓRCIOS</h2>
                        <p>Preencha seus dados, em breve retornaremos sua mensagem. Obrigado por escolher a Zenatti Consórcios!</p>
                        <!-- Botão do WhatsApp -->
                        <a href="https://wa.me/SEUNUMERO?text=Olá,%20gostaria%20de%20entrar%20em%20contato%20sobre%20os%20consórcios" class="whatsapp-button">Fale Conosco no WhatsApp</a>
                      </div>
                </div>

                <div class="col-md-6">
                    <form action="process_contact.php" method="post">
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nome" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" required>
                        </div>
                        <div class="form-group">
                            <input type="number" name="telefone" id="telefone" class="form-control" placeholder="Telefone" required>
                        </div>
                        <div class="form-group">
                            <input type="number" name="whatsapp" id="whatsapp" class="form-control" placeholder="WhatsApp" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="cidade" id="cidade" class="form-control" placeholder="Cidade" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="uf" id="uf" class="form-control" placeholder="UF" required>
                        </div>
                        <div class="form-group">
                            <textarea name="message" id="message" class="form-control" rows="5" placeholder="Mensagem" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">ENVIAR MENSAGEM</button>
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
            <li class="list-inline-item"><a href="#" target="_blank" class="social-link"><i class="icon ion-logo-twitter"></i></a></li>
            <li class="list-inline-item"><a href="#" target="_blank" class="social-link"><i class="icon ion-logo-facebook"></i></a></li>
            <li class="list-inline-item"><a href="#" target="_blank" class="social-link"><i class="icon ion-logo-youtube"></i></a></li>
          </ul>
          <p class="copyrights-text mb-0">Direitos autorais Csimulador 2024</p>
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