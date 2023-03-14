<?php
foreach($_GET as $key => $value){
	$$key = $value;
}

$menu = '';
$codigo = '';
?>

<input type="hidden" name="cd_usuario" id="cd_usuario" value="<?php echo $codigo; ?>">
<table class="table table-responsive">
    <tr>
    <td>
    <label>USU&Aacute;RIO:</label>
    <input type="text" name="txtusuario" id="txtusuario" disabled class="form-control">
    </td>
    <td>
    <label>CLIFOR:</label>
    <input type="text" name="txtnome" id="txtnome" size="45" disabled class="form-control">
    </td>
</tr>
<tr>
    <td>
    <label>MENU:</label> 
    <select size="1" name="menu" id="menu" class="form-control" style="background:#E0FFFF;"
                onchange="javascript: carrega_menus();">">
            <option selected value=0>Selecione um menu</option>
            <?php
            $SQL = "SELECT distinct(nr_sequencial), ds_menu
  FROM g_menus 
  ORDER BY ds_menu";

            $RSS = mysqli_query($conexao, $SQL);
            while ($linha = mysqli_fetch_row($RSS)) {
                $cdgomenu = $linha[0];
                $descmenu = $linha[1];
                if ($menu == $cdgomenu) {
                    $selecionado = "selected";
                } else {
                    $selecionado = "";
                }
                echo "<option $selecionado value=$cdgomenu>" . ($descmenu) . "</option>";
            }
            ?> 
        </select>
    </td>
    <td>
    <label>M&Oacute;DULO:</label> 
    <select size="1" name="modulo" id="modulo" class="form-control" style="background:#E0FFFF;"
                onchange="javascript: carrega_menus();">">
            <option selected value=0>Selecione um m&oacute;dulo</option>
            <option value=1>GERAL</option>
            <option value="2">MOVIMENTOS</option>
            <option value="3">RELATÓRIOS</option>
            
        </select>
    </td>
</tr>  
</table>
<div class="row">
    <div class="col-md-12">
        <table class="table table-responsive">
            <tr>
                <td width="25%" align="center"><input type="button" class="btn btn-primary" name="btremovetodos" id="btremovetodos" value="<<" onClick="javascript: deltodos();"></td>
                <td width="25%" align="center"><input type="button" class="btn btn-primary" name="btremoveselecionados" id="btremoveselecionados" value="<" onClick="javascript: delselecionados();"></td>
                <td width="25%" align="center"><input type="button" class="btn btn-primary" name="btaddselecionados" id="btaddselecionados" value=">" onClick="javascript: addselecionados();"></td>
                <td width="25%" align="center"><input type="button" class="btn btn-primary" name="btaddtodos" id="btaddtodos" value=">>" onClick="javascript: addtodos();"></td>
            </tr>
            <tr>
            <table class="table table-responsive">
                <tr>
                    <td width="50%">
                        <fieldset><legend><strong>Dispon&iacute;veis</strong></legend>
                            <iframe width="100%" src="admin/libera/submenusdisponiveis.php" height="410" name="smenudisponiveis" id="smenudisponiveis" frameborder="0" marginheight="0" marginwidth="0" scrolling="yes"></iframe>
                        </fieldset>
                    </td>
                    <td width="50%">
                        <fieldset><legend><strong>Liberados</strong></legend>
                            <iframe width="100%" src="admin/libera/submenusliberados.php" height="410" name="smenuliberados" id="smenuliberados" frameborder="0" marginheight="0" marginwidth="0" scrolling="yes"></iframe>
                        </fieldset>
                    </td>
                </tr>
            </table>
            </tr>
        </table>
    </div>
</div>
</body>
</html>

