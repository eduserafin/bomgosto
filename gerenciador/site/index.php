<?php

    foreach($_GET as $key => $value){
        $$key = $value;
    }

?>
<script type="text/javascript">

    function Buscar(nome, pg) {
        
        document.getElementById('pgatual').value = '';
        document.getElementById('pgatual').value = parseInt(pg)+1;
        var url = 'gerenciador/site/listadados.php?consulta=sim&pg=' + pg + '&nome=' + nome;
        $.get(url, function (dataReturn) {
            $('#rslista').html(dataReturn);
        });

    }

</script>

<iframe name="acao" width="0" height="0" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>
<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a id="tabgeral" href="#geral" data-toggle="tab">PÁGINA INICIAL</a></li>
    <li><a id="tabsobre" href="#sobre" data-toggle="tab">SOBRE</a></li>
    <li><a id="tabproduto" href="#produto" data-toggle="tab">PRODUTOS</a></li>
    <li><a id="tabcontato" href="#contato" data-toggle="tab">CONTATO</a></li>
    <li><a id="tabredes" href="#redes" data-toggle="tab">REDES SOCIAIS</a></li>
    <li><a id="tabanexos" href="#anexo" data-toggle="tab">UPLOAD</a></li>
    <li><a id="tablista" href="#lista" data-toggle="tab">LISTA</a></li>
</ul> 

<div class="tab-content">
    <div class="tab-pane active" id="geral">
        <div class="row-100">          
            <?php include "formulario.php"; ?>          
        </div>
    </div> 
    <div class="tab-pane" id="sobre">
        <div class="row-100">
            <?php include "sobre.php"; ?>        
        </div>
    </div>
    <div class="tab-pane" id="produto">
        <div class="row-100">
            <?php include "produto.php"; ?>        
        </div>
    </div>
    <div class="tab-pane" id="contato">
        <div class="row-100">
            <?php include "contato.php"; ?>        
        </div>
    </div>
    <div class="tab-pane" id="redes">
        <div class="row-100">
            <?php include "redes.php"; ?>        
        </div>
    </div>
    <div class="tab-pane" id="anexo">
        <div class="row-100">
            <?php include "anexos.php"; ?>        
        </div>
    </div>
    <div class="tab-pane" id="lista">
        <div class="row-100">
            <?php include "lista.php"; ?>        
        </div>
    </div>
</div>

