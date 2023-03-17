<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<div class="col-md-12">
    <div class="row">
        <fieldset>
            <div class="form-group form-inline col-md-12">
                <br>
                <input type="text" class="form-control" id="txtpesquisanome" placeholder="Pesquisar" size="35" maxlength="60">
                <?php include "inc/botao_consultar.php"; ?>
            </div>
        </fieldset>
    </div>
    <div class="row table-responsive" id="rslista">
        <?php include "admin/smenus/listadados.php";?>
    </div>
</div>

<script language="JavaScript">
function consultar(pg) {
  Buscar(document.getElementById('txtpesquisanome').value, pg);
}
</script>

