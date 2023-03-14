<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<body onLoad="document.getElementById('menu').focus();">
<input type="hidden" name="cd_smenu" id="cd_smenu" value="<?php echo $codigo; ?>">

<div class="form-group col-md-12">
    <div class="row">
        <?php include "inc/botao_novo.php"; ?>
        <?php include "inc/botao_salvar.php"; ?>
        <?php include "inc/botao_excluir.php"; ?>
    </div>
</div>


    <div class="row">
      <div class="col-md-12">
                        <label for="menu">MENU:</label>
                        <?php include "inc/menus.php"; ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
                        <label for="txtnome">DESCRI&Ccedil;&Atilde;O:</label>
                        <input type="text" class="form-control" name="txtnome" id="txtnome" size="45" maxlength="60" style="background:#E0FFFF;">
      </div>
      <div class="col-md-6">
                        <label for="txtlink">LINK:</label>
                        <input type="text" class="form-control" name="txtlink" id="txtlink" size="50" maxlength="50" style="background:#E0FFFF;">
      </div>  
    </div>
    <div class="row">
      <div class="col-md-6">
                        <label for="txticone">&Iacute;CONE:</label>
                        <input type="text" class="form-control" name="txticone" id="txticone" size="15" maxlength="25" style="background:#E0FFFF;">
      </div>
      <div class="col-md-6">
                        <label for="modulo">M&Oacute;DULO:</label>
                        <select class="form-control" name="modulo" id="modulo">
                            <option selected value="0">Selecione</option>
                            <option value="1">GERAL</option>
                            <option value="2">MOVIMENTOS</option>
                            <option value="3">RELATÓRIOS</option>
                        </select>
      </div>
    </div>

</body>

<script language="JavaScript">
    function executafuncao(id) {
        if (id == "new") {
            document.getElementById("cd_smenu").value = "";
            document.getElementById("txtnome").value = "";
            document.getElementById("txtlink").value = "";
            document.getElementById("txticone").value = "";
            document.getElementById("modulo").value = 0;
            document.getElementById("menu").value = 0;
            document.getElementById('menu').focus();
        } else if (id == 'save') {
            
            var codigo = document.getElementById("cd_smenu").value;
            var nome = document.getElementById("txtnome").value;
            nome = nome.replace("'", "");
            var link = document.getElementById("txtlink").value;
            link = link.replace("'", "");
            var icone = document.getElementById("txticone").value;
            icone = icone.replace("'", "");
            var modulo = document.getElementById("modulo").value;
            var menu = document.getElementById("menu").value;

            if (menu == 0) {
                alert("Selecione um menu!");
                document.getElementById("menu").focus();
            } else if (nome == "") {
                alert("Informe o nome do sub-menu!");
                document.getElementById("txtnome").focus();
            } else if (link == "") {
                alert("Informe o link de acesso!");
                document.getElementById("txtlink").focus();
            } else if (icone == "") {
                alert("Informe o icone do sub-menu!");
                document.getElementById("txticone").focus();
            } else {
                if (codigo == "") {
                    Tipo = "I"
                } else {
                    Tipo = "A";
                }

                window.open("admin/smenus/acao.php?Tipo=" + Tipo + "&codigo=" + codigo + "&nome=" + nome + "&link=" + link + "&icone=" + icone + "&menu=" + menu + "&modulo=" + modulo, "acao");
            }
        }
        else if (id=="delete"){
          if (document.getElementById('cd_smenu').value == "")
          {
              alert('Para efetuar a exclus?o ? necess?rio selecionar um registro primeiro');
              return;
          }
          if (!confirm("Deseja excluir o registro selecionado?")) {
              return false;
          } else
          {
              var codigo = document.getElementById('cd_smenu').value;
              window.open('admin/smenus/acao.php?Tipo=E&codigo=' + codigo, 'acao');
          }
        }
    }
</script>