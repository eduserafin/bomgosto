<body onLoad="document.getElementById('txtnome').focus();">
<input type="hidden" name="cd_user" id="cd_user" value="">
<div class="form-group col-md-12">
    <div class="row">
        <?php include "inc/botao_novo.php"; ?>
        <?php include "inc/botao_salvar.php"; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
                    <label for="txtnome">Nome:</label>                    
                    <input type="text" name="txtnome" id="txtnome" size="15" maxlength="70" class="form-control"></td>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
                    <label for="txtlogin">Login:</label>                    
                    <input type="text" name="txtlogin" id="txtlogin" size="15" maxlength="14" class="form-control"></td>
    </div>
    <div class="col-md-3">        
                    <label for="password">Senha:</label>
                    <input type="password" name="txtsenha" id="txtsenha" size="20" maxlength="32" class="form-control"></td>
    </div>
    <div class="col-md-3">
                    <label>E-mail:</label>
                    <input type="text" name="txtemail" id="txtemail" size="15" maxlength="60" class="form-control"></td>
    </div>
</div>

</body>
<script type="text/javascript">
function executafuncao(id){
  if (id=='new'){
    document.getElementById('cd_user').value = "";
    document.getElementById('txtlogin').value = "";
    document.getElementById('txtnome').value = "";
    document.getElementById('txtsenha').value = "";
    document.getElementById('txtemail').value = "";
    document.getElementById('txtnome').focus();
  }
  else if (id=="save"){  
    var codigo = document.getElementById('cd_user').value;
    var login = document.getElementById('txtlogin').value;
    var nome = document.getElementById('txtnome').value;
    var senha = document.getElementById('txtsenha').value;
    var email = document.getElementById('txtemail').value;
    
    if (nome != '') {
        nome = nome.replace("'", "");
    }
    if (senha != '') {
        senha = senha.replace("'", "");
    }
    if (login != '') {
        login = login.replace("'", "");
    }

    if (login == '') {
        alert('Informe o login!');
        document.getElementById('clifor').focus();
    } else if (nome == '') {
        alert('Informe o usu�rio!');
        document.getElementById('txtnome').focus();
    } else {
        if (codigo == '') {
            Tipo = "I"
        } else {
            Tipo = "A";
        }

        window.open('admin/usuario/acao.php?Tipo=' + Tipo + '&codigo=' + codigo + '&nome=' + nome + '&senha=' + senha + '&login=' + login + '&email=' + email, "acao");
    }
  }
}
</script>