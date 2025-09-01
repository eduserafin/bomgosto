<style>
    /* Frame invisível para upload */
    .importacao-frame {
        width: 0;
        height: 0;
        border: none;
        display: none;
    }

    /* Navegação por abas */
    .importacao-tabs {
        border-bottom: 2px solid #ddd;
        margin-bottom: 20px;
    }

    .importacao-tabs > li > a {
        color: #555;
        font-weight: 600;
        padding: 10px 20px;
        border: none;
        border-radius: 4px 4px 0 0;
        background-color: #f3f4f6;
        transition: all 0.3s ease;
    }

    .importacao-tabs > li.active > a,
    .importacao-tabs > li > a:hover {
        background-color: #fff;
        color: #0d6efd; /* cor azul do bootstrap */
        border-bottom: 2px solid transparent;
    }

    /* Formulário */
    .importacao-form {
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0px 4px 12px rgba(0,0,0,0.08);
        max-width: 500px;
        margin-top: 10px;
    }

    /* Linhas e colunas */
    .importacao-row {
        margin-bottom: 18px;
        display: flex;
        flex-direction: column;
    }
    .importacao-col label {
        font-weight: 600;
        margin-bottom: 8px;
        color: #444;
    }

    /* Inputs */
    .importacao-input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s;
    }
    .importacao-input:focus {
        border-color: #28a745;
        outline: none;
        box-shadow: 0px 0px 6px rgba(40,167,69,0.2);
    }

    /* Botão */
    .importacao-btn {
        background: #28a745;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    .importacao-btn:hover {
        background: #218838;
    }
</style>

<?php

    if($_SESSION["ST_ADMIN"] == 'G'){
        $v_filtro_empresa = "AND nr_sequencial = " . $_SESSION["CD_EMPRESA"] . "";
    } else if ($_SESSION["ST_ADMIN"] == 'C') {
        $v_filtro_empresa = "AND nr_sequencial = " . $_SESSION["CD_EMPRESA"] . "";
    } else {
        $v_filtro_empresa = "";
    }

?>

<iframe name="acao" class="importacao-frame"></iframe>

<ul class="nav nav-tabs importacao-tabs" id="myTab">
    <li class="active">
        <a id="tabgeral" href="#geral" data-toggle="tab">📂 IMPORTAÇÃO</a>
    </li>
</ul>

<form method="POST" enctype="multipart/form-data" action="importacoes/leads/importacao.php" target="acao" class="importacao-form">
    <div class="importacao-row">
        <div class="importacao-col">
            <label for="selempresa">Empresa</font></label>                     
            <select class="importacao-input" name="selempresa" id="selempresa" required>
                <option value='0'>Selecione uma empresa</option>
                <?php
                    $sql = "SELECT nr_sequencial, ds_empresa
                            FROM empresas
                            WHERE st_status = 'A'
                            $v_filtro_empresa
                            ORDER BY ds_empresa";
                    $res = mysqli_query($conexao, $sql);
                    while($lin=mysqli_fetch_row($res)){
                        $cdg = $lin[0];
                        $desc = $lin[1];

                        echo "<option value=$cdg>$desc</option>";

                    }
                ?>
            </select>
        </div>
    </div>

    <div class="importacao-row">
        <div class="importacao-col">
            <label for="arquivo">Arquivo Excel (.xlsx)</label>
            <input type="file" class="importacao-input" name="arquivo" id="arquivo" 
                accept=".xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
        </div>
    </div>


    <div class="importacao-row">
        <button type="submit" name="btimportar" id="btimportar" class="importacao-btn">
            <span class="glyphicon glyphicon-open"></span> Importar
        </button>
    </div>
</form>
