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

  $categoria = $_GET['categoria'];
  if ($categoria != "") {
    $v_sql = " AND UPPER(ds_categoria) like UPPER('%" . $categoria . "%')";
  }

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
      <table width="100%" class="table table-bordered table-striped">
        <tr>
          <th style="vertical-align:middle;">CATEGORIA</th>
          <th style="vertical-align:middle;">STATUS</th>
          <th colspan=2 style="vertical-align:middle; text-align:center">A&Ccedil;&Otilde;ES</th>
        </tr>

        <?php
        
          $SQL = "SELECT nr_sequencial, ds_categoria, st_status
                    FROM categorias
                  WHERE 1 = 1 $v_sql 
                  ORDER BY ds_categoria ASC LIMIT $porpagina offset $inicio";
                  // echo $SQL;
          $RSS = mysqli_query($conexao, $SQL);
          while ($linha = mysqli_fetch_row($RSS)) {
            $nr_sequencial = $linha[0];
            $ds_categoria = $linha[1];
            $st_status = $linha[2];

            if( $st_status == "1"){$status = 'ATIVO';}
            else {$status = 'INATIVO';}

            ?>

            <tr>
              <td><?php echo $ds_categoria; ?></td>
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
        window.open("produtos/categorias/acao.php?Tipo=D&Codigo=" + id, "acao");

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
                
                window.open("produtos/categorias/acao.php?Tipo=E&codigo="+id, "acao");

            } else {

                return false;

            }
        });

      }

    }

</script>