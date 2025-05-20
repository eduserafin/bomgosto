<body onLoad="document.getElementById('txtnome').focus();">
<input type="hidden" name="cd_colab" id="cd_colab" value="">
<div class="form-group col-md-12">
    <div class="row">
        <?php include "inc/botao_novo.php"; ?>
        <?php include "inc/botao_salvar.php"; ?>
    </div>
</div>
    <div class="row">
        <div class="col-md-4">
            <label>NOME: <font color='red'>*</font></label>
            <input type="text" name="txtnome" id="txtnome" size="10" maxlength="25" style="background:#E6FFE0;" value="<?php echo $txtrg; ?>" class="form-control">
        </div>
        <div class="col-md-2">
            <label>SEXO: <font color='red'>*</font></label>
            <?php include $ant . "inc/sexo.php"; ?>
        </div>
        <div class="col-md-2">
            <label>DATA ADMISSÃO: <font color='red'>*</font></label>
            <input type="date" name="txtdataadm" id="txtdataadm" value="<?php echo $txtdataadm; ?>" style="background:#E0FFFF;" class="form-control">
        </div>
        <div class="col-md-2">
            <label>CPF: <font color='red'>*</font></label>
            <input type="text" name="txcpf" id="txcpf" size="10" maxlength="25" style="background:#E6FFE0;" value="<?php echo $txtrg; ?>" class="form-control">
        </div>
        <div class="col-md-2">
            <label>RG: <font color='red'>*</font></label>
            <input type="text" name="txtrg" id="txtrg" size="10" maxlength="25" style="background:#E6FFE0;" value="<?php echo $txtrg; ?>" class="form-control">
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <label>ORGÃO EMISSOR RG:</label>
            <input type="text" name="txtorgaorg" id="txtorgaorg" size="10" maxlength="5" value="<?php echo $txtorgaorg; ?>" class="form-control">
        </div>
        <div class="col-md-2">
            <label>UF RG:</label>
            <select size="1" name="txtufrg" id="txtufrg" class="form-control">
                <option selected value=0>Selecione...</option>
                <?php
                    $SQL = "SELECT cd_estado, sg_estado
                            FROM estado
                            ORDER BY sg_estado";
                    $RES = mysqli_query($conexao, $SQL);
                    while($lin=mysqli_fetch_row($RES)){
                        $nr_cdgo = $lin[0];
                        $sg_uf = $lin[1];
                        echo "<option value=$nr_cdgo>$sg_uf</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <label>EXPEDIÇÃO RG:</label>
            <input type="date" name="txtdatarg" id="txtdatarg" value="<?php echo $txtdatarg; ?>" class="form-control">
        </div>
        <div class="col-md-2">
            <label>NACIONALIDADE:</label>
            <input type="text" name="txtnacionalidade" id="txtnacionalidade" maxlength="60" value="<?php echo $txtnacionalidade; ?>" class="form-control">
        </div>
        <div class="col-md-4">
            <label>LOCAL DE NASCIMENTO:</label>
            <input type="text" name="txtlocalnascimento" id="txtlocalnascimento" maxlength="200" value="<?php echo $txtlocalnascimento; ?>" class="form-control">
        </div>
        <div class="col-md-4">
            <label>GRAU DE ESCOLARIDADE:</label>
            <input type="text" name="txtgrauescolaridade" id="txtgrauescolaridade" maxlength="60" value="<?php echo $txtgrauescolaridade; ?>" class="form-control">
        </div>
        <div class="col-md-2">
            <label>ESTADO CIVIL:</label>
            <input type="text" name="txtestadocivil" id="txtestadocivil" maxlength="60" value="<?php echo $txtestadocivil; ?>" class="form-control">
        </div>
        <div class="col-md-2">
            <label>DATA NASCIMENTO:</label>
            <input type="date" name="txtdatanasc" id="txtdatanasc" value="<?php echo $txtdatanasc; ?>" class="form-control">
        </div>
        <div class="col-md-2">
            <label>DATA DEMISSÃO:</label>
            <input type="date" name="txtdatadem" id="txtdatadem" value="<?php echo $txtdatadem; ?>" class="form-control">
        </div>
        <div class="col-md-2">
            <label for="txtstatus">STATUS: <font color='red'>*</font></label>
            <select class="form-control" name="txtstatus" id="txtstatus" style="background:#E0FFFF;">
                <option value="A">ATIVO</option>
                <option value="I">INATIVO</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>FUNÇÃO: <font color='red'>*</font></label>
            <select size="1" name="selfuncao" id="selfuncao" class="form-control" style="background:#E0FFFF;">
                <option selected value=0>Selecione...</option>
                <?php
                    $SQL = "SELECT nr_sequencial, ds_funcao
                            FROM funcoes
                            ORDER BY ds_funcao";
                    $RES = mysqli_query($conexao, $SQL);
                    while($lin=mysqli_fetch_row($RES)){
                        $nr_cdgo = $lin[0];
                        $ds_desc = $lin[1];
                        echo "<option value=$nr_cdgo>$ds_desc</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <label>TELEFONE: <font color='red'>*</font></label> 
            <input type="text" name="txttelefone" id="txttelefone" maxlength="20" value="<?php echo $txttelefone; ?>" class="form-control" style="background:#E6FFE0;">
        </div>
        <div class="col-md-4">
            <label>E-MAIL: <font color='red'>*</font></label>
            <input type="text" name="txtemail" id="txtemail" size="40" maxlength="60" value="<?php echo $txtemail; ?>" class="form-control" style="background:#E6FFE0;">
        </div>
    </div>

    <br>

    <div id="msgexibe" class="alert alert-info fade in alert-dismissable" >
        <span class="glyphicon glyphicon-pencil"></span> ENDEREÇO
    </div>

    <div class="row">
        <div class="col-md-3">
            <label>ENDEREÇO:</label>
            <input type="text" name="txtendereco" id="txtendereco" maxlength="200" value="<?php echo $txtendereco; ?>" class="form-control">
        </div>
        <div class="col-md-1">
            <label>N. END:</label>
            <input type="text" name="txtnrendereco" id="txtnrendereco" maxlength="10" value="<?php echo $txtnrendereco; ?>" class="form-control">
        </div>
        <div class="col-md-4">
            <label>BAIRRO:</label>
            <input type="text" name="txtbairro" id="txtbairro" maxlength="60" value="<?php echo $txtbairro; ?>" class="form-control">
        </div>
        <div class="col-md-4">
            <label>COMPLEMENTO:</label>
            <input type="text" name="txtdscomplemento" id="txtdscomplemento" maxlength="60" value="<?php echo $txtdscomplemento; ?>" class="form-control">
        </div>
        <div class="col-md-1">
            <label>UF:</label>
            <select size="1" name="seluf" id="seluf" class="form-control" onChange="javascript: BuscarCidades(document.getElementById('seluf').value, '');">
                <option selected value=0>Selecione...</option>
                <?php
                    $SQL = "SELECT cd_estado, sg_estado
                            FROM estado
                            ORDER BY sg_estado";
                    $RES = mysqli_query($conexao, $SQL);
                    while($lin=mysqli_fetch_row($RES)){
                        $nr_cdgo = $lin[0];
                        $sg_uf = $lin[1];
                        echo "<option value=$nr_cdgo>$sg_uf</option>";
                    }
                ?>
            </select>
        </div>

        <div class="col-md-3">
            <div class="row" id="rscidades">
                <?php include "cidades.php"; ?>
            </div>
        </div>

        <div class="col-md-2">
            <label>CEP:</label>
            <input type="text" name="txtcep" id="txtcep" maxlength="8" value="<?php echo $txtcep; ?>" class="form-control">
        </div>
    </div>

    <br>

    <div id="msgexibe" class="alert alert-info fade in alert-dismissable">
        <span class="glyphicon glyphicon-pencil"></span>FILIAÇÃO
    </div>
        
    <div class="row">
        <div class="col-md-6">
            <label>NOME DA MÃE:</label>
            <input type="text" name="txtnomemae" id="txtnomemae" maxlength="40" class="form-control" value="<?php echo $txtnomemae; ?>">
        </div>
        <div class="col-md-6">
            <label>NOME DO PAI:</label>
            <input type="text" name="txtnomepai" id="txtnomepai" maxlength="40" class="form-control" value="<?php echo $txtnomepai; ?>">
        </div>
    </div>

    <br>

    <div id="msgexibe" class="alert alert-info fade in alert-dismissable">
        <span class="glyphicon glyphicon-pencil"></span>PARÂMETROS
    </div>

    <div class="row">
        <div class="col-md-2">
            <label>COMISSÃO:</label>
            <input type="number" name="txtcomissao" id="txtcomissao" maxlength="10" class="form-control" value="<?php echo $txtcomissao; ?>">
        </div>
    </div>

</body>

<script type="text/javascript">

    function limparTexto(texto) {
        return texto.replace(/[^a-zA-Z0-9\s]/g, '');
    }

    function executafuncao(id){

        if (id=='new'){
            document.getElementById('cd_colab').value = "";
            document.getElementById('txtnome').value = "";
            document.getElementById('txcpf').value = "";
            document.getElementById('txtrg').value = "";
            document.getElementById('txtorgaorg').value = "";
            document.getElementById('txtufrg').value = "0";
            document.getElementById('txtdatarg').value = "";
            document.getElementById('txtgrauescolaridade').value = "";
            document.getElementById('txtnacionalidade').value = "";
            document.getElementById('txtlocalnascimento').value = "";
            document.getElementById('txtestadocivil').value = "";
            document.getElementById('sexo').value = "M";
            document.getElementById('txttelefone').value = "";
            document.getElementById('txtdataadm').value = "";
            document.getElementById('txtdatadem').value = "";
            document.getElementById('txtdatanasc').value = "";
            document.getElementById('txtemail').value = "";
            document.getElementById('txtendereco').value = "";
            document.getElementById('txtnrendereco').value = "";
            document.getElementById('txtbairro').value = "";
            document.getElementById('txtdscomplemento').value = "";
            document.getElementById('seluf').value = "0";
            document.getElementById('selcidade').value = "0";
            document.getElementById('txtcep').value = "";
            document.getElementById('txtnomemae').value = "";
            document.getElementById('txtnomepai').value = "";
            document.getElementById('txtcomissao').value = "";
            document.getElementById('txtstatus').value = "A";
            document.getElementById('selfuncao').value = "0";
            document.getElementById('txtnome').focus();
        }
        else if (id=="save"){  
            var codigo = document.getElementById('cd_colab').value;
            var nome = limparTexto(document.getElementById('txtnome').value);
            var cpf = limparTexto(document.getElementById('txcpf').value);
            var rg = limparTexto(document.getElementById('txtrg').value);
            var orgaorg = limparTexto(document.getElementById('txtorgaorg').value);
            var ufrg = document.getElementById('txtufrg').value;
            var datarg = document.getElementById('txtdatarg').value;
            var escolaridade = limparTexto(document.getElementById('txtgrauescolaridade').value);
            var nacionalidade = limparTexto(document.getElementById('txtnacionalidade').value);
            var local = limparTexto(document.getElementById('txtlocalnascimento').value);
            var civil = limparTexto(document.getElementById('txtestadocivil').value);
            var sexo = document.getElementById('sexo').value;
            var telefone = limparTexto(document.getElementById('txttelefone').value);
            var dataadm = document.getElementById('txtdataadm').value;
            var datadem = document.getElementById('txtdatadem').value;
            var datanasc = document.getElementById('txtdatanasc').value;
            var email = limparTexto(document.getElementById('txtemail').value);
            var endereco = limparTexto(document.getElementById('txtendereco').value);
            var nrendereco = limparTexto(document.getElementById('txtnrendereco').value);
            var bairro = limparTexto(document.getElementById('txtbairro').value);
            var complemento = limparTexto(document.getElementById('txtdscomplemento').value);
            var uf = document.getElementById('seluf').value;
            var cidade = document.getElementById('selcidade').value;
            var cep = limparTexto(document.getElementById('txtcep').value);
            var nomemae = limparTexto(document.getElementById('txtnomemae').value);
            var nomepai = limparTexto(document.getElementById('txtnomepai').value);
            var comissao = document.getElementById('txtcomissao').value;
            var status = document.getElementById('txtstatus').value;
            var funcao = document.getElementById('selfuncao').value;
            
            if (nome == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o nome do colaborador!'
                });
                document.getElementById('txtnome').focus();
            } 
            else if (sexo == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o sexo do colaborador!'
                });
                document.getElementById('sexo').focus();
            }
            else if (dataadm == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a data de admissão do colaborador!'
                });
                document.getElementById('txtdataadm').focus();
            }
            else if (cpf == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o CPF do colaborador!'
                });
                document.getElementById('txcpf').focus();
            }
            else if (rg == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o RG do colaborador!'
                });
                document.getElementById('txtrg').focus();
            }
            else if (funcao == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe uma função!'
                });
                document.getElementById('selfuncao').focus();
            }
            else if (email == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe um e-mail!'
                });
                document.getElementById('txtemail').focus();
            }
            else if (telefone == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe um número de contato!'
                });
                document.getElementById('txttelefone').focus();
            } else {
                if (codigo == '') {
                    Tipo = "I"
                } else {
                    Tipo = "A";
                }

                window.open('cadastros/colaboradores/acao.php?' + 'Tipo=' + Tipo + '&codigo=' + codigo + '&nome=' + nome + '&cpf=' + cpf + '&rg=' + rg + '&orgaorg=' + orgaorg + '&ufrg=' + ufrg + '&datarg=' + datarg + '&escolaridade=' + escolaridade + '&nacionalidade=' + nacionalidade + '&local=' + local + '&civil=' + civil + '&sexo=' + sexo + '&telefone=' + telefone + '&dataadm=' + dataadm + '&datadem=' + datadem + '&datanasc=' + datanasc + '&email=' + email + '&endereco=' + endereco + '&nrendereco=' + nrendereco + '&bairro=' + bairro + '&complemento=' + complemento + '&uf=' + uf + '&cidade=' + cidade + '&cep=' + cep + '&nomemae=' + nomemae + '&nomepai=' + nomepai + '&comissao=' + comissao + '&status=' + status + '&funcao=' + funcao, "acao");

            }
        }
    }
</script>