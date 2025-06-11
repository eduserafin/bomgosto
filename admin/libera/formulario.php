<?php
foreach($_GET as $key => $value){
	$$key = $value;
}

$menu = '';
$codigo = '';
?>

<style>
    .action-btn {
        font-weight: bold;
        font-size: 16px;
        border-radius: 4px;
        transition: background 0.3s ease;
    }

    .action-btn:hover {
        background-color: #f5f5f5;
    }

    .custom-card {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border-radius: 4px;
        overflow: hidden;
    }

     /* Estilo base moderno */
     .btn-modern {
        font-weight: bold;
        font-size: 16px;
        border-radius: 6px;
        padding: 10px 18px;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Cores específicas */
    .btn-remove-all {
        background-color: #d9534f;
        border-color: #d43f3a;
        color: white;
    }

    .btn-remove-selected {
        background-color: #f0ad4e;
        border-color: #eea236;
        color: white;
    }

    .btn-add-selected {
        background-color: #5bc0de;
        border-color: #46b8da;
        color: white;
    }

    .btn-add-all {
        background-color: #5cb85c;
        border-color: #4cae4c;
        color: white;
    }

    /* Efeito hover */
    .btn-modern:hover {
        opacity: 0.9;
        transform: scale(1.05);
    }
</style>

<input type="hidden" name="cd_usuario" id="cd_usuario" value="<?php echo $codigo; ?>">
<div class="row">
    <div class="col-md-4">
        <label>USU&Aacute;RIO:</label>
        <input type="text" name="txtusuario" id="txtusuario" disabled class="form-control">
    </div>
    <div class="col-md-4">
            <label>CLIFOR:</label>
            <input type="text" name="txtnome" id="txtnome" size="45" disabled class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <label>MENU:</label> 
        <select size="1" name="menu" id="menu" class="form-control" style="background:#E0FFFF;"
                onchange="javascript: carrega_menus();">">
            <option selected value=0>Selecione um menu</option>
            <?php
                $SQL = "SELECT distinct(nr_sequencial), ds_menu
                        FROM menus 
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
    </div>
    <div class="col-md-4">
        <label>M&Oacute;DULO:</label> 
        <select size="1" name="modulo" id="modulo" class="form-control" style="background:#E0FFFF;" onchange="javascript: carrega_menus();">">
            <option selected value=0>Selecione um m&oacute;dulo</option>
            <option value=1>GERAL</option>
            <option value="2">MOVIMENTOS</option>
            <option value="3">RELATÓRIOS</option>   
        </select>
    </div> 
</div> 

<div class="row">
    <div class="col-md-12">
        <table class="table table-responsive">
            <tr>
                <td width="25%" align="center">
                    <input type="button" class="btn btn-modern btn-remove-all" name="btremovetodos" id="btremovetodos" value="<<" onClick="javascript: deltodos();">
                </td>
                <td width="25%" align="center">
                    <input type="button" class="btn btn-modern btn-remove-selected" name="btremoveselecionados" id="btremoveselecionados" value="<" onClick="javascript: delselecionados();">
                </td>
                <td width="25%" align="center">
                    <input type="button" class="btn btn-modern btn-add-selected" name="btaddselecionados" id="btaddselecionados" value=">" onClick="javascript: addselecionados();">
                </td>
                <td width="25%" align="center">
                    <input type="button" class="btn btn-modern btn-add-all" name="btaddtodos" id="btaddtodos" value=">>" onClick="javascript: addtodos();">
                </td>
            </tr>
        </table>
       
        <div class="col-md-12">
            <div class="col-sm-6">
                <div class="panel panel-default custom-card">
                    <div class="panel-heading text-center"><strong>DISPONÍVEIS</strong></div>
                    <div class="panel-body" style="padding: 0;">
                        <iframe width="100%" src="admin/libera/submenusdisponiveis.php" height="410" name="smenudisponiveis" id="smenudisponiveis" frameborder="0" marginheight="0" marginwidth="0" scrolling="yes"></iframe>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default custom-card">
                    <div class="panel-heading text-center"><strong>LIBERADOS</strong></div>
                    <div class="panel-body" style="padding: 0;">
                        <iframe width="100%" src="admin/libera/submenusliberados.php" height="410" name="smenuliberados" id="smenuliberados" frameborder="0" marginheight="0" marginwidth="0" scrolling="yes"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<script language="JavaScript">

    function addselecionados() {
        var cd_usuario = document.getElementById('cd_usuario').value;
        var cd_menu = document.getElementById('menu').value;
        var cd_modulo = document.getElementById('modulo').value;

        if (cd_usuario == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Selecione um usuario!'
            });
        } else if (cd_menu == 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Selecione um menu!'
            });
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
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Selecione um submenu para adicionar!'
                });
            } else {
                window.open('admin/libera/acao.php?Tipo=1&cd_usuario=' + cd_usuario + '&texto=' + texto + '&cd_menu=' + cd_menu + '&cd_modulo=' + cd_modulo, "acao");
            }
        }
    }



    function delselecionados() {
        var cd_usuario = document.getElementById('cd_usuario').value;
        var cd_menu = document.getElementById('menu').value;
        var cd_modulo = document.getElementById('modulo').value;

        if (cd_usuario == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Selecione um usuario!'
            });
        } else if (cd_menu == 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Selecione um menu!'
            });
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

            if (texto == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Selecione um submenu para adicionar!'
                });
            } else {
                window.open('admin/libera/acao.php?Tipo=2&cd_usuario=' + cd_usuario + '&texto=' + texto + '&cd_menu=' + cd_menu + '&cd_modulo=' + cd_modulo, "acao");
            }
        }
    }

    function addtodos() {
        var cd_usuario = document.getElementById('cd_usuario').value;
        var cd_menu = document.getElementById('menu').value;
        var cd_modulo = document.getElementById('modulo').value;

        if (cd_usuario == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Selecione um usuario!'
            });
        } else if (cd_menu == 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Selecione um menu!'
            });
            document.getElementById('menu').focus();
        } else {
            window.open('admin/libera/acao.php?Tipo=3&cd_usuario=' + cd_usuario + '&cd_menu=' + cd_menu + '&cd_modulo=' + cd_modulo, "acao");
        }
    }

    function deltodos() {
        var cd_usuario = document.getElementById('cd_usuario').value;
        var cd_menu = document.getElementById('menu').value;
        var cd_modulo = document.getElementById('modulo').value;

        if (cd_usuario == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Selecione um usuario!'
            });
        } else if (cd_menu == 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Selecione um menu!'
            });
            document.getElementById('menu').focus();
        } else {
            window.open('admin/libera/acao.php?Tipo=4&cd_usuario=' + cd_usuario + '&cd_menu=' + cd_menu + '&cd_modulo=' + cd_modulo, "acao");
        }
    }

    function carrega_menus() {
        var cd_usuario = document.getElementById('cd_usuario').value;
        var cd_menu = document.getElementById('menu').value;
        var cd_modulo = document.getElementById('modulo').value;

        if (cd_usuario == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Selecione um usuario!'
            });
        } else {
            window.open('admin/libera/submenusliberados.php?codigo=' + cd_menu + '&cd_usuario=' + cd_usuario + '&cd_modulo=' + cd_modulo, 'smenuliberados');
            window.open('admin/libera/submenusdisponiveis.php?codigo=' + cd_menu + '&cd_usuario=' + cd_usuario + '&cd_modulo=' + cd_modulo, 'smenudisponiveis');
        }
    }
     function carrega_menus2() {
        var cd_usuario = document.getElementById('cd_usuario').value;
        var cd_menu = document.getElementById('menu').value;
        var cd_modulo = document.getElementById('modulo').value;

        if (cd_usuario == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Selecione um usuario!'
            });
        } else {
            window.open('submenusliberados.php?codigo=' + cd_menu + '&cd_usuario=' + cd_usuario + '&cd_modulo=' + cd_modulo, 'smenuliberados');
            window.open('submenusdisponiveis.php?codigo=' + cd_menu + '&cd_usuario=' + cd_usuario + '&cd_modulo=' + cd_modulo, 'smenudisponiveis');
        }
    }
</script>