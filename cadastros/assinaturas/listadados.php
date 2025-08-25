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

$empresa = $_GET['empresa'];
if ($empresa != 0) {
    $v_sql .= " AND a.nr_seq_empresa = $empresa";
}

$status = $_GET['status'];
if ($status != "") {
    $v_sql .= " AND a.st_status = '$status'";
}

$datai = $_GET['datai'];
if ($datai != "") {
    $v_sql .= " AND a.dt_cadastro >= '$datai'";
}

$dataf = $_GET['dataf'];
if ($dataf != "") {
    $v_sql .= " AND a.dt_cadastro <= '$dataf'";
}

include $ant."inc/exporta_excel.php";

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
    <table width="100%" class="table table-bordered table-striped modern-table">
        <tr>
            <th><strong>EMPRESA</strong></th>
            <th><strong>FORMA</strong></th>
            <th><strong>VALOR</strong></th>
            <th><strong>INÍCIO</strong></th>
            <th><strong>FIM</strong></th>
            <th><strong>OBSERVAÇÃO</strong></th>
            <th><strong>STATUS</strong></th>
            <th colspan="2" style="text-align: center;"><strong>AÇÕES</strong></th>
        </tr>
        <?php
        
            $SQL = "SELECT a.nr_sequencial, a.dt_inicio,
                    a.dt_fim, a.vl_valor, a.ds_observacoes, e.ds_empresa,
                    CASE 
                        WHEN a.st_status = 'A' THEN 'ATIVO'
                        WHEN a.st_status = 'I' THEN 'INATIVO'
                        WHEN a.st_status = 'P' THEN 'PENDENTE'
                        WHEN a.st_status = 'C' THEN 'CANCELADO'
                        WHEN a.st_status = 'T' THEN 'TESTE'
                        ELSE 'INDEFINIDO'
                    END AS ds_status,
                    CASE
                        WHEN a.tp_forma = 'D' THEN 'DINHEIRO'
                        WHEN a.tp_forma = 'P' THEN 'PIX'
                        WHEN a.tp_forma = 'C' THEN 'CARTÃO'
                        WHEN a.tp_forma = 'B' THEN 'BOLETO'
                        ELSE 'INDEFINIDO'
                    END AS ds_forma
                    FROM assinaturas a
                    INNER JOIN empresas e ON a.nr_seq_empresa = e.nr_sequencial
                    WHERE 1 = 1 
                    " . $v_sql . "
                    ORDER BY a.nr_sequencial DESC limit $porpagina offset $inicio";
            //echo "<pre>$SQL</pre>";
            $RSS = mysqli_query($conexao, $SQL);
            while ($linha = mysqli_fetch_row($RSS)) {
                $nr_sequencial = $linha[0];
                $dt_inicio = date('d/m/Y', strtotime($linha[1]));
                $dt_fim = date('d/m/Y', strtotime($linha[2]));
                $vl_valor = $linha[3];
                $valor = number_format($vl_valor, 2, ',', '.');
                $ds_observacao = $linha[4];
                $ds_empresa = $linha[5];
                $ds_status = $linha[6];
                $ds_forma = $linha[7];

                ?>
                <tr>
                    <td><?php echo $ds_empresa; ?></td>
                    <td><?php echo $ds_forma; ?></td>
                    <td><?php echo $valor; ?></td>
                    <td><?php echo $dt_inicio; ?></td>
                    <td><?php echo $dt_fim; ?></td>
                    <td><?php echo $ds_observacao; ?></td>
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
            window.open('cadastros/assinaturas/acao.php?Tipo=D&Codigo=' + id, "acao");
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
                    
                    window.open("cadastros/assinaturas/acao.php?Tipo=E&codigo="+id, "acao");

                } else {

                    return false;

                }
            });

        }

    }

</script>