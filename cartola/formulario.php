<body onLoad="document.getElementById('txtrodada').focus();">
<input type="hidden" name="cd_cartola" id="cd_cartola" value="">
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
            <span class="glyphicon glyphicon-pencil"></span> CONTROLE DE RODADAS CARTOLA 2021
        </div>
    </div>

<div class="form-group col-md-12"> 
    <div class="col-md-2"> 
                    <label for="txtrodada">Rodada:</label>                    
                    <input type="number" name="txtrodada" id="txtrodada" size="15" maxlength="14" class="form-control" style="background:#E0FFFF;"></td>
    </div>
</div>

<div class="form-group col-md-12">
   <div class="col-md-6">
                    <label for="txtvencedor">Vencedor:</label>                    
                    <select id="txtvencedor" class="form-control" style="background:#E0FFFF;">
                        <option value='0'>Selecione um Time</option>
                        <?php
                        $sql = "SELECT nr_sequencial, ds_time, ds_nome
                                FROM cartola_times
                                ORDER BY ds_time";
                        $res = mysqli_query($conexao, $sql);
                        while($lin=mysqli_fetch_row($res)){
                            $codigo = $lin[0];
                            $time = $lin[1];
                            $nome = $lin[2];

                            echo "<option value='$codigo'>$time ($nome)</option>";
                        }
                        ?>
                    </select>
    </div>

    <div class="col-md-2"> 
                    <label for="txtpontos">Pontuação:</label>                    
                    <input type="number" name="txtpontos" id="txtpontos" size="15" maxlength="14" class="form-control" style="background:#E0FFFF;"></td>
    </div>

       <div class="col-md-6">
                    <label for="txtpagador1">Pagador:</label>                    
                    <select id="txtpagador1" class="form-control" style="background:#E0FFFF;">
                        <option value='0'>Selecione um Time</option>
                        <?php
                        $sql = "SELECT nr_sequencial, ds_time, ds_nome
                                FROM cartola_times
                                ORDER BY ds_time";
                        $res = mysqli_query($conexao, $sql);
                        while($lin=mysqli_fetch_row($res)){
                            $codigo = $lin[0];
                            $time = $lin[1];
                            $nome = $lin[2];

                            echo "<option value='$codigo'>$time ($nome)</option>";
                        }
                        ?>
                    </select>
    </div>

    <div class="col-md-2"> 
                    <label for="txtpontos1">Pontuação:</label>                    
                    <input type="number" name="txtpontos1" id="txtpontos1" size="15" maxlength="14" class="form-control" style="background:#E0FFFF;"></td>
    </div>

       <div class="col-md-6">
                    <label for="txtpagador2">Pagador:</label>                    
                    <select id="txtpagador2" class="form-control" style="background:#E0FFFF;">
                        <option value='0'>Selecione um Time</option>
                        <?php
                        $sql = "SELECT nr_sequencial, ds_time, ds_nome
                                FROM cartola_times
                                ORDER BY ds_time";
                        $res = mysqli_query($conexao, $sql);
                        while($lin=mysqli_fetch_row($res)){
                            $codigo = $lin[0];
                            $time = $lin[1];
                            $nome = $lin[2];

                            echo "<option value='$codigo'>$time ($nome)</option>";
                        }
                        ?>
                    </select>
    </div>

    <div class="col-md-2"> 
                    <label for="txtpontos2">Pontuação:</label>                    
                    <input type="number" name="txtpontos2" id="txtpontos2" size="15" maxlength="14" class="form-control" style="background:#E0FFFF;"></td>
    </div>

       <div class="col-md-6">
                    <label for="txtpagador3">Pagador:</label>                    
                    <select id="txtpagador3" class="form-control" style="background:#E0FFFF;">
                        <option value='0'>Selecione um Time</option>
                        <?php
                        $sql = "SELECT nr_sequencial, ds_time, ds_nome
                                FROM cartola_times
                                ORDER BY ds_time";
                        $res = mysqli_query($conexao, $sql);
                        while($lin=mysqli_fetch_row($res)){
                            $codigo = $lin[0];
                            $time = $lin[1];
                            $nome = $lin[2];

                            echo "<option value='$codigo'>$time ($nome)</option>";
                        }
                        ?>
                    </select>
    </div>

    <div class="col-md-2"> 
                    <label for="txtpontos3">Pontuação:</label>                    
                    <input type="number" name="txtpontos3" id="txtpontos3" size="15" maxlength="14" class="form-control" style="background:#E0FFFF;"></td>
    </div>

       <div class="col-md-6">
                    <label for="txtpagador4">Pagador:</label>                    
                    <select id="txtpagador4" class="form-control" style="background:#E0FFFF;">
                        <option value='0'>Selecione um Time</option>
                        <?php
                        $sql = "SELECT nr_sequencial, ds_time, ds_nome
                                FROM cartola_times
                                ORDER BY ds_time";
                        $res = mysqli_query($conexao, $sql);
                        while($lin=mysqli_fetch_row($res)){
                            $codigo = $lin[0];
                            $time = $lin[1];
                            $nome = $lin[2];

                            echo "<option value='$codigo'>$time ($nome)</option>";
                        }
                        ?>
                    </select>
    </div>

     <div class="col-md-2"> 
                    <label for="txtpontos4">Pontuação:</label>                    
                    <input type="number" name="txtpontos4" id="txtpontos4" size="15" maxlength="14" class="form-control" style="background:#E0FFFF;"></td>
    </div>

    <div class="col-md-6">
                    <label for="txtpagador5">Pagador:</label>                    
                    <select id="txtpagador5" class="form-control" style="background:#E0FFFF;">
                        <option value='0'>Selecione um Time</option>
                        <?php
                        $sql = "SELECT nr_sequencial, ds_time, ds_nome
                                FROM cartola_times
                                ORDER BY ds_time";
                        $res = mysqli_query($conexao, $sql);
                        while($lin=mysqli_fetch_row($res)){
                            $codigo = $lin[0];
                            $time = $lin[1];
                            $nome = $lin[2];

                            echo "<option value='$codigo'>$time ($nome)</option>";
                        }
                        ?>
                    </select>
    </div>

     <div class="col-md-2"> 
                    <label for="txtpontos5">Pontuação:</label>                    
                    <input type="number" name="txtpontos5" id="txtpontos5" size="15" maxlength="14" class="form-control" style="background:#E0FFFF;"></td>
    </div>

    </div>
