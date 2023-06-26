<?php
    foreach($_GET as $key => $value){
        $$key = $value;
    }

    if ($consulta == "sim") {
        require_once '../../conexao.php';
    }

    
    $SQL = "SELECT ds_nome
                FROM consorcio
            WHERE nr_sequencial = $nr_seq_proposta";
            // echo $SQL;
    $RSS = mysqli_query($conexao, $SQL);
    while ($linha = mysqli_fetch_row($RSS)) {
        $ds_nome = $linha[0];
    }

    $vl_credito_total = 0;
    $SQL1 = "SELECT vl_credito_total
                FROM consorcio
            WHERE nr_sequencial = $nr_seq_proposta"; //echo $SQL1;
    $RES1 = mysqli_query($conexao, $SQL1);
    while($linha1=mysqli_fetch_row($RES1)){
        $vl_credito_total= $linha1[0];
    }

    $vl_simulado = 0;
    $vl_total_simulado = 0;
    $SQL2 = "SELECT vl_credito * nr_cotas AS vl_simulado
                FROM consorcio_propostas
            WHERE nr_seq_proposta = $nr_seq_proposta"; //echo $SQL2;
    $RES2 = mysqli_query($conexao, $SQL2);
    while($linha2=mysqli_fetch_row($RES2)){
        $vl_simulado= $linha2[0];
        $vl_total_simulado += $vl_simulado;
    }

    if($vl_credito_total == $vl_total_simulado) {
        $style = "background:#40E0D0;";
    } else {
        $style = "background:#FF0000;";
    }
?>

<input type="hidden" name="cd_simulacao" id="cd_simulacao" value="">
<input type="hidden" name="nr_seq_proposta" id="nr_seq_proposta" value="<?php echo $nr_seq_proposta; ?>">
<div class="row-100">
    <div id="msgexibe" class="alert alert-info fade in alert-dismissable" >
        <span class="glyphicon glyphicon-pencil"></span> SIMULAR PROPOSTA - <?php echo $ds_nome; ?> | <?php echo number_format($vl_credito_total, 2, ",", "."); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-2">
        <label for="txtcreditocota">CRÉDITO COTA:</label>                    
        <input type="number" name="txtcreditocota" id="txtcreditocota" size="15" maxlength="100" class="form-control" style="background:#E0FFFF; text-align: right;" require onchange="javascript: parcelas(document.getElementById('selplano').value);">
    </div>
    <div class="col-md-3">
        <label for="selmes">QUANTIDADE DE MÊS:</label>                    
        <select id="selmes" class="form-control" style="background:#E0FFFF;" 
        require onchange="javascript: parcelas(document.getElementById('selplano').value);">
            <option value="0">Selecione uma opção</option>
            <?php
                $sql = "SELECT nr_sequencial, nr_quantidade
                            FROM consorcio_quantidade_mes
                            WHERE st_status = 1
                        ORDER BY nr_quantidade DESC";
                $res = mysqli_query($conexao, $sql);
                while($lin=mysqli_fetch_row($res)){
                    $codigo = $lin[0];
                    $desc = $lin[1];

                    echo "<option value='$codigo'>$desc</option>";
                }
            ?>
        </select>
    </div>

    <div class="col-md-3">
        <label for="selprazo">PRAZO DO GRUPO:</label>                    
        <select id="selprazo" class="form-control" style="background:#E0FFFF;">
            <option value="0">Selecione uma opção</option>
            <?php
                $sql = "SELECT nr_sequencial, nr_quantidade
                            FROM consorcio_prazo_grupo
                            WHERE st_status = 1
                        ORDER BY nr_quantidade DESC";
                $res = mysqli_query($conexao, $sql);
                while($lin=mysqli_fetch_row($res)){
                    $codigo = $lin[0];
                    $desc = $lin[1];

                    echo "<option value='$codigo'>$desc</option>";
                }
            ?>
        </select>
    </div>

    <div class="col-md-3">
        <label for="selplano">PLANO:</label>                    
        <select id="selplano" class="form-control" style="background:#E0FFFF;"
        require onchange="javascript: parcelas(this.value);">
            <option value="0">Selecione uma opção</option>
            <?php
                $sql = "SELECT nr_sequencial, ds_plano
                            FROM consorcio_planos
                            WHERE st_status = 1
                        ORDER BY ds_plano";
                $res = mysqli_query($conexao, $sql);
                while($lin=mysqli_fetch_row($res)){
                    $codigo = $lin[0];
                    $desc = $lin[1];

                    echo "<option value='$codigo'>$desc</option>";
                }
            ?>
        </select>
    </div>  

    <div class="col-md-1">
        <label for="txttaxa">TX. ADM:</label>                    
        <input type="number" name="txttaxa" id="txttaxa" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;" require onchange="javascript: parcelas(document.getElementById('selplano').value);">
    </div>

    <div class="col-md-2">
        <label for="txtseguro">SEGURO PRESTAMISTA:</label>                    
        <input type="number" name="txtseguro" id="txtseguro" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;" require onchange="javascript: parcelas(document.getElementById('selplano').value);">
    </div>

    <div class="col-md-2">
        <label for="txtlance">% LANCE EMBUTIDO:</label>                    
        <input type="number" name="txtlance" id="txtlance" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;">
    </div>

    <div class="col-md-2">
        <label for="txtconvertidadas">PARCELAS CONVERTIDAS:</label>                    
        <input type="number" name="txtconvertidadas" id="txtconvertidadas" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;">
    </div>

    <div class="col-md-2" hidden>
        <label for="txtreduzida">PARCELAS REDUZIDAS:</label>                                       
        <select id="txtreduzida" class="form-control" style="background:#E0FFFF;">
            <option value="0">Selecione uma opção</option>
            <?php
                $sql = "SELECT nr_sequencial, ds_plano
                            FROM consorcio_parcelas_reduzidas
                            WHERE st_status = 1
                        ORDER BY ds_plano";
                $res = mysqli_query($conexao, $sql);
                while($lin=mysqli_fetch_row($res)){
                    $codigo = $lin[0];
                    $desc = $lin[1];

                    echo "<option value='$codigo'>$desc</option>";
                }
            ?>
        </select>
    </div>  

    <div class="col-md-2" hidden>
        <label for="txttipo">TIPO DE LANCE:</label>                    
        <select id="txttipo" class="form-control" style="background:#E0FFFF;">
            <option value="0">Selecione uma opção</option>
            <?php
                $sql = "SELECT nr_sequencial, ds_tipo
                            FROM consorcio_tipo_lance
                            WHERE st_status = 1
                        ORDER BY ds_tipo";
                $res = mysqli_query($conexao, $sql);
                while($lin=mysqli_fetch_row($res)){
                    $codigo = $lin[0];
                    $desc = $lin[1];

                    echo "<option value='$codigo'>$desc</option>";
                }
            ?>
        </select>
    </div>  

    <div class="col-md-1">
        <label for="txtcotas">COTAS:</label>                    
        <input type="number" name="txtcotas" id="txtcotas" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;">
    </div>

    <div class="col-md-4" id="rsparcelas">
        <?php include "parcelas.php" ?>
    </div>

    <div class="col-md-2"><br>
        <button type=button name="btsimular" id="btsimular" class="btn btn-success" onClick="javascript: simular();"><span class="glyphicon glyphicon-ok"></span> SIMULAR</button>
    </div>
</div>

<div class="row-100"><br>
    <div class="form-group col-md-6">
        <pre style="text-align:center; background:#40E0D0;">VALOR TOTAL DA PROPOSTA - <b><?php echo number_format($vl_credito_total, 2, ",", "."); ?></b></pre>
    </div>
    <div class="form-group col-md-6">
        <pre style="text-align:center; <?php echo $style; ?>">VALOR TOTAL SIMULADO - <b><?php echo number_format($vl_total_simulado, 2, ",", "."); ?></b></pre>
    </div>
</div>

<script type="text/javascript">

    function parcelas(tipo) {

        var credito = document.getElementById('txtcreditocota').value;
        credito = credito.replace(",", ".");
        var taxa = document.getElementById("txttaxa").value;
        taxa = taxa.replace(",", ".");
        var seguro = document.getElementById("txtseguro").value;
        seguro = seguro.replace(",", ".");
        var mes = document.getElementById("selmes").value;
        var quantidade = document.getElementById("txtcotas").value;

        var url = 'consorcios/simulador/parcelas.php?consulta=sim&tipo=' + tipo + '&credito=' + credito + '&taxa=' + taxa + '&seguro=' + seguro + '&seq_mes=' + mes;
        $.get(url, function(dataReturn) {
            $('#rsparcelas').html(dataReturn);
        });

    }

    function simular() {

        var simulacao = document.getElementById('cd_simulacao').value;
        var codigo = document.getElementById('nr_seq_proposta').value;
        var credito = document.getElementById('txtcreditocota').value;
        credito = credito.replace(",", ".");
        var cotas = document.getElementById("txtcotas").value;
        var mes = document.getElementById("selmes").value;
        var prazo = document.getElementById("selprazo").value;
        var taxa = document.getElementById("txttaxa").value;
        taxa = taxa.replace(",", ".");
        var plano = document.getElementById("selplano").value;
        var seguro = document.getElementById("txtseguro").value;
        seguro = seguro.replace(",", ".");
        var parcela1 = document.getElementById("txtparcela1").value;
        parcela1 = parcela1.replace(",", ".");
        var parcela2 = document.getElementById("txtparcela2").value;
        parcela2 = parcela2.replace(",", ".");
        var lance = document.getElementById("txtlance").value;
        var convertidada = document.getElementById("txtconvertidadas").value;
        var reduzida = document.getElementById("txtreduzida").value;
        var tipo = document.getElementById("txttipo").value;
            
        if (codigo == "") {

            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Selecione uma proposta!'
            });
            document.getElementById('nr_seq_proposta').focus();
            
        } else if (credito == "") {

            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Informe o valor do crédito!'
            });
            document.getElementById('txtcreditocota').focus();

        } else if (cotas == "") {

            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Informe a quantidade de cotas!'
            });
            document.getElementById('txtcotas').focus();

        } else if (mes == 0) {

            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Informe a quantidade de mêses!'
            });
            document.getElementById('selmes').focus();

        } else if (prazo == 0) {

            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Informe o prazo do grupo!'
            });
            document.getElementById('selprazo').focus();

        } else if (taxa == "") {

            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Informe a porcentagem da taxa administrativa!'
            });
            document.getElementById('txttaxa').focus();

        } else if (plano == 0) {

            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Informe um plano!'
            });
            document.getElementById('selplano').focus();

        } else if (seguro == "") {

            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Informe a porcentagem do seguro!'
            });
            document.getElementById('txtseguro').focus();

        }
        else if (lance == "") {

            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Informe a % do lance embutido!'
            });
            document.getElementById('txtlance').focus();

        } else if (convertidada == "") {

            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Informe a quantidade de parcelas convertidas!'
            });
            document.getElementById('txtconvertidadas').focus();

        } else {

            if (simulacao == "") {
                Tipo = "S"
            } else {
                Tipo = "ES";
            }

            window.open('consorcios/simulador/acao.php?Tipo=' + Tipo + '&codigo=' + codigo + '&credito=' + credito + '&cotas=' + cotas + '&mes=' + mes + '&prazo=' + prazo + '&taxa=' + taxa + '&plano=' + plano + '&seguro=' + seguro + '&parcela1=' + parcela1 + '&parcela2=' + parcela2 + '&lance=' + lance + '&convertidada=' + convertidada + '&reduzida=' + reduzida + '&tipo=' + tipo + '&simulacao=' + simulacao, "acao");
        }
    }

</script>