<?php

  foreach($_GET as $key => $value){
    $$key = $value;
  }

  if ($consulta == "sim") {
      require_once '../../conexao.php';
      $ant = "../../";
  }

  if ($_GET['pg'] < 0){
      $pg = 0;
      echo "<script language='javascript'>document.getElementById('pgatual').value=1;</script>";
  }
  else if ($_GET['pg'] !== 0) {
      $pg = $_GET['pg'];
  } else {
      $pg = 0;
  }

  $porpagina = 15;
  $inicio = $pg * $porpagina;

  $nome = $_GET['nome'];
  if ($nome != "") {
    $v_sql = " AND UPPER(ds_tipo) like UPPER('%" . $nome . "%')";
  }

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
      <table width="100%" class="table table-bordered table-striped">
        <tr>
          <th style="vertical-align:middle;">TIPOS DE LANCE</th>
          <th style="vertical-align:middle;">STATUS</th>
          <th colspan=2 style="vertical-align:middle; text-align:center">A&Ccedil;&Otilde;ES</th>
        </tr>

        <?php
        
          $SQL = "SELECT nr_sequencial, ds_tipo, st_status
                    FROM consorcio_tipo_lance
                  WHERE 1 = 1 $v_sql 
                  ORDER BY ds_tipo ASC LIMIT $porpagina offset $inicio";
                  // echo $SQL;
          $RSS = mysqli_query($conexao, $SQL);
          while ($linha = mysqli_fetch_row($RSS)) {
            $nr_sequencial = $linha[0];
            $ds_tipo = $linha[1];
            $st_status = $linha[2];

            if( $st_status == "1"){$status = 'ATIVO';}
            else {$status = 'INATIVO';}

            ?>

            <tr>
              <td><?php echo $ds_tipo; ?></td>
              <td><?php echo $status; ?></td>
              <td width="3%" align="center"><?php include $ant."inc/btn_editar.php";?></td>
              <td width="3%" align="center"><?php include $ant."inc/btn_excluir.php";?></td>
            </tr>

            <?php
          }
        ?>

      </table>
  
      <br><?php include $ant."inc/paginacao.php";?>

  </body>
</html> 

<script language="javascript">

    function executafuncao2(tipo, id) {

      if (tipo == 'ED'){

        document.getElementById('tabgeral').click();
        window.open("parametros/tipos/acao.php?Tipo=D&Codigo=" + id, "acao");

      } else if (tipo == 'EX'){

        Swal.fire({
            title: 'Deseja excluir a categoria selecionada?',
            text: "Não tem como reverter esta ação!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, excluir!'
        }).then((result) => {
            if (result.isConfirmed) {
                
                window.open("parametros/tipos/acao.php?Tipo=E&codigo="+id, "acao");

            } else {

                return false;

            }
        });

      }

    }

</script>