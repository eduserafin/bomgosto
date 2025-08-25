<?php
foreach($_GET as $key => $value){
    $$key = $value;
}

$consulta = isset($_GET["consulta"]) ? $_GET["consulta"] : "";
$empresa = isset($_GET["empresa"]) ? $_GET["empresa"] : "";
$editar = isset($_GET["editar"]) ? $_GET["editar"] : "";
$quantidade = isset($_GET["quantidade"]) ? $_GET["quantidade"] : "";

if ($consulta == "sim") {
    $ant = "../../";
    require_once $ant.'conexao.php';
}

?>

<label>USUÁRIOS:</label>

<div style="background:#E0FFFF; padding: 10px; border-radius: 5px; max-height: 300px; overflow-y: auto;">
    <?php
        $sql = "SELECT u.nr_sequencial, c.ds_colaborador
                FROM colaboradores c
                INNER JOIN usuarios u ON u.nr_seq_colaborador = c.nr_sequencial
                WHERE u.st_status = 'A'
                AND u.nr_seq_empresa = $empresa
                ORDER BY c.ds_colaborador";
        $res = mysqli_query($conexao, $sql);
        while($lin = mysqli_fetch_row($res)){
            $cdg = $lin[0];
            $desc = $lin[1];

            $checked = "";

            if ($editar == 'S') {
                $check_sql = "SELECT 1 FROM assinaturas_usuarios WHERE nr_seq_usuario = $cdg LIMIT 1";
                $check_res = mysqli_query($conexao, $check_sql);
                if (mysqli_num_rows($check_res) > 0) {
                    $checked = "checked";
                }
            }

            echo "<div style='margin-bottom:5px;'>
                    <label>
                        <input type='checkbox' name='usuario[]' value='$cdg' $checked> $desc
                    </label>
                  </div>";
        }
    ?>
</div>


