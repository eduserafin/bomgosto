<?php

    foreach($_GET as $key => $value){
        $$key = $value;
    }

?>
<script type="text/javascript">

    function Buscar(credito, nome, cidade, status, segmento, data1, data2, dataagenda1, dataagenda2, pg) {
        
        document.getElementById('pgatual').value = '';
        document.getElementById('pgatual').value = parseInt(pg)+1;
        document.getElementById('dvAguarde').style.display = 'block';
        var url = 'crm/leads/listadados.php?consulta=sim&pg=' + pg + '&credito=' + credito + '&nome=' + nome + '&cidade=' + cidade + '&status=' + status + '&data1=' + data1+ '&data2=' + data2 + '&dataagenda1=' + dataagenda1 + '&dataagenda2=' + dataagenda2 + '&segmento=' + segmento;
        $.get(url, function (dataReturn) {
            $('#rslista').html(dataReturn);
        });

    }

    function buscaComercial(id){
        var url = 'crm/leads/crm.php?consulta=sim&lead=' + id;
        $.get(url, function (dataReturn) {
            $('#comercial').html(dataReturn);
        });
    }

</script>

<iframe name="acao" width="0" height="0" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>
<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a id="tabgeral" href="#geral" data-toggle="tab">CADASTRO</a></li>
    <li><a id="tabformulario" href="#comercial" data-toggle="tab">CRM</a></li>
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
    <div class="tab-pane" id="comercial">
        <div class="row-100">
            <?php include "crm.php"; ?>        
        </div>
    </div>
</div>

