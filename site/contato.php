<?php

  foreach($_GET as $key => $value){
    $$key = $value;
  }

  require_once '../conexao.php';

  if($codigo != ""){

    $SQL = "SELECT ds_titulo, ds_conteudo, nr_telefone, nr_whatsapp, ds_email
                FROM contato_site
            WHERE nr_seq_configuracao = $codigo";
    //echo "<pre>$SQL</pre>";
    $RSS = mysqli_query($conexao, $SQL);
    while($linha = mysqli_fetch_row($RSS)){
      $ds_titulo = $linha[0];
      $ds_conteudo = $linha[1];
      $nr_telefone = $linha[2];
      $nr_whatsapp = $linha[3];
      $ds_email = $linha[4];
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
    <link rel="shortcut icon" href="<?php echo $caminho1; ?>">
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

          #whatsapp-icon {
            font-size: 5em; /* Altere o valor conforme necessário para aumentar o ícone */
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
            color: <?php echo $cor_secundaria; ?>;; /* Cor dos ícones sociais ao passar o mouse */
          }
          
          .copyrights-text {
            margin-top: 10px; /* Espaçamento acima do texto de direitos autorais */
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

          .btn-primary-enviar {
            transition: background-color 0.3s ease; /* Adiciona um efeito de transição de cor */
            background-color: <?php echo $cor_secundaria; ?>;
            border-color: <?php echo $cor_secundaria; ?>; /* Adicionando a mesma cor para a borda */
            height: 50px; /* Defina o tamanho desejado para a altura */
            color: #FFFFFF;
          }

          .btn-primary-enviar:hover {
            background-color: <?php echo $cor_principal; ?>; /* Escurecendo um pouco ao passar o mouse */
            border-color: <?php echo $cor_principal; ?>; /* Também escurecendo a borda ao passar o mouse */
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

          .titulo{
            color: <?php echo $cor_principal; ?>
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
      <section class="contact-form">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-6">
              <div class="description">
                <h2 class="hero-heading titulo"><?php echo $ds_titulo; ?></h2>
                <p><?php echo $ds_conteudo; ?></p>
                <button type="button" class="btn btn-primary" onclick="redirectToWhatsApp()">Chama no Whats!</button>
                <a href="https://api.whatsapp.com/send?phone=<?php echo $nr_whatsapp; ?>" class="float" target="_blank" id="whatsapp-link">
                  <i class="icon ion-logo-whatsapp" id="whatsapp-icon"></i>
                </a>
              </div>
            </div>

            <div class="col-md-4" style="background-color: <?php echo $cor_principal; ?>;">
              <div class="form-group mt-5">
                  <input type="text" name="txtnome" id="txtnome" class="form-control" placeholder="Nome" required>
              </div>
              <div class="form-group">
                  <input type="email" name="txtemail" id="txtemail" class="form-control" placeholder="E-mail" required>
              </div>
              <div class="form-group">
                  <input type="number" name="txttelefone" id="txttelefone" class="form-control" placeholder="Telefone" required>
              </div>
              <div class="form-group">
                  <input type="number" name="txtwhatsapp" id="txtwhatsapp" class="form-control" placeholder="WhatsApp" required>
              </div>
              <div class="form-group">
                  <select id="txtcidadecontato" class="form-control" style="width: 100%"></select>
              </div>
              <div class="form-group">
                  <textarea name="txtmemsagem" id="txtmemsagem" class="form-control" rows="5" placeholder="Mensagem" required></textarea>
              </div>
              <div class="col-md-12 mt-2" style="text-align: center;">
                <button type="button" class="btn btn-primary-enviar" onClick="javascript: SalvarLead();">Enviar Mensagem </button>
              </div>
              <br>
            </div>
          </div>
        </div>
      </section>
    </div>
    <br><br>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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
          $('#txtcidadecontato').select2({
              placeholder: "Cidade",
              minimumInputLength: 3,  // Só busca após digitar 3 letras
              ajax: {
                  url: 'buscar_cidades.php', // Arquivo PHP que retorna os resultados
                  dataType: 'json',
                  delay: 250,
                  data: function(params) {
                      return { term: params.term }; // Envia a pesquisa ao servidor
                  },
                  processResults: function(data) {
                      return { results: data }; // Retorna os dados no formato do Select2
                  }
              }
          });
      });

      function redirectToWhatsApp() {
        // Obtenha o link do atributo href da tag <a>
        var whatsappLink = document.getElementById('whatsapp-link').getAttribute('href');
        // Redirecione para o mesmo link que a tag <a>
        window.location.href = whatsappLink;
      }

      function SalvarLead(){

        var tipo = '<?php echo $tipo; ?>';
        var produto = '<?php echo $produto; ?>';
        var nome = document.getElementById('txtnome').value;
        var email = document.getElementById("txtemail").value;
        var telefone = document.getElementById('txttelefone').value;
        var whatsapp = document.getElementById("txtwhatsapp").value;
        var cidade = document.getElementById('txtcidadecontato').value;
        var mensagem = document.getElementById("txtmemsagem").value;

        if (nome == "") {
          alert('Informe o seu Nome!');
          document.getElementById('txtnome').focus();
        } else if (mensagem == '') {
          alert('Descreva sua mensagem!');
          document.getElementById('txtmemsagem').focus();
        } else if (cidade == 0) {
          alert('Informe a sua Cidade!');
          document.getElementById('txtcidadecontato').focus();
        } else if (email == '' && telefone == '' && whatsapp == '') {
          alert('Preencha pelo menos um dos campos de contato (Email, Telefone ou WhatsApp)!');
          if (email == '') {
              document.getElementById("txtemail").focus();
          } else if (telefone == '') {
              document.getElementById('txttelefone').focus();
          } else if (whatsapp == '') {
              document.getElementById("txtwhatsapp").focus();
          } 
        } else {

          window.open('acao.php?Tipo=SL&tipo=' + tipo + '&nome=' + nome + '&email=' + email + '&telefone=' + telefone + '&whatsapp=' + whatsapp + '&cidade=' + cidade + '&mensagem=' + mensagem + '&produto=' + produto, "acao");
        
        }
      }

      function recarregarPagina() {
        location.reload();
      }

    </script>
  </body>
</html>