<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<div class="col-md-12">
    <div class="row">
        <legend>Pesquisar por</legend>
            <div class="col-md-3">
                    <label for="produto">Produto:</label>                    
                    <select id="produto" class="form-control">
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

            <div class="col-md-3">           
                <label for="opcao">Tipo de pagamento:</label>
                <select id="opcao" name="opcao" class="form-control" required>
                <option value='0'>Selecione uma opção</option>
                <option value="A">Avista</option>
                <option value="P">Parcelado</option>
                <option value="N">Não pagou</option> 
                </select>                 
            </div>

             <div class="col-md-3">
                  <label for="data">Data:</label>   
                  <input type="date" name="data" id="data" class="form-control">
             </div>
        <br>
            <div class="col-md-2">
                <?php include "inc/botao_consultar.php"; ?>
            </div>
    </div>
<br>
    <div class="row table-responsive" id="rslista">
        <?php include "vendas/lancamentos/listadados.php";?>
    </div>
</div>

<script language="JavaScript">
function consultar(pg) {
    Buscar(document.getElementById('produto').value, document.getElementById('opcao').value, document.getElementById('data').value, pg);
}
</script>