<?php
    foreach($_GET as $key => $value){
        $$key = $value;
    }
    
    $dataFinal = date('Y-m-d');
    
    $dataInicial = date('Y-m-d', strtotime('-6 days'));
?>

<div class="row-100">
    <div class="row">
        <div class="col-md-3">
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
            <label for="pesquisacategoria">CATEGORIA:</label>
            <select class="form-control" name="pesquisacategoria" id="pesquisacategoria">
                <option value="">Todas</option>
                <option value="I">Ideia</option>
                <option value="C">Correção</option>
                <option value="O">Solicitação</option>
                <option value="S">Suporte</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="pesquisaprioridade">PRIORIDADE:</label>
            <select class="form-control" name="pesquisaprioridade" id="pesquisaprioridade">
                <option value="">Todas</option>
                <option value="A">Alta</option>
                <option value="M">Média</option>
                <option value="B">Baixa</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="pesquisastatus">STATUS:</label>
            <select class="form-control" name="pesquisastatus" id="pesquisastatus">
                <option value="">Todas</option>
                <option value="A">Aberto</option>
                <option value="E">Em Andamento</option>
                <option value="P">Parado</option>
                <option value="C">Concluído</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="pesquisatitulo">TÍTULO:</label>                  
            <input type="text" name="pesquisatitulo" id="pesquisatitulo" size="15" maxlength="50" class="form-control" Placeholder="Descreva">
        </div>
        <div class="col-md-4 form-inline">
            <label for="pesquisadata">PERÍODO:</label>
            <input type="date" class="form-control" id="pesquisabertura" size="10" maxlength="10" value="<?php echo $dataInicial; ?>">
            <input type="date" class="form-control" id="pesquisafechamento" size="10" maxlength="10" value="<?php echo $dataFinal; ?>">
        </div>
        <div class="col-md-1"><br>
            <?php include "inc/botao_consultar.php"; ?>
        </div>
    </div>

    <?php include "inc/aguarde.php"; ?>

    <div class="row table-responsive" id="rslista">
        <?php include "chamados/chamados/listadados.php";?>
    </div>
</div>

<script language="JavaScript">

    function consultar(pg) {
        Buscar( document.getElementById('pesquisaempresa').value,
                document.getElementById('pesquisacategoria').value,
                document.getElementById('pesquisaprioridade').value,
                document.getElementById('pesquisastatus').value,
                document.getElementById('pesquisatitulo').value,
                document.getElementById('pesquisabertura').value,
                document.getElementById('pesquisafechamento').value,
                pg);
    }

    function excel() {
        var empresa = window.document.getElementById('pesquisaempresa').value;
        var categoria = window.document.getElementById('pesquisacategoria').value;
        var prioridade = window.document.getElementById('pesquisaprioridade').value;
        var status = window.document.getElementById('pesquisastatus').value;
        var titulo = window.document.getElementById('pesquisatitulo').value;
        var abertura = window.document.getElementById('pesquisabertura').value;
        var fechamento = window.document.getElementById('pesquisafechamento').value;
        
        document.getElementById('dvAguarde').style.display = 'block';
        window.open('chamados/chamados/excel.php?empresa=' + empresa + '&categoria=' + categoria + '&prioridade=' + prioridade + '&status=' + status + '&titulo=' + titulo + '&abertura=' + abertura + '&fechamento=' + fechamento, 'acao');
    } 

</script>