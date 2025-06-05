<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<?php
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

$empresa = mb_strtoupper($empresa, 'UTF-8');

if ($empresa !== "") {
    $buscasql = "AND ds_nome like '%".$empresa."%'";
}

?>

<table width="100%" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th style="vertical-align:middle;">ANEXOS</th>
            <th style="vertical-align:middle;">EMPRESA</th>
            <th style="vertical-align:middle;">NOME</th>
            <th style="vertical-align:middle;">CNPJ</th>
            <th style="vertical-align:middle;">STATUS</th>
            <th colspan=2 style="vertical-align:middle; text-align:center">A&Ccedil;&Otilde;ES</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $SQL = "SELECT nr_sequencial, ds_nome, ds_empresa, nr_cnpj,
                    CASE WHEN st_status = 'A' THEN 'ATIVO' ELSE 'INATIVO' END AS st_status
                    FROM empresas
                    WHERE 1=1 
                    $buscasql
                    ORDER BY ds_nome ASC limit $porpagina offset $inicio"; 
            //echo "<pre>$SQL</pre>";
            $RS = mysqli_query($conexao, $SQL);
            while ($linha = mysqli_fetch_row($RS)) {
                $nr_sequencial = $linha[0];
                $ds_nome = $linha[1];
                $ds_empresa = $linha[2];
                $nr_cnpj = $linha[3];
                $st_status = $linha[4];

                $SQL1 = "SELECT nr_sequencial, ds_arquivo
                        FROM anexos_empresa
                        WHERE nr_seq_empresa = $nr_sequencial";
                $RSS1 = mysqli_query($conexao, $SQL1);
                $anexos = array(); 
                while($linha = mysqli_fetch_assoc($RSS1)){ 
                    $anexos[] = $linha['ds_arquivo'];
                }

                ?>

                <tr>
                    <td width="5%" align="center">
                        <?php if(count($anexos) > 0) { ?>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                    <span class="glyphicon glyphicon-save"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <?php foreach($anexos as $anexo) { ?>
                                    <li><a href="cadastros/empresas/arquivos/<?php echo $anexo ?>" target='_blank'><?php echo $anexo ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </td>
                    <td><?php echo $ds_empresa; ?></td>
                    <td><?php echo $ds_nome; ?></td>
                    <td><?php echo $nr_cnpj; ?></td>
                    <td><?php echo $st_status; ?></td>
                    <td width="3%" align="center"><?php include $ant."inc/btn_editar.php";?></td>
                    <!--<td width="3%" align="center"><?php include $ant."inc/btn_excluir.php";?></td>-->
                </tr>
                <?php
            }
        ?> 
    </tbody>
</table>
<br>
<?php include $ant."inc/paginacao.php";?>

<script language="javascript">

    function executafuncao2(tipo, id) {

        if (tipo == 'ED'){

            document.getElementById('tabgeral').click();
            window.open("cadastros/empresas/acao.php?Tipo=D&Codigo=" + id, "acao");
        }

        else if (tipo == 'EX'){

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
                    
                    window.open("cadastros/empresas/acao.php?Tipo=E&codigo=" + id, "acao");

                } else {

                    return false;

                }
            });

        }

    }
    
</script>
