<?php
$consulta = '';
$pg = '';
$descricao = '';
$pesquisanome = '';
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
   
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <table width="100%" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="vertical-align:middle;">MENU</th>
                    <th style="vertical-align:middle;">SUB-MENU</th>
                    <th style="vertical-align:middle; text-align:center">M&Oacute;DULO</th>
                    <th style="vertical-align:middle;">LINK</th>
                    <th colspan=2 style="vertical-align:middle; text-align:center">A&Ccedil;&Otilde;ES</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $SQL = "SELECT m.nr_sequencial, m.ds_menu, m.ic_menu, s.nr_sequencial, s.ds_smenu, s.ic_smenu, s.lk_smenu, s.tipo_menu 
  FROM g_smenus s INNER JOIN g_menus m ON s.nr_seq_menu = m.nr_sequencial 
  WHERE (UPPER(m.ds_menu) LIKE UPPER('%" . $pesquisanome . "%') 
         OR UPPER(s.ds_smenu) LIKE UPPER('%" . $pesquisanome . "%')) 
  ORDER BY m.ds_menu, s.ds_smenu ASC limit $porpagina offset $inicio";
                //echo $SQL;
                $RS = mysqli_query($conexao, $SQL);
                while ($linha = mysqli_fetch_row($RS)) {
                    $id_menu = $linha[0];
                    $ds_menu = $linha[1];
                    $ic_menu = $linha[2];
                    $nr_sequencial = $linha[3];
                    $ds_smenu = $linha[4];
                    $ic_smenu = $linha[5];
                    $lk_smenu = $linha[6];
                    $tp_smenu = $linha[7];
                    if ($tp_smenu == 0) {
                        $tipo_menu = "N&Atilde;O DEFINIDO";
                    } else if ($tp_smenu == 1) {
                        $tipo_menu = "GERAL";
                    } else if ($tp_smenu == 2) {
                        $tipo_menu = "MOVIMENTOS";
                    } else if ($tp_smenu == 3) {
                        $tipo_menu = "RELAT&Oacute;RIOS";
                    }
                    ?>
                    <tr>
                        <td><?php echo $ds_menu; ?></td>
                        <td><?php echo $ds_smenu; ?></td>
                        <td><?php echo $tipo_menu; ?></td>
                        <td><?php echo $lk_smenu; ?></td>
                        <td width="3%" align="center"><?php include $ant."inc/btn_editar.php";?></td>
                        <td width="3%" align="center"><?php include $ant."inc/btn_excluir.php";?></td>
                    </tr>
    <?php
}
?>
            </tbody>
        </table>
        <br>
    <?php include $ant."inc/paginacao.php";?>

</body>
</html>
<script language="javascript">
    function executafuncao2(tipo, id) {
      if (tipo == 'ED'){
        document.getElementById('tabgeral').click();
        window.open("admin/smenus/acao.php?Tipo=D&Codigo=" + id, "acao");
      }
      else if (tipo == 'EX'){
        if (!confirm("Deseja excluir o registro selecionado?")) {
          return false;
        } 
        else {
          window.open("admin/smenus/acao.php?Tipo=E&codigo=" + id, "acao");
        }
      }
    }
</script>
