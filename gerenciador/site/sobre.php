<?php

    foreach($_GET as $key => $value){
        $$key = $value;
    }

    if ($consultar == "sim") {
        $ant = "../../";
        require_once $ant.'conexao.php';
    }

    if($codigo != ""){

        $SQL = "SELECT ds_titulo, ds_conteudo, ds_titulo1, ds_conteudo1, ds_titulo2, ds_conteudo2
                    FROM sobre_site
                WHERE nr_seq_configuracao = $codigo";
        //echo "<pre>$SQL</pre>";
        $RSS = mysqli_query($conexao, $SQL);
        while($linha = mysqli_fetch_row($RSS)){
            $ds_titulo = $linha[0];
            $ds_conteudo = $linha[1];
            $ds_titulo1 = $linha[2];
            $ds_conteudo1 = $linha[3];
            $ds_titulo2 = $linha[4];
            $ds_conteudo2 = $linha[5];
        }
    }

?>

<body onLoad="document.getElementById('txtnome').focus();">
    <input type="hidden" name="cd_configuracao" id="cd_configuracao" value="<?php echo $codigo; ?>">
    <div class="form-group col-md-12">
        <div class="row">
            <button type=button name="btsalvar" id="btsalvar" class="btn btn-success" onClick="javascript: SalvarSobre(<?php echo $codigo; ?>);"><span class="glyphicon glyphicon-ok"></span> SALVAR</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label for="txttitulosobre">TÍTULO:</label>                    
            <input type="text" name="txttitulosobre" id="txttitulosobre" size="15" maxlength="100" class="form-control" placeholder="Título Principal" value="<?php echo $ds_titulo; ?>">
        </div>

        <div class="col-md-12">
            <label for="txtconteudosobre">CONTEÚDO:</label>    
            <textarea id="txtconteudosobre" rows="10" class="form-control" maxlength="1000" placeholder="Descreva o conteúdo."><?php echo $ds_conteudo; ?></textarea>
        </div>

        <div class="col-md-12">
            <label for="txttitulosobre1">TÍTULO 1:</label>                    
            <input type="text" name="txttitulosobre1" id="txttitulosobre1" size="15" maxlength="100" class="form-control" placeholder="Segundo título" value="<?php echo $ds_titulo1; ?>">
        </div>

        <div class="col-md-12">
            <label for="txtconteudosobre1">CONTEÚDO 1:</label>    
            <textarea id="txtconteudosobre1" rows="10" class="form-control" maxlength="1000" placeholder="Descreva o conteúdo."><?php echo $ds_conteudo1; ?></textarea>
        </div>

        <div class="col-md-12">
            <label for="txttitulosobre2">TÍTULO 2:</label>                    
            <input type="text" name="txttitulosobre2" id="txttitulosobre2" size="15" maxlength="100" class="form-control" placeholder="Terçeiro título" value="<?php echo $ds_titulo2; ?>">
        </div>

        <div class="col-md-12">
            <label for="txtconteudosobre2">CONTEÚDO 2:</label>    
            <textarea id="txtconteudosobre2" rows="10" class="form-control" maxlength="1000" placeholder="Descreva o conteúdo."><?php echo $ds_conteudo2; ?></textarea>
        </div>
    </div>
</body>

<script type="text/javascript">

    function SalvarSobre(id){

        var titulo = document.getElementById('txttitulosobre').value;
        var conteudo = document.getElementById("txtconteudosobre").value;
        var titulo1 = document.getElementById('txttitulosobre1').value;
        var conteudo1 = document.getElementById("txtconteudosobre1").value;
        var titulo2 = document.getElementById('txttitulosobre2').value;
        var conteudo2 = document.getElementById("txtconteudosobre2").value;

        window.open('gerenciador/site/acao.php?Tipo=S&codigo=' + id + '&titulo=' + titulo + '&conteudo=' + conteudo + '&titulo1=' + titulo1 + '&conteudo1=' + conteudo1 + '&titulo2=' + titulo2 + '&conteudo2=' + conteudo2, "acao");
    }

</script>