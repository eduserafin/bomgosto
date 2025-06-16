<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<div class="row">
    <legend></legend>
    <div class="col-md-6">                
        <input type="text" name="txtpesquisa" id="txtpesquisa" size="15" maxlength="14" class="form-control" Placeholder="Pesquisar">
    </div>

    <div class="col-md-2">
        <?php include "inc/botao_consultar.php"; ?>
    </div>
</div>
<br>
<div class="row-100 table-responsive" id="rslista">
    <?php include "gerenciador/site/listadados.php";?>
</div>


<script language="JavaScript">

    function consultar(pg) {

        Buscar(document.getElementById('txtpesquisa').value, pg);
        
    }

</script>