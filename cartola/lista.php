<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<div class="col-md-12">
    <div class="row">
        <legend>Pesquisar por</legend>
           
             <div class="col-md-2"> 
                    <label for="rodada">Rodada:</label>                    
                    <input type="number" name="rodada" id="rodada" size="15" maxlength="14" class="form-control">
            </div>

             <div class="col-md-3">
                  <label for="data">Data:</label>   
                  <input type="date" name="data" id="data" class="form-control">
             </div>
        <br>
            <div class="col-md-2">
                <?php include "inc/botao_consultar.php"; ?>
            </div>
    </div>
<br>
    <div class="row table-responsive" id="rslista">
        <?php include "cartola/listadados.php";?>
    </div>
</div>

<script language="JavaScript">
function consultar(pg) {
    Buscar(document.getElementById('rodada').value, document.getElementById('data').value, pg);
}
</script>