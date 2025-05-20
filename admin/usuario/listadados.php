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
    $pesquisanome = " AND u.nome like UPPER('%$descricao%')";
}

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
    <table width="100%" class="table table-bordered table-striped">
        <tr>
            <th class="bg-info"><strong>NOME</strong></th>
            <th class="bg-info"><strong>LOGIN</strong></th>
            <th class="bg-info"><strong>E-MAIL</strong></th>
            <th class="bg-info"><strong>AÇÕES</strong></th>
        </tr>
        <?php
        
                $SQL = "SELECT u.idusuario, UPPER(u.nome), u.login, u.email
                        FROM tb_usuarios u
                        WHERE 1 = 1 $pesquisanome 
                        ORDER BY u.nome asc limit $porpagina offset $inicio";
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