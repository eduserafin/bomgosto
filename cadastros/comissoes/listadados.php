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

$colaborador = $_GET['colaborador'];
$administradora = $_GET['administradora'];

if ($colaborador != 0) {
    $v_colaborador = "AND m.nr_seq_colaborador = $colaborador";
}

if ($administradora != 0) {
    $v_administradora = "AND m.nr_seq_administradora = $administradora";
}

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
    <table width="100%" class="table table-bordered table-striped">
        <tr>
            <th><strong>COLABORADOR</strong></th>
            <th><strong>COMISSÃO</strong></th>
            <th><strong>PARCELAS</strong></th>
            <th><strong>ADMINISTRADORA</strong></th>
            <th colspan=2><strong>AÇÕES</strong></th>
        </tr>
        <?php
        
            $SQL = "SELECT m.nr_sequencial, c.ds_colaborador, m.vl_comissao, m.nr_parcelas, a.ds_administradora
                    FROM comissoes m
                    INNER JOIN colaboradores c ON c.nr_sequencial = m.nr_seq_colaborador
                    INNER JOIN administradoras a ON a.nr_sequencial = m.nr_seq_administradora
                    WHERE c.nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "
                    $v_colaborador 
                    $v_administradora 
                    ORDER BY c.ds_colaborador ASC limit $porpagina offset $inicio";
            //echo $SQL;
            $RSS = mysqli_query($conexao, $SQL);
            while ($linha = mysqli_fetch_row($RSS)) {
                $nr_sequencial = $linha[0];
                $ds_colaborador = $linha[1];
                $vl_comissao = $linha[2];
                $nr_parcelas = $linha[3];
                $ds_administradora = $linha[4];
                ?>
                <tr>
                    <td><?php echo $ds_colaborador; ?></td>
                    <td><?php echo $vl_comissao; ?></td>
                    <td><?php echo $nr_parcelas; ?></td>
                    <td><?php echo $ds_administradora; ?></td>
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
            window.open('cadastros/comissoes/acao.php?Tipo=D&Codigo=' + id, "acao");
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
                    
                    window.open("cadastros/comissoes/acao.php?Tipo=E&codigo="+id, "acao");

                } else {

                    return false;

                }
            });

        }

    }

</script>
