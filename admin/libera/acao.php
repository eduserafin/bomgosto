<?php
foreach($_GET as $key => $value){
	$$key = $value;
}

session_start(); 
include "../../conexao.php";

//=======================	CARREGAR DADOS NO FORMULARIO

if ($Tipo == "D") {
    $SQL = "SELECT nr_sequencial, nr_seq_colaborador
            FROM usuarios u
            WHERE nr_sequencial=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] == $Codigo) {
        echo "<script language='javascript'>window.parent.document.getElementById('cd_usuario').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtusuario').value='" . strtoupper($RS["ds_login"]) . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtnome').value='" . $RS["nr_seq_colaborador"] . "';</script>";
        echo "<script language='javascript'>window.parent.carrega_menus2();</script>";
    }
}

//=======================		INCLUS�O DE MENUS SELECIONADOS

if ($Tipo == "1") {

    while ($texto != "") {

      $cd_submenu = substr($texto, 0, strpos($texto, ","));
      $texto = substr($texto, strpos($texto, ",") + 1, strlen($texto));

      $insert = "INSERT INTO menus_user (nr_seq_smenu, nr_seq_user, st_liberado) 
                  VALUES ($cd_submenu, $cd_usuario, 'S')";
      mysqli_query($conexao, $insert);

    }

    echo "<script language='JavaScript'>
            window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Acessos liberados com sucesso!'
            });
            window.parent.carrega_menus2();
        </script>";

}

//=======================		REMO��O DE MENUS SELECIONADOS

if ($Tipo == "2") {

    while ($texto != "") {

        $cd_submenu = substr($texto, 0, strpos($texto, ","));
        $texto = substr($texto, strpos($texto, ",") + 1, strlen($texto));

        $delete = "DELETE FROM menus_user 
                    WHERE nr_seq_user = " . $cd_usuario . "  
                    AND nr_seq_smenu = " . $cd_submenu;
        mysqli_query($conexao, $delete);
    }

    echo "<script language='JavaScript'>
            window.parent.Swal.fire({
                icon: 'success',
                title: 'Show...',
                text: 'Acessos removidos com sucesso!'
            });
            window.parent.carrega_menus2();
        </script>";

}

//=======================		LIBERA��O DE TODOS OS SUB-MENUS

if ($Tipo == "3") {

    if ($cd_modulo != 0){ $v_tp_menu = "AND tp_smenu=$cd_modulo"; }

    $delete = "DELETE FROM menus_user 
                WHERE nr_seq_user = " . $cd_usuario . " 
                AND nr_seq_smenu IN (SELECT nr_sequencial FROM submenus WHERE nr_seq_menu = " . $cd_menu . " $v_tp_menu)";
    mysqli_query($conexao, $delete);

    $SQL = "SELECT distinct(nr_sequencial) 
            FROM submenus 
            WHERE nr_seq_menu = " . $cd_menu . $v_tp_menu;
    $RSS = mysqli_query($conexao, $SQL);
    while ($linha = mysqli_fetch_row($RSS)) {
        $cd_submenu = $linha[0];

        $insert = "INSERT INTO menus_user (nr_seq_smenu, nr_seq_user, st_liberado) 
                    VALUES ($cd_submenu, $cd_usuario, 'S')";
        mysqli_query($conexao, $insert);

    }

    echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                  icon: 'success',
                  title: 'Show...',
                  text: 'Acessos liberados com sucesso!'
              });
              window.parent.carrega_menus2();
          </script>";

}

//=======================		REMOVER TODOS OS SUB-MENUS

if ($Tipo == "4") {

    if ($cd_modulo != 0){ $v_tp_menu = "AND tp_smenu=$cd_modulo"; }

    $delete = "DELETE FROM menus_user 
              WHERE nr_seq_user=" . $cd_usuario . "
              AND nr_seq_smenu IN (SELECT nr_sequencial FROM submenus WHERE nr_seq_menu = " . $cd_menu . " $v_tp_menu)";
    mysqli_query($conexao, $delete);

    echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                  icon: 'success',
                  title: 'Show...',
                  text: 'Acessos removidos com sucesso!'
              });
              window.parent.carrega_menus2();
          </script>";

}

//=======================		INCLUS�O DE USUARIOS SELECIONADOS

if ($Tipo == "11") {

    while ($texto != "") {

        $cd_usuario = substr($texto, 0, strpos($texto, ","));
        $texto = substr($texto, strpos($texto, ",") + 1, strlen($texto));

        $insert = "INSERT INTO menus_user (nr_seq_smenu, nr_seq_user, st_liberado) 
                    VALUES ($cd_smenu, $cd_usuario, 'S')";
        mysqli_query($conexao, $insert);

    }

    echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                  icon: 'success',
                  title: 'Show...',
                  text: 'Acessos liberados com sucesso!'
              });
              window.parent.carrega_usuarios2();
          </script>";

}

//=======================		REMO��O DE USUÁRIOS SELECIONADOS

if ($Tipo == "22") {

    while ($texto != "") {
      $cd_usuario = substr($texto, 0, strpos($texto, ","));
      $texto = substr($texto, strpos($texto, ",") + 1, strlen($texto));

      $delete = "DELETE FROM menus_user 
                  WHERE nr_seq_user = " . $cd_usuario . "  
                  AND nr_seq_smenu = " . $cd_smenu;
      mysqli_query($conexao, $delete);

    }

    echo "<script language='JavaScript'>
              window.parent.Swal.fire({
                  icon: 'success',
                  title: 'Show...',
                  text: 'Acessos removidos com sucesso!'
              });
              window.parent.carrega_usuarios2();
          </script>";

}

?>