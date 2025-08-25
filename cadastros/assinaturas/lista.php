<?php
    foreach($_GET as $key => $value){
        $$key = $value;
    }
?>

<div class="row-100">
    <div class="row">
        <div class="col-md-2">
            <label for="pesquisaempresa">EMPRESA:</label>                     
                <select id="pesquisaempresa" class="form-control">
                    <option value='0'>Selecione uma empresa</option>
                    <?php
                        $sql = "SELECT nr_sequencial, ds_empresa
                                FROM empresas
                                WHERE st_status = 'A'
                                ORDER BY ds_empresa";
                        $res = mysqli_query($conexao, $sql);
                        while($lin=mysqli_fetch_row($res)){
                            $cdg = $lin[0];
                            $desc = $lin[1];

                            echo "<option value='$cdg'>$desc</option>";
                        }
                    ?>
                </select>
        </div>
        <div class="col-md-2">
            <label for="pesquisastatus">STATUS:</label>
            <select class="form-control" name="pesquisastatus" id="pesquisastatus">
                <option value="">Todos</option>
                <option value="A">Ativo</option>
                <option value="I">Inativo</option>
                <option value="P">Pendente</option>
                <option value="C">Cancelado</option>
                <option value="T">Teste</option>
            </select>
        </div>
        <div class="col-md-4 form-inline">
            <label for="pesquisadata">PERÍODO:</label>
            <input type="date" class="form-control" id="pesquisadatai" size="10" maxlength="10">
            <input type="date" class="form-control" id="pesquisadataf" size="10" maxlength="10">
        </div>
        <div class="col-md-1"><br>
            <?php include "inc/botao_consultar.php"; ?>
        </div>
    </div>

    <?php include "inc/aguarde.php"; ?>

    <div class="row table-responsive" id="rslista">
        <?php include "cadastros/assinaturas/listadados.php";?>
    </div>
</div>

<script language="JavaScript">

    function consultar(pg) {
        Buscar( document.getElementById('pesquisaempresa').value,
                document.getElementById('pesquisastatus').value,
                document.getElementById('pesquisadatai').value,
                document.getElementById('pesquisadataf').value,
                pg);
    }

    function excel() {
        var empresa = window.document.getElementById('pesquisaempresa').value;
        var status = window.document.getElementById('pesquisastatus').value;
        var datai = window.document.getElementById('pesquisadatai').value;
        var dataf = window.document.getElementById('pesquisadataf').value;
        
        document.getElementById('dvAguarde').style.display = 'block';
        window.open('cadastros/assinaturas/excel.php?status=' + status + '&datai=' + datai + '&dataf=' + dataf + '&empresa=' + empresa, 'acao');
    } 

</script>