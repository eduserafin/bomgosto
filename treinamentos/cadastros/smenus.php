<?php
foreach($_GET as $key => $value){
    $$key = $value;
}

$consulta = isset($_GET["consulta"]) ? $_GET["consulta"] : "";
$menu = isset($_GET["menu"]) ? $_GET["menu"] : "";

if ($consulta == "sim") {
    $ant = "../../";
    require_once $ant.'conexao.php';
}

?>

<label for="txtsmenu">SUB-MENU:</label>                     
<select id="txtsmenu" class="form-control" style="background:#E0FFFF;">
    <option value='0'>Selecione um smenus</option>
    <?php
        $sql = "SELECT nr_sequencial, ds_smenu
                FROM submenus
                WHERE nr_seq_menu = $menu
                ORDER BY ds_smenu";
        $res = mysqli_query($conexao, $sql);
        while($lin=mysqli_fetch_row($res)){
            $cdg = $lin[0];
            $desc = $lin[1];

            if($smenus == $cdg){
                $sel = 'selected';
            } else {
                $sel = '';
            }
           
            echo "<option value='$cdg' $sel>$desc</option>";
        }
    ?>
</select>
