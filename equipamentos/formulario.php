<body onLoad="document.getElementById('txtequipamento').focus();">
<input type="hidden" name="cd_equipamento" id="cd_equipamento" value="">
<div class="form-group col-md-12">
    <div class="row">
        <?php include "inc/botao_novo.php"; ?>
        <?php include "inc/botao_salvar.php"; ?>
          <?php include "inc/botao_excluir.php"; ?>
    </div>
</div>

<div class="row">  
    <div class="col-md-12">
        <div id="msgexibe" class="alert alert-info fade in alert-dismissable" >
            <span class="glyphicon glyphicon-pencil"></span> CADASTRO DE EQUIPAMENTOS EMPRESTADO AO CLIENTE - controle de devolução de equipamentos!
        </div>
    </div>

   <div class="col-md-2">
                    <label for="txtequipamento">Equipamento:</label>                    
                    <select id="txtequipamento" class="form-control" style="background:#E0FFFF;">
                        <option value='0'>Selecione um equipamento</option>
                        <?php
                        $sql = "SELECT nr_sequencial, ds_equipamento
                                FROM equipamentos
                                ORDER BY ds_equipamento";
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
                    <label for="txtnome">Cliente:</label>
                    <input type="text" name="txtnome" id="txtnome" size="20" maxlength="50" class="form-control"></td>
    </div>

</div>
</body>
<script type="text/javascript">
function executafuncao(id){
  if (id=='new'){
    document.getElementById('cd_equipamento').value = "";
    document.getElementById('txtequipamento').value = "";
    document.getElementById('txtquantidade').value = "";
    document.getElementById('txtnome').value = "";
    document.getElementById('txtequipamento').focus();
  }
  else if (id=="save"){  
    var codigo = document.getElementById('cd_equipamento').value;
    var equipamento = document.getElementById('txtequipamento').value;
    var quantidade = document.getElementById('txtquantidade').value;
    var nome = document.getElementById('txtnome').value;
    if (equipamento != 0) {
        equipamento = equipamento.replace("'", "");
    }
    if (quantidade != '') {
        quantidade = quantidade.replace("'", "");
    }

    if (equipamento == 0) {
        alert('Informe um equipamento');
        document.getElementById('txtequipamento').focus();
    } else if (quantidade == 0) {
        alert('Informe a quantidade de equipamentos emprestado');
        document.getElementById('txtquantidade').focus();
    } else {
        if (codigo == '') {
            Tipo = "I"
        } else {
            Tipo = "A";
        }

        window.open('equipamentos/acao.php?Tipo=' + Tipo + '&codigo=' + codigo + '&equipamento=' + equipamento + '&quantidade=' + quantidade + '&nome=' + nome, "acao");
    }
  } else if (id == "delete") {
            if (document.getElementById('cd_equipamento').value == "")
            {
                alert('Para efetuar a exclus\u00e3o \u00e9 necess\u00e1rio selecionar um registro primeiro');
                return;
            }
            if (!confirm("Deseja excluir o registro selecionado?")) {
                return false;
            } else
            {
                var codigo = document.getElementById('cd_equipamento').value;
                window.open('equipamentos/acao.php?Tipo=E&codigo=' + codigo, 'acao');
            }
        }
    }

</script>