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
                <input type="text" name="txtpesquisanome" id="txtpesquisanome" size="50" class="form-control" placeholder="Pesquisar">
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