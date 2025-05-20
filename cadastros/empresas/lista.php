<?php
foreach ($_GET as $key => $value) {
    $$key = $value;
}
?>

<div class="row-100">
    <fieldset>
        <legend>Pesquisar por</legend>
        <div class="col-md-3">
            <label for="txtpesquisanome">DESCRI&Ccedil;&Atilde;O:</label>
            <input type="text" class="form-control" id="txtpesquisanome" placeholder="Descri&ccedil;&atilde;o" size="35" maxlength="60">
        </div>  
        <div class="col-md-1"><br>
            <?php include "inc/botao_consultar.php"; ?>
        </div>
    </fieldset>

    <?php include "inc/aguarde.php"; ?>
    <div class="row-100 table-responsive" id="rslista">
        <?php include "cadastros/empresas/listadados.php"; ?>
    </div>

</div>

<script language="JavaScript">
    function consultar(pg) {
        Buscar(document.getElementById('txtpesquisanome').value, pg);
    }
</script>