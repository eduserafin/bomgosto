<body onLoad="document.getElementById('txtdespesa').focus();">
<input type="hidden" name="cd_despesa" id="cd_despesa" value="">
<div class="form-group col-md-12">
    <div class="row">
        <?php include "inc/botao_novo.php"; ?>
        <?php include "inc/botao_salvar.php"; ?>
          <?php include "inc/botao_excluir.php"; ?>
    </div>
</div>
<div class="row">

   <div class="col-md-6">
                    <label for="txtdespesa">Descrição da Despesa:</label>                    
                    <input type="text" name="txtdespesa" id="txtdespesa" size="15" maxlength="14" class="form-control" style="background:#E0FFFF;"></td>
    </div>

    <div class="col-md-3">        
                    <label for="txtvalor">Valor da Despesa:</label>
                    <input type="number" name="txtvalor" id="txtvalor" size="20" maxlength="32" class="form-control" style="background:#E0FFFF;"></td>
    </div>

     <div class="col-md-2">        
                    <label for="txtdata">Data da Despesa:</label>
                    <input type="date" name="txtdata" id="txtdata" size="20" maxlength="50" class="form-control"></td>
    </div>
</div>
</body>
<script type="text/javascript">
function executafuncao(id){
  if (id=='new'){
    document.getElementById('cd_despesa').value = "";
    document.getElementById('txtdespesa').value = "";
    document.getElementById('txtvalor').value = "";
    document.getElementById('txtdata').value = "";
    document.getElementById('txtdespesa').focus();
  }
  else if (id=="save"){  
    var codigo = document.getElementById('cd_despesa').value;
    var despesa = document.getElementById('txtdespesa').value;
    var valor = document.getElementById('txtvalor').value;
    var data = document.getElementById('txtdata').value;

    if (despesa == "") {
        alert('Informe uma despesa');
        document.getElementById('txtdespesa').focus();
    } else if (valor == 0) {
        alert('Informe o valor da despesa');
        document.getElementById('txtvalor').focus();
    } else if (data == '') {
        alert('Informe a data de pagamento');
        document.getElementById('txtdata').focus();
    } else {
        if (codigo == '') {
            Tipo = "I"
        } else {
            Tipo = "A";
        }

        window.open('despesas/lancamentos/acao.php?Tipo=' + Tipo + '&codigo=' + codigo + '&despesa=' + despesa + '&valor=' + valor + '&data=' + data + '&valor=' + valor, "acao");
    }
  } else if (id == "delete") {
            if (document.getElementById('cd_despesa').value == "")
            {
                alert('Para efetuar a exclus\u00e3o \u00e9 necess\u00e1rio selecionar um registro primeiro');
                return;
            }
            if (!confirm("Deseja excluir o registro selecionado?")) {
                return false;
            } else
            {
                var codigo = document.getElementById('cd_despesa').value;
                window.open('despesas/lancamentos/acao.php?Tipo=E&codigo=' + codigo, 'acao');
            }
        }
    }

</script>