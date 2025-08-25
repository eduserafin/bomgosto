<?php
foreach($_GET as $key => $value){
    $$key = $value;
}

if ($consulta == "sim") {
    require_once '../conexao.php';
    $ant = "../";


    if ($_GET['pg'] < 0){
        $pg = 0;
        echo "<script>document.getElementById('pgatual').value=1;</script>";
    } else if ($_GET['pg'] !== 0) {
        $pg = $_GET['pg'];
    } else {
        $pg = 0;
    }
    
    $porpagina = 15;
    $inicio = $pg * $porpagina;
    
    $v_sql = "";
    
    $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 0;
    if ($pagina != 0) {
        $v_sql .= " AND nr_seq_pagina = $pagina";
    }
    
    $formulario = isset($_GET['formulario']) ? intval($_GET['formulario']) : 0;
    if ($formulario != 0) {
        $v_sql .= " AND nr_seq_formulario = $formulario";
    }
    
    $data1 = isset($_GET['data1']) ? $_GET['data1'] : "";
    if ($data1 != "") {
        $v_sql .= " AND dt_cadastro >= '$data1'";
    }
    
    $data2 = isset($_GET['data2']) ? $_GET['data2'] : "";
    if ($data2 != "") {
        $v_sql .= " AND dt_cadastro <= '$data2'";
    }
    
    function formatarTelefone($numero) {
        // Remove tudo que não é número
        $numero = preg_replace('/\D/', '', $numero);
    
        // Remove o 55 do início se existir
        if (substr($numero, 0, 2) === '55') {
            $numero = substr($numero, 2);
        }
    
        // Se tiver 11 dígitos: 9 dígitos + DDD
        if (strlen($numero) === 11) {
            return sprintf("(%s) %s-%s",
                substr($numero, 0, 2),
                substr($numero, 2, 5),
                substr($numero, 7, 4)
            );
        }
        // Se tiver 10 dígitos: 8 dígitos + DDD
        elseif (strlen($numero) === 10) {
            return sprintf("(%s) %s-%s",
                substr($numero, 0, 2),
                substr($numero, 2, 4),
                substr($numero, 6, 4)
            );
        }
        // Se tiver 9 dígitos (sem DDD): celular
        elseif (strlen($numero) === 9) {
            return sprintf("%s-%s",
                substr($numero, 0, 5),
                substr($numero, 5, 4)
            );
        }
        // Se tiver 8 dígitos (sem DDD): fixo
        elseif (strlen($numero) === 8) {
            return sprintf("%s-%s",
                substr($numero, 0, 4),
                substr($numero, 4, 4)
            );
        }
        // Caso não caiba em nenhum caso acima, retorna como está
        return $numero;
    }
    
    ?>
    
    <style>
    .fb-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        font-family: 'Segoe UI', sans-serif;
    }
    
    .fb-table th, .fb-table td {
        padding: 12px 15px;
        text-align: left;
        font-size: 14px;
    }
    
    .fb-table th {
        background: #1877f2;
        color: #fff;
        font-weight: 600;
    }
    
    .fb-table tr:nth-child(even) {
        background: #f9f9f9;
    }
    
    .fb-table tr:hover {
        background: #eef3fc;
    }
    
    .fb-table-container {
        width: 100%;
        overflow-x: auto;
    }
    </style>
    
    <div class="fb-table-container">
        <table class="fb-table">
            <thead>
                <tr>
                    <th>NOME</th>
                    <th>TELEFONE</th>
                    <th>EMAIL</th>
                    <th>DATA</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $SQL = "SELECT nr_sequencial, ds_nome, dt_cadastro, nr_telefone, ds_email
                        FROM lead 
                        WHERE nr_seq_usercadastro = " . $_SESSION["CD_USUARIO"] . " 
                        "  . $v_sql . "
                        ORDER BY nr_sequencial DESC LIMIT $porpagina OFFSET $inicio";
    
                $RSS = mysqli_query($conexao, $SQL);
                while ($linha = mysqli_fetch_row($RSS)) {
                    $nr_sequencial = $linha[0];
                    $ds_nome = htmlspecialchars($linha[1]);
                    $dt_cadastro = date('d/m/Y', strtotime($linha[2]));
                    $contato = formatarTelefone($linha[3]);
                    $ds_email = htmlspecialchars($linha[4]);
                    ?>
                    <tr>
                        <td><?= $ds_nome ?></td>
                        <td><?= $contato ?></td>
                        <td><?= $ds_email ?></td>
                        <td><?= $dt_cadastro ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    
    <?php include $ant . "inc/paginacao.php"; ?>
<?php } ?>

<script>
window.parent.document.getElementById('dvAguarde').style.display = 'none';
</script>
