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
        <table width="100%" class="table table-bordered table-striped modern-table">
            <thead>
                <tr>
                    <th>MENUS</th>
                    <th colspan="2" style="text-align: center;"><strong>AÇÕES</strong></th>
                </tr>
            </thead>
            <?php
                $SQL = "SELECT nr_sequencial, ds_menu  
                        FROM menus
                        WHERE UPPER(ds_menu) LIKE UPPER('%" . $pesquisanome . "%') 
                        ORDER BY ds_menu ASC limit $porpagina offset $inicio";
                
                $RSS = mysqli_query($conexao, $SQL);
                while ($linha = mysqli_fetch_row($RSS)) {
                    $nr_sequencial = $linha[0];
                    $desc_menu = $linha[1];
                    ?>
                    <tr>
                        <td><?php echo $desc_menu; ?></td>
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
            window.open('admin/menus/acao.php?Tipo=D&Codigo=' + id, "acao");
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
                    
                    window.open("admin/menus/acao.php?Tipo=E&codigo="+id, "acao");

                } else {

                    return false;

                }
            });

        }

    }

</script>