</div>
</body>

<script type="text/javascript">
function executafuncao(id){
  if (id=='new'){
    document.getElementById('cd_cartola').value = "";
    document.getElementById('txtrodada').value = "";
    document.getElementById('txtvencedor').value = 0;
    document.getElementById('txtpontos').value = "";
    document.getElementById('txtpagador1').value = 0;
    document.getElementById('txtpontos1').value = "";
    document.getElementById('txtpagador2').value = 0;
    document.getElementById('txtpontos2').value = "";
    document.getElementById('txtpagador3').value = 0;
    document.getElementById('txtpontos3').value = "";
    document.getElementById('txtpagador4').value = 0;
    document.getElementById('txtpontos4').value = "";
    document.getElementById('txtpagador5').value = 0;
    document.getElementById('txtpontos5').value = "";
    document.getElementById('txtrodada').focus();
  }
  else if (id=="save"){  
    var codigo = document.getElementById('cd_cartola').value;
    var rodada = document.getElementById('txtrodada').value;
    var vencedor = document.getElementById('txtvencedor').value;
    var pontos = document.getElementById('txtpontos').value;
    var pagador1 = document.getElementById('txtpagador1').value;
    var pontos1 = document.getElementById('txtpontos1').value;
    var pagador2 = document.getElementById('txtpagador2').value;
    var pontos2 = document.getElementById('txtpontos2').value;
    var pagador3 = document.getElementById('txtpagador3').value;
    var pontos3 = document.getElementById('txtpontos3').value;
    var pagador4 = document.getElementById('txtpagador4').value;
    var pontos4 = document.getElementById('txtpontos4').value;
    var pagador5 = document.getElementById('txtpagador5').value;
    var pontos5 = document.getElementById('txtpontos5').value;

    if (rodada == "") {
        alert('Informe a rodada');
        document.getElementById('txtrodada').focus();
    } else if (vencedor == 0) {
        alert('Informe o vencedor da rodada');
        document.getElementById('txtvencedor').focus();
    }else if (pontos == "") {
        alert('Informe a pontuação do vencedor');
        document.getElementById('txtpontos').focus();
    }else if (pagador1 == 0) {
        alert('Informe o primeiro pagador');
        document.getElementById('txtpagador1').focus();
    }else if (pontos1 == "") {
        alert('Informe a pontuação do primeiro pagador');
        document.getElementById('txtpontos1').focus();
    }else if (pagador2 == 0) {
        alert('Informe o segundo pagador');
        document.getElementById('txtpagador2').focus();
    }else if (pontos2 == "") {
        alert('Informe a pontuação do segundo pagador');
        document.getElementById('txtpontos2').focus();
    }else if (pagador3 == 0) {
        alert('Informe o terceiro pagador');
        document.getElementById('txtpagador3').focus();
    }else if (pontos3 == "") {
        alert('Informe a pontuação do terceiro pagador');
        document.getElementById('txtpontos3').focus();
    }else if (pagador4 == 0) {
        alert('Informe o quarto pagador');
        document.getElementById('txtpagador4').focus();
    }else if (pontos4 == "") {
        alert('Informe a pontuação do quarto pagador');
        document.getElementById('txtpontos4').focus();
    }else if (pagador5 == 0) {
        alert('Informe o quarto pagador');
        document.getElementById('txtpagador5').focus();
    }else if (pontos5 == "") {
        alert('Informe a pontuação do quarto pagador');
        document.getElementById('txtpontos5').focus();
    } else {
        if (codigo == '') {
            Tipo = "I"
        } else {
            Tipo = "A";
        }

        window.open('cartola/acao.php?Tipo=' + Tipo + '&codigo=' + codigo + '&rodada=' + rodada + '&vencedor=' + vencedor + '&pontos=' + pontos + 
       '&pagador1=' + pagador1 + '&pontos1=' + pontos1 + '&pagador2=' + pagador2 + '&pontos2=' + pontos2 + '&pagador3=' + pagador3 + 
        '&pontos3=' + pontos3 + '&pagador4=' + pagador4 + '&pontos4=' + pontos4  + '&pagador5=' + pagador5 + '&pontos5=' + pontos5, "acao");
    }
  } else if (id == "delete") {
            if (document.getElementById('cd_cartola').value == "")
            {
                alert('Para efetuar a exclus\u00e3o \u00e9 necess\u00e1rio selecionar um registro primeiro');
                return;
            }
            if (!confirm("Deseja excluir o registro selecionado?")) {
                return false;
            } else
            {
                var codigo = document.getElementById('cd_cartola').value;
                window.open('cartola/acao.php?Tipo=E&codigo=' + codigo, 'acao');
            }
        }
    }

</script>