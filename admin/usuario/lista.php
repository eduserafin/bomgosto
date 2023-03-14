<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<div class="col-md-12">
    <div class="row">
        <fieldset>
            <legend>Pesquisar por</legend>
            <div class="form-group form-inline col-md-12">
                <label for="txtpesquisausuario">NOME:</label>
                <input type="text" name="txtpesquisanome" id="txtpesquisanome" size="35" class="form-control">
                <?php include "inc/botao_consultar.php"; ?>
            </div>
        </fieldset>
    </div>
    <div class="row table-responsive" id="rslista">
        <?php include "admin/usuario/listadados.php";?>
    </div>
</div>

<script language="JavaScript">
function consultar(pg) {
  Buscar(document.getElementById('txtpesquisanome').value, pg);
}
</script>