<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<div class="col-md-12">
    <div class="row">
        <legend>Pesquisar por</legend>
            <div class="col-md-2">
                    <label for="equipamento">Equipamento:</label>                    
                    <select id="equipamento" class="form-control">
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
                    <label for="nome">Cliente:</label>
                    <input type="text" name="nome" id="nome" size="20" maxlength="50" class="form-control"></td>
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
        <?php include "equipamentos/listadados.php";?>
    </div>
</div>

<script language="JavaScript">
function consultar(pg) {
    Buscar(document.getElementById('equipamento').value, document.getElementById('data').value, document.getElementById('nome').value, pg);
}
</script>