<script language="JavaScript">

    function addselecionados() {
        var cd_usuario = document.getElementById('cd_usuario').value;
        var cd_menu = document.getElementById('menu').value;
        var cd_modulo = document.getElementById('modulo').value;

        if (cd_usuario == '') {
            alert('Selecione um usuario.');
        } else if (cd_menu == 0) {
            alert('Selecione um menu.');
            document.getElementById('menu').focus();
        } else {
            var texto = "";
            var total = window.frames['smenudisponiveis'].total.value;

            for (k = 1; k <= total; k++) {
                checkbox = window.frames['smenudisponiveis'].document.getElementById('chk' + k);

                if (checkbox.checked) {
                    texto = texto + window.frames['smenudisponiveis'].document.getElementById('cdgo_smenu' + k).value + ",";
                }
            }

            if (texto == '') {
                alert('Selecione um submenu para adicionar.');
            } else {
                window.open('admin/libera/acao.php?Tipo=1&cd_usuario=' + cd_usuario + '&texto=' + texto + '&cd_menu=' + cd_menu + '&cd_modulo=' + cd_modulo, "acao");
            }
        }
    }



    function delselecionados() {
        var cd_usuario = document.getElementById('cd_usuario').value;
        var cd_menu = document.getElementById('menu').value;
        var cd_modulo = document.getElementById('modulo').value;

        if (cd_usuario == '') {
            alert('Selecione um usuario.');
        } else if (cd_menu == 0) {
            alert('Selecione um menu.');
            document.getElementById('menu').focus();
        } else {
            var texto = "";
            var total = window.frames['smenuliberados'].total.value;
            for (k = 1; k <= total; k++) {
                checkbox = window.frames['smenuliberados'].document.getElementById('chk' + k);

                if (checkbox.checked) {
                    texto = texto + window.frames['smenuliberados'].document.getElementById('cdgo_smenu' + k).value + ",";
                }
            }

            if (texto == "") {
                alert('Selecione um submenu para excluir.');
            } else {
                window.open('admin/libera/acao.php?Tipo=2&cd_usuario=' + cd_usuario + '&texto=' + texto + '&cd_menu=' + cd_menu + '&cd_modulo=' + cd_modulo, "acao");
            }
        }
    }

    function addtodos() {
        var cd_usuario = document.getElementById('cd_usuario').value;
        var cd_menu = document.getElementById('menu').value;
        var cd_modulo = document.getElementById('modulo').value;

        if (cd_usuario == '') {
            alert('Selecione um usuario.');
        } else if (cd_menu == 0) {
            alert('Selecione um menu.');
            document.getElementById('menu').focus();
        } else {
            window.open('admin/libera/acao.php?Tipo=3&cd_usuario=' + cd_usuario + '&cd_menu=' + cd_menu + '&cd_modulo=' + cd_modulo, "acao");
        }
    }

    function deltodos() {
        var cd_usuario = document.getElementById('cd_usuario').value;
        var cd_menu = document.getElementById('menu').value;
        var cd_modulo = document.getElementById('modulo').value;

        if (cd_usuario == '') {
            alert('Selecione um usuario.');
        } else if (cd_menu == 0) {
            alert('Selecione um menu.');
            document.getElementById('menu').focus();
        } else {
            window.open('admin/libera/acao.php?Tipo=4&cd_usuario=' + cd_usuario + '&cd_menu=' + cd_menu + '&cd_modulo=' + cd_modulo, "acao");
        }
    }

    function carrega_menus() {
        var cd_usuario = document.getElementById('cd_usuario').value;
        var cd_menu = document.getElementById('menu').value;
        var cd_modulo = document.getElementById('modulo').value;

        if (cd_usuario == '') {
            alert('Selecione um usuário.');
        } else {
            window.open('admin/libera/submenusliberados.php?codigo=' + cd_menu + '&cd_usuario=' + cd_usuario + '&cd_modulo=' + cd_modulo, 'smenuliberados');
            window.open('admin/libera/submenusdisponiveis.php?codigo=' + cd_menu + '&cd_usuario=' + cd_usuario + '&cd_modulo=' + cd_modulo, 'smenudisponiveis');
        }
    }
     function carrega_menus2() {
        var cd_usuario = document.getElementById('cd_usuario').value;
        var cd_menu = document.getElementById('menu').value;
        var cd_modulo = document.getElementById('modulo').value;

        if (cd_usuario == '') {
            alert('Selecione um usuário.');
        } else {
            window.open('submenusliberados.php?codigo=' + cd_menu + '&cd_usuario=' + cd_usuario + '&cd_modulo=' + cd_modulo, 'smenuliberados');
            window.open('submenusdisponiveis.php?codigo=' + cd_menu + '&cd_usuario=' + cd_usuario + '&cd_modulo=' + cd_modulo, 'smenudisponiveis');
        }
    }
</script>