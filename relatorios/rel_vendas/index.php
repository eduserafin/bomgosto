<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<script type="text/javascript">

    function Buscar(produto, opcao, data1, data2, nome, vendedor, pg) {
        document.getElementById('pgatual').value = '';
        document.getElementById('pgatual').value = parseInt(pg)+1;
        var url = 'relatorios/rel_vendas/listadados.php?consulta=sim&pg=' + pg + '&produto=' + produto + '&opcao=' + opcao + '&data1=' + data1 + '&data2=' + data2 + '&nome=' + nome + '&vendedor=' + vendedor;
        $.get(url, function (dataReturn) {
            $('#rslista').html(dataReturn);
        });
    }

</script>


<iframe name="acao" width="0" height="0" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>

<div class="col-md-12">
    <div class="row">
        <legend>Pesquisar por</legend>
            <div class="col-md-3">
                    <label for="produto">Produto:</label>                    
                    <select id="produto" class="form-control">
                        <option value='0'>Selecione</option>
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

           <div class="col-md-3">
                    <label for="vendedor">Vendedor:</label>                    
                    <select id="vendedor" class="form-control">
                        <option value='0'>Selecione</option>
                        <?php
                        $sql = "SELECT idusuario, nome
                                FROM tb_usuarios
                                ORDER BY nome";
                        $res = mysqli_query($conexao, $sql);
                        while($lin=mysqli_fetch_row($res)){
                            $codigo = $lin[0];
                            $desc = $lin[1];

                            echo "<option value='$codigo'>$desc</option>";
                        }
                        ?>
                    </select>
           </div>

            <div class="col-md-3">           
                <label for="opcao">Tipo de pagamento:</label>
                <select id="opcao" name="opcao" class="form-control" required>
                <option value='0'>Selecione</option>
                <option value="A">AVISTA</option>
                <option value="P">PARCELADO</option>
                <option value="N">NÃO PAGOU</option> 
                </select>                 
            </div>
    </div>

        <div class="row">
            <div class="col-md-10 form-inline">
            <br>
                    <label for="data">DATA:</label>
                    <input type="date" class="form-control" name="data1" id="data1">
                    <input type="date" class="form-control" name="data2" id="data2">
                  
                    <label for="nome">Cliente:</label>
                    <input type="text" name="nome" id="nome" size="45" maxlength="50" class="form-control"></td>
            
                <?php include "inc/botao_consultar.php"; ?>
            </div>
        </div>

<br>
    <div class="row table-responsive" id="rslista">
        <?php include "relatorios/rel_vendas/listadados.php";?>
    </div>
</div>

<script language="JavaScript">
function consultar(pg) {
    Buscar(document.getElementById('produto').value, document.getElementById('opcao').value, document.getElementById('data1').value, document.getElementById('data2').value, document.getElementById('nome').value, document.getElementById('vendedor').value, pg);
}
</script>

