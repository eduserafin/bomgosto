<body onLoad="document.getElementById('txtproduto').focus();">
<input type="hidden" name="cd_venda" id="cd_venda" value="">
<div class="form-group col-md-12">
    <div class="row">
        <?php include "inc/botao_novo.php"; ?>
        <?php include "inc/botao_salvar.php"; ?>
          <?php include "inc/botao_excluir.php"; ?>
    </div>
</div>
<div class="row">
   <div class="col-md-2">
                    <label for="txtproduto">Produto:</label>                    
                    <select id="txtproduto" class="form-control" style="background:#E0FFFF;">
                        <option value='0'>Selecione um produto</option>
                        <?php
                        $sql = "SELECT nr_sequencial, ds_produto
                                FROM produtos
                                ORDER BY ds_produto";
                        $res = mysqli_query($conexao, $sql);
                        while($lin=mysqli_fetch_row($res)){
                            $codigo = $lin[0];
                            $desc = $lin[1];

                            echo "<option value='$codigo'>$desc</option>";
                        }
                        ?>
                    </select>
    </div>

    <div class="col-md-2">
                    <label for="txtquantidade">Quantidade:</label>                    
                    <input type="number" name="txtquantidade" id="txtquantidade" size="15" maxlength="14" class="form-control" style="background:#E0FFFF;"></td>
    </div>

    <div class="col-md-2">        
                    <label for="txtvalor">Valor total:</label>
                    <input type="number" name="txtvalor" id="txtvalor" size="20" maxlength="32" class="form-control" style="background:#E0FFFF;"></td>
    </div>

   <div class="col-md-2">           
            <label for="txtopcao">Tipo de pagamento:</label>
            <select id="txtopcao" name="txtopcao" class="form-control" style="background:#E0FFFF;" required>
            <option value='0'>Selecione uma opção</option>
            <option value="A">Avista</option>
            <option value="P">Parcelado</option>
            <option value="N">Não pagou</option> 
            </select>                 
    </div>

     <div class="col-md-2">        
                    <label for="txtnome">Cliente:</label>
                    <input type="text" name="txtnome" id="txtnome" size="20" maxlength="50" class="form-control"></td>
    </div>
</div>
</body>
<script type="text/javascript">
function executafuncao(id){
  if (id=='new'){
    document.getElementById('cd_venda').value = "";
    document.getElementById('txtproduto').value = "";
    document.getElementById('txtquantidade').value = "";
    document.getElementById('txtvalor').value = "";
    document.getElementById('txtopcao').value = "";
    document.getElementById('txtnome').value = "";
    document.getElementById('txtproduto').focus();
  }
  else if (id=="save"){  
    var codigo = document.getElementById('cd_venda').value;
    var produto = document.getElementById('txtproduto').value;
    var quantidade = document.getElementById('txtquantidade').value;
    var valor = document.getElementById('txtvalor').value;
    var pagamento = document.getElementById('txtopcao').value;
    var nome = document.getElementById('txtnome').value;
    if (produto != 0) {
        produto = produto.replace("'", "");
    }
    if (quantidade != '') {
        quantidade = quantidade.replace("'", "");
    }
    if (valor != '') {
        valor = valor.replace("'", "");
    }

    if (produto == 0) {
        alert('Informe um produto');
        document.getElementById('txtproduto').focus();
    } else if (quantidade == 0) {
        alert('Informe a quantidade de produtos');
        document.getElementById('txtquantidade').focus();
    } else if (valor == 0) {
        alert('Informe o valor da venda');
        document.getElementById('txtvalor').focus();
    } else if (pagamento == '') {
        alert('Informe um tipo de pagamento');
        document.getElementById('txtopcao').focus();
    } else {
        if (codigo == '') {
            Tipo = "I"
        } else {
            Tipo = "A";
        }

        window.open('vendas/lancamentos/acao.php?Tipo=' + Tipo + '&codigo=' + codigo + '&produto=' + produto + '&quantidade=' + quantidade + '&valor=' + valor + '&pagamento=' + pagamento + '&nome=' + nome, "acao");
    }
  } else if (id == "delete") {
            if (document.getElementById('cd_venda').value == "")
            {
                alert('Para efetuar a exclus\u00e3o \u00e9 necess\u00e1rio selecionar um registro primeiro');
                return;
            }
            if (!confirm("Deseja excluir o registro selecionado?")) {
                return false;
            } else
            {
                var codigo = document.getElementById('cd_venda').value;
                window.open('vendas/lancamentos/acao.php?Tipo=E&codigo=' + codigo, 'acao');
            }
        }
    }

</script>