<?php
    if($_SESSION["ST_ADMIN"] == 'G'){
      $v_filtro_empresa = "AND nr_sequencial = " . $_SESSION["CD_EMPRESA"] . "";
    } else if ($_SESSION["ST_ADMIN"] == 'C') {
      $v_filtro_empresa = "AND nr_sequencial = " . $_SESSION["CD_EMPRESA"] . "";
    } else {
      $v_filtro_empresa = "";
    }
?>

<body onLoad="document.getElementById('txtnome').focus();">
    <input type="hidden" name="cd_colab" id="cd_colab" value="">
    <div class="form-group col-md-12">
        <div class="row">
            <?php include "inc/botao_novo.php"; ?>
            <?php include "inc/botao_salvar.php"; ?>
            <?php include "inc/botao_excluir.php"; ?>
        </div>
    </div>
    <div class="row">
         <div class="col-md-3">
            <label>NOME: <font color='red'>*</font></label>
            <input type="text" name="txtnome" id="txtnome" size="10" maxlength="25" style="background:#E6FFE0;" value="<?php echo $txtrg; ?>" class="form-control">
        </div>
        <div class="col-md-3">
            <label for="txtempresa">EMPRESA: <font color='red'>*</font></label>                     
            <select id="txtempresa" class="form-control" style="background:#E0FFFF;">
                <option value='0'>Selecione uma empresa</option>
                <?php
                    $sql = "SELECT nr_sequencial, ds_empresa
                            FROM empresas
                            WHERE st_status = 'A'
                            $v_filtro_empresa
                            ORDER BY ds_empresa";
                    $res = mysqli_query($conexao, $sql);
                    while($lin=mysqli_fetch_row($res)){
                        $cdg = $lin[0];
                        $desc = $lin[1];

                        echo "<option value=$cdg>$desc</option>";

                    }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <label>SEXO: <font color='red'>*</font></label>
            <select size="1" name="sexo" id="sexo" class="form-control" style="background:#E0FFFF;">
                <option selected value=0>Selecione...</option>
            	<option value="M">Masculino</option>
                <option value="F">Feminino</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>FUNÇÃO: <font color='red'>*</font></label>
            <select size="1" name="selfuncao" id="selfuncao" class="form-control" style="background:#E0FFFF;">
                <option selected value=0>Selecione...</option>
                <?php
                    $SQL = "SELECT nr_sequencial, ds_funcao
                            FROM funcoes
                            WHERE st_status = 'A'
                            AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . " 
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
    </div>
    
    <div class="row">
        <div class="col-md-2">
            <label>CPF: <font color='red'>*</font></label>
            <input type="text" name="txcpf" id="txcpf" size="10" maxlength="25" style="background:#E6FFE0;" value="<?php echo $txtrg; ?>" class="form-control">
        </div>
        <div class="col-md-2">
            <label>RG: <font color='red'>*</font></label>
            <input type="text" name="txtrg" id="txtrg" size="10" maxlength="25" style="background:#E6FFE0;" value="<?php echo $txtrg; ?>" class="form-control">
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

    <div class="row">
        
        <div class="col-md-2">
            <label>DATA ADMISSÃO: <font color='red'>*</font></label>
            <input type="date" name="txtdataadm" id="txtdataadm" value="<?php echo $txtdataadm; ?>" style="background:#E0FFFF;" class="form-control">
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
        <div class="col-md-2">
            <label>N. END:</label>
            <input type="text" name="txtnrendereco" id="txtnrendereco" maxlength="10" value="<?php echo $txtnrendereco; ?>" class="form-control">
        </div>
        <div class="col-md-3">
            <label>BAIRRO:</label>
            <input type="text" name="txtbairro" id="txtbairro" maxlength="60" value="<?php echo $txtbairro; ?>" class="form-control">
        </div>
        <div class="col-md-3">
            <label>COMPLEMENTO:</label>
            <input type="text" name="txtdscomplemento" id="txtdscomplemento" maxlength="60" value="<?php echo $txtdscomplemento; ?>" class="form-control">
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <label>UF:</label>
            <select size="1" name="seluf" id="seluf" class="form-control" onChange="javascript: BuscarCidades(document.getElementById('seluf').value, '');">
                <option selected value=0>Selecione...</option>
                <?php
                    $SQL = "SELECT nr_sequencial, sg_estado
                            FROM estados
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
        <div class="col-md-3" id="rscidades">
            <?php include "cidades.php"; ?>
        </div>
        <div class="col-md-2">
            <label>CEP:</label>
            <input type="text" name="txtcep" id="txtcep" maxlength="8" value="<?php echo $txtcep; ?>" class="form-control">
        </div>
    </div>
</body>

<script type="text/javascript">

    /* $(document).ready(function() {
        $('#selfuncao').select2();
    }); */

    function limparTexto(texto) {
        return texto.replace(/[^\p{L}\p{N}\s]/gu, '');
    }

    function executafuncao(id){

        if (id=='new'){
            document.getElementById('cd_colab').value = "";
            document.getElementById('txtempresa').value = "0";
            document.getElementById('txtnome').value = "";
            document.getElementById('sexo').value = "0";
            document.getElementById('txcpf').value = "";
            document.getElementById('txtrg').value = "";
            document.getElementById('selfuncao').value = "0";
            document.getElementById('txtdataadm').value = "";
            document.getElementById('txtdatadem').value = "";
            document.getElementById('txtstatus').value = "A";
            document.getElementById('txttelefone').value = "";
            document.getElementById('txtemail').value = "";
            document.getElementById('txtendereco').value = "";
            document.getElementById('txtnrendereco').value = "";
            document.getElementById('txtbairro').value = "";
            document.getElementById('txtdscomplemento').value = "";
            document.getElementById('seluf').value = "0";
            document.getElementById('selcidade').value = "0";
            document.getElementById('txtcep').value = "";
            document.getElementById('txtnome').focus();
        }
        else if (id=="save"){  
            var codigo = document.getElementById('cd_colab').value;
            var empresa = document.getElementById('txtempresa').value;
            var nome = limparTexto(document.getElementById('txtnome').value);
            var sexo = document.getElementById('sexo').value;
            var cpf = limparTexto(document.getElementById('txcpf').value);
            var rg = limparTexto(document.getElementById('txtrg').value);
            var funcao = document.getElementById('selfuncao').value;
            var dataadm = document.getElementById('txtdataadm').value;
            var datadem = document.getElementById('txtdatadem').value;
            var status = document.getElementById('txtstatus').value;
            var telefone = limparTexto(document.getElementById('txttelefone').value);
            var email = document.getElementById('txtemail').value;
            var endereco = limparTexto(document.getElementById('txtendereco').value);
            var nrendereco = limparTexto(document.getElementById('txtnrendereco').value);
            var bairro = limparTexto(document.getElementById('txtbairro').value);
            var complemento = limparTexto(document.getElementById('txtdscomplemento').value);
            var estado = document.getElementById('seluf').value;
            var cidade = document.getElementById('selcidade').value;
            var cep = limparTexto(document.getElementById('txtcep').value);
            
             if (empresa == 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe uma empresa!'
                });
                document.getElementById('txtempresa').focus();
            } 
            else if (nome == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o nome do colaborador!'
                });
                document.getElementById('txtnome').focus();
            } 
            else if (sexo == 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o sexo do colaborador!'
                });
                document.getElementById('sexo').focus();
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
            else if (dataadm == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a data de admissão do colaborador!'
                });
                document.getElementById('txtdataadm').focus();
            }
            else if (telefone == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe um número de contato!'
                });
                document.getElementById('txttelefone').focus();
            }
            else if (email == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe um e-mail!'
                });
                document.getElementById('txtemail').focus();
            }
            else {
                if (codigo == '') {
                    Tipo = "I"
                } else {
                    Tipo = "A";
                }

                window.open('cadastros/colaboradores/acao.php?' + 'Tipo=' + Tipo + '&codigo=' + codigo + '&nome=' + nome + '&cpf=' + cpf + '&rg=' + rg + '&funcao=' + funcao + '&dataadm=' + dataadm + '&datadem=' + datadem + '&status=' + status + '&telefone=' + telefone + '&email=' + email + '&endereco=' + endereco + '&nrendereco=' + nrendereco + '&bairro=' + bairro + '&complemento=' + complemento + '&estado=' + estado + '&cidade=' + cidade + '&cep=' + cep + '&empresa=' + empresa + '&sexo=' + sexo, "acao");

            }
        } else if (id == "delete") {

            var codigo = document.getElementById('cd_colab').value;

            if(codigo==''){  

                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Selecione um registro para realizar a exclusão!'
                }); 

            } else {

                Swal.fire({
                    title: 'Deseja excluir o registro selecionado?',
                    text: "Não tem como reverter esta ação!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, excluir!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        
                        window.open("cadastros/colaboradores/acao.php?Tipo=E&codigo="+codigo, "acao");

                    } else {

                        return false;

                    }
                });

            }
        }
    }
</script>