<?php

  foreach($_GET as $key => $value){
    $$key = $value;
  }

  require_once '../conexao.php';

  $SQL = "SELECT ds_nome, ds_secao1, ds_subsecao1, ds_secao2, ds_subsecao2, ds_secao3, ds_subsecao3,
            ds_secao4, ds_subsecao4, ds_secao5, ds_subsecao5
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
    <link rel="shortcut icon" href="img/favicon.png">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <!-- navbar-->
    <header class="header">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <!-- Navbar brand--><a href="index.html" class="navbar-brand font-weight-bold"><img src="img/logo.png" alt="..." class="img-fluid"></a>
          <!-- Navbar toggler button-->
          <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right">Menu<i class="icon ion-md-list ml-2"></i></button>
          <div id="navbarSupportedContent" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto ml-auto">
                  <!-- Link-->
                  <li class="nav-item"> <a href="schedule.html" class="nav-link">Produtos</a></li>
                  <!-- Link-->
                  <li class="nav-item"> <a href="text.html" class="nav-link">Sobre</a></li>
                  <!-- Link-->
                  <li class="nav-item"> <a href="#" class="nav-link">Contato</a></li>
              <li class="nav-item dropdown"><a id="pages" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Abas</a>
                <div class="dropdown-menu">
                  <a href="index.html" class="dropdown-item">Home</a>
                  <a href="schedule.html" class="dropdown-item">Produtos</a>
                  <a href="text.html" class="dropdown-item">Sobre</a>
                  <a href="text.html" class="dropdown-item">Contato</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <div class="page-holder">
      <!-- Hero Section-->
      <section class="hero shape-1">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <h1 class="hero-heading"><?php echo $ds_secao1; ?></h1>
              <p class="lead mt-5 font-weight-light"><?php echo $ds_subsecao1; ?></p>
              <!-- Subscription form-->
              <form action="#" class="subscription-form mt-5">
                <div class="form-group">
                  <br><br>
                  <button type="submit" class="btn btn-primary">Quero Realizar Meus Sonhos!</button>
                </div>
              </form> 
              <!-- Platforms-->
              <div class="platforms d-none d-lg-block"><span class="platforms-title">Compatible with</span>
                <ul class="platforms-list list-inline">
                  <li class="list-inline-item"><img src="img/netflix.svg" alt="" class="platform-image img-fluid"></li>
                  <li class="list-inline-item"><img src="img/apple.svg" alt="" class="platform-image img-fluid"></li>
                  <li class="list-inline-item"><img src="img/android.svg" alt="" class="platform-image img-fluid"></li>
                  <li class="list-inline-item"><img src="img/windows.svg" alt="" class="platform-image img-fluid"></li>
                  <li class="list-inline-item"><img src="img/synology.svg" alt="" class="platform-image img-fluid"></li>
                </ul>
              </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
              <div class="device-wrapper mx-auto">
                <div data-device="iPhone7" data-orientation="portrait" data-color="black" class="device">
                  <div class="screen"><img src="img/screen.jpg" alt="..." class="img-fluid"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Features Section-->
      <section class="features shape-2">         
        <div class="container">
          <div class="section-header text-center"><span class="section-header-title"></span>
            <h2 class="h1"><?php echo $ds_secao2; ?></h2>
            <div class="row">
              <div class="col-lg-8 mx-auto">
                <p class="lead"><?php echo $ds_subsecao2; ?></p>
              </div>
            </div>
          </div>
          <div class="row mt-5 text-center">
            <div class="col-lg-4">
              <div class="features-item mb-5 mb-lg-0">
                <div class="gradient-icon gradient-1"><i class="icon ion-ios-play"></i></div>
                <h3 class="h5">Automated tracking</h3>
                <p>Track your favorite shows automatically without switching between apps.</p><a href="#" class="features-link">Learn more<i class="icon ion-ios-arrow-forward ml-2"></i></a>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="features-item mb-5 mb-lg-0">
                <div class="gradient-icon gradient-2"><i class="icon ion-ios-cog"></i></div>
                <h3 class="h5">Machine learning</h3>
                <p>Get recommendations like never before, which are truly customized for your taste.</p><a href="#" class="features-link">Learn more<i class="icon ion-ios-arrow-forward ml-2"></i></a>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="features-item mb-5 mb-lg-0">
                <div class="gradient-icon gradient-3"><i class="icon ion-ios-notifications"></i></div>
                <h3 class="h5">Smart notifications</h3>
                <p>Receive smart notifications exactly at the right moments when you need them.</p><a href="#" class="features-link">Learn more<i class="icon ion-ios-arrow-forward ml-2"></i></a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- TV Shows Section-->
      <section class="tv-shows padding-big">
        <div class="swiper-container tv-shows-slider">
          <div class="swiper-wrapper">
            <!-- <div class="swiper-slide"> <a href="#" class="tv-shows-link"><img src="img/tv-shows-1.jpg" alt="..." class="tv-shows-image img-fluid"></a></div>
            <div class="swiper-slide"> <a href="#" class="tv-shows-link"><img src="img/tv-shows-2.jpg" alt="..." class="tv-shows-image img-fluid"></a></div>
           <div class="swiper-slide"> <a href="#" class="tv-shows-link"><img src="img/tv-shows-3.jpg" alt="..." class="tv-shows-image img-fluid"></a></div>
            <div class="swiper-slide"> <a href="#" class="tv-shows-link"><img src="img/tv-shows-4.jpg" alt="..." class="tv-shows-image img-fluid"></a></div>
            <div class="swiper-slide"> <a href="#" class="tv-shows-link"><img src="img/tv-shows-5.jpg" alt="..." class="tv-shows-image img-fluid"></a></div>
            <div class="swiper-slide"> <a href="#" class="tv-shows-link"><img src="img/tv-shows-6.jpg" alt="..." class="tv-shows-image img-fluid"></a></div>
            <div class="swiper-slide"> <a href="#" class="tv-shows-link"><img src="img/tv-shows-7.jpg" alt="..." class="tv-shows-image img-fluid"></a></div> -->
          </div>
        </div>
      </section>
      <!-- App Showcase Section-->
      <section class="app-showcase pb-big">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <h2 class="mb-4"><?php echo $ds_secao3; ?></h2>
              <p class="lead"><?php echo $ds_subsecao3; ?></p>
              <div class="row mt-5">
                <div class="col-lg-8">
                  <div id="v-pills-tab" role="tablist" aria-orientation="vertical" class="nav flex-column nav-pills showcase-nav"><a id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true" class="nav-link active showcase-link"> <i class="icon ion-md-pie mr-4"></i>Customized Dashboard</a><a id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false" class="nav-link showcase-link"> <i class="icon ion-ios-moon mr-4"></i>Automatic Day &amp; Night Modes</a><a id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false" class="nav-link showcase-link"> <i class="icon ion-md-chatbubbles mr-4"></i>Integrated Chat Platform</a></div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div id="v-pills-tabContent" class="tab-content showcase-content">
                <div id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" class="tab-pane fade show active">
                  <div class="showcase-image-holder">
                    <div class="device-wrapper">
                      <div data-device="iPhone7" data-orientation="portrait" data-color="black" class="device">
                        <div class="screen"><img src="img/showcase-screen-1.jpg" alt="..." class="img-fluid"></div>
                      </div>
                    </div><img src="img/showcase-img-1.jpg" alt="..." class="showcase-image d-none d-lg-block">
                  </div>
                </div>
                <div id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" class="tab-pane fade">
                  <div class="showcase-image-holder">
                    <div class="device-wrapper">
                      <div data-device="iPhone7" data-orientation="portrait" data-color="black" class="device">
                        <div class="screen"><img src="img/showcase-screen-2.jpg" alt="..." class="img-fluid"></div>
                      </div>
                    </div><img src="img/showcase-img-2.jpg" alt="..." class="showcase-image d-none d-lg-block">
                  </div>
                </div>
                <div id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab" class="tab-pane fade">
                  <div class="showcase-image-holder">
                    <div class="device-wrapper">
                      <div data-device="iPhone7" data-orientation="portrait" data-color="black" class="device">
                        <div class="screen"><img src="img/showcase-screen-3.jpg" alt="..." class="img-fluid"></div>
                      </div>
                    </div><img src="img/showcase-img-3.jpg" alt="..." class="showcase-image d-none d-lg-block">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Testimonials Section-->
      <section class="testimonials bg-black">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 section-padding">
              <div class="section-header pr-3"><span class="section-header-title text-white"></span>
                <h2 class="h1 text-white"><?php echo $ds_secao4; ?></h2>
                <p class="lead text-white mt-4 mb-4"><?php echo $ds_subsecao4; ?></p><!--<a href="#" class="btn btn-primary">Mais Depoimentos</a>-->
              </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
              <div class="row feeds">
                <div class="col-lg-6">
                  <div class="swiper-container testimonials-slider-1">
                    <div class="swiper-wrapper">
                      <!-- Feed slide-->
                      <div class="swiper-slide"> 
                        <!-- Feed block-->
                        <div class="feed-block">
                          <div class="feed-header">
                            <div class="feed-user">
                              <div class="feed-user-avatar"><img src="img/testimonial-avatar-4.svg" alt="user" class="feed-user-image img-fluid"></div>
                              <div class="feed-user-name"><strong>Bruce Murphy</strong></div>
                            </div>
                            <div class="feed-icon"> <i class="icon ion-logo-twitter"></i></div>
                          </div>
                          <div class="feed-body">
                            <p class="feed-text">I use ShowTrackr every day, and it’s awesome! I track all of my TV shows in it. :) </p>
                          </div>
                          <div class="feed-date">Jan 18, 2018</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Subscription Section-->
      <section class="subscription padding-big">
        <div class="container text-center">
          <div class="section-header">
            <div class="row">
              <div class="col-lg-8 mx-auto"><span class="section-header-title"></span>
                <h2 class="h1"><?php echo $ds_secao5; ?></h2>
                <p class="lead"><?php echo $ds_subsecao5; ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-7 mx-auto">
                <!-- Subscription form-->
                <form action="#" class="subscription-form mt-5">
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="your@email.com" class="form-control">
                    <button type="submit" class="btn btn-primary">Start tracking</button>
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
            <li class="list-inline-item"><a href="#" target="_blank" class="social-link"><i class="icon ion-logo-twitter"></i></a></li>
            <li class="list-inline-item"><a href="#" target="_blank" class="social-link"><i class="icon ion-logo-facebook"></i></a></li>
            <li class="list-inline-item"><a href="#" target="_blank" class="social-link"><i class="icon ion-logo-youtube"></i></a></li>
          </ul>
          <p class="copyrights-text mb-0">Copyright &copy; 2018 All rights reserved — Designed by <a href="https://dribbble.com/danielkorpai" target="_blank" class="copyrights-link">Daniel Korpai</a></p>
          <p class="copyrights-text mb-0">Coded by <a href="https://bootstrapious.com/landing-pages" target="_blank" class="copyrights-link">Bootstrapious</a></p>
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