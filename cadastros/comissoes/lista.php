<?php
    foreach($_GET as $key => $value){
        $$key = $value;
    }
?>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-3">
            <label for="pesquisacolaborador">COLABORADOR:</label>
            <select size="10" name="pesquisacolaborador" id="pesquisacolaborador" class="form-control">
                <option selected value=0>Selecione</option>
                <?php
                    $SQL = "SELECT nr_sequencial, ds_colaborador
                            FROM colaboradores
                            WHERE st_status = 'A'
                            AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . " 
                            ORDER BY ds_colaborador";
                    $RES = mysqli_query($conexao, $SQL);
                    while($lin=mysqli_fetch_row($RES)){
                        $nr_cdgo = $lin[0];
                        $ds_desc = $lin[1];
                        echo "<option value=$nr_cdgo>$ds_desc</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="pesquisaadministradora">ADMINISTRADORA:</label>
            <select size="10" name="pesquisaadministradora" id="pesquisaadministradora" class="form-control">
                <option selected value=0>Selecione</option>
                <?php
                    $SQL = "SELECT nr_sequencial, ds_administradora
                            FROM administradoras
                            WHERE st_status = 'A'
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
        <div class="col-md-2">
            <?php include "inc/botao_consultar.php"; ?>
        </div>
    </div>

    <div class="row table-responsive" id="rslista">
        <?php include "cadastros/comissoes/listadados.php";?>
    </div>
</div>

<script language="JavaScript">

    $(document).ready(function() {
        $('#pesquisacolaborador').select2();
    });

    $(document).ready(function() {
        $('#pesquisaadministradora').select2();
    });

    function consultar(pg) {
        Buscar(document.getElementById('pesquisacolaborador').value, document.getElementById('pesquisaadministradora').value, pg);
    }
    
</script>