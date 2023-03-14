<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<select class="form-control" name="menu" id="menu" style="background:#E0FFFF;">
    <option selected value=0>Selecione um menu</option>
	<?php
    $SQL = "SELECT distinct(nr_sequencial), ds_menu
        FROM g_menus 
        ORDER BY ds_menu";
                 
    $RSS = mysqli_query($conexao, $SQL);
    while ($LINHA = mysqli_fetch_row($RSS)){
        $cdgomenu = $LINHA[0];
        $descmenu = $LINHA[1];
        if ($menu == $cdgomenu) { $selecionado = "selected"; } else { $selecionado = ""; }
        echo "<option $selecionado value=$cdgomenu>" . ($descmenu) . "</option>";
    }
    ?> 
</select>
</body>
</html>