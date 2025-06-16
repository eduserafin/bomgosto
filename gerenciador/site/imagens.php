<?php
  foreach($_GET as $key => $value){
    $$key = $value;
  }

  session_start(); 
  include "../../validar.php";
  include "../../conexao.php";

  if($cdarquivo != ""){

    $sql = "SELECT ds_arquivo
                FROM upload
            WHERE nr_seq_configuracao = $codigo
            AND nr_sequencial = $cdarquivo";
    //echo "<pre>$sql</pre>";
    $res = mysqli_query($conexao, $sql);
    while($lin = mysqli_fetch_row($res)){
        $ds_arquivo = $lin[0];
    }

  }

?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $Titulo;?></title>
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <?php
    if($ds_arquivo==""){
      echo "<pre><font color='#FF0000'><strong>Arquivo n&atilde;o encontrado.</strong>";
      exit;
    }
  ?>
    <iframe src="imagens/<?php echo $ds_arquivo;?>" width="100%" height="100%"></iframe>
  </body>
</html>