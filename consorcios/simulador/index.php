<?php

    foreach($_GET as $key => $value){
        $$key = $value;
    }

    include "../../funcoesgerais.php";

?>
<script type="text/javascript">

    function Buscar(credito, prazo, pg) {
        
        document.getElementById('pgatual').value = '';
        document.getElementById('pgatual').value = parseInt(pg)+1;
        var url = 'consorcios/simulador/listadados.php?consulta=sim&pg=' + pg + '&credito=' + credito + '&prazo=' + prazo;
        $.get(url, function (dataReturn) {
            $('#rslista').html(dataReturn);
        });

    }

</script>

<iframe name="acao" width="0" height="0" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>
<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a id="tabgeral" href="#geral" data-toggle="tab">SIMULADOR</a></li>
    <li><a id="tablista" href="#lista" data-toggle="tab">LISTA</a></li>
</ul> 

<div class="tab-content">
    <div class="tab-pane active" id="geral">
        <div class="row-100">          
            <?php include "formulario.php"; ?>          
        </div>
    </div>
    <div class="tab-pane" id="lista">
        <div class="row-100">
            <?php include "lista.php"; ?>        
        </div>
    </div>
</div>

