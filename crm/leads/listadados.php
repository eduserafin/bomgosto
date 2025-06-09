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
  $nome = mb_strtoupper($nome, 'UTF-8');
  if ($nome != "") {
    $v_sql .= " AND ls.ds_nome like '%" . $nome . "%'";
  }

  $credito = $_GET['credito'];
  if ($credito != "") {
    $v_sql .= " AND ls.vl_valor = $credito";
  }

  $cidade = $_GET['cidade'];
  if ($cidade != 0) {
    $v_sql .= " AND ls.nr_seq_cidade = $cidade";
  }

  $status = $_GET['status'];
  if ($status != 0) {
    $v_sql .= " AND ls.nr_seq_situacao = $status";
  }

  $segmento = $_GET['segmento'];
  if ($segmento != 0) {
    $v_sql .= " AND ls.nr_seq_segmento = $segmento";
  }

  $data1 = $_GET['data1'];
  if ($data1 != "") {
    $v_sql .= " AND ls.dt_cadastro >= '$data1'";
  }

  $data2 = $_GET['data2'];
  if ($data2 != "") {
    $v_sql .= " AND ls.dt_cadastro <= '$data2'";
  }

  $dataagenda1 = $_GET['dataagenda1'];
  if ($dataagenda1 != "") {
    $v_sql .= " AND ls.dt_agenda >= '$dataagenda1'";
  }

  $dataagenda2 = $_GET['dataagenda2'];
  if ($dataagenda2 != "") {
    $v_sql .= " AND ls.dt_agenda <= '$dataagenda2'";
  }

  include $ant."inc/exporta_excel.php";

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
      <table width="100%" class="table table-bordered table-striped modern-table">
        <tr>
          <th style="vertical-align:middle;">NOME</th>
          <th style="vertical-align:middle;">VALOR</th>
          <th style="vertical-align:middle;">CIDADE</th>
          <th style="vertical-align:middle;">CONTATO</th>
          <th style="vertical-align:middle;">DATA LEAD</th>
          <th style="vertical-align:middle;">DATA AGENDA</th>
          <th style="vertical-align:middle;">SEGMENTO</th>
          <th style="vertical-align:middle;">STATUS</th>
          <th colspan=2 style="vertical-align:middle; text-align:center">A&Ccedil;&Otilde;ES</th>
        </tr>

        <?php
        
          $SQL = "SELECT ls.nr_sequencial, ls.ds_nome, ls.vl_valor, ls.dt_cadastro, s.ds_segmento,
                    ls.nr_telefone AS contato, CONCAT(c.ds_municipio, ' - ', e.sg_estado) AS municipio_estado,
                    st.ds_situacao, ls.dt_agenda
                    FROM lead ls
                    INNER JOIN cidades c ON c.nr_sequencial = ls.nr_seq_cidade
                    INNER JOIN estados e ON c.nr_seq_estado = e.nr_sequencial
                    LEFT JOIN segmentos s ON ls.nr_seq_segmento = s.nr_sequencial
                    LEFT JOIN situacoes st ON ls.nr_seq_situacao = st.nr_sequencial
                  WHERE 1 = 1  
                  $v_sql
                  ORDER BY ls.nr_sequencial DESC LIMIT $porpagina offset $inicio";
          //echo "<pre>$SQL</pre>";
          $RSS = mysqli_query($conexao, $SQL);
          while ($linha = mysqli_fetch_row($RSS)) {
            $nr_sequencial = $linha[0];
            $ds_nome = $linha[1];
            $vl_valor = $linha[2]; 
            $valor = number_format($vl_valor, 2, ',', '.');
            $dt_cadastro = date('d/m/Y', strtotime($linha[3]));
            $ds_segmento = $linha[4];
            $contato = $linha[5];
            $municipio_estado = $linha[6];
            $ds_situacao = $linha[7];
            $dt_agenda = $linha[8];
            if($dt_agenda != "") { $dt_agenda = date('d/m/Y', strtotime($dt_agenda)); }

            ?>

            <tr>
              <td><?php echo $ds_nome; ?></td>
              <td><?php echo $valor; ?></td>
              <td><?php echo $municipio_estado; ?></td>
              <td><?php echo $contato; ?></td>
              <td><?php echo $dt_cadastro; ?></td>
              <td><?php echo $dt_agenda; ?></td>
              <td><?php echo $ds_segmento; ?></td>
              <td><?php echo $ds_situacao; ?></td>
              <td width="3%" align="center"><?php include $ant."inc/btn_editar.php";?></td>
              <!--<td width="3%" align="center"><?php include $ant."inc/btn_excluir.php";?></td>-->
            </tr>

            <?php
          }
        ?>

      </table>
  
      <?php include $ant."inc/paginacao.php";?>

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