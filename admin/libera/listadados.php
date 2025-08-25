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
    $sqlfiltro = "";
    if ($descricao !== "") {
        $pesquisanome = $descricao;
        $sqlfiltro = "AND UPPER(c.ds_colaborador) like UPPER('%" . $descricao . "%')";
    }
    
    if($_SESSION["ST_ADMIN"] == 'G'){
      $v_filtro_empresa = "AND u.nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "";
    } else if ($_SESSION["ST_ADMIN"] == 'C') {
      $v_filtro_empresa = "AND u.nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "";
    } else {
      $v_filtro_empresa = "";
    }

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <table width="100%" class="table table-bordered table-striped modern-table">
            <tr>
                <th>USUÁRIO</th>
                <th>AÇÕES</th>
            </tr>
            <?php
                $SQL = "SELECT u.nr_sequencial, UPPER(c.ds_colaborador)
                        FROM usuarios u 
                        INNER JOIN colaboradores c ON c.nr_sequencial = u.nr_seq_colaborador
                        WHERE 1=1 
                        ".$sqlfiltro."
                        ".$v_filtro_empresa."
                        ORDER BY c.ds_colaborador ASC limit $porpagina offset $inicio";
                //echo "<pre>$SQL</pre>";
                $RSS = mysqli_query($conexao, $SQL);
                while ($linha = mysqli_fetch_row($RSS)) {
                    $nr_sequencial = $linha[0];
                    $desc_user = $linha[1];
                    ?>
                    <tr>
                        <td><?php echo $desc_user; ?> </td>
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
          window.open('admin/libera/acao.php?Tipo=D&Codigo=' + id, "acao");
        }
    }
    
</script>