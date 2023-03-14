<body onLoad="document.getElementById('txtproduto').focus();">
<input type="hidden" name="cd_produto" id="cd_produto" value="">
<div class="form-group col-md-12">
    <div class="row">
        <?php include "inc/botao_novo.php"; ?>
        <?php include "inc/botao_salvar.php"; ?>
          <?php include "inc/botao_excluir.php"; ?>
    </div>
</div>
<div class="row">
   <div class="col-md-6">
                    <label for="txtproduto">Produto:</label>                    
                    <input type="text" name="txtproduto" id="txtproduto" size="15" maxlength="50" class="form-control" style="background:#E0FFFF;"></td>
    </div>

    <div class="col-md-2">
                    <label for="txtunidade">Valor Unitário:</label>                    
                    <input type="number" name="txtunidade" id="txtunidade" size="15" maxlength="14" class="form-control" style="background:#E0FFFF;"></td>
    </div>

    <div class="col-md-2">
        <label for="ativo">STATUS:</label>
        <?php include "inc/ativos.php";?>
    </div>
</div>
</body>
<script type="text/javascript">
function executafuncao(id){
  if (id=='new'){
    document.getElementById('cd_produto').value = "";
    document.getElementById('txtproduto').value = "";
    document.getElementById('txtunidade').value = "";
    document.getElementById("ativo").value = 1;
    document.getElementById('txtproduto').focus();
  }
  else if (id=="save"){  
    var codigo = document.getElementById('cd_produto').value;
    var produto = document.getElementById('txtproduto').value;
    var unitario = document.getElementById('txtunidade').value;
     var status = document.getElementById("ativo").value;
  
    if (produto != 0) {
        produto = produto.replace("'", "");
    }
    if (unitario != '') {
        unitario = unitario.replace("'", "");
    }
   

    if (produto == 0) {
        alert('Informe um produto');
        document.getElementById('txtproduto').focus();
    } else if (unitario == 0) {
        alert('Informe o valor unitário');
        document.getElementById('txtunidade').focus();
    } else {
        if (codigo == '') {
            Tipo = "I"
        } else {
            Tipo = "A";
        }

        window.open('produtos/cadastros/acao.php?Tipo=' + Tipo + '&codigo=' + codigo + '&produto=' + produto + '&unitario=' + unitario + '&status=' + status, "acao");
    }
  } else if (id == "delete") {
            if (document.getElementById('cd_produto').value == "")
            {
                alert('Para efetuar a exclus\u00e3o \u00e9 necess\u00e1rio selecionar um registro primeiro');
                return;
            }
            if (!confirm("Deseja excluir o registro selecionado?")) {
                return false;
            } else
            {
                var codigo = document.getElementById('cd_produto').value;
                window.open('produtos/cadastros/acao.php?Tipo=E&codigo=' + codigo, 'acao');
            }
        }
    }

</script>