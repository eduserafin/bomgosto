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
    $v_sql .= " AND c.nr_seq_empresa = $empresa";
}

$titulo = $_GET['titulo'];
$titulo = mb_strtoupper($titulo, 'UTF-8');
if ($titulo != "") {
    $v_sql .= " AND c.ds_titulo like '%" . $titulo . "%'";
}

$categoria = $_GET['categoria'];
if ($categoria != "") {
    $v_sql .= " AND c.st_categoria = '$categoria'";
}

$prioridade = $_GET['prioridade'];
if ($prioridade != "") {
    $v_sql .= " AND c.st_prioridade = '$prioridade'";
}

$status = $_GET['status'];
if ($status != "") {
    $v_sql .= " AND c.st_status = '$status'";
}

$abertura = $_GET['abertura'];
if ($abertura != "") {
    $v_sql .= " AND c.dt_abertura >= '$abertura'";
}

$fechamento = $_GET['fechamento'];
if ($fechamento != "") {
    $v_sql .= " AND c.dt_abertura <= '$fechamento'";
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
            <th><strong>CATEGORIA</strong></th>
            <th><strong>PRIORIDADE</strong></th>
            <th><strong>STATUS</strong></th>
            <th><strong>DATA ABERTURA</strong></th>
            <th><strong>DATA FECHAMENTO</strong></th>
            <th><strong>TÍTULO</strong></th>
            <th colspan="2" style="text-align: center;"><strong>AÇÕES</strong></th>
        </tr>
        <?php
        
            $SQL = "SELECT c.nr_sequencial, e.ds_empresa, c.dt_abertura, c.dt_fechamento, c.ds_titulo, c.ds_descricao,
                    CASE 
                        WHEN c.st_status = 'A' THEN 'ABERTO'
                        WHEN c.st_status = 'E' THEN 'EM ANDAMENTO'
                        WHEN c.st_status = 'P' THEN 'PARADO'
                        WHEN c.st_status = 'C' THEN 'CONCLUÍDO'
                        ELSE 'INDEFINIDO'
                    END AS ds_status,
                    CASE
                        WHEN c.st_categoria = 'I' THEN 'IDEIA'
                        WHEN c.st_categoria = 'C' THEN 'CORREÇÃO'
                        WHEN c.st_categoria = 'O' THEN 'SOLICITAÇÃO'
                        WHEN c.st_categoria = 'S' THEN 'SUPORTE'
                        ELSE 'INDEFINIDO'
                    END AS ds_categoria,
                    CASE
                        WHEN c.st_prioridade = 'A' THEN 'ALTA'
                        WHEN c.st_prioridade = 'M' THEN 'MÉDIA'
                        WHEN c.st_prioridade = 'B' THEN 'BAIXA'
                        ELSE 'INDEFINIDO'
                    END AS ds_prioridade
                    FROM chamados c
                    INNER JOIN empresas e ON c.nr_seq_empresa = e.nr_sequencial
                    WHERE 1 = 1 
                    " . $v_sql . "
                    ORDER BY c.nr_sequencial DESC limit $porpagina offset $inicio";
            //echo "<pre>$SQL</pre>";
            $RSS = mysqli_query($conexao, $SQL);
            while ($linha = mysqli_fetch_row($RSS)) {
                $nr_sequencial = $linha[0];
                $ds_empresa = $linha[1];
                $dt_abertura = $linha[2];
                if($dt_abertura != "") { $dt_abertura = date('d/m/Y', strtotime($dt_abertura)); }
                $dt_fechamento = $linha[3];
                if($dt_fechamento != "") { $dt_fechamento = date('d/m/Y', strtotime($dt_fechamento)); }
                $ds_titulo = $linha[4];
                $ds_descricao = $linha[5];
                $ds_status = $linha[6];
                $ds_categoria = $linha[7];
                $ds_prioridade = $linha[8];

                ?>
                <tr>
                    <td><?php echo $ds_empresa; ?></td>
                    <td><?php echo $ds_categoria; ?></td>
                    <td><?php echo $ds_prioridade; ?></td>
                    <td><?php echo $ds_status; ?></td>
                    <td><?php echo $dt_abertura; ?></td>
                    <td><?php echo $dt_fechamento; ?></td>
                    <td><?php echo $ds_titulo; ?></td>
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
            window.open('chamados/chamados/acao.php?Tipo=D&Codigo=' + id, "acao");
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
                    
                    window.open("chamados/chamados/acao.php?Tipo=E&codigo="+id, "acao");

                } else {

                    return false;

                }
            });

        }

    }

</script>