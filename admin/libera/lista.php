<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<div class="col-md-12">
    <div class="row">
        <fieldset>
            <legend>Pesquisar por</legend>
            <div class="form-group form-inline col-md-6">
                <label for="txtpesquisanome">DESCRI&Ccedil;&Atilde;O:</label>
                <input type="text" class="form-control" id="txtpesquisanome" placeholder="Descri&ccedil;&atilde;o" size="35" maxlength="60">
                <?php include "inc/botao_consultar.php"; ?>
            </div>
        </fieldset>
    </div>
    <div class="row table-responsive" id="rslistavande">
        <?php include "admin/libera/listadados.php";?>
    </div>
</div>

<script language="JavaScript">
function consultar(pg) {
  Buscar(document.getElementById('txtpesquisanome').value, pg);
}
</script>
