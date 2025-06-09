<?php
    foreach($_GET as $key => $value){
        $$key = $value;
    }

    // Define os meses
    $meses = [
        '01' => 'Janeiro',
        '02' => 'Fevereiro',
        '03' => 'Março',
        '04' => 'Abril',
        '05' => 'Maio',
        '06' => 'Junho',
        '07' => 'Julho',
        '08' => 'Agosto',
        '09' => 'Setembro',
        '10' => 'Outubro',
        '11' => 'Novembro',
        '12' => 'Dezembro'
    ];

    // Define os anos (3 últimos até o atual)
    $anoAtual = date('Y');
    $anos = [];
    for ($i = 2; $i >= 0; $i--) {
        $anos[] = $anoAtual - $i;
    }

?>

<div class="col-md-12">
    <div class="row">
        <div class="col-md-3">
            <label>COLABORADOR:</label>
            <select size="1" name="pesquisacolaborador" id="pesquisacolaborador" class="form-control">
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
            <select class="form-control" name="pesquisaadministradora" id="pesquisaadministradora">
                <option value="0">Selecione</option>
                <?php
                    $sel = "SELECT nr_sequencial, ds_administradora 
                            FROM administradoras 
                            WHERE st_status = 'A' 
                            AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . " 
                            ORDER BY ds_administradora";
                    $res = mysqli_query($conexao, $sel);
                    while($lin = mysqli_fetch_row($res)){
                        $selecionado = $lin[0] == $nr_seq_administradora ? "selected" : "";
                        echo "<option $selecionado value=$lin[0]>$lin[1]</option>";
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
        <div class="col-md-2">
            <label for="pesquisadata" class="form-label">MÊS/ANO:</label>
            <div class="form-inline">
                <select name="pesquisames" id="pesquisames" class="form-control me-2">
                    <?php foreach ($meses as $num => $nome): ?>
                        <option value="<?= $num ?>" <?= $num == date('m') ? 'selected' : '' ?>><?= $nome ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="pesquisaano" id="pesquisaano" class="form-control">
                    <?php foreach ($anos as $ano): ?>
                        <option value="<?= $ano ?>" <?= $ano == $anoAtual ? 'selected' : '' ?>><?= $ano ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <?php include "inc/botao_consultar.php"; ?>
            </div>
        </div>

    </div>

    <?php include "inc/aguarde.php"; ?>

    <div class="row table-responsive" id="rslista">
        <?php include "relatorios/comissao/listadados.php";?>
    </div>
</div>

<script language="JavaScript">

    $(document).ready(function() {
        $('#pesquisacolaborador').select2();
    });

    $(document).ready(function() {
        $('#pesquisaadministradora').select2();
    });

    $(document).ready(function() {
        $('#pesquisasegmento').select2();
    });

    function consultar(pg) {
        Buscar( 
                document.getElementById('pesquisacolaborador').value,
                document.getElementById('pesquisaadministradora').value,
                document.getElementById('pesquisasegmento').value,
                document.getElementById('pesquisames').value,
                document.getElementById('pesquisaano').value,
                pg);
    }

    function excel() {
        
        var colaborador = window.document.getElementById('pesquisacolaborador').value;
        var administradora = window.document.getElementById('pesquisaadministradora').value;
        var segmento = window.document.getElementById('pesquisasegmento').value;
        var mes = window.document.getElementById('pesquisames').value;
        var ano = window.document.getElementById('pesquisaano').value;
        
        document.getElementById('dvAguarde').style.display = 'block';
        window.open('crm/leads/excel.php?valor=' + valor + '&nome=' + nome + '&cidade=' + cidade + '&status=' + status + '&data1=' + data1 + '&data2=' + data2 + '&dataagenda1=' + dataagenda1 + '&dataagenda2=' + dataagenda2 + '&segmento=' + segmento, 'acao');
    } 

</script>