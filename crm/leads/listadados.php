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
    $v_sql = " AND ls.ds_nome like UPPER('%" . $nome . "%')";
  }

  $credito = $_GET['credito'];
  if ($credito != "") {
    $v_sql = " AND ls.vl_valor = $credito";
  }

  $cidade = $_GET['cidade'];
  if ($cidade != 0) {
    $v_sql = " AND ls.nr_seq_cidade = $cidade";
  }

  $status = $_GET['status'];
  if ($status != "") {
    $v_sql = " AND ls.st_situacao = '$status'";
  }

  $tipo = $_GET['tipo'];
  if ($tipo != "") {
    $v_sql = " AND ls.tp_tipo = $tipo";
  }

  $data1 = $_GET['data1'];
  if ($data1 != "") {
    $v_sql = " AND ls.dt_cadastro = '$data1'";
  }

  $data2 = $_GET['data2'];
  if ($data2 != "") {
    $v_sql = " AND ls.dt_cadastro = '$data2'";
  }

  include $ant."inc/exporta_excel.php";

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
      <table width="100%" class="table table-bordered table-striped">
        <tr>
          <th style="vertical-align:middle;">NOME</th>
          <th style="vertical-align:middle;">VALOR</th>
          <th style="vertical-align:middle;">CIDADE</th>
          <th style="vertical-align:middle;">CONTATO</th>
          <th style="vertical-align:middle;">DATA</th>
          <th style="vertical-align:middle;">PRODUTO</th>
          <th style="vertical-align:middle;">TIPO</th>
          <th style="vertical-align:middle;">STATUS</th>
          <th colspan=2 style="vertical-align:middle; text-align:center">A&Ccedil;&Otilde;ES</th>
        </tr>

        <?php
        
          $SQL = "SELECT ls.nr_sequencial, ls.ds_nome, ls.vl_valor, ls.dt_cadastro, ps.ds_produto,
                    CONCAT(ls.nr_whatsapp, ' - ', ls.nr_telefone) AS contato,
                    CONCAT(m.ds_municipioibge, ' - ', m.sg_estado) AS municipio_estado,
                    ls.tp_tipo, ls.st_situacao
                    FROM lead_site ls
                    INNER JOIN municipioibge m ON m.cd_municipioibge = ls.nr_seq_cidade
                    LEFT JOIN produtos_site ps ON ls.nr_seq_produto = ps.nr_sequencial
                  WHERE 1 = 1  
                  $v_sql
                  ORDER BY ls.nr_sequencial DESC LIMIT $porpagina offset $inicio";
          //echo "<pre>$SQL</pre>";
          $RSS = mysqli_query($conexao, $SQL);
          while ($linha = mysqli_fetch_row($RSS)) {
            $nr_sequencial = $linha[0];
            $ds_nome = $linha[1];
            $vl_valor = $linha[2]; 
            $valor = number_format($vl_valor / 100, 2, ',', '.');
            $dt_cadastro = date('d/m/Y', strtotime($linha[3]));
            $ds_produto = $linha[4];
            $contato = $linha[5];
            $municipio_estado = $linha[6];
            $tp_tipo = $linha[7];
            $st_situacao = $linha[8];

            $dstipo = '';
            if($tp_tipo == 'S'){
              $dstipo = 'SIMULAÇÃO';
            } else if ($tp_tipo == 'C'){
              $dstipo = 'CONTATO';
            } else {
              $dstipo = '';
            }

            $dsstatus = '';
            if($st_situacao == 'N'){
              $dsstatus = 'NOVO';
            } else if ($st_situacao == 'C'){
              $dsstatus = 'CONTATO';
            } else if ($st_situacao == 'P'){
              $dsstatus = 'PERDIDA';
            } else if ($st_situacao == 'E'){
              $dsstatus = 'EM ANDAMENTO';
            } else if ($st_situacao == 'T'){
              $dsstatus = 'CONTRATADA';
            } else {
              $dsstatus = '';
            }


            ?>

            <tr>
              <td><?php echo $ds_nome; ?></td>
              <td><?php echo $valor; ?></td>
              <td><?php echo $municipio_estado; ?></td>
              <td><?php echo $contato; ?></td>
              <td><?php echo $dt_cadastro; ?></td>
              <td><?php echo $ds_produto; ?></td>
              <td><?php echo $dstipo; ?></td>
              <td><?php echo $dsstatus; ?></td>
              <td width="3%" align="center"><?php include $ant."inc/btn_editar.php";?></td>
              <!--<td width="3%" align="center"><?php include $ant."inc/btn_excluir.php";?></td>-->
            </tr>

            <?php
          }
        ?>

      </table>
  
      <br><?php include $ant."inc/paginacao.php";?>

  </body>
</html> 

<script language="javascript">

    window.parent.document.getElementById('dvAguarde').style.display = 'none';

    function executafuncao2(tipo, id) {

      if (tipo == 'ED'){

        document.getElementById('tabgeral').click();
        window.open("crm/leads/acao.php?Tipo=D&Codigo=" + id, "acao");

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
                
                window.open("crm/leads/acao.php?Tipo=E&codigo="+id, "acao");

            } else {

                return false;

            }
        });

      }

    }

</script>