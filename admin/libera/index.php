<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<script type="text/javascript">

    function Buscar(descricao, pg) {
        document.getElementById('pgatual').value = '';
        document.getElementById('pgatual').value = parseInt(pg) + 1;
        var url = 'admin/libera/listadados.php?consulta=sim&pg=' + pg + '&descricao=' + descricao;
        $.get(url, function (dataReturn) {
            document.getElementById("rslistavande").innerHTML = dataReturn;
        });
    }
    
    function busca_smenu(menu, modulo) {
        var url = 'admin/libera/smenu.php?menu=' + menu + '&modulo=' + modulo;
        $.get(url, function (dataReturn) {
            document.getElementById("rssmenu").innerHTML = dataReturn;
        });
    }

</script>

<iframe name="acao" width="0" height="0" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>

<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a id="tabgeral" href="#geral" data-toggle="tab">USU&Aacute;RIO x ACESSO</a></li>
    <li><a id="tablista" href="#lista" data-toggle="tab">LISTA USU&Aacute;RIO</a></li>
</ul> 

<div class="tab-content">
    <div class="tab-pane active" id="geral">
        <div class="row">          
            <?php include "formulario.php"; ?>          
        </div>
    </div>
    <div class = "tab-pane" id = "lista">
        <div class="row">
            <fieldset>
                
                <div id="rslista">
                    <?php include ("lista.php"); ?>
                </div>    
            </fieldset>
        </div>
    </div>
</div>
