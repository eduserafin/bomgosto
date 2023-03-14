<?php
$consulta = '';
$pesquisanome = '';
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

$produto = $_GET['produto'];
if ($produto != 0) {
    $v_sql = " AND v.nr_seq_produto = $produto";
}

$vendedor = $_GET['vendedor'];
if ($vendedor != 0) {
    $v_sql = " AND v.cd_usercadastro = $vendedor";
}

$opcao = $_GET['opcao'];
if ($opcao != '0') {
 $v_sql = " AND v.tp_pagamento = '$opcao'";
}

$dt1 = $_GET['data1'];
if ($dt1 != "") { $v_sql = " AND v.dt_cadastro >= '" . $dt1 . "'"; }

$dt2 = $_GET['data2'];
if ($dt2 != "") { $v_sql = " AND v.dt_cadastro <= '" . $dt2 . "'"; }

$nome = $_GET['nome'];
if ($nome != "") {
 $v_sql = " AND UPPER(ds_cliente) like UPPER('%" . $nome . "%')";

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
            <th><strong>PRODUTO</strong></th>
            <th><strong>QUANTIDADE</strong></th>
            <th><strong>VALOR</strong></th>
            <th><strong>TIPO DE PAGAMENTO</strong></th>
            <th><strong>DATA</strong></th>
            <th><strong>VENDEDOR</strong></th>
        
        </tr>
        <?php
        
                $SQL = "SELECT v.nr_sequencial, v.ds_cliente, p.ds_produto, v.nr_quantidade, v.vl_venda, v.tp_pagamento, v.dt_cadastro, v.cd_usercadastro
                        FROM vendas v
                        INNER JOIN produtos p ON p.nr_sequencial = v.nr_seq_produto
                        WHERE 1 = 1 ". $v_sql ."
                        ORDER BY v.nr_sequencial ASC LIMIT $porpagina offset $inicio";
                //echo $SQL;
                $RSS = mysqli_query($conexao, $SQL);
                while ($linha = mysqli_fetch_row($RSS)) {
                    $nr_sequencial = $linha[0];
                    $ds_cliente = $linha[1];
                    $ds_produto = $linha[2];
                    $nr_quantidade = number_format($linha[3], 2, ",", ".");
                    $vl_venda = number_format($linha[4], 2, ",", ".");
                    $tp_pagamento = $linha[5];
                    $dt_cadastro = date('d/m/Y', strtotime($linha[6]));
                    $ds_usuario = $linha[7];

                     if($ds_usuario  == 2) {$ds_usuario = 'WELLINTON';}
                  else  {$ds_usuario = 'MARCIO';}

                  if($tp_pagamento  == 'A') {$tp_pagamento = 'AVISTA';}
                  else if ($tp_pagamento == 'P') {$tp_pagamento = 'PARCELADO';}
                  else  {$tp_pagamento = 'NÃO PAGOU';}

                    ?>
                    <tr>
                        <td><?php echo $ds_cliente; ?></td>
                        <td><?php echo $ds_produto; ?></td>
                        <td><?php echo $nr_quantidade; ?></td>
                        <td><?php echo $vl_venda; ?></td>
                        <td><?php echo $tp_pagamento; ?></td>
                        <td><?php echo $dt_cadastro; ?></td>
                        <td><?php echo $ds_usuario; ?></td>
                    </tr>
                    <?php
                }
                ?>
    </table>
    <br>
    <?php include $ant."inc/paginacao.php";?>
  </body>
</html>   
