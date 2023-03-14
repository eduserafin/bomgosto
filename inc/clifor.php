<select size="1" name="clifor" id="clifor" style="background:#E0FFFF;" class="form-control">
    <option selected value=0>Selecione um clifor</option>
    <?php
    $SQL = "SELECT distinct(nr_sequencial), ds_colaborador
        FROM g_clifor 
        ORDER BY ds_colaborador";

    $RSS = pg_query($conexao, $SQL);
    while ($LINHA = pg_fetch_row($RSS)) {
        $cdgoclifor = $LINHA[0];
        $descclifor = $LINHA[1];
        if ($clifor == $cdgoclifor) {
            $selecionado = "selected";
        } else {
            $selecionado = "";
        }
        echo "<option $selecionado value='$cdgoclifor'>" . ($descclifor) . "</option>";
    }
    ?> 
</select>