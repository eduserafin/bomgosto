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

$descricao = $_GET['descricao'];
if ($descricao !== "") {
    $pesquisanome = " AND c.ds_colaborador like UPPER('%$descricao%')";
}

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
    <table width="100%" class="table table-bordered table-striped modern-table">
        <tr>
            <th class="bg-info"><strong>NOME</strong></th>
            <th class="bg-info"><strong>LOGIN</strong></th>
            <th class="bg-info"><strong>E-MAIL</strong></th>
            <th class="bg-info"><strong>AÇÕES</strong></th>
        </tr>
        <?php
            $SQL = "SELECT u.nr_sequencial, c.ds_colaborador, u.ds_login, u.ds_email
                    FROM usuarios u
                    INNER JOIN colaboradores c ON c.nr_sequencial = u.nr_seq_colaborador
                    WHERE u.nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "
                    $pesquisanome 
                    ORDER BY c.ds_colaborador asc limit $porpagina offset $inicio";
            //echo $SQL;
            $RSS = mysqli_query($conexao, $SQL);
            while ($linha = mysqli_fetch_row($RSS)) {
                $nr_sequencial = $linha[0];
                $user = $linha[1];
                $login = $linha[2];
                $email = $linha[3];
                ?>
                <tr>
                    <td><?php echo $user; ?></td>
                    <td><?php echo $login; ?></td>
                    <td><?php echo $email; ?></td>
                    <td width="3%" align="center"><?php include $ant."inc/btn_editar.php";?></td>
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
          window.open('admin/usuario/acao.php?Tipo=D&Codigo=' + id, "acao");
      }
    }
</script>