<?php
    foreach($_GET as $key => $value){
        $$key = $value;
    }
?>

<div class="row-100">
    <div class="row">
        <div class="col-md-3">
            <label for="pesquisanome">NOME:</label>                  
            <input type="text" name="pesquisanome" id="pesquisanome" size="15" maxlength="14" class="form-control" Placeholder="Descreva">
        </div>
        <div class="col-md-3">    
            <label for="pesquisacidade">CIDADE:</label>        
            <select id="pesquisacidade" class="form-control">
                <option value='0'>Selecione</option>
                <?php
                    $sel = "SELECT c.nr_sequencial, c.ds_municipio, e.sg_estado
                            FROM cidades c
                            INNER JOIN estados e ON c.nr_seq_estado = e.nr_sequencial
                            ORDER BY c.ds_municipio";
                    $res = mysqli_query($conexao, $sel);
                    while($lin=mysqli_fetch_row($res)){
                        $nr_cdgo = $lin[0];
                        $ds_munic = $lin[1];
                        $sg_estado = $lin[2];

                        echo "<option value=$nr_cdgo>$ds_munic - $sg_estado</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="pesquisastatus">STATUS:</label>
            <select class="form-control" name="pesquisastatus" id="pesquisastatus">
            <option value='0'>Selecione</option>
            <?php
                $sel = "SELECT nr_sequencial, ds_situacao 
                        FROM situacoes 
                        WHERE st_status = 'A'  
                        ORDER BY ds_situacao";
                $res = mysqli_query($conexao, $sel);
                while($lin=mysqli_fetch_row($res)){
                    $nr_cdgo = $lin[0];
                    $ds_desc = $lin[1];

                    echo "<option value=$nr_cdgo>$ds_desc</option>";
                }
            ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="pesquisasegmento">SEGMENTO:</label>
            <select name="pesquisasegmento" id="pesquisasegmento" class="form-control">
                <option value="0">Selecione</option>
                <?php
                    $sel = "SELECT nr_sequencial, ds_segmento
                            FROM segmentos
                            WHERE st_status = 'A'
                            AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "
                            ORDER BY ds_segmento";
                    $res = mysqli_query($conexao, $sel);
                    while($lin=mysqli_fetch_row($res)){
                        $nr_cdgo = $lin[0];
                        $ds_desc = $lin[1];
                        echo "<option value=$nr_cdgo>$ds_desc</option>";
                    }
                ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 form-inline">
            <label for="pesquisadataagenda">DATA AGENDA:</label>
            <input type="date" class="form-control" id="pesquisadataagenda1" size="10" maxlength="10">
            <input type="date" class="form-control" id="pesquisadataagenda2" size="10" maxlength="10">
        </div>
        <div class="col-md-4 form-inline">
            <label for="pesquisadata">DATA LEAD:</label>
            <input type="date" class="form-control" id="pesquisadata1" size="10" maxlength="10">
            <input type="date" class="form-control" id="pesquisadata2" size="10" maxlength="10">
        </div>
        <div class="col-md-1"><br>
            <?php include "inc/botao_consultar.php"; ?>
        </div>
    </div>

    <?php include "inc/aguarde.php"; ?>

    <div class="row table-responsive" id="rslista">
        <?php include "crm/leads/listadados.php";?>
    </div>
</div>

<script language="JavaScript">

    $(document).ready(function() {
        $('#pesquisacidade').select2();
    });

    $(document).ready(function() {
        $('#pesquisastatus').select2();
    });

    $(document).ready(function() {
        $('#pesquisasegmento').select2();
    });

    function consultar(pg) {
        Buscar( 
                document.getElementById('pesquisanome').value,
                document.getElementById('pesquisacidade').value,
                document.getElementById('pesquisastatus').value,
                document.getElementById('pesquisasegmento').value,
                document.getElementById('pesquisadata1').value,
                document.getElementById('pesquisadata2').value,
                document.getElementById('pesquisadataagenda1').value,
                document.getElementById('pesquisadataagenda2').value,
                pg);
    }

    function excel() {
        
        var nome = window.document.getElementById('pesquisanome').value;
        var cidade = window.document.getElementById('pesquisacidade').value;
        var status = window.document.getElementById('pesquisastatus').value;
        var segmento = window.document.getElementById('pesquisasegmento').value;
        var data1 = window.document.getElementById('pesquisadata1').value;
        var data2 = window.document.getElementById('pesquisadata2').value;
        var dataagenda1 = window.document.getElementById('pesquisadataagenda1').value;
        var dataagenda2 = window.document.getElementById('pesquisadataagenda2').value;
        
        document.getElementById('dvAguarde').style.display = 'block';
        window.open('crm/leads/excel.php?nome=' + nome + '&cidade=' + cidade + '&status=' + status + '&data1=' + data1 + '&data2=' + data2 + '&dataagenda1=' + dataagenda1 + '&dataagenda2=' + dataagenda2 + '&segmento=' + segmento, 'acao');
    } 

</script>