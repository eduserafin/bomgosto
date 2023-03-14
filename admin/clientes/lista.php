<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<div class="col-md-12">
    <div class="row">
        <fieldset>
            <legend>Pesquisar por</legend>
            <div class="form-group col-md-2">
                <label for="txtpesquisanome">NOME:</label>
                <input type="text" name="txtpesquisanome" id="txtpesquisanome" size="35" class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label for="selaverbacao">Averba&ccedil;&atilde;o Autom&aacute;tica:</label>                    
                <select id="selaverbacao" class="form-control">
                    <option value='1'>SIM</option>
                    <option value='0'>N&Atilde;O</option>
                    <option value='99' selected>TODOS</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="selgxml">GXML:</label>                    
                <select id="selgxml" class="form-control">
                    <option value='1'>SIM</option>
                    <option value='0'>N&Atilde;O</option>
                    <option value='9' selected>TODOS</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label for="selbloqueado">BLOQUEIO:</label>                    
                <select id="selbloqueado" class="form-control">
                    <option value='S'>SIM</option>
                    <option value='N'>N&Atilde;O</option>
                    <option value='T' selected>TODOS</option>
                </select>
            </div>

            <div class="form-group col-md-1">
                <label for="selcontrato">CONTRATO:</label>                    
                <select id="selcontrato" class="form-control">
                    <option value='S'>ANEXADO</option>
                    <option value='N'>SEM ANEXO</option>
                    <option value='T' selected>TODOS</option>
                </select>
            </div>

            <div class="form-group col-md-1">
                <label for="selcertificado">CERTIFICADO:</label>                    
                <select id="selcertificado" class="form-control">
                    <option value='S'>ANEXADO</option>
                    <option value='N'>SEM ANEXO</option>
                    <option value='T' selected>TODOS</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <br>
                <?php include "inc/botao_consultar.php"; ?>
            </div>
        </fieldset>
    </div>
    <div class="row table-responsive" id="rslista">
        <?php include "admin/clientes/listadados.php";?>
    </div>
</div>

<script language="JavaScript">
function consultar(pg) {
  Buscar(document.getElementById('txtpesquisanome').value, document.getElementById('selaverbacao').value, document.getElementById('selgxml').value, document.getElementById('selbloqueado').value, document.getElementById('selcontrato').value, document.getElementById('selcertificado').value, pg);
}
</script>