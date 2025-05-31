<body onLoad="document.getElementById('txtnome').focus();">
<input type="hidden" name="cd_colab" id="cd_colab" value="">
<div class="form-group col-md-12">
    <div class="row">
        <?php include "inc/botao_novo.php"; ?>
        <?php include "inc/botao_salvar.php"; ?>
        <?php include "inc/botao_excluir.php"; ?>
    </div>
</div>
    <div class="row">
        <div class="col-md-2">
            <label>COMISSÃO:</label>
            <input type="number" name="txtcomissao" id="txtcomissao" maxlength="10" class="form-control" value="<?php echo $txtcomissao; ?>">
        </div>

        <div class="col-md-2">
            <label>PARCELAS:</label>
            <input type="number" name="txtparcelas" id="txtparcelas" maxlength="10" class="form-control" value="<?php echo $txtcomissao; ?>">
        </div>

        <div class="col-md-3">
            <label>ADMINISTRADORA:</label>
            <select size="1" name="seladministradora" id="seladministradora" class="form-control">
                <option selected value=0>Selecione...</option>
                <?php
                    $SQL = "SELECT nr_sequencial, ds_administradora
                            FROM administradoras
                            WHERE st_ativa = 'A'
                            AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . " 
                            ORDER BY ds_administradora";
                    $RES = mysqli_query($conexao, $SQL);
                    while($lin=mysqli_fetch_row($RES)){
                        $nr_cdgo = $lin[0];
                        $ds_desc = $lin[1];
                        echo "<option value=$nr_cdgo>$ds_desc</option>";
                    }
                ?>
            </select>
        </div>
    </div>