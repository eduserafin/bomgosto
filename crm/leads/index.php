<?php

    foreach($_GET as $key => $value){
        $$key = $value;
    }

?>
<script type="text/javascript">

    function Buscar(nome, cidade, status, segmento, data1, data2, dataagenda1, dataagenda2, visual, pg) {
        
        if(visual == 'L'){
            
            document.getElementById('pgatual').value = '';
            document.getElementById('pgatual').value = parseInt(pg)+1;
            document.getElementById('dvAguarde').style.display = 'block';
            var url = 'crm/leads/listadados.php?consulta=sim&pg=' + pg + '&nome=' + nome + '&cidade=' + cidade + '&status=' + status + '&data1=' + data1+ '&data2=' + data2 + '&dataagenda1=' + dataagenda1 + '&dataagenda2=' + dataagenda2 + '&segmento=' + segmento;
            $.get(url, function (dataReturn) {
                $('#rslista').html(dataReturn);
            });
            
        } else if(visual == 'Q'){
            
             document.getElementById('dvAguarde').style.display = 'block';
            var url = 'crm/leads/listaquadros.php?consulta=sim&pg=' + pg + '&nome=' + nome + '&cidade=' + cidade + '&status=' + status + '&data1=' + data1+ '&data2=' + data2 + '&dataagenda1=' + dataagenda1 + '&dataagenda2=' + dataagenda2 + '&segmento=' + segmento;
            $.get(url, function (dataReturn) {
                $('#rslista').html(dataReturn);
            });
            
        }

    }

    function buscaComercial(id){
        var url = 'crm/leads/crm.php?consulta=sim&lead=' + id;
        $.get(url, function (dataReturn) {
            $('#comercial').html(dataReturn);
            $('#tabcomercial').tab('show');
        });
    }
    
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');
    
        if (tab === 'lista') {
            // Remover a classe active da aba atual e conteúdo
            document.querySelector('.nav-tabs li.active')?.classList.remove('active');
            document.querySelector('.tab-content .tab-pane.active')?.classList.remove('active');
    
            // Ativar a aba LISTA
            document.querySelector('#tablista').parentElement.classList.add('active');
            document.querySelector('#lista').classList.add('active');
        }
        else if (tab === 'crm') {
            document.querySelector('.nav-tabs li.active')?.classList.remove('active');
            document.querySelector('.tab-content .tab-pane.active')?.classList.remove('active');
    
            document.querySelector('#tabcomercial').parentElement.classList.add('active');
            document.querySelector('#comercial').classList.add('active');
        }
    });
    
</script>

<link rel="stylesheet" href="assets/css/estilo.css">
<iframe name="acao" width="0" height="0" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>
<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a id="tabgeral" href="#geral" data-toggle="tab">CADASTRO</a></li>
    <li><a id="tablista" href="#lista" data-toggle="tab">LISTA</a></li>
    <li><a id="tabcomercial" href="#comercial" data-toggle="tab">CRM</a></li>
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

