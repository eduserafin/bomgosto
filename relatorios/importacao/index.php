
<link rel="stylesheet" href="assets/css/estilo.css">
<iframe name="acao" width="0" height="0" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>
<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a id="tabgeral" href="#geral" data-toggle="tab">IMPORTAÇÃO</a></li>
</ul> 

<form method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-3">
            <label>Administradora:</label>
            <select class="form-control" name="seladministradora" id="seladministradora">
                <option value="0">Selecione...</option>
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
    </div> 
    <div class="row">
        <div class="col-md-3">
            <label>Arquivo PDF:</label>
            <input type="file" name="arquivo" accept="application/pdf" required><br><br>
        </div> 
        <button type=submit name="btimportar" id="btimportar" class="btn btn-success"><span class="glyphicon glyphicon-open"></span> Importar</button>
    </div> 
</form>