<?php
    foreach($_GET as $key => $value){
        $$key = $value;
    }

    if ($consulta == "sim") {
        require_once '../../conexao.php';
    }

    if($credito == "") { $credito = 0; }
    if($taxa == "") { $taxa = 0; }
    if($seguro == "") { $seguro = 0; }
    if($seq_mes != "") { 
        $SQL = "SELECT nr_quantidade
                    FROM consorcio_quantidade_mes 
                WHERE nr_sequencial = $seq_mes";
                //echo $SQL;
        $RSS = mysqli_query($conexao, $SQL);
        while ($linha = mysqli_fetch_row($RSS)) {
            $mes = $linha[0];

        }
    }

    $ds_parcela1 = $mes / 2; //Obtem o numero do primeiro grupo de parcelas
    $ds_parcela2 = $ds_parcela1 + 1; //Obtem o numero do segundo grupo de parcelas

    if($tipo == 1) {

        if($credito != 0 && $taxa != 0 && $mes != 0 && $seguro != 0) {

            $pc_taxa = $taxa / 100;
            $pc_seguro = $seguro / 100;
          
            //((D7*D9)/(H7/2)+(D7/H7)+((D7+(D7*D9))*L9))
            $vl_parcelad1 = (($credito * $pc_taxa) / ($mes / 2) + ($credito / $mes) + (($credito + ($credito * $pc_taxa)) * $pc_seguro)); 
            //((D7/H7)+((D7*D9)+D7)*L9))
            $vl_parcelad2 = (($credito / $mes) + (($credito * $pc_taxa) + $credito) * $pc_seguro);
        }

    } else if ($tipo == 2) {

        if($credito != 0 && $taxa != 0 && $mes != 0 && $seguro != 0) {

            $pc_taxa = $taxa / 100;
            $pc_seguro = $seguro / 100;

            //(((D7*D9)+D7)*L9)+((D7*D9)+D7)/H7
            $vl_parcelal1 = ((($credito * $pc_taxa) + $credito) * $pc_seguro) + (($credito * $pc_taxa) + $credito) / $mes;
            $vl_parcelal2 = 0;
        }
    }


?>

<?php if($tipo == 2) { ?>

    <div class="col-md-6">
        <label for="txtparcela1">1º - <?php echo $ds_parcela1; ?>º PARCELAS:</label>                    
        <input type="number" name="txtparcela1" id="txtparcela1" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;" value="<?php echo $vl_parcelal1; ?>" disabled onblur="formatarCampo(this)">
    </div>

    <div class="col-md-6" hidden>
        <label for="txtparcela2"><?php echo $ds_parcela2; ?>º - <?php echo $mes; ?>º:</label>                    
        <input type="number" name="txtparcela2" id="txtparcela2" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;" value="<?php echo $vl_parcelal2; ?>" disabled onblur="formatarCampo(this)">
    </div>

<?php } else if($tipo == 1) { ?>

    <div class="col-md-6">
        <label for="txtparcela1">1º - <?php echo $ds_parcela1; ?>º PARCELAS:</label>                    
        <input type="number" name="txtparcela1" id="txtparcela1" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;" value="<?php echo $vl_parcelad1; ?>" disabled onblur="formatarCampo(this)">
    </div>

    <div class="col-md-6">
        <label for="txtparcela2"><?php echo $ds_parcela2; ?>º - <?php echo $mes; ?>º PARCELAS:</label>                    
        <input type="number" name="txtparcela2" id="txtparcela2" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;" value="<?php echo $vl_parcelad2; ?>" disabled onblur="formatarCampo(this)">
    </div>

<?php } ?>

<script>

    if('<?php echo $vl_parcelad1;?>' > 0){
        formatarCampo(document.getElementById('txtparcela1'))
    } 

    if('<?php echo $vl_parcelad2;?>' > 0){
        formatarCampo(document.getElementById('txtparcela2'))
    } 

    if('<?php echo $vl_parcelal1;?>' > 0){
        formatarCampo(document.getElementById('txtparcela1'))
    } 

    function formatarCampo(campo) {
        var valor = parseFloat(campo.value);
        if (!isNaN(valor)) {
            campo.value = valor.toFixed(2);
        }
    }

</script>