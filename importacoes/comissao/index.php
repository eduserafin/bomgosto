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

<iframe name="acao" class="importacao-frame"></iframe>

<ul class="nav nav-tabs importacao-tabs" id="myTab">
    <li class="active">
        <a id="tabgeral" href="#geral" data-toggle="tab">📂 IMPORTAÇÃO</a>
    </li>
</ul>

<form method="POST" enctype="multipart/form-data" action="importacoes/comissao/importacao.php" target="acao" class="importacao-form">
    <div class="importacao-row">
        <div class="importacao-col">
            <label for="seladministradora">Administradora</label>
            <select class="importacao-input" name="seladministradora" id="seladministradora" required>
                <option value="">Selecione...</option>
                <?php
                    $sel = "SELECT nr_sequencial, ds_administradora 
                            FROM administradoras 
                            WHERE st_status = 'A' 
                            AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . " 
                            ORDER BY ds_administradora";
                    $res = mysqli_query($conexao, $sel);
                    while($lin = mysqli_fetch_row($res)){
                        echo "<option value=$lin[0]>$lin[1]</option>";
                    }
                ?>
            </select>
        </div>
    </div>

    <div class="importacao-row">
        <div class="importacao-col">
            <label for="arquivo">Arquivo PDF</label>
            <input type="file" class="importacao-input" name="arquivo" id="arquivo" accept="application/pdf" required>
        </div>
    </div>

    <div class="importacao-row">
        <button type="submit" name="btimportar" id="btimportar" class="importacao-btn">
            <span class="glyphicon glyphicon-open"></span> Importar
        </button>
    </div>
</form>
