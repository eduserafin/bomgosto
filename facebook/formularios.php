<?php
foreach($_GET as $key => $value){
    $$key = $value;
}

$consulta = isset($_GET["consulta"]) ? $_GET["consulta"] : "";
$pagina = isset($_GET["pagina"]) ? intval($_GET["pagina"]) : 0; // sanitiza aqui

if ($consulta == "sim") {
    $ant = "../";
    require_once $ant.'conexao.php';
}
?>

<label for="pesquisaformulario">Formulários:</label>                     
<select id="pesquisaformulario">
    <option value='0'>Selecione um formulário</option>
    <?php
        $sql = "SELECT nr_sequencial, ds_formulario 
                FROM fb_formularios
                WHERE nr_seq_pagina = $pagina";
        $res = mysqli_query($conexao, $sql);
        while($lin=mysqli_fetch_row($res)){
            $cdg = $lin[0];
            $desc = $lin[1];
            echo "<option value='$cdg'>$desc</option>";
        }
    ?>
</select>
