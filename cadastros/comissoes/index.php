<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<script type="text/javascript">

    function Buscar(colaborador, administradora, pg) {
        document.getElementById('pgatual').value = '';
        document.getElementById('pgatual').value = parseInt(pg)+1;
        var url = 'cadastros/comissoes/listadados.php?consulta=sim&pg=' + pg + '&colaborador=' + colaborador + '&administradora=' + administradora;
        $.get(url, function (dataReturn) {
            $('#rslista').html(dataReturn);
        });
    }

    function BuscarComissao(parcelas, codigo) {

        var url = 'cadastros/comissoes/comissao.php?consulta=sim&parcelas=' + parcelas + '&codigo=' + codigo;
        $.get(url, function(dataReturn) {
            $('#rscomissoes').html(dataReturn);
        });

    }

</script>

<link rel="stylesheet" href="assets/css/estilo.css">
<iframe name="acao" width="0" height="0" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>
<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a id="tabgeral" href="#geral" data-toggle="tab">CADASTRO</a></li>
    <li><a id="tablista" href="#lista" data-toggle="tab">LISTA</a></li>
</ul> 

<div class="tab-content">
    <div class="tab-pane active" id="geral">
        <div class="row-100">          
            <?php include "formulario.php"; ?>          
        </div>
    </div>
    <div class = "tab-pane" id = "lista">
        <div class="row-100">
            <?php include 'lista.php'; ?>        
        </div>
    </div>
</div>

