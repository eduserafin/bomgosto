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

$v_sql = "";

$nome = $_GET['nome'];
$nome = mb_strtoupper($nome, 'UTF-8');
if ($nome != "") {
    $v_sql = "AND (m.ds_menu like '%" . $nome . "%' OR s.ds_smenu like '%" . $nome . "%')";
}

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
    <table width="100%" class="table table-bordered table-striped modern-table">
        <tr>
            <th><strong>MENU</strong></th>
            <th><strong>SMENU</strong></th>
            <th colspan="2" style="text-align: center;"><strong>AÇÕES</strong></th>
        </tr>
        <?php
        
            $SQL = "SELECT t.nr_sequencial, m.ds_menu, s.ds_smenu, t.ds_link
                    FROM treinamentos t
                    INNER JOIN menus m ON m.nr_sequencial = t.nr_seq_menu
                    INNER JOIN submenus s ON s.nr_sequencial = t.nr_seq_smenu 
                    WHERE 1 = 1 
                    " . $v_sql . "
                    ORDER BY t.nr_sequencial DESC limit $porpagina offset $inicio";
            //echo "<pre>$SQL</pre>";
            $RSS = mysqli_query($conexao, $SQL);
            while ($linha = mysqli_fetch_row($RSS)) {
                $nr_sequencial = $linha[0];
                $ds_menu = $linha[1];
                $ds_smenu = $linha[2];
                $ds_link = $linha[3];

                ?>
                <tr>
                    <td><?php echo $ds_menu; ?></td>
                    <td><?php echo $ds_smenu; ?></td>
                    <td width="3%" align="center"><?php include $ant."inc/btn_editar.php";?></td>
                    <td width="3%" align="center"><?php include $ant."inc/btn_excluir.php";?></td>
                </tr>
                <?php
            }
        ?>
    </table>

    <?php include $ant."inc/paginacao.php";?>
    
  </body>
</html>   

<script language="javascript">

    function executafuncao2(tipo, id) {

        if (tipo == 'ED'){
            document.getElementById('tabgeral').click();
            window.open('treinamentos/cadastros/acao.php?Tipo=D&Codigo=' + id, "acao");
        } else if (tipo == 'EX'){
            Swal.fire({
                title: 'Deseja excluir o registro selecionado?',
                text: "Não tem como reverter esta ação!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    window.open("treinamentos/cadastros/acao.php?Tipo=E&codigo="+id, "acao");

                } else {

                    return false;

                }
            });

        }

    }

</script>