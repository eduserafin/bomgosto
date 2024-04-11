<?php

    foreach($_GET as $key => $value){
        $$key = $value;
    }

    if ($consultar == "sim") {
        $ant = "../../";
        require_once $ant.'conexao.php';
    }

    if($codigo != ""){

        $SQL = "SELECT ds_titulo, ds_conteudo, nr_telefone, nr_whatsapp, ds_email
                    FROM contato_site
                WHERE nr_seq_configuracao = $codigo";
        //echo "<pre>$SQL</pre>";
        $RSS = mysqli_query($conexao, $SQL);
        while($linha = mysqli_fetch_row($RSS)){
            $ds_titulo = $linha[0];
            $ds_conteudo = $linha[1];
            $nr_telefone = $linha[2];
            $nr_whatsapp = $linha[3];
            $ds_email = $linha[4];
        }

        ?>

        <body onLoad="document.getElementById('txttitulocontato').focus();">
            <input type="hidden" name="cd_configuracao_contato" id="cd_configuracao_contato" value="<?php echo $codigo; ?>">
            <div class="row">
                <div class="col-md-2">
                    <button type=button name="btsalvar" id="btsalvar" class="btn btn-success" onClick="javascript: SalvarContato(<?php echo $codigo; ?>);"><span class="glyphicon glyphicon-ok"></span> SALVAR</button>
                </div>
                <div class="col-md-10"><br>
                    <label>Preencha com informações da empresa, essas informações iram aparecer no site, na aba Contato.</label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="txttitulocontato">TÍTULO:</label>                    
                    <input type="text" name="txttitulocontato" id="txttitulocontato" size="15" maxlength="100" class="form-control" placeholder="Título Principal" value="<?php echo $ds_titulo; ?>">
                </div>

                <div class="col-md-12">
                    <label for="txtconteudocontato">CONTEÚDO:</label>    
                    <textarea id="txtconteudocontato" rows="10" class="form-control" maxlength="1000" placeholder="Descreva o conteúdo."><?php echo $ds_conteudo; ?></textarea>
                </div>

                <div class="col-md-6">
                    <label for="txttelefonecontato">TELEFONE:</label>                    
                    <input type="text" name="txttelefonecontato" id="txttelefonecontato" size="15" maxlength="15" class="form-control" placeholder="Telefone" value="<?php echo $nr_telefone; ?>">
                </div>

                <div class="col-md-6">
                    <label for="txtwhatscontatato">WHATSAPP:</label>                    
                    <input type="number" name="txtwhatscontatato" id="txtwhatscontatato" size="15" maxlength="15" class="form-control" placeholder="Whatsapp" value="<?php echo $nr_whatsapp; ?>">
                </div>

                <div class="col-md-12">
                    <label for="txtemailcontato">E-MAIL:</label>                    
                    <input type="text" name="txtemailcontato" id="txtemailcontato" size="15" maxlength="100" class="form-control" placeholder="E-mail" value="<?php echo $ds_email; ?>">
                </div>
            </div>
        </body>
    <?php } ?>

<script type="text/javascript">

    function SalvarContato(id){

        var titulo = document.getElementById('txttitulocontato').value;
        var conteudo = document.getElementById("txtconteudocontato").value;
        var telefone = document.getElementById('txttelefonecontato').value;
        var whatsapp = document.getElementById("txtwhatscontatato").value;
        var email = document.getElementById('txtemailcontato').value;

        window.open('gerenciador/site/acao.php?Tipo=C&codigo=' + id + '&titulo=' + titulo + '&conteudo=' + conteudo + '&telefone=' + telefone + '&whatsapp=' + whatsapp + '&email=' + email, "acao");
    }

</script>