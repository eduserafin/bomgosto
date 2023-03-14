<?php
$consulta = '';
$pg = '';
$descricao = '';
$sqlfiltro = '';
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

$busca = $_GET['descricao'];
$descricao = $busca;
if ($descricao !== "") {
    $pesquisanome = $descricao;
    $sqlfiltro = "and upper(u.nome) like upper('%" . $descricao . "%')";
}

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>

        <table width="100%" class="table table-bordered table-striped">
            <tr>
                <th>USUÁRIO</th>
                <th>AÇÕES</th>
            </tr>
            <?php
            $SQL = "SELECT u.idusuario, UPPER(u.nome)
  FROM tb_usuarios u where 1=1 ".$sqlfiltro."
  ORDER BY u.nome ASC limit $porpagina offset $inicio";
            $RSS = mysqli_query($conexao, $SQL);
            while ($linha = mysqli_fetch_row($RSS)) {
                $nr_sequencial = $linha[0];
                $desc_user = $linha[1];
                ?>
                <tr>
                    <td><?php echo $desc_user; ?> </td>
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
          window.open('admin/libera/acao.php?Tipo=D&Codigo=' + id, "acao");
        }
    }
</script>