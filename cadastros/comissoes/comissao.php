<?php
    foreach($_GET as $key => $value){
        $$key = $value;
    }


    $consulta = $_GET['consulta'];
    $parcelas = $_GET['parcelas'];
    $codigo = $_GET['codigo'];

    if ($consulta == "sim") {
        require_once '../../conexao.php';
        $ant = "../../";
    }

    $comissoes = []; 

    if($codigo != ""){

        $SQL = "SELECT vl_comissao, nr_parcela
                FROM parcelas_comissoes
                WHERE nr_seq_comissao = " . $codigo ."
                ORDER BY nr_parcela ASC";
        //echo "<pre>$SQL</pre>";
        $RSS = mysqli_query($conexao, $SQL);
        while ($linha = mysqli_fetch_assoc($RSS)) {
            $comissoes[(int)$linha['nr_parcela']] = $linha['vl_comissao'];
        }
    }

?>

<table width="100%" class="table table-bordered table-striped modern-table">
    <tr>
        <th><strong>PARCELAS</strong></th>
        <th><strong>COMISSÕES</strong></th>
    </tr>   

    <?php for ($i = 1; $i <= $parcelas; $i++) { 

        $valorComissao = isset($comissoes[$i]) ? $comissoes[$i] : '';

        ?>

        <tr>
            <td width="10%" align="center"><?php echo $i; ?>º</td>
            <td><input type="number" name="txtcomissaoparcela<?php echo $i; ?>" id="txtcomissaoparcela<?php echo $i; ?>" maxlength="10" class="form-control" value="<?php echo $valorComissao; ?>"></td>
        </tr>

    <?php  } ?>
</table>