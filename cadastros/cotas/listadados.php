<?php

$consulta = $_GET['consulta'];
$pg = $_GET['pg'];
$administradora = $_GET['administradora'];
$grupo = $_GET['grupo'];
$cota = $_GET['cota'];
$status = $_GET['status'];

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

$v_filtros = "";

if ($administradora != 0) {
    $v_filtros .= "AND c.nr_seq_administradora = $administradora";
}

if ($grupo != "") {
    $v_filtros .= "AND c.ds_grupo = '$grupo'";
}

if ($cota != "") {
    $v_filtros .= "AND c.nr_cota = $cota";
}

if ($status != "") {
    $v_filtros .= "AND c.st_status = '$status'";
}

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
    <table width="100%" class="table table-bordered table-striped modern-table">
        <tr>
            <th><strong>ADMINISTRADORA</strong></th>
            <th><strong>GRUPO</strong></th>
            <th><strong>COTA</strong></th>
            <th><strong>VALOR DO CRÉDITO</strong></th>
            <th><strong>VALOR DA ENTRADA</strong></th>
            <th><strong>PRAZO</strong></th>
            <th><strong>VALOR DA PARCELA</strong></th>
            <th><strong>NOME CONSORCIADO</strong></th>
            <th><strong>DATA</strong></th>
            <th><strong>STATUS</strong></th>
            <th colspan="2" style="text-align: center;"><strong>AÇÕES</strong></th>
        </tr>
        <?php
        
            $SQL = "SELECT c.nr_sequencial, a.ds_administradora, c.ds_grupo, c.nr_cota, c.vl_credito,
                    c.vl_entrada, c.nr_prazo, c.vl_parcela, c.ds_nome, c.dt_cadastro,
                    CASE
                        WHEN c.st_status = 'A' THEN 'ATIVA'
                        WHEN c.st_status = 'V' THEN 'VENDIDA'
                        ELSE ''
                    END AS ds_status
                    FROM cotas_contempladas c
                    INNER JOIN administradoras a ON a.nr_sequencial = c.nr_seq_administradora
                    WHERE c.nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "
                    " . $v_filtros . "
                    ORDER BY c.nr_sequencial DESC limit $porpagina offset $inicio";
            //echo "<pre>$SQL</pre>";
            $RSS = mysqli_query($conexao, $SQL);
            while ($linha = mysqli_fetch_row($RSS)) {
                $nr_sequencial = $linha[0];
                $ds_administradora = $linha[1];
                $ds_grupo = $linha[2];
                $nr_cota = $linha[3];
                $vl_credito = $linha[4];
                $valor_credito = number_format($vl_credito, 2, ',', '.');
                $vl_entrada = $linha[5];
                $valor_entrada = number_format($vl_entrada, 2, ',', '.');
                $nr_prazo = $linha[6];
                $vl_parcela = $linha[7];
                $valor_parcela = number_format($vl_parcela, 2, ',', '.');
                $ds_nome = $linha[8];
                $dt_cadastro = date('d/m/Y', strtotime($linha[9]));
                $ds_status = $linha[10];

                ?>
                
                <tr>
                    <td><?php echo $ds_administradora; ?></td>
                    <td><?php echo $ds_grupo; ?></td>
                    <td><?php echo $nr_cota; ?></td>
                    <td><?php echo $valor_credito; ?></td>
                    <td><?php echo $valor_entrada; ?></td>
                    <td><?php echo $nr_prazo; ?></td>
                    <td><?php echo $valor_parcela; ?></td>
                    <td><?php echo $ds_nome; ?></td>
                    <td><?php echo $dt_cadastro; ?></td>
                    <td><?php echo $ds_status; ?></td>
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
            window.open('cadastros/cotas/acao.php?Tipo=D&Codigo=' + id, "acao");
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
                    
                    window.open("cadastros/cotas/acao.php?Tipo=E&codigo="+id, "acao");

                } else {

                    return false;

                }
            });

        }

    }

</script>
