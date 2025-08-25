<?php

    foreach($_GET as $key => $value){
        $$key = $value;
    }

?>
<script type="text/javascript">

    function Buscar(colaborador, administradora, segmento, mes, ano, status, grupo, cota, pg) {

        document.getElementById('pgatual').value = '';
        document.getElementById('pgatual').value = parseInt(pg)+1;
        document.getElementById('dvAguarde').style.display = 'block';
        var url = 'relatorios/comissao/listadados.php?consulta=sim&pg=' + pg + '&colaborador=' + colaborador + '&administradora=' + administradora + '&segmento=' + segmento + '&mes=' + mes + '&ano=' + ano + '&status=' + status + '&grupo=' + grupo + '&cota=' + cota;
        $.get(url, function (dataReturn) {
            $('#rslista').html(dataReturn);
        });

    }

</script>

<link rel="stylesheet" href="assets/css/estilo.css">
<iframe name="acao" width="0" height="0" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>
<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a id="tabgeral" href="#geral" data-toggle="tab">RELATÓRIO COMISSÕES</a></li>
</ul> 

<div class="tab-content">
    <div class="tab-pane active" id="geral">
        <div class="row-100">          
            <?php include "lista.php"; ?>          
        </div>
    </div>
</div>

