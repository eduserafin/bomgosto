<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<div class="col-md-12">
    <div class="row">
        <legend>Pesquisar por</legend>
            <div class="col-md-6">
                                       
                    <input type="text" name="produto" id="produto" size="15" maxlength="50" class="form-control" Placeholder="produto">
             </div>
     
            <div class="col-md-2">
                <?php include "inc/botao_consultar.php"; ?>
            </div>
    </div>
<br>
    <div class="row table-responsive" id="rslista">
        <?php include "produtos/cadastros/listadados.php";?>
    </div>
</div>

<script language="JavaScript">
function consultar(pg) {
    Buscar(document.getElementById('produto').value, pg);
}
</script>