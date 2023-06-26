<?php
    foreach($_GET as $key => $value){
        $$key = $value;
    }
?>

<div class="col-md-12">
    <div class="row">
        <legend>Pesquisar por</legend>

            <div class="col-md-2">
                <label for="pesquisacredito">VALOR CRÉDITO:</label>                  
                <input type="number" name="pesquisacredito" id="pesquisacredito" size="15" maxlength="14" class="form-control" Placeholder="">
            </div>
            <div class="col-md-4">
                <label for="pesquisanome">NOME PROPOSTA:</label>                  
                <input type="text" name="pesquisanome" id="pesquisanome" size="15" maxlength="14" class="form-control" Placeholder="Descreva">
            </div>
            <br>
            <div class="col-md-2">
                <?php include "inc/botao_consultar.php"; ?>
            </div>
    </div>
<br>
    <div class="row table-responsive" id="rslista">
        <?php include "consorcios/simulador/listadados.php";?>
    </div>
</div>

<script language="JavaScript">
function consultar(pg) {
    Buscar(document.getElementById('pesquisacredito').value, document.getElementById('pesquisanome').value, pg);
}
</script>