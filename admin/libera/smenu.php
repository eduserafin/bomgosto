<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<?php

require_once '../../cabecalho_frames.php';

$ant = "../../";



if ($modulo != 0) { $v_modulo = " AND tipo_menu = $modulo"; }

?>



<html>

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    </head>

    <body>

    

    <label>SUBMENU:</label> 

    <select size="1" name="CDSMENU" id="CDSMENU" class="form-control" style="background:#E0FFFF;"

                onchange="javascript: carrega_usuarios();">">

            <option selected value=0>Selecione um sub-menu</option>

            <?php

            $SQL = "SELECT distinct(nr_sequencial), ds_smenu

  FROM g_smenus 

 WHERE nr_seq_menu = $menu

 $v_modulo

  ORDER BY ds_smenu";



            $RSS = mysqli_query($conexao, $SQL);

            while ($linha = mysqli_fetch_row($RSS)) {

                $cdgomenu = $linha[0];

                $descmenu = $linha[1];

                if ($CDSMENU == $cdgomenu) {

                    $selecionado = "selected";

                } else {

                    $selecionado = "";

                }

                echo "<option $selecionado value=$cdgomenu>" . ($descmenu) . "</option>";

            }

            ?> 

        </select>

</body>

</html>