<body onLoad="document.getElementById('txtnome').focus();">
<input type="hidden" name="cd_user" id="cd_user" value="">
<div class="form-group col-md-12">
    <div class="row">
        <?php include "inc/botao_novo.php"; ?>
        <?php include "inc/botao_salvar.php"; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <label for="txtnome">COLABORADOR:</label>                     
            <select id="txtnome" class="form-control" style="background:#E0FFFF;">
                <option value='0'>Selecione um colaborador</option>
                <?php
                    $sql = "SELECT nr_sequencial, ds_colaborador
                            FROM colaboradores
                            WHERE st_status = 'A'
                            AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "
                            ORDER BY ds_colaborador";
                    $res = mysqli_query($conexao, $sql);
                    while($lin=mysqli_fetch_row($res)){
                        $cdg = $lin[0];
                        $desc = $lin[1];

                        echo "<option value='$cdg'>$desc</option>";
                    }
                ?>
            </select>
    </div>
    <div class="col-md-3">
        <label for="txtadmin">PERFIL:</label>
        <select class="form-control" name="txtadmin" id="txtadmin" style="background:#E0FFFF;">
            <option value="G">Gerente</option>
            <option value="C">Colaborador</option>
        </select>
    </div>
    <div class="col-md-3">
        <label for="txtstatus">STATUS:</label>
        <select class="form-control" name="txtstatus" id="txtstatus" style="background:#E0FFFF;">
            <option value="A">ATIVO</option>
            <option value="I">INATIVO</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <label for="txtlogin">LOGIN:</label>                    
        <input type="text" name="txtlogin" id="txtlogin" size="15" maxlength="14" class="form-control" style="background:#E0FFFF;">
    </div>
    <div class="col-md-3">        
        <label for="password">SENHA:</label>
        <input type="password" name="txtsenha" id="txtsenha" size="20" maxlength="32" class="form-control" style="background:#E0FFFF;">
    </div>
    <div class="col-md-4">
        <label>E-MAIL:</label>
        <input type="text" name="txtemail" id="txtemail" size="15" maxlength="60" class="form-control" style="background:#E0FFFF;">
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
    document.getElementById('txtadmin').value = "S";
    document.getElementById('txtstatus').value = "A";
    document.getElementById('txtnome').focus();
  }
  else if (id=="save"){  
    var codigo = document.getElementById('cd_user').value;
    var login = document.getElementById('txtlogin').value;
    var colaborador = document.getElementById('txtnome').value;
    var senha = document.getElementById('txtsenha').value;
    var email = document.getElementById('txtemail').value;
    var admin = document.getElementById('txtadmin').value;
    var status = document.getElementById('txtstatus').value;
    
    if (senha != '') {
        senha = senha.replace("'", "");
    }
    if (login != '') {
        login = login.replace("'", "");
    }

    if (login == '') {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Informe o Login!'
        });
        document.getElementById('txtlogin').focus();
    } else if (senha == '') {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Informe a Senha!'
        });
        document.getElementById('txtsenha').focus();
    } else if (colaborador == 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Selecione um colaborador'
        });
        document.getElementById('txtnome').focus();
    } else {
        if (codigo == '') {
            Tipo = "I"
        } else {
            Tipo = "A";
        }
        window.open('admin/usuario/acao.php?Tipo=' + Tipo + '&codigo=' + codigo + '&colaborador=' + colaborador + '&senha=' + senha + '&login=' + login + '&email=' + email + '&admin=' + admin + '&status=' + status, "acao");
    }
  }
}

</script>