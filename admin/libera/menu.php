<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<div class="row">

    <div class="col-md-4 table-responsive">

    <label>MENU:</label> 

    <select size="1" name="CDMENU" id="CDMENU" class="form-control" style="background:#E0FFFF;"

                onchange="javascript: busca_smenu(document.getElementById('CDMENU').value, document.getElementById('CDMODULO').value);">">

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

    </div>

    

    <div class="col-md-4 table-responsive">

      <label>M&Oacute;DULO:</label> 

      <select size="1" name="CDMODULO" id="CDMODULO" class="form-control" style="background:#E0FFFF;"

              onchange="javascript: busca_smenu(document.getElementById('CDMENU').value, document.getElementById('CDMODULO').value);">">

            <option selected value=0>Selecione um m&oacute;dulo</option>

            <option value=1>GERAL</option>

            <option value=2>MOVIMENTOS</option>

            <option value=3>RELAT&Oacute;RIOS</option>

            

        </select>

    </div>

    

    <div class="col-md-4 table-responsive" id="rssmenu">



    </div>

</div>

<div class="row">

    <div class="col-md-12">

        <table class="table table-responsive">

            <tr>

                <td width="25%" align="center"><input type="button" class="btn btn-primary" name="btremovetodos" id="btremovetodos" value="<<" onClick="javascript: deltodosUser();"></td>

                <td width="25%" align="center"><input type="button" class="btn btn-primary" name="btremoveselecionados" id="btremoveselecionados" value="<" onClick="javascript: delselecionadosUser();"></td>

                <td width="25%" align="center"><input type="button" class="btn btn-primary" name="btaddselecionados" id="btaddselecionados" value=">" onClick="javascript: addselecionadosUser();"></td>

                <td width="25%" align="center"><input type="button" class="btn btn-primary" name="btaddtodos" id="btaddtodos" value=">>" onClick="javascript: addtodosUser();"></td>

            </tr>

            <tr>

            <table class="table table-responsive">

                <tr>

                    <td width="50%">

                        <fieldset><legend><strong>Dispon&iacute;veis</strong></legend>

                            <iframe width="100%" src="admin/libera/usuariosdisponiveis.php" height="410" name="usuariosdisponiveis" id="usuariosdisponiveis" frameborder="0" marginheight="0" marginwidth="0" scrolling="yes"></iframe>

                        </fieldset>

                    </td>

                    <td width="50%">

                        <fieldset><legend><strong>Liberados</strong></legend>

                            <iframe width="100%" src="admin/libera/usuariosliberados.php" height="410" name="usuariosliberados" id="usuariosliberados" frameborder="0" marginheight="0" marginwidth="0" scrolling="yes"></iframe>

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

            

    function addselecionadosUser() {

        var cd_menu = document.getElementById('CDMENU').value;

        var cd_modulo = document.getElementById('CDMODULO').value;

        var cd_smenu = document.getElementById('CDSMENU').value;



        if (cd_smenu == 0) {

            alert('Selecione um submenu.');

        } else {

            var texto = "";

            var total = window.frames['usuariosdisponiveis'].totusuarios.value;



            for (k = 1; k <= total; k++) {

                checkbox = window.frames['usuariosdisponiveis'].document.getElementById('CHKUSUARIO' + k);



                if (checkbox.checked) {

                    texto = texto + window.frames['usuariosdisponiveis'].document.getElementById('CDUSUARIO' + k).value + ",";

                }

            }



            if (texto == '') {

                alert('Selecione um usuario para adicionar.');

            } else {

                window.open('admin/libera/acao.php?Tipo=11&cd_smenu=' + cd_smenu + '&texto=' + texto + '&cd_menu=' + cd_menu + '&cd_modulo=' + cd_modulo, "acao");

            }

        }

    }





    function delselecionadosUser() {

        var cd_menu = document.getElementById('CDMENU').value;

        var cd_modulo = document.getElementById('CDMODULO').value;

        var cd_smenu = document.getElementById('CDSMENU').value;

         

        if (cd_smenu == 0) {

            alert('Selecione um sub-menu.');

            document.getElementById('CDSMENU').focus();

        } else {

            var texto = "";

            

            var total = window.frames['usuariosliberados'].document.getElementById('totusuarios').value;

            

            for (k = 1; k <= total; k++) {

                checkbox = window.frames['usuariosliberados'].document.getElementById('CHKUSUARIO' + k);



                if (checkbox.checked) {

                    texto = texto + window.frames['usuariosliberados'].document.getElementById('CDUSUARIO' + k).value + ",";

                }

            }



            if (texto == "") {

                alert('Selecione um usuario para excluir.');

            } else {

                window.open('admin/libera/acao.php?Tipo=22&cd_smenu=' + cd_smenu + '&texto=' + texto + '&cd_menu=' + cd_menu + '&cd_modulo=' + cd_modulo, "acao");

            } 

        }     

    }



    function addtodosUser() {

        var cd_menu = document.getElementById('CDMENU').value;

        var cd_modulo = document.getElementById('CDMODULO').value;

        var cd_smenu = document.getElementById('CDSMENU').value;



        if (cd_smenu == 0) {

            alert('Selecione um sub-menu.');

            document.getElementById('CDSMENU').focus();

        } else {

            window.open('admin/libera/acao.php?Tipo=33&cd_smenu=' + cd_smenu + '&cd_menu=' + cd_menu + '&cd_modulo=' + cd_modulo, "acao");

        }

    }



    function deltodosUser() {

        var cd_menu = document.getElementById('CDMENU').value;

        var cd_modulo = document.getElementById('CDMODULO').value;

        var cd_smenu = document.getElementById('CDSMENU').value;



        if (cd_smenu == 0) {

            alert('Selecione um sub-menu.');

            document.getElementById('CDSMENU').focus();

        } else {

            window.open('admin/libera/acao.php?Tipo=44&cd_smenu=' + cd_smenu + '&cd_menu=' + cd_menu + '&cd_modulo=' + cd_modulo, "acao");

        }

    }

      

    function carrega_usuarios() {

        var cd_menu = document.getElementById('CDMENU').value;

        var cd_modulo = document.getElementById('CDMODULO').value;

        var cd_smenu = document.getElementById('CDSMENU').value;

        

        if (cd_smenu == '') {

            alert('Selecione um sub-menu.');

        } else {

            window.open('admin/libera/usuariosliberados.php?CDSMENU=' + cd_smenu + '&CDMENU=' + cd_menu + '&CDMODULO=' + cd_modulo, 'usuariosliberados');

            window.open('admin/libera/usuariosdisponiveis.php?CDSMENU=' + cd_smenu + '&CDMENU=' + cd_menu + '&CDMODULO=' + cd_modulo, 'usuariosdisponiveis');

        }

    } 

     function carrega_usuarios2() {

        var cd_menu = document.getElementById('CDMENU').value;

        var cd_modulo = document.getElementById('CDMODULO').value;

        var cd_smenu = document.getElementById('CDSMENU').value;



        if (cd_usuario == '') {

            alert('Selecione um usu�rio.');

        } else {

            window.open('usuariosliberados.php?CDSMENU=' + cd_smenu + '&CDMENU=' + cd_menu + '&CDMODULO=' + cd_modulo, 'usuariosliberados');

            window.open('usuariosdisponiveis.php?CDSMENU=' + cd_smenu + '&CDMENU=' + cd_menu + '&CDMODULO=' + cd_modulo, 'usuariosdisponiveis');

        }

    } 

</script>