<?php
    foreach($_GET as $key => $value){
        $$key = $value;
    }
?>

<div class="col-md-12">
    <div class="row">
        <legend>Pesquisar por</legend>

            <div class="col-md-6">
                    <label for="pesquisacredito">VALOR CRÉDITO:</label>                  
                    <input type="text" name="pesquisacredito" id="pesquisacredito" size="15" maxlength="14" class="form-control" Placeholder="Descrição da Despesa">
            </div>

             <div class="col-md-3">
                <label for="pesquizaprazo">PRAZO CLIENTE:</label>           
                <select id="pesquizaprazo" class="form-control">
                    <option value="0">Selecione uma opção</option>
                    <?php
                        $sql = "SELECT nr_sequencial, nr_quantidade
                                    FROM consorcio_quantidade_mes
                                ORDER BY nr_quantidade DESC";
                        $res = mysqli_query($conexao, $sql);
                        while($lin=mysqli_fetch_row($res)){
                            $codigo = $lin[0];
                            $desc = $lin[1];

                            echo "<option value='$codigo'>$desc</option>";
                        }
                    ?>
                </select>
            </div>
        <br>
            <div class="col-md-2">
                <?php include "inc/botao_consultar.php"; ?>
            </div>
    </div>
<br>
    <div class="row table-responsive" id="rslista">
        <?php include "consorcios/simulador/listadados.php";?>
    </div>
</div>

<script language="JavaScript">
function consultar(pg) {
    Buscar(document.getElementById('pesquisacredito').value, document.getElementById('pesquizaprazo').value, pg);
}
</script>