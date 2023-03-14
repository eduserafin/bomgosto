<?php
$consulta = '';
$pg = '';
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

$despesa = $_GET['despesa'];
if ($despesa != "") {
 $v_sql = " AND UPPER(ds_descricao) like UPPER('%" . $despesa . "%')";
}

$data = $_GET['data'];
if ($data != '') {
 $v_sql = " AND dt_despesa = '$data'";
}


?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
    <table width="100%" class="table table-bordered table-striped">
        <tr>
            <th><strong>DESPESA</strong></th>
            <th><strong>VALOR DESPESA </strong></th>
            <th><strong>DATA DESPESA</strong></th>
            <th><strong>EDITAR</strong></th>
            <th><strong>EXCLUIR</strong></th>

        </tr>
        <?php
        
                $SQL = "SELECT nr_sequencial, ds_descricao, vl_despesa, dt_despesa
                        FROM despesas
                        WHERE 1 = 1 $v_sql 
                        ORDER BY nr_sequencial ASC LIMIT $porpagina offset $inicio";
               // echo $SQL;
                $RSS = mysqli_query($conexao, $SQL);
                while ($linha = mysqli_fetch_row($RSS)) {
                    $nr_sequencial = $linha[0];
                    $ds_despesa = $linha[1];
                    $vl_despesa = number_format($linha[2], 2, ",", ".");
                    $dt_despesa = date('d/m/Y', strtotime($linha[3]));


                    ?>
                    <tr>
                        <td><?php echo $ds_despesa; ?></td>
                        <td><?php echo $vl_despesa; ?></td>
                        <td><?php echo $dt_despesa; ?></td>
                        <td width="3%" align="center"><?php include $ant."inc/btn_editar.php";?></td>
                        <td width="3%" align="center"><?php include $ant."inc/btn_excluir.php";?></td>
                    </tr>
                    <?php
                }
                ?>
    </table>
    <br>
    <?php include $ant."inc/paginacao.php";?>
  </body>
</html>   
<script language="javascript">
    function executafuncao2(tipo, id) {
      if (tipo == 'ED'){
        document.getElementById('tabgeral').click();
        window.open("despesas/lancamentos/acao.php?Tipo=D&Codigo=" + id, "acao");
      }else if (tipo == 'EX'){
        if (!confirm("Deseja excluir o registro selecionado?")) {
          return false;
        } 
        else {
          window.open("despesas/lancamentos/acao.php?Tipo=E&codigo=" + id, "acao");
        }
      }
    }
</script>