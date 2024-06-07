<?php
    foreach($_GET as $key => $value){
        $$key = $value;
    }
?>

<div class="row">
    <legend>Pesquisar por</legend>

        <div class="col-md-2" hidden>
            <label for="pesquisacredito">VALOR CRÉDITO:</label>                  
            <input type="number" name="pesquisacredito" id="pesquisacredito" size="15" maxlength="14" class="form-control" Placeholder="">
        </div>
        <div class="col-md-4">
            <label for="pesquisanome">NOME:</label>                  
            <input type="text" name="pesquisanome" id="pesquisanome" size="15" maxlength="14" class="form-control" Placeholder="Descreva">
        </div>
        <div class="col-md-4">    
            <label for="pesquisacidade">CIDADE:</label>        
            <select id="pesquisacidade" class="form-control">
                <option value='0'>Selecione uma cidade</option>
                <?php
                $sql = "SELECT cd_municipioibge, CONCAT(ds_municipioibge, ' - ', sg_estado) AS municipio_estado
                        FROM municipioibge
                        WHERE ds_municipioibge NOT LIKE '%TRIAL%'
                        ORDER BY ds_municipioibge, sg_estado";
                $res = mysqli_query($conexao, $sql);
                while($lin=mysqli_fetch_row($res)){
                    $cdg = $lin[0];
                    $desc = $lin[1];

                    echo "<option value='$cdg'>$desc</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="pesquisastatus">STATUS:</label>
            <select class="form-control" name="pesquisastatus" id="pesquisastatus">
                <option value="" <?php echo $status == '' ? 'selected' : ''; ?>>TODOS</option>
                <option value="N" <?php echo $status == 'N' ? 'selected' : ''; ?>>NOVOS</option>
                <option value="C" <?php echo $status == 'C' ? 'selected' : ''; ?>>ENTRAR EM CONTATO</option>
                <option value="P" <?php echo $status == 'P' ? 'selected' : ''; ?>>PERDIDA</option>
                <option value="E" <?php echo $status == 'E' ? 'selected' : ''; ?>>EM ANDAMENTO</option>
                <option value="T" <?php echo $status == 'T' ? 'selected' : ''; ?>>CONTRATADA</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="pesquisatipo">TIPO:</label>
            <select class="form-control" name="pesquisatipo" id="pesquisatipo">
                <option selected value="">Selecione...</option>
                <option value="S">SIMULAÇÃO</option>
                <option value="C">CONTATO</option>
            </select>
        </div>
        <div class="col-md-5 form-inline"><br>
            <label for="pesquisadataagenda">DATA AGENDA:</label>
            <input type="date" class="form-control" id="pesquisadataagenda1" size="10" maxlength="10">
            <input type="date" class="form-control" id="pesquisadataagenda2" size="10" maxlength="10">
        </div>
        <div class="col-md-6 form-inline"><br>
            <label for="pesquisadata">DATA LEAD:</label>
            <input type="date" class="form-control" id="pesquisadata1" size="10" maxlength="10">
            <input type="date" class="form-control" id="pesquisadata2" size="10" maxlength="10">
            <?php include "inc/botao_consultar.php"; ?>
        </div>
</div>
<br>
<?php include "inc/aguarde.php"; ?>
<div class="row table-responsive" id="rslista">
    <?php include "crm/leads/listadados.php";?>
</div>


<script language="JavaScript">

    function consultar(pg) {
        Buscar(document.getElementById('pesquisacredito').value, 
                document.getElementById('pesquisanome').value,
                document.getElementById('pesquisacidade').value,
                document.getElementById('pesquisastatus').value,
                document.getElementById('pesquisatipo').value,
                document.getElementById('pesquisadata1').value,
                document.getElementById('pesquisadata2').value,
                document.getElementById('pesquisadataagenda1').value,
                document.getElementById('pesquisadataagenda2').value,
                pg);
    }

    function excel() {
        
        var valor = window.document.getElementById('pesquisacredito').value;
        var nome = window.document.getElementById('pesquisanome').value;
        var cidade = window.document.getElementById('pesquisacidade').value;
        var status = window.document.getElementById('pesquisastatus').value;
        var tipo = window.document.getElementById('pesquisatipo').value;
        var data1 = window.document.getElementById('pesquisadata1').value;
        var data2 = window.document.getElementById('pesquisadata2').value;
        var dataagenda1 = window.document.getElementById('pesquisadataagenda1').value;
        var dataagenda2 = window.document.getElementById('pesquisadataagenda2').value;
        
        document.getElementById('dvAguarde').style.display = 'block';
        window.open('crm/leads/excel.php?valor=' + valor + '&nome=' + nome + '&cidade=' + cidade + '&status=' + status + '&tipo=' + tipo + '&data1=' + data1 + '&data2=' + data2 + '&dataagenda1=' + dataagenda1 + '&dataagenda2=' + dataagenda2, 'acao');
    } 

</script>