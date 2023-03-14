<?php
$consulta = '';
$equipamento = '';
$nome = '';
$data = '';
$pg = '';
foreach($_GET as $key => $value){
	$$key = $value;
}

if ($consulta == "sim") {
    require_once '../conexao.php';
    $ant = "../";
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

$equipamento = $_GET['equipamento'];
if ($equipamento != 0) {
    $v_sql = " AND c.nr_seq_equipamento = $equipamento";
}

$nome = $_GET['nome'];  
if ($nome != "") {
    $v_sql = " AND UPPER(c.ds_cliente) like UPPER('%$nome%')";
}

$data = $_GET['data'];
if ($data != '') {
 $v_sql = " AND c.dt_cadastro = '$data'";
}


?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
    <table width="100%" class="table table-bordered table-striped">
        <tr>
            <th><strong>CLIENTE</strong></th>
            <th><strong>EQUIPAMENTO</strong></th>
            <th><strong>QUANTIDADE</strong></th>
            <th><strong>DATA</strong></th>
            <th><strong>DEVOLVIDO</strong></th>
            <th colspan=3 style="vertical-align:middle; text-align:center">A&Ccedil;&Otilde;ES</th>
            
        </tr>
        <?php
        
                $SQL = "SELECT c.nr_sequencial, c.ds_cliente, e.ds_equipamento, c.nr_quantidade, c.dt_cadastro, c.st_devolvido, dt_devolvido
                        FROM controle_equipamentos c
                        INNER JOIN equipamentos e ON e.nr_sequencial = c.nr_seq_equipamento
                        WHERE 1 = 1 $v_sql 
                        ORDER BY c.nr_sequencial ASC LIMIT $porpagina offset $inicio";
                //echo $SQL;
                $RSS = mysqli_query($conexao, $SQL);
                while ($linha = mysqli_fetch_row($RSS)) {
                    $nr_sequencial = $linha[0];
                    $ds_cliente = $linha[1];
                    $ds_equipamento = $linha[2];
                    $nr_quantidade = number_format($linha[3], 2, ",", ".");
                    $dt_cadastro = date('d/m/Y', strtotime($linha[4]));
                    $st_devolvido = $linha[5];
                    $dt_devolvido = $linha[6];
                    if($dt_devolvido !=''){
                    $dt_devolvido = date('d/m/Y', strtotime($linha[6]));}
                    else{$dt_devolvido == "";}
                    
                    ?>
                    <tr>
                        <td><?php echo $ds_cliente; ?></td>
                        <td><?php echo $ds_equipamento; ?></td>
                        <td><?php echo $nr_quantidade; ?></td>
                        <td><?php echo $dt_cadastro; ?></td>
                        <td><?php echo $dt_devolvido; ?></td>

                        <?php
                          if($st_devolvido == 'N'){
                            ?>
                            <td width="3%" align="center"> <button type="button" class="btn btn-success" onclick="javascript: executafuncao2('DE', <?php echo $nr_sequencial; ?>);" title="EDITAR" alt="EDITAR"><span class="glyphicon glyphicon-ok"></span></button></td>
                            <?php
                          }
                          ?>
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
        window.open("equipamentos/acao.php?Tipo=D&Codigo=" + id, "acao");
      }
      else if (tipo == 'DE'){
        document.getElementById('tabgeral').click();
        window.open("equipamentos/acao.php?Tipo=S&Codigo=" + id, "acao");
        } 
      else if (tipo == 'EX'){
        if (!confirm("Deseja excluir o registro selecionado?")) {
          return false;
        } 
      else {
          window.open("equipamentos/acao.php?Tipo=E&codigo=" + id, "acao");
        }
      }
    }
  
</script>