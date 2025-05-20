<?php
foreach($_GET as $key => $value){
	$$key = $value;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
    <body onLoad="document.getElementById('txtcnpj').focus();">
        <input type="hidden" name="cd_empresa" id="cd_empresa">
        <div class="row">
            <div class="col-md-4">
                <?php include "inc/botao_novo.php"; ?>
                <?php include "inc/botao_salvar.php"; ?>
            </div>
            <div class="col-md-6">
                <div id="imporSuccess" style=" opacity:0; visibility: hidden">
                    <div class="alert alert-success" role="alert" style="height: 38px; display: flex; align-items: center;">
                        Dados importados do SEFAZ, clique em SALVAR para finalizar o cadastro
                    </div>
                </div>
            </div>
        </div>
        <div class="row-100">
            <div class="row">
                <div class="col-md-3">
                    <label for="txtcnpj">CNPJ:</label>
                    <input class="form-control" type="text" name="txtcnpj" id="txtcnpj" maxlength="18" style="background:#E0FFFF;" onchange="buscaCNPJ(value)">
                </div>
                <div class="col-md-6">
                    <label for="txtnome">NOME:</label>
                    <input class="form-control" type="text" name="txtnome" id="txtnome" maxlength="60" style="background:#E0FFFF;">
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
                    <label for="txtie">IE:</label>
                    <input class="form-control" type="text" name="txtie" id="txtie" maxlength="20">
                </div>
                <div class="col-md-4">
                    <label for="txtlogradouro">LOGRADOURO:</label>
                    <input class="form-control" type="text" name="txtlogradouro" id="txtlogradouro" maxlength="200" style="background:#E0FFFF;">
                </div>
                <div class="col-md-3">
                    <label for="txtbairro">BAIRRO:</label>
                    <input class="form-control" type="text" name="txtbairro" id="txtbairro" maxlength="200" style="background:#E0FFFF;">
                </div>
                <div class="col-md-2">
                    <label for="txtbairro">N. ENDEREÇO:</label>
                    <input class="form-control" type="text" name="txtnumero" id="txtnumero" maxlength="9" style="background:#E0FFFF;">
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <label for="txtcomplemento">COMPLEMENTO:</label>
                    <input class="form-control" type="text" name="txtcomplemento" id="txtcomplemento" maxlength="200">
                </div>
                <div class="col-md-2">
                    <label for="txtcep">CEP:</label>
                    <input class="form-control" type="text" name="txtcep" id="txtcep" maxlength="9" style="background:#E0FFFF;">
                </div>
                <div class="col-md-1">
                    <label for="txtestado">UF:</label>
                    <select name="txtestado" id="txtestado" class="form-control" style="background:#E0FFFF;">
                        <option value="0">Selecione</option>
                        <?php
                            $sel = "SELECT cd_estado, sg_estado
                                    FROM estado
                                    ORDER BY sg_estado";
                            $res = mysqli_query($conexao, $sel);
                            while($lin=mysqli_fetch_row($res)){
                                $nr_cdgo = $lin[0];
                                $sg_uf = $lin[1];
                                echo "<option value=$nr_cdgo>$sg_uf</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="txtmunicipio">CIDADE:</label>
                    <select name="txtmunicipio" id="txtmunicipio" class="form-control" style="background:#E0FFFF;">
                        <option value="0">Selecione</option>
                        <?php
                            $sel = "SELECT cd_municipioibge, ds_municipioibge
                                    FROM municipioibge
                                    ORDER BY ds_municipioibge";
                            $res = mysqli_query($conexao, $sel);
                            while($lin=mysqli_fetch_row($res)){
                                $nr_cdgo = $lin[0];
                                $ds_munic = $lin[1];
                                echo "<option value=$nr_cdgo>$ds_munic</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="txttelefone">TELEFONE</label>
                    <input type="text" id="txttelefone" name="txttelefone" class="form-control" maxlength="20" style="background:#E0FFFF;">
                </div>
                <div class="col-md-3">
                    <label for="txtemail">E-MAIL</label>
                    <input type="text" id="txtemail" name="txtemail" class="form-control" maxlength="200" style="background:#E0FFFF;">
                </div>
                <div class="col-md-3">
                    <label for="txtempresa">EMPRESA</label>
                    <input type="text" id="txtempresa" name="txtempresa" class="form-control" maxlength="200" style="background:#E0FFFF;">
                </div>
            </div>
           
            <div class="row">
                <div class="col-md-12" id="rsanexos">
                
                </div>
            </div>
        </div>
    </body>
</html>


<script language="javascript">
    
    async function buscaCNPJ(cnpj) {
        var cliente = document.getElementById('cd_empresa').value;
        if(cliente == ""){
            var cnpj = cnpj.replace('/','');
            var cnpj = cnpj.replace('.','');
            var cnpj = cnpj.replace('-','');
            try {
                const response = await fetch(`https://publica.cnpj.ws/cnpj/${cnpj}`);
                const data = await response.json();
                let msgSuccessfile = document.getElementById('imporSuccess')
                msgSuccessfile.style.visibility = 'hidden'
                if (data) {
                    msgSuccessfile.style.visibility = 'initial'
                    msgSuccessfile.style.transition = 'opacity 0.5s'
                    setInterval(() => msgSuccessfile.style.opacity = 1, 500)
                }
                document.getElementById('txtnome').value = data.razao_social;
                document.getElementById('txtie').value = data.estabelecimento.inscricoes_estaduais[0].inscricao_estadual;
                document.getElementById('txtlogradouro').value = `${data.estabelecimento.tipo_logradouro} ${data.estabelecimento.logradouro}`;
                document.getElementById('txtbairro').value = `${data.estabelecimento.bairro}`;
                document.getElementById('txtnumero').value = `${data.estabelecimento.numero}`;
                document.getElementById('txtcomplemento').value = `${data.estabelecimento.complemento}`;
                document.getElementById('txtcep').value = `${data.estabelecimento.cep}`;
                document.getElementById('txtestado').value = `${data.estabelecimento.estado.ibge_id}`;
                document.getElementById('txtmunicipio').value = `${data.estabelecimento.cidade.ibge_id}`;
            } catch {
                const response = await fetch(`https://publica.cnpj.ws/cnpj/${cnpj}`);
                const data = await response.json();
                let msgSuccessfile = document.getElementById('imporSuccess')
                msgSuccessfile.style.visibility = 'hidden'
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: `${data.detalhes} Informe os dados manualmente!`
                })
            }
        }
    };

    function executafuncao(id) {

        if (id == 'new') {

            document.getElementById('cd_empresa').value = "";
            document.getElementById('txtcnpj').value = "";
            document.getElementById('txtnome').value = "";
            document.getElementById('txtstatus').value = "A";
            document.getElementById('txtie').value = "";
            document.getElementById('txtlogradouro').value = "";
            document.getElementById('txtbairro').value = "";
            document.getElementById('txtnumero').value = "";
            document.getElementById('txtcomplemento').value = "";
            document.getElementById('txtcep').value = "";
            document.getElementById('txtestado').value = "0";
            document.getElementById('txtmunicipio').value = "0";
            document.getElementById('txttelefone').value = "";
            document.getElementById('txtemail').value = "";
            document.getElementById('txtempresa').value = "";
            let msgSuccessfile = document.getElementById('imporSuccess')
            msgSuccessfile.style.visibility = 'hidden'

        } else if (id == "save") {

            var codigo = document.getElementById('cd_empresa').value;
            var nome = document.getElementById('txtnome').value;
            var cnpj = document.getElementById('txtcnpj').value;
            var ie = document.getElementById('txtie').value;
            var logradouro = document.getElementById('txtlogradouro').value;
            var bairro = document.getElementById('txtbairro').value;
            var numero = document.getElementById('txtnumero').value;
            var complemento = document.getElementById('txtcomplemento').value;
            var cep = document.getElementById('txtcep').value;
            var estado = document.getElementById('txtestado').value;
            var municipio = document.getElementById('txtmunicipio').value;
            var telefone = document.getElementById('txttelefone').value;
            var email = document.getElementById('txtemail').value;
            var status = document.getElementById('txtstatus').value;
            var empresa = document.getElementById('txtempresa').value;

            if (nome == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o nome da empresa!'
                });
                document.getElementById('txtnome').focus();
            } 
            else if (empresa == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a empresa!'
                });
                document.getElementById('txtempresa').focus();
            }
            else if (cnpj == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o CNPJ da empresa!'
                });
                document.getElementById('txtcnpj').focus();
            }
            else if (logradouro == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o logradouro!'
                });
                document.getElementById('txtlogradouro').focus();
            }
            else if (bairro == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o bairro!'
                });
                document.getElementById('txtbairro').focus();
            }
            else if (numero == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o numero!'
                });
                document.getElementById('txtnumero').focus();
            }
            else if (cep == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o CEP!'
                });
                document.getElementById('txtcep').focus();
            }
            else if (estado == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o estado!'
                });
                document.getElementById('txtestado').focus();
            }
            else if (municipio == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o municipio da empresa!'
                });
                document.getElementById('txtmunicipio').focus();
            }
            else if (telefone == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe um telefone!'
                });
                document.getElementById('txttelefone').focus();
            }
            else if (email == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o e-mail!'
                });
                document.getElementById('txtemail').focus();
            }
            else {

                if (codigo == '') { Tipo = "I" } 
                else { Tipo = "A"; }

                window.open('cadastros/empresas/acao.php?Tipo=' + Tipo + '&codigo=' + codigo + '&nome=' + nome + '&cnpj=' + cnpj + '&logradouro=' + logradouro + '&bairro=' + bairro + '&numero=' + numero + '&complemento=' + complemento + '&cep=' + cep + '&estado=' + estado + '&municipio=' + municipio + '&ie=' + ie + '&status=' + status + '&telefone=' + telefone + '&email=' + email + '&empresa=' + empresa, "acao");
            
            }

        } else if (id == "delete") {

            if (document.getElementById('cd_empresa').value == "") { 
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Para efetuar a exclus\u00e3o \u00e9 necess\u00e1rio selecionar um registro primeiro!'
                }); 
            }
            else {
                Swal.fire({
                    title: 'Deseja excluir o cliente selecionado?',
                    text: "Não tem como reverter esta ação!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, excluir!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        
                        var codigo = document.getElementById('cd_empresa').value;
                        window.open('cadastros/empresas/acao.php?Tipo=E&codigo=' + codigo, 'acao');

                    } else {

                        return false;

                    }
                });

            }
          

        }

    }
</script>