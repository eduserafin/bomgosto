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
    <title>Showtracker landing page</title>
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
                  <li class="nav-item"> <a href="schedule.html" class="nav-link active">What's on</a></li>
                  <!-- Link-->
                  <li class="nav-item"> <a href="text.html" class="nav-link">Text Page</a></li>
                  <!-- Link-->
                  <li class="nav-item"> <a href="#" class="nav-link">Get started</a></li>
              <li class="nav-item dropdown"><a id="pages" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Pages</a>
                <div class="dropdown-menu"><a href="index.html" class="dropdown-item">Home</a><a href="schedule.html" class="dropdown-item">What's on</a><a href="text.html" class="dropdown-item">Text Page</a></div>
              </li>
            </ul>
            <ul class="navbar-nav">
              <li class="nav-item"><a href="#" data-toggle="modal" data-target="#login" class="nav-link font-weight-bold mr-3">Login</a></li>
              <li class="nav-item"><a href="#" class="navbar-btn btn btn-primary">Get Started</a></li>
            </ul>
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
      <!-- Hero Section-->
      <section class="hero shape-1 shape-1-sm">
        <div class="container">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 pl-0">
              <li class="breadcrumb-item"><a href="index.html" class="animsition-link">Home</a></li>
              <li aria-current="page" class="breadcrumb-item active">What's on </li>
            </ol>
          </nav>
          <h1>What's On</h1>
          <div class="row">
            <div class="col-lg-8">
              <p class="lead font-weight-light">This is the lead paragraph of the article. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
            </div>
          </div>
          <!-- Platforms-->
          <div class="platforms mt-4 d-none d-lg-block"><span class="platforms-title">Compatible with</span>
            <ul class="platforms-list list-inline">
              <li class="list-inline-item"><img src="img/netflix.svg" alt="" class="platform-image img-fluid"></li>
              <li class="list-inline-item"><img src="img/apple.svg" alt="" class="platform-image img-fluid"></li>
              <li class="list-inline-item"><img src="img/android.svg" alt="" class="platform-image img-fluid"></li>
              <li class="list-inline-item"><img src="img/windows.svg" alt="" class="platform-image img-fluid"></li>
              <li class="list-inline-item"><img src="img/synology.svg" alt="" class="platform-image img-fluid"></li>
            </ul>
          </div>
        </div>
      </section>
      <!-- Schedule Section-->
      <section class="schedule shape-2">
        <div class="container">
          <div class="schedule-table">
            <nav>
              <div id="nav-tab" role="tablist" class="nav nav-tabs schedule-nav nav-fill"><a id="nav-mon-tab" data-toggle="tab" href="#nav-mon" role="tab" aria-controls="nav-mon" aria-selected="true" class="nav-item nav-link schedule-nav-link active">Monday</a><a id="nav-tue-tab" data-toggle="tab" href="#nav-tue" role="tab" aria-controls="nav-tue" aria-selected="false" class="nav-item nav-link schedule-nav-link">Tuesday</a><a id="nav-wed-tab" data-toggle="tab" href="#nav-wed" role="tab" aria-controls="nav-wed" aria-selected="false" class="nav-item nav-link schedule-nav-link">Wednesday</a><a id="nav-thu-tab" data-toggle="tab" href="#nav-thu" role="tab" aria-controls="nav-thu" aria-selected="false" class="nav-item nav-link schedule-nav-link">Thursday</a><a id="nav-fri-tab" data-toggle="tab" href="#nav-fri" role="tab" aria-controls="nav-fri" aria-selected="false" class="nav-item nav-link schedule-nav-link">Friday</a><a id="nav-sat-tab" data-toggle="tab" href="#nav-sat" role="tab" aria-controls="nav-sat" aria-selected="false" class="nav-item nav-link schedule-nav-link">Saturday</a><a id="nav-sun-tab" data-toggle="tab" href="#nav-sun" role="tab" aria-controls="nav-sun" aria-selected="false" class="nav-item nav-link schedule-nav-link">Sunday</a></div>
            </nav>
            <div id="nav-tabContent" class="tab-content">
              <div id="nav-mon" role="tabpanel" aria-labelledby="nav-mon-tab" class="tab-pane fade show active"> 
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-1.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-1">Science fiction</span>
                          <h3 class="schedule-item-name">Black Mirror</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">14:45</li>
                                <li class="list-inline-item viewing-times-item">18:30</li>
                                <li class="list-inline-item viewing-times-item">20:30</li>
                                <li class="list-inline-item viewing-times-item">24:45</li>
                              </ul>
                            </div>
                            <div class="duration">105 Mins<span class="certification">15</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-2.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-2">Adventure</span>
                          <h3 class="schedule-item-name">Stranger things</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">11:00</li>
                                <li class="list-inline-item viewing-times-item">16:00</li>
                                <li class="list-inline-item viewing-times-item">18:00</li>
                                <li class="list-inline-item viewing-times-item">21:00</li>
                              </ul>
                            </div>
                            <div class="duration">120 Mins<span class="certification">PG</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-3.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-3">Adventure</span>
                          <h3 class="schedule-item-name">Westworld</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">11:00</li>
                                <li class="list-inline-item viewing-times-item">14:30</li>
                                <li class="list-inline-item viewing-times-item">20:00</li>
                                <li class="list-inline-item viewing-times-item">21:15</li>
                              </ul>
                            </div>
                            <div class="duration">117 Mins<span class="certification">U</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-4.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-1">Drama</span>
                          <h3 class="schedule-item-name">House of cards</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">10:00</li>
                                <li class="list-inline-item viewing-times-item">12:45</li>
                                <li class="list-inline-item viewing-times-item">17:00</li>
                                <li class="list-inline-item viewing-times-item">21:15</li>
                              </ul>
                            </div>
                            <div class="duration">135 Mins<span class="certification">18</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
              </div>
              <div id="nav-tue" role="tabpanel" aria-labelledby="nav-tue-tab" class="tab-pane fade"> 
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-1.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-2">Science fiction</span>
                          <h3 class="schedule-item-name">Black Mirror</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">14:45</li>
                                <li class="list-inline-item viewing-times-item">18:30</li>
                                <li class="list-inline-item viewing-times-item">20:30</li>
                                <li class="list-inline-item viewing-times-item">24:45</li>
                              </ul>
                            </div>
                            <div class="duration">105 Mins<span class="certification">15</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-2.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-3">Adventure</span>
                          <h3 class="schedule-item-name">Stranger things</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">11:00</li>
                                <li class="list-inline-item viewing-times-item">16:00</li>
                                <li class="list-inline-item viewing-times-item">18:00</li>
                                <li class="list-inline-item viewing-times-item">21:00</li>
                              </ul>
                            </div>
                            <div class="duration">120 Mins<span class="certification">PG</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-3.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-1">Adventure</span>
                          <h3 class="schedule-item-name">Westworld</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">11:00</li>
                                <li class="list-inline-item viewing-times-item">14:30</li>
                                <li class="list-inline-item viewing-times-item">20:00</li>
                                <li class="list-inline-item viewing-times-item">21:15</li>
                              </ul>
                            </div>
                            <div class="duration">117 Mins<span class="certification">U</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-4.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-2">Drama</span>
                          <h3 class="schedule-item-name">House of cards</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">10:00</li>
                                <li class="list-inline-item viewing-times-item">12:45</li>
                                <li class="list-inline-item viewing-times-item">17:00</li>
                                <li class="list-inline-item viewing-times-item">21:15</li>
                              </ul>
                            </div>
                            <div class="duration">135 Mins<span class="certification">18</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
              </div>
              <div id="nav-wed" role="tabpanel" aria-labelledby="nav-wed-tab" class="tab-pane fade">
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-1.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-1">Science fiction</span>
                          <h3 class="schedule-item-name">Black Mirror</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">14:45</li>
                                <li class="list-inline-item viewing-times-item">18:30</li>
                                <li class="list-inline-item viewing-times-item">20:30</li>
                                <li class="list-inline-item viewing-times-item">24:45</li>
                              </ul>
                            </div>
                            <div class="duration">105 Mins<span class="certification">15</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-2.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-2">Adventure</span>
                          <h3 class="schedule-item-name">Stranger things</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">11:00</li>
                                <li class="list-inline-item viewing-times-item">16:00</li>
                                <li class="list-inline-item viewing-times-item">18:00</li>
                                <li class="list-inline-item viewing-times-item">21:00</li>
                              </ul>
                            </div>
                            <div class="duration">120 Mins<span class="certification">PG</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-3.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-3">Adventure</span>
                          <h3 class="schedule-item-name">Westworld</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">11:00</li>
                                <li class="list-inline-item viewing-times-item">14:30</li>
                                <li class="list-inline-item viewing-times-item">20:00</li>
                                <li class="list-inline-item viewing-times-item">21:15</li>
                              </ul>
                            </div>
                            <div class="duration">117 Mins<span class="certification">U</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-4.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-1">Drama</span>
                          <h3 class="schedule-item-name">House of cards</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">10:00</li>
                                <li class="list-inline-item viewing-times-item">12:45</li>
                                <li class="list-inline-item viewing-times-item">17:00</li>
                                <li class="list-inline-item viewing-times-item">21:15</li>
                              </ul>
                            </div>
                            <div class="duration">135 Mins<span class="certification">18</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
              </div>
              <div id="nav-thu" role="tabpanel" aria-labelledby="nav-thu-tab" class="tab-pane fade">
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-1.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-2">Science fiction</span>
                          <h3 class="schedule-item-name">Black Mirror</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">14:45</li>
                                <li class="list-inline-item viewing-times-item">18:30</li>
                                <li class="list-inline-item viewing-times-item">20:30</li>
                                <li class="list-inline-item viewing-times-item">24:45</li>
                              </ul>
                            </div>
                            <div class="duration">105 Mins<span class="certification">15</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-2.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-3">Adventure</span>
                          <h3 class="schedule-item-name">Stranger things</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">11:00</li>
                                <li class="list-inline-item viewing-times-item">16:00</li>
                                <li class="list-inline-item viewing-times-item">18:00</li>
                                <li class="list-inline-item viewing-times-item">21:00</li>
                              </ul>
                            </div>
                            <div class="duration">120 Mins<span class="certification">PG</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-3.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-1">Adventure</span>
                          <h3 class="schedule-item-name">Westworld</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">11:00</li>
                                <li class="list-inline-item viewing-times-item">14:30</li>
                                <li class="list-inline-item viewing-times-item">20:00</li>
                                <li class="list-inline-item viewing-times-item">21:15</li>
                              </ul>
                            </div>
                            <div class="duration">117 Mins<span class="certification">U</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-4.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-2">Drama</span>
                          <h3 class="schedule-item-name">House of cards</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">10:00</li>
                                <li class="list-inline-item viewing-times-item">12:45</li>
                                <li class="list-inline-item viewing-times-item">17:00</li>
                                <li class="list-inline-item viewing-times-item">21:15</li>
                              </ul>
                            </div>
                            <div class="duration">135 Mins<span class="certification">18</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
              </div>
              <div id="nav-fri" role="tabpanel" aria-labelledby="nav-fri-tab" class="tab-pane fade">
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-1.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-3">Science fiction</span>
                          <h3 class="schedule-item-name">Black Mirror</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">14:45</li>
                                <li class="list-inline-item viewing-times-item">18:30</li>
                                <li class="list-inline-item viewing-times-item">20:30</li>
                                <li class="list-inline-item viewing-times-item">24:45</li>
                              </ul>
                            </div>
                            <div class="duration">105 Mins<span class="certification">15</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-2.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-2">Adventure</span>
                          <h3 class="schedule-item-name">Stranger things</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">11:00</li>
                                <li class="list-inline-item viewing-times-item">16:00</li>
                                <li class="list-inline-item viewing-times-item">18:00</li>
                                <li class="list-inline-item viewing-times-item">21:00</li>
                              </ul>
                            </div>
                            <div class="duration">120 Mins<span class="certification">PG</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-3.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-1">Adventure</span>
                          <h3 class="schedule-item-name">Westworld</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">11:00</li>
                                <li class="list-inline-item viewing-times-item">14:30</li>
                                <li class="list-inline-item viewing-times-item">20:00</li>
                                <li class="list-inline-item viewing-times-item">21:15</li>
                              </ul>
                            </div>
                            <div class="duration">117 Mins<span class="certification">U</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-4.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-3">Drama</span>
                          <h3 class="schedule-item-name">House of cards</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">10:00</li>
                                <li class="list-inline-item viewing-times-item">12:45</li>
                                <li class="list-inline-item viewing-times-item">17:00</li>
                                <li class="list-inline-item viewing-times-item">21:15</li>
                              </ul>
                            </div>
                            <div class="duration">135 Mins<span class="certification">18</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
              </div>
              <div id="nav-sat" role="tabpanel" aria-labelledby="nav-sat-tab" class="tab-pane fade">
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-1.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-1">Science fiction</span>
                          <h3 class="schedule-item-name">Black Mirror</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">14:45</li>
                                <li class="list-inline-item viewing-times-item">18:30</li>
                                <li class="list-inline-item viewing-times-item">20:30</li>
                                <li class="list-inline-item viewing-times-item">24:45</li>
                              </ul>
                            </div>
                            <div class="duration">105 Mins<span class="certification">15</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-2.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-2">Adventure</span>
                          <h3 class="schedule-item-name">Stranger things</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">11:00</li>
                                <li class="list-inline-item viewing-times-item">16:00</li>
                                <li class="list-inline-item viewing-times-item">18:00</li>
                                <li class="list-inline-item viewing-times-item">21:00</li>
                              </ul>
                            </div>
                            <div class="duration">120 Mins<span class="certification">PG</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-3.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-3">Adventure</span>
                          <h3 class="schedule-item-name">Westworld</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">11:00</li>
                                <li class="list-inline-item viewing-times-item">14:30</li>
                                <li class="list-inline-item viewing-times-item">20:00</li>
                                <li class="list-inline-item viewing-times-item">21:15</li>
                              </ul>
                            </div>
                            <div class="duration">117 Mins<span class="certification">U</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-4.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-1">Drama</span>
                          <h3 class="schedule-item-name">House of cards</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">10:00</li>
                                <li class="list-inline-item viewing-times-item">12:45</li>
                                <li class="list-inline-item viewing-times-item">17:00</li>
                                <li class="list-inline-item viewing-times-item">21:15</li>
                              </ul>
                            </div>
                            <div class="duration">135 Mins<span class="certification">18</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
              </div>
              <div id="nav-sun" role="tabpanel" aria-labelledby="nav-sun-tab" class="tab-pane fade">
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-1.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-2">Science fiction</span>
                          <h3 class="schedule-item-name">Black Mirror</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">14:45</li>
                                <li class="list-inline-item viewing-times-item">18:30</li>
                                <li class="list-inline-item viewing-times-item">20:30</li>
                                <li class="list-inline-item viewing-times-item">24:45</li>
                              </ul>
                            </div>
                            <div class="duration">105 Mins<span class="certification">15</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-2.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-3">Adventure</span>
                          <h3 class="schedule-item-name">Stranger things</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">11:00</li>
                                <li class="list-inline-item viewing-times-item">16:00</li>
                                <li class="list-inline-item viewing-times-item">18:00</li>
                                <li class="list-inline-item viewing-times-item">21:00</li>
                              </ul>
                            </div>
                            <div class="duration">120 Mins<span class="certification">PG</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-3.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-1">Adventure</span>
                          <h3 class="schedule-item-name">Westworld</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">11:00</li>
                                <li class="list-inline-item viewing-times-item">14:30</li>
                                <li class="list-inline-item viewing-times-item">20:00</li>
                                <li class="list-inline-item viewing-times-item">21:15</li>
                              </ul>
                            </div>
                            <div class="duration">117 Mins<span class="certification">U</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Schedule item-->
                    <div class="schedule-table-item">
                      <div class="row align-items-center">
                        <div class="col-lg-3"><a href="#" class="schedule-item-image"><img src="img/tv-shows-4.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="col-lg-9"><span class="schedule-item-genre gradient-2">Drama</span>
                          <h3 class="schedule-item-name">House of cards</h3>
                          <p class="schedule-item-description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor dolore voluptas unde sequi veritatis debitis accusantium eligendi, provident quo assumenda!</p>
                          <div class="schedule-item-time">
                            <div class="viewing-times"><span><i class="icon ion-md-time"></i>Viewing times</span>
                              <ul class="list-inline viewing-times-list mb-0">
                                <li class="list-inline-item viewing-times-item disabled">10:00</li>
                                <li class="list-inline-item viewing-times-item">12:45</li>
                                <li class="list-inline-item viewing-times-item">17:00</li>
                                <li class="list-inline-item viewing-times-item">21:15</li>
                              </ul>
                            </div>
                            <div class="duration">135 Mins<span class="certification">18</span></div>
                          </div>
                        </div>
                      </div>
                    </div>
              </div>
            </div>
          </div>
          <div class="contact-block text-center">
            <div class="contact-text">Need help? Contact our support team on</div>
            <div class="contact-number">0330 123 4567</div>
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