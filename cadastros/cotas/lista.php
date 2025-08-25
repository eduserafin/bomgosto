<div class="col-md-12">
    <div class="row">
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
            <label for="pesquisagrupo">GRUPO:</label>
            <input type="text" name="pesquisagrupo" id="pesquisagrupo" maxlength="10" class="form-control">
        </div>

        <div class="col-md-2">
            <label for="pesquisacota">COTA:</label>
            <input type="number" name="pesquisacota" id="pesquisacota" maxlength="10" class="form-control">
        </div>

        <div class="col-md-2">
            <label for="pesquisastatus">STATUS:</label>
            <select class="form-control" name="pesquisastatus" id="pesquisastatus">
                <option value="">Selecione</option>
                <option value="A">Ativa</option>
                <option value="V">Vendida</option>
            </select>
        </div>
        
        <div class="col-md-2" style="margin-top: 20px;">
            <?php include "inc/botao_consultar.php"; ?>
        </div>
    </div>

    <div class="row table-responsive" id="rslista">
        <?php include "cadastros/cotas/listadados.php";?>
    </div>
</div>

<script language="JavaScript">

    $(document).ready(function() {
        $('#pesquisaadministradora').select2();
    });

    function consultar(pg) {
        Buscar(document.getElementById('pesquisaadministradora').value, 
                document.getElementById('pesquisagrupo').value,
                document.getElementById('pesquisacota').value,
                document.getElementById('pesquisastatus').value,
            pg);
    }
    
</script>