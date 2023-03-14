<?php
$consulta = '';
$produto = '';
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
if ($produto != "") {
 $v_sql = " AND UPPER(ds_produto) like UPPER('%" . $produto . "%')";

}

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
    <table width="100%" class="table table-bordered table-striped">
        <tr>
        
            <th><strong>PRODUTO</strong></th>
            <th><strong>VALOR UNITÁRIO</strong></th>
            <th><strong>STATUS</strong></th>
            <th><strong>EDITAR</strong></th>
            <th><strong>EXCLUIR</strong></th>
        </tr>
        <?php
        
                $SQL = "SELECT nr_sequencial, ds_produto, vl_unitario, ds_status
                        FROM produtos
                        WHERE 1 = 1 $v_sql 
                        ORDER BY ds_produto ASC LIMIT $porpagina offset $inicio";
               // echo $SQL;
                $RSS = mysqli_query($conexao, $SQL);
                while ($linha = mysqli_fetch_row($RSS)) {
                    $nr_sequencial = $linha[0];
                    $ds_produto = $linha[1];
                    $vl_unitario = number_format($linha[2], 2, ",", ".");
                    $ds_status = $linha[3];

                    if( $ds_status == 1){$status = 'ATIVO';}
                    else {$status = 'INATIVO';}


                    ?>
                    <tr>
                        <td><?php echo $ds_produto; ?></td>
                        <td><?php echo $vl_unitario; ?></td>
                        <td><?php echo $status; ?></td>
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
        window.open("produtos/cadastros/acao.php?Tipo=D&Codigo=" + id, "acao");
      }else if (tipo == 'EX'){
        if (!confirm("Deseja excluir o registro selecionado?")) {
          return false;
        } 
        else {
          window.open("produtos/cadastros/acao.php?Tipo=E&codigo=" + id, "acao");
        }
      }
    }
</script>