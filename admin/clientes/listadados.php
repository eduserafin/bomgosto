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
    $pesquisanome = " AND UPPER(c.razaosocial) like UPPER('%$descricao%')";
}

if ($averba == "99") {
    $pesquisaaverba = " ";
}
else {
    $pesquisaaverba = " AND averbacao = '$averba'";
}

if ($gxml == "9") {
    $pesquisagxml = " ";
}
else {
    $pesquisagxml = " AND gxml = '$gxml'";
}

if ($bloqueio == "T") {
    $pesquisabloqueio = " ";
}
else {
    $pesquisabloqueio = " AND cli_bloqueado = '$bloqueio'";
}

if ($contrato == "T") {
    $pesquisacontrato = " ";
}
elseif ($contrato == "N") {
    $pesquisacontrato = " AND (ds_arquivo_contrato = '' or ds_arquivo_contrato is null) ";
}
else{
    $pesquisacontrato = " AND ds_arquivo_contrato <> ''";
}

if ($certificado == "T") {
    $pesquisacertificado = " ";
}
elseif ($certificado == "N") {
    $pesquisacertificado = " AND (ds_arquivo_certificado = '' or ds_arquivo_certificado is null) ";
}
else{
    $pesquisacertificado = " AND ds_arquivo_certificado <> ''";
}

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
    <table width="100%" class="table table-bordered table-striped">
        <tr>
            <th><strong>RAZ&Atilde;O SOCIAL</strong></th>
            <th><strong>RESPONS&Aacute;VEL</strong></th>
            <th><strong>FONE</strong></th>
            <th><strong>EMAIL</strong></th>
            <th><strong>STATUS</strong></th>
            <th><strong>CONTRATO</strong></th>
            <th><strong>CERTIFICADO</strong></th>
            <th><strong>AÇÕES</strong></th>
        </tr>
        <?php
        
                $SQL = "SELECT c.idcliente, c.responsavel, c.razaosocial, c.fone1||' | '||c.fone2, c.emailcli, ds_arquivo_contrato, ds_arquivo_certificado,
                        CASE c.status
                            WHEN '1' THEN 'ATIVO'
                            ELSE 'INATIVO'
                        END as status
      FROM tab_clientes c
      WHERE 1 = 1 $pesquisanome $pesquisaaverba $pesquisagxml $pesquisabloqueio $pesquisacontrato $pesquisacertificado
      ORDER BY status ASC, c.razaosocial asc limit $porpagina offset $inicio";
                //echo $SQL;
                $RSS = pg_query($conexao, $SQL);
                while ($linha = pg_fetch_row($RSS)) {
                    $nr_sequencial = $linha[0];
                    $desc_responsavel = $linha[1];
                    $desc_razaosocial = $linha[2];
                    $desc_fone = $linha[3];
                    $desc_email = $linha[4];
                    $contrato = $linha[5];
                    $certificado = $linha[6];
                    $desc_status = $linha[7];
                    

                    ?>
                    <tr>
                        <td><?php echo $desc_razaosocial; ?></td>
                        <td><?php echo $desc_responsavel; ?></td>
                        <td><?php echo $desc_fone; ?></td>
                        <td><?php echo $desc_email; ?></td>
                        <td><?php echo $desc_status; ?></td>
                        <td align="center">
                            <?php if(strlen($contrato) > 0){ ?>
                            <a href="admin/clientes/documentos/<?php echo $contrato; ?>" target="_blank" class="btn btn-info">
                                <i class="fa fa-download"></i>
                            </a>
                            <?php } ?>
                        </td>
                        <td align="center">
                            <?php if(strlen($certificado) > 0){ ?>
                            <a href="admin/clientes/certificados/<?php echo $certificado; ?>" target="_blank" class="btn btn-info">
                                <i class="fa fa-download"></i>
                            </a>
                            <?php } ?>
                        </td>
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
          window.open('admin/clientes/acao.php?Tipo=D&Codigo=' + id, "acao");
      }
    }
</script>