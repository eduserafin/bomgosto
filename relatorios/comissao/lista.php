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

    // Define os anos: 3 anteriores, atual e 3 seguintes
    $anoAtual = date('Y');
    $anos = [];
    
    for ($i = -3; $i <= 3; $i++) {
        $anos[] = $anoAtual + $i;
    }
    
    if($_SESSION["ST_ADMIN"] == 'G'){
        $v_filtro_empresa = "AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "";
        $v_filtro_colaborador = "";
    } else if ($_SESSION["ST_ADMIN"] == 'C') {
        $v_filtro_empresa = "AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "";
        $v_filtro_colaborador = "AND nr_sequencial in (SELECT nr_seq_colaborador FROM usuarios WHERE nr_sequencial = " . $_SESSION["CD_USUARIO"] . ")";
    } else {
        $v_filtro_empresa = "";
        $v_filtro_colaborador = "";
    }

?>

<div class="row-100">
    <div class="row">
        <div class="col-md-3">
            <label>COLABORADOR:</label>
            <select size="1" name="pesquisacolaborador" id="pesquisacolaborador" class="form-control">
                <option selected value=0>Selecione</option>
                <?php
                    $SQL = "SELECT nr_sequencial, ds_colaborador
                            FROM colaboradores
                            WHERE st_status = 'A'
                            " . $v_filtro_empresa . "
                            " . $v_filtro_colaborador . "
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
                <option value="0">Todas</option>
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
                <option value="0">Todos</option>
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
            <label for="pesquisastatus">STATUS:</label>
            <select name="pesquisastatus" id="pesquisastatus" class="form-control">
                <option value="0">Todos</option>
                <option value="">AGUARDANDO</option>
                <option value="T">PENDENTE CLIENTE</option>
                <option value="P">PAGO AO VENDEDOR</option>
                <option value="E">ESTORNO</option>
                <option value="C">CANCELADO</option>
            </select>
        </div>
        <div class="col-md-3">
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
        <div class="col-md-2">
            <label for="pesquisagrupo">GRUPO:</label>                  
            <input type="text" name="pesquisagrupo" id="pesquisagrupo" size="15" maxlength="20" class="form-control">
        </div>
        <div class="col-md-2">
            <label for="pesquisacota">COTA:</label>                  
            <input type="text" name="pesquisacota" id="pesquisacota" size="15" maxlength="20" class="form-control">
        </div>
        <div class="col-md-1"><br>
            <?php include "inc/botao_consultar.php"; ?>
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
                document.getElementById('pesquisastatus').value,
                document.getElementById('pesquisagrupo').value,
                document.getElementById('pesquisacota').value,
                pg);
    }

    function Pdf() {

        var colaborador = document.getElementById('pesquisacolaborador').value;
        var administradora = document.getElementById("pesquisaadministradora").value;
        var segmento = document.getElementById("pesquisasegmento").value;
        var mes = document.getElementById("pesquisames").value;
        var ano = document.getElementById("pesquisaano").value;
        var status = document.getElementById("pesquisastatus").value;
        var grupo = document.getElementById("pesquisagrupo").value;
        var cota = document.getElementById("pesquisacota").value;

        window.open('relatorios/comissao/pdf.php?colaborador=' + colaborador + '&administradora=' + administradora + '&segmento=' + segmento + '&mes=' + mes + '&ano=' + ano + '&status=' + status + '&grupo=' + grupo + '&cota=' + cota, "mensagemrel");
        document.getElementById("clickModal").click();

    }

</script>