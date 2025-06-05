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

$descricao = $_GET['descricao'];
$descricao = mb_strtoupper($descricao, 'UTF-8');

if ($descricao !== "") {
    $pesquisanome = " AND c.ds_colaborador like '%$descricao%'";
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
    <table width="100%" class="table table-bordered table-striped">
        <tr>
            <th><strong>NOME</strong></th>
            <th><strong>CPF</strong></th>
            <th><strong>RG</strong></th>
            <th><strong>FUNÇÃO</strong></th>
            <th><strong>STATUS</strong></th>
            <th colspan=2><strong>AÇÕES</strong></th>
        </tr>
        <?php
        
            $SQL = "SELECT c.nr_sequencial, c.ds_colaborador, c.nr_cpf, c.nr_rg, f.ds_funcao,
                    CASE WHEN c.st_status = 'A' THEN 'ATIVO' ELSE 'INATIVO' END AS st_status
                    FROM colaboradores c
                    INNER JOIN funcoes f ON c.nr_seq_funcao = f.nr_sequencial
                    WHERE c.nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "
                    $pesquisanome 
                    ORDER BY c.ds_colaborador ASC limit $porpagina offset $inicio";
            //echo $SQL;
            $RSS = mysqli_query($conexao, $SQL);
            while ($linha = mysqli_fetch_row($RSS)) {
                $nr_sequencial = $linha[0];
                $ds_nome = $linha[1];
                $nr_cpf = $linha[2];
                $nr_rg = $linha[3];
                $ds_funcao = $linha[4];
                $st_status = $linha[5];
                ?>
                <tr>
                    <td><?php echo $ds_nome; ?></td>
                    <td><?php echo $nr_cpf; ?></td>
                    <td><?php echo $nr_rg; ?></td>
                    <td><?php echo $ds_funcao; ?></td>
                    <td><?php echo $st_status; ?></td>
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
            window.open('cadastros/colaboradores/acao.php?Tipo=D&Codigo=' + id, "acao");
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
                    
                    window.open("cadastros/colaboradores/acao.php?Tipo=E&codigo="+id, "acao");

                } else {

                    return false;

                }
            });

        }

    }

</script>
