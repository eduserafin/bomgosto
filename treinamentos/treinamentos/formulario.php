

<?php

foreach($_GET as $key => $value){
	$$key = $value;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Treinamentos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f9fb;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 100%;
            margin: auto;
            padding: 20px;
        }
        .menu-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        .menu-card:hover {
            transform: scale(1.01);
        }
        .menu-title {
            display: flex;
            align-items: center;
            font-size: 1.6rem;
            color: #333;
            margin-bottom: 10px;
        }
        .menu-title i {
            margin-right: 10px;
            color: #007bff;
        }
        .submenu-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 10px;
        }
        .submenu-link {
            background: #007bff;
            color: #fff;
            text-decoration: none;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
            transition: background 0.2s;
            font-size: 1.4rem;
        }
        .submenu-link:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Treinamentos disponíveis</h2>

        <?php
        $SQL0 = "SELECT DISTINCT(menus.nr_sequencial), menus.ds_menu, menus.ic_menu
                FROM menus_user
                INNER JOIN submenus ON menus_user.nr_seq_smenu = submenus.nr_sequencial
                INNER JOIN menus ON submenus.nr_seq_menu = menus.nr_sequencial
                WHERE menus_user.st_liberado = 'S'
                AND menus_user.nr_seq_user = " . $_SESSION["CD_USUARIO"] . "
                ORDER BY menus.ds_menu ASC";
        //echo "<pre>$SQL0</pre>";
        $RSS0 = mysqli_query($conexao, $SQL0);
        while ($RS0 = mysqli_fetch_array($RSS0)) {
            $nr_menu = $RS0[0];
            $ds_menu = $RS0[1];
            $ic_menu = $RS0[2];
        ?>

        <div class="menu-card">
            <div class="menu-title">
                <i class="<?php echo $ic_menu; ?>"></i>
                <?php echo $ds_menu; ?>
            </div>
            <div class="submenu-list">
                <?php
                $SQL1 = "SELECT submenus.nr_sequencial, submenus.ds_smenu, submenus.lk_smenu, submenus.ic_smenu
                        FROM menus_user
                        INNER JOIN submenus ON menus_user.nr_seq_smenu = submenus.nr_sequencial
                        WHERE menus_user.st_liberado = 'S'
                        AND submenus.tp_perfil = 'N'
                        AND menus_user.nr_seq_user = " . $_SESSION["CD_USUARIO"] . "
                        AND submenus.nr_seq_menu = " . $nr_menu . "
                        ORDER BY submenus.ds_smenu ASC";
                //echo "<pre>$SQL1</pre>";
                $RSS1 = mysqli_query($conexao, $SQL1);
                while ($RS1 = mysqli_fetch_array($RSS1)) {
                    $nr_smenu = $RS1[0];
                    $ds_smenu = $RS1[1];
                    $lk_smenu = $RS1[2];
                    $ic_smenu = $RS1[3];
                ?>
                   <a href="javascript:void(0);" 
                        onclick="AbrirModal('treinamentos/treinamentos/lista.php?id_menu=<?php echo $nr_menu; ?>&id_smenu=<?php echo $nr_smenu; ?>');"
                        class="submenu-link">
                            <i class="<?php echo $ic_smenu; ?>"></i> <?php echo $ds_smenu; ?>
                    </a>
                <?php } ?>
            </div>
        </div>

        <?php } ?>

    </div>

</body>
</html>
