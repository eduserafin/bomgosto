<?php
foreach($_GET as $key => $value){
	$$key = $value;
}

include "conexao.php";

require_once("Mobile_Detect.php");
$detect = new Mobile_Detect;
$AtivaMenu = true;
if ($detect->isMobile() or $detect->isTablet()) {
    $AtivaMenu = false;
}

$ano_ref = date('Y');

$mes_ref = date('m');

$data_vigente = date('Y-m-d');

        
$SQL = "SELECT c.nr_sequencial, c.nr_rodada, 
               t.ds_time, c.nr_pontos, t.ds_nome,
               t1.ds_time, c.nr_pontos1, t1.ds_nome, 
               t2.ds_time, c.nr_pontos2, t2.ds_nome, 
               t3.ds_time, c.nr_pontos3, t3.ds_nome,
               t4.ds_time, c.nr_pontos4, t4.ds_nome, 
               t5.ds_time, c.nr_pontos5, t5.ds_nome
        FROM cartola c
        INNER JOIN cartola_times t ON t.nr_sequencial = c.nr_seq_time_vencedor
        INNER JOIN cartola_times t1 ON t1.nr_sequencial = c.nr_seq_time_pagador1
        INNER JOIN cartola_times t2 ON t2.nr_sequencial = c.nr_seq_time_pagador2
        INNER JOIN cartola_times t3 ON t3.nr_sequencial = c.nr_seq_time_pagador3
        INNER JOIN cartola_times t4 ON t4.nr_sequencial = c.nr_seq_time_pagador4
        LEFT JOIN cartola_times t5 ON t5.nr_sequencial = c.nr_seq_time_pagador5
        WHERE 1 = 1 
        ORDER BY c.nr_sequencial DESC LIMIT 1";
//echo $SQL;
$RSS = mysqli_query($conexao, $SQL);
while ($linha = mysqli_fetch_row($RSS)) {
    $nr_sequencial = $linha[0];
    $nr_rodada = number_format($linha[1], 0, ",", ".");
    $ds_time_vencedor = $linha[2];
    $nr_pontos = number_format($linha[3], 2, ",", ".");
    $nome_vencedor = $linha[4];
    $ds_time_pagador1 = $linha[5];
    $nr_pontos1 = number_format($linha[6], 2, ",", ".");
    $nome_pagador1 = $linha[7];
    $ds_time_pagador2 = $linha[8];
    $nr_pontos2 = number_format($linha[9], 2, ",", ".");
    $nome_pagador2 = $linha[10];
    $ds_time_pagador3 = $linha[11];
    $nr_pontos3 = number_format($linha[12], 2, ",", ".");
    $nome_pagador3 = $linha[13];
    $ds_time_pagador4 = $linha[14];
    $nr_pontos4 = number_format($linha[15], 2, ",", ".");
    $nome_pagador4 = $linha[16];
    $ds_time_pagador5 = $linha[17];
    $nr_pontos5 = number_format($linha[18], 2, ",", ".");
    $nome_pagador5 = $linha[19];

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LIGA CARTOLA - Viveiro Serafin</title>
  <meta content="" name="description">

  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/cartola2.jpg" rel="icon">
  <link href="assets/img/cartola2.jpg" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: FlexStart - v1.3.0
  * Template URL: https://bootstrapmade.com/flexstart-bootstrap-startup-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/cartola2.jpg" alt="">
        <span>Cartola Temporada <?php echo $ano_ref ?></span>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center">
          <h1 data-aos="fade-up">LIGA VIVEIRO SERAFIN</h1>
          <h2 data-aos="fade-up" data-aos-delay="400">Acompanhe os resultados de cada Rodada</h2>
          <div data-aos="fade-up" data-aos-delay="600">
            <div class="text-center text-lg-start">
              <a href="#values" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                <span>Rodada <?php echo $nr_rodada?></span>
                <i class="bi bi-arrow-right"></i>
              </a>
              <a href="#contact" class="btn btn-warning btn-lg scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                <span>Controle de rodadas</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
          <img src="assets/img/cartola.png" class="img-fluid" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Values Section ======= -->
    <section id="values" class="values">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h1>Resultados da rodada</h1>
          <p><?php echo $nr_rodada;?></p>
        </header>

        <div class="row" style="text-align: center;">

        <div class="col-lg-12">
            <div class="box" data-aos="fade-up" data-aos-delay="200">
              <img src="assets/img/trofeu.png" class="img-fluid" alt="">
              <h3>Ganhador da rodada</h3>
              <p><?php echo $ds_time_vencedor ;?></p>
              <p><?php echo $nome_vencedor ;?></p>
              <h3><?php echo $nr_pontos ;?> Pontos</h3>
            </div>
          </div>
        </div>

        <div class="row">

        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="box" data-aos="fade-up" data-aos-delay="200">
              <img src="assets/img/icone_negativo6.png" class="img-fluid" alt="">
              <h3>Pagador</h3>
              <p><?php echo $ds_time_pagador1 ;?></p>
              <p><?php echo $nome_pagador1 ;?></p>
              <h3><?php echo $nr_pontos1 ;?> Pontos</h3>
            </div>
          </div>

          <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="box" data-aos="fade-up" data-aos-delay="400">
              <img src="assets/img/icone_negativo4.png" class="img-fluid" alt="">
              <h3>Pagador</h3>
              <p><?php echo $ds_time_pagador2 ;?></p>
              <p><?php echo $nome_pagador2 ;?></p>
              <h3><?php echo $nr_pontos2 ;?> Pontos</h3>
            </div>
          </div>

          <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="box" data-aos="fade-up" data-aos-delay="600">
              <img src="assets/img/icone_negativo5.jpg" class="img-fluid" alt="">
              <h3>Pagador</h3>
              <p><?php echo $ds_time_pagador3 ;?></p>
              <p><?php echo $nome_pagador3 ;?></p>
              <h3><?php echo $nr_pontos3 ;?> Pontos</h3>
            </div>
          </div>

          <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="box" data-aos="fade-up" data-aos-delay="600">
              <img src="assets/img/icone_negativo2.png" class="img-fluid" alt="">
              <h3>Pagador</h3>
              <p><?php echo $ds_time_pagador4 ;?></p>
              <p><?php echo $nome_pagador4 ;?></p>
              <h3><?php echo $nr_pontos4 ;?> Pontos</h3>
            </div>
          </div>

          <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="box" data-aos="fade-up" data-aos-delay="600">
              <img src="assets/img/icone_negativo3.jpg" class="img-fluid" alt="">
              <h3>Pagador</h3>
              <p><?php echo $ds_time_pagador5 ;?></p>
              <p><?php echo $nome_pagador5 ;?></p>
              <h3><?php echo $nr_pontos5 ;?> Pontos</h3>
            </div>
          </div>

        </div>

      </div>

    </section><!-- End Values Section -->

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
      <div class="container" data-aos="fade-up">

        <div class="row gy-4">

      <?php

            $SQL0 = "SELECT COUNT(st_pagou1), COUNT(st_pagou2), COUNT(st_pagou3), COUNT(st_pagou4), COUNT(st_recebeu), COUNT(st_pagou5)
                    FROM cartola 
                    WHERE 1 = 1 ";
            //echo $SQL;
            $RSS0 = mysqli_query($conexao, $SQL0);
            while ($linha0 = mysqli_fetch_row($RSS0)) {
                $qtpagou1 = $linha0[0];
                $qtpagou2 = $linha0[1];
                $qtpagou3 = $linha0[2];
                $qtpagou4 = $linha0[3];
                $qtrecebeu = $linha0[4];
                $qtpagou5 = $linha0[5];

                $qt_recebeu = $qtrecebeu * 100;
                $pagou1 = $qtpagou1 * 5;
                $pagou2 = $qtpagou2 * 5;
                $pagou3 = $qtpagou3 * 5;
                $pagou4 = $qtpagou4 * 5;
                $pagou5 = $qtpagou5 * 5;

                $pagamento = $pagou1 + $pagou2 + $pagou3 + $pagou4 + $pagou5;
            }
      ?>

          <div class="col-lg-3 col-md-6">
            <div class="count-box">
            <i class="bi bi-award-fill"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="<?php echo $nr_rodada ;?>" data-purecounter-duration="1" class="purecounter"></span>
                <p>Rodadas</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="count-box">
            <i class="bi bi-emoji-laughing" style="color: #ee6c20;"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="<?php echo $qt_recebeu ;?>" data-purecounter-duration="1" class="purecounter"></span>
                <p>Valor pago</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="count-box">
            <i class="bi bi-hand-thumbs-up-fill" style="color: #15be56;"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="<?php echo  $pagamento ;?>" data-purecounter-duration="1" class="purecounter"></span>
                <p>Valor Recebido</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="count-box">
            <i class="bi bi-hourglass-bottom" style="color: #bb0852;"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="950" data-purecounter-duration="1" class="purecounter"></span>
                <p>Total a receber</p>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Counts Section -->

    
    <!-- ======= table ======= -->

<section id="contact" class="contact">
  <div class="container" data-aos="fade-up">
    <div class="row gy-4">

        <header class="section-header">
          <h2>CONTROLE DE PAGAMENTOS</h2>
          <p>Acompanhe o resultade das rodadas</p>
        </header>

<div class="table-responsive">
    <table width="80%" class="table table-bordered table-striped">
        <tr>
            <th><font size=2><strong>RODADA</strong></font></th>
            <th><font size=2><strong>VENCEDOR</strong></font></th>
            <th><font size=2><strong>PONTOS</strong></font></th>
            <th><font size=2><strong>#</strong></font></th>
            <th><font size=2><strong>PAGADOR</strong></font></th>
            <th><font size=2><strong>PONTOS</strong></font></th>
            <th><font size=2><strong>#</strong></font></th>
            <th><font size=2><strong>PAGADOR</strong></font></th>
            <th><font size=2><strong>PONTOS</strong></font></th>
            <th><font size=2><strong>#</strong></font></th>
            <th><font size=2><strong>PAGADOR</strong></font></th>
            <th><font size=2><strong>PONTOS</strong></font></th>
            <th><font size=2><strong>#</strong></font></th>
            <th><font size=2><strong>PAGADOR</strong></font></th>
            <th><font size=2><strong>PONTOS</strong></font></th>
            <th><font size=2><strong>#</strong></font></th>
            <th><font size=2><strong>PAGADOR</strong></font></th>
            <th><font size=2><strong>PONTOS</strong></font></th>
            <th><font size=2><strong>#</strong></font></th>
            
        </tr>
        <?php
        
                $SQL1 = "SELECT c.nr_sequencial, t.ds_nome, c.nr_pontos, t1.ds_nome, c.nr_pontos1, 
                t2.ds_nome, c.nr_pontos2, t3.ds_nome, c.nr_pontos3, t4.ds_nome, c.nr_pontos4, c.nr_rodada, 
                c.dt_cadastro, c.dt_recebimento, c.st_pagou1, c.st_pagou2, c.st_pagou3, c.st_pagou4,
                c.st_recebeu, c.dt_pagamento1, c.dt_pagamento2, c.dt_pagamento3, c.dt_pagamento4,
                c.dt_pagamento5, c.st_pagou5, c.nr_pontos5, t5.ds_nome
                        FROM cartola c
                        INNER JOIN cartola_times t ON t.nr_sequencial = c.nr_seq_time_vencedor
                        INNER JOIN cartola_times t1 ON t1.nr_sequencial = c.nr_seq_time_pagador1
                        INNER JOIN cartola_times t2 ON t2.nr_sequencial = c.nr_seq_time_pagador2
                        INNER JOIN cartola_times t3 ON t3.nr_sequencial = c.nr_seq_time_pagador3
                        INNER JOIN cartola_times t4 ON t4.nr_sequencial = c.nr_seq_time_pagador4
                        LEFT JOIN cartola_times t5 ON t5.nr_sequencial = c.nr_seq_time_pagador5
                        WHERE 1 = 1 
                        ORDER BY c.nr_sequencial ASC";
                //echo $SQL;
                $RSS1 = mysqli_query($conexao, $SQL1);
                while ($linha1 = mysqli_fetch_row($RSS1)) {
                    $sequencial = $linha1[0];
                    $time_vencedor = $linha1[1];
                    $pontos = number_format($linha1[2], 2, ",", ".");
                    $time_pagador1 = $linha1[3];
                    $pontos1 = number_format($linha1[4], 2, ",", ".");
                    $time_pagador2 = $linha1[5];
                    $pontos2 = number_format($linha1[6], 2, ",", ".");
                    $time_pagador3 = $linha1[7];
                    $pontos3 = number_format($linha1[8], 2, ",", ".");
                    $time_pagador4 = $linha1[9];
                    $pontos4 = number_format($linha1[10], 2, ",", ".");
                    $rodada = number_format($linha1[11], 0, ",", ".");
                    $cadastro = date('d/m/Y', strtotime($linha1[12]));
                    $recebimento = date('d/m/Y', strtotime($linha1[13]));
                    $pagou1 = $linha1[14];
                    $pagou2 = $linha1[15];
                    $pagou3 = $linha1[16];
                    $pagou4 = $linha1[17];
                    $recebeu = $linha1[18];
                    $pagamento1 = date('d/m/Y', strtotime($linha1[19]));
                    $pagamento2 = date('d/m/Y', strtotime($linha1[20]));
                    $pagamento3 = date('d/m/Y', strtotime($linha1[21]));
                    $pagamento4 = date('d/m/Y', strtotime($linha1[22]));
                    $pagamento5 = date('d/m/Y', strtotime($linha1[23]));
                    $pagou5 = $linha1[24];
                    $pontos5 = number_format($linha1[25], 2, ",", ".");
                    $time_pagador5 = $linha1[26];

                    ?>
                    <tr>
                        <td><font size=2><?php echo $rodada; ?></font></td>
                        <td><font size=2><?php echo $time_vencedor; ?></font></td>
                        <td><font size=2><?php echo $pontos; ?></font></td>
                        <?php
                          if($recebeu == ''){
                            ?>
                            <td><i class="bi bi-hand-thumbs-down-fill"></i></td>
                            <?php
                          } 
                          else {
                             ?>
                             <td><i class="bi bi-hand-thumbs-up-fill"></i></td>
                            <?php
                          }
                          ?>
                        <td><font size=2><?php echo $time_pagador1; ?></font></td>
                        <td><font size=2><?php echo $pontos1; ?></font></td>
                        <?php
                            if($pagou1 == ''){
                            ?>
                              <td><i class="bi bi-hand-thumbs-down-fill"></i></td>
                            <?php
                          }
                          else {
                             ?>
                            <td><i class="bi bi-hand-thumbs-up-fill"></i></td>
                            <?php
                          }
                          ?>
                        <td><font size=2><?php echo $time_pagador2; ?></font></td>
                        <td><font size=2><?php echo $pontos2; ?></font></td>
                          <?php
                            if($pagou2 == ''){
                            ?>
                              <td><i class="bi bi-hand-thumbs-down-fill"></i></td>
                            <?php
                          }
                          else {
                             ?>
                             <td><i class="bi bi-hand-thumbs-up-fill"></i></td>
                            <?php
                          }
                          ?>
                        <td><font size=2><?php echo $time_pagador3; ?></font></td>
                        <td><font size=2><?php echo $pontos3; ?></font></td>
                          <?php
                            if($pagou3 == ''){
                            ?>
                              <td><i class="bi bi-hand-thumbs-down-fill"></i></td>
                            <?php
                          }
                          else {
                             ?>
                               <td><i class="bi bi-hand-thumbs-up-fill"></i></td>
                            <?php
                          }
                          ?>
                        <td><font size=2><?php echo $time_pagador4; ?></font></td>
                        <td><font size=2><?php echo $pontos4; ?></font></td>
                          <?php
                            if($pagou4 == ''){
                            ?>
                           <td><i class="bi bi-hand-thumbs-down-fill"></i></td>
                            <?php
                          }
                          else {
                             ?>
                            <td><i class="bi bi-hand-thumbs-up-fill"></i></td>
                            <?php
                          }
                          ?> 
                        <td><font size=2><?php echo $time_pagador5; ?></font></td>
                        <td><font size=2><?php echo $pontos5; ?></font></td>
                          <?php
                            if($pagou5 == ''){
                            ?>
                           <td><i class="bi bi-hand-thumbs-down-fill"></i></td>
                            <?php
                          }
                          else {
                             ?>
                            <td><i class="bi bi-hand-thumbs-up-fill"></i></td>
                            <?php
                          }
                          ?> 
                    </tr>
                    <?php
                }
                ?>
      </table>
    </div>
  </div>
</div>
</section><!-- End Table -->

  <!-- ======= Footer ======= -->
  
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Eduardo Luiz Serafin</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/flexstart-bootstrap-startup-template/ -->
       <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>