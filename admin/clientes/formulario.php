<body onLoad="document.getElementById('txtcnpj').focus();">
<input type="hidden" name="cd_cliente" id="cd_cliente" value="">
<div class="form-group col-md-12">
    <div class="row">
        <?php include "inc/botao_novo.php"; ?>
        <?php include "inc/botao_salvar.php"; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-2">
                    <label for="txtcnpj">CNPJ:</label>                    
                    <input type="text" name="txtcnpj" id="txtcnpj" size="15" maxlength="14" style="background:#E0FFFF;" class="form-control"></td>
    </div>
    <div class="col-md-6">
                    <label for="txtnome">Raz&atilde;o Social:</label>                    
                    <input type="text" name="txtnome" id="txtnome" size="15" maxlength="200" style="background:#E0FFFF;" class="form-control"></td>
    </div>
    <div class="col-md-2">
                    <label for="txtie">IE:</label>                    
                    <input type="text" name="txtie" id="txtie" size="15" maxlength="30" style="background:#E0FFFF;" class="form-control"></td>
    </div>
    <div class="col-md-2">
                    <label for="txttributacao">TRIBUTA&Ccedil;&Atilde;O:</label>                    
                    <select id="txttributacao" class="form-control" style="background:#E0FFFF;">
                        <option value='1'>LUCRO REAL/PRESUMIDO</option>
                        <option value='2' selected>SIMPLES NACIONAL</option>
                    </select>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
                    <label for="txtendereco">ENDERE&Ccedil;O:</label>                    
                    <input type="text" name="txtendereco" id="txtendereco" style="background:#E0FFFF;" maxlength="200" class="form-control"></td>
    </div>
    <div class="col-md-2">
                    <label for="txtbairro">BAIRRO:</label>                    
                    <input type="text" name="txtbairro" id="txtbairro" style="background:#E0FFFF;" maxlength="200" class="form-control"></td>
    </div>
    <div class="col-md-2">
                    <label for="txtcomplemento">COMPLEMENTO:</label>                    
                    <input type="text" name="txtcomplemento" id="txtcomplemento" maxlength="200" class="form-control"></td>
    </div>
    <div class="col-md-2">
                    <label for="txtcep">CEP:</label>                    
                    <input type="text" name="txtcep" id="txtcep" maxlength="12" class="form-control"></td>
    </div>

    <div class="col-md-3">
                    <label for="txtcidade">CIDADE/UF:</label>                    
                    <select id="txtcidade" class="form-control" style="background:#E0FFFF;">
                        <option value='0'>Selecione a cidade</option>
                        <?php
                        $sql = "SELECT cd_municipioibge, ds_municipioibge||' - '||sg_estado
                                FROM municipioibge
                                ORDER BY ds_municipioibge, sg_estado";
                        $res = pg_query($conexao, $sql);
                        while($lin=pg_fetch_row($res)){
                            $codigo = $lin[0];
                            $desc = $lin[1];

                            echo "<option value='$codigo'>$desc</option>";
                        }
                        ?>
                    </select>
    </div>
</div>

<div class="row">
    <div class="col-md-2">
                    <label for="txtresponsavel">RESPONS&Aacute;VEL:</label>                    
                    <input type="text" name="txtresponsavel" id="txtresponsavel" style="background:#E0FFFF;" maxlength="60" class="form-control"></td>
    </div>
    <div class="col-md-4">
                    <label for="txtemail">E-mails (separado por ";"):</label>                    
                    <input type="text" name="txtemail" id="txtemail" maxlength="200" class="form-control"></td>
    </div>
    <div class="col-md-4">
                    <label for="txtcontabilidade">CONTABILIDADE:</label>                    
                    <select id="txtcontabilidade" class="form-control">
                        <option value='0'>Selecione a contabilidade</option>
                        <?php
                        $sql = "SELECT idcontabilidade, descricao
                                FROM tab_contabilidades
                                ORDER BY descricao";
                        $res = pg_query($conexao, $sql);
                        while($lin=pg_fetch_row($res)){
                            $codigo = $lin[0];
                            $desc = $lin[1];

                            echo "<option value='$codigo'>$desc</option>";
                        }
                        ?>
                    </select>
    </div>
    <div class="col-md-2">
                    <label for="txtemailcontabilidade">E-mail CONTABILIDADE:</label>                    
                    <input type="text" name="txtemailcontabilidade" id="txtemailcontabilidade" size="15" maxlength="200" class="form-control"></td>
    </div>
</div>

<div class="row">
    <div class="col-md-2">
                    <label for="txttelefone">TELEFONE:</label>                    
                    <input type="text" name="txttelefone" id="txttelefone" style="background:#E0FFFF;" maxlength="50" class="form-control"></td>
    </div>
    <div class="col-md-2">
                    <label for="txttelefone2">TELEFONE:</label>                    
                    <input type="text" name="txttelefone2" id="txttelefone2" maxlength="50" class="form-control"></td>
    </div>
    <div class="col-md-3">
                    <label for="txtdata">DATA IN&Iacute;CIO:</label>                    
                    <input type="date" name="txtdata" id="txtdata" maxlength="12" class="form-control"></td>
    </div>
    <div class="col-md-3">
                    <label for="txtdata2">DATA SA&Iacute;DA:</label>                    
                    <input type="date" name="txtdata2" id="txtdata2" maxlength="12" class="form-control"></td>
    </div>
    <div class="col-md-2">
                    <label for="txtstatus">STATUS:</label>                    
                    <select id="txtstatus" class="form-control">
                        <option value='1'>SIM</option>
                        <option value='0'>N&Atilde;O</option>
                    </select>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
                    <label for="txtobs1">OBSERVA&Ccedil;&Atilde;O PROPOSTA:</label>                    
                    <input type="text" name="txtobs1" id="txtobs1" maxlength="200" class="form-control"></td>
    </div>
    <div class="col-md-6">
                    <label for="txtobs2">OBSERVA&Ccedil;&Atilde;O CTE:</label>                    
                    <input type="text" name="txtobs2" id="txtobs2" maxlength="200" class="form-control"></td>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-3">
                    <label for="txtservico">Servi&ccedil;o Contratado:</label>                    
                    <select id="txtservico" class="form-control" style="background:#E0FFFF;">
                        <option value='COM'>Sistema Completo</option>
                        <option value='GER'>Sistema Gerencial (sem emiss&otilde;es)</option>
                        <option value='CTE'>Somente CT-e (cliente emite)</option>
                        <option value='MDF'>Somente MDF-e (cliente emite)</option>
                        <option value='CSV'>Emiss&atilde;o CT-e pela Inove</option>
                    </select>
    </div>
    <div class="col-md-3">
                    <label for="txtbase">Base de Dados AWS:</label>                    
                    <input type="text" name="txtbase" id="txtbase" maxlength="40" class="form-control"></td>
    </div>
    <div class="col-md-3">
                    <label for="txtgxml">GXML:</label>                    
                    <select id="txtgxml" class="form-control">
                        <option value='1'>SIM</option>
                        <option value='0' selected>N&Atilde;O</option>
                    </select>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-3">
                    <label for="txtenvio">Envio Autom&aacute;tico:</label>                    
                    <select id="txtenvio" class="form-control">
                        <option value='1'>SIM</option>
                        <option value='0' selected>N&Atilde;O</option>
                    </select>
    </div>
    <div class="col-md-3">
                    <label for="txtplacas">Envio Rel. Placas:</label>                    
                    <select id="txtplacas" class="form-control">
                        <option value='1'>SIM</option>
                        <option value='0' selected>N&Atilde;O</option>
                    </select>
    </div>
    <div class="col-md-3">
                    <label for="txtsped">Envio SPED:</label>                    
                    <select id="txtsped" class="form-control">
                        <option value='1'>SIM</option>
                        <option value='0' selected>N&Atilde;O</option>
                    </select>
    </div>
    <div class="col-md-3">
                    <label for="seldia">Dia Envio:</label>                    
                    <select class="form-control" name="seldia" id="seldia">
                        <option value='0'>Selecione o dia do envio do movimento</option>
                        <option value='1'>1</option>
                        <option value='7'>7</option>
                    </select>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-3">
                    <label for="txtcertificado">CERTIFICADO DIGITAL:</label>                    
                    <select id="txtcertificado" class="form-control">
                        <option value='1'>A1</option>
                        <option value='3'>A3</option>
                    </select>
    </div>
    <div class="col-md-3">
                    <label for="txtvencimento">VENCIMENTO:</label>                    
                    <input type="date" name="txtvencimento" id="txtvencimento" maxlength="10" class="form-control"></td>
    </div>
</div>

<a href="#" target="_blank" id="linkCertificado"></a>&nbsp;&nbsp;
<input type="hidden" id="dsCertificado">
<button class="btn btn-danger btn-sm hidden" id="btnExcluirCertificado" onclick="excluirCertificado()">
    <i class="fa fa-trash"></i> Excluir
</button>

<div class="row">
    <div class=" col-md-3">
        <label>UPLOAD</label>
    </div>
</div>

<input type="file" id="campoCertificado" class="bloqueia_carregando form-control" required>
<span class="help-block">Selecione o certificado do cliente para enviar.</span>
<label style="width:100%">
    <span class="hidden" id="carregando_certificado">  <i class="fa fa-spinner fa-pulse"></i> Carregando...</span>&nbsp;
</label>

<hr>

<div class="row">
    <div class="col-md-3">
                    <label for="txtintegracao">INTEGRAÇÃO ATS</label>                    
                    <select id="txtintegracao" class="form-control">
                        <option value='S'>SIM</option>
                        <option value='N'>NÃO</option>
                    </select>
    </div>
    <div class="col-md-3">
                     <label for="txtbloqueado">BLOQUEADO PELO FINANCEIRO</label>                    
                    <select id="txtbloqueado" class="form-control">
                        <option value='S'>SIM</option>
                        <option value='N'>NÃO</option>
                    </select>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-2">
                    <label for="txtaverbacao">Averba&ccedil;&atilde;o Autom&aacute;tica:</label>                    
                    <select id="txtaverbacao" class="form-control">
                        <option value='1'>SIM</option>
                        <option value='0' selected>N&Atilde;O</option>
                    </select>
    </div>
    <div class="col-md-2">
                    <label for="txtusuarioaverba">Usu&aacute;rio ATM:</label>                    
                    <input type="text" name="txtusuarioaverba" id="txtusuarioaverba" maxlength="60" class="form-control"></td>
    </div>
    <div class="col-md-2">
                    <label for="txtsenhaaverba">Senha ATM:</label>                    
                    <input type="text" name="txtsenhaaverba" id="txtsenhaaverba" maxlength="60" class="form-control"></td>
    </div>
    <div class="col-md-2">
                    <label for="txtatm">Cod ATM:</label>                    
                    <input type="text" name="txtatm" id="txtatm" maxlength="60" class="form-control"></td>
    </div>
    <div class="col-md-4">
                    <label for="txtobsaverba">Observa&ccedil;&atilde;o:</label>                    
                    <input type="text" name="txtobsaverba" id="txtobsaverba" maxlength="200" class="form-control"></td>
    </div>    
</div>
<hr>
<label>CONTRATO:</label>&nbsp;&nbsp;
<a href="#" target="_blank" id="linkContrato"></a>&nbsp;&nbsp;
<input type="hidden" id="dsArquivo">
<button class="btn btn-danger btn-sm hidden" id="btnExcluirContrato" onclick="excluirArquivo()">
    <i class="fa fa-trash"></i> Excluir
</button>

<div class="row">
    <div class=" col-md-3">
        <label>UPLOAD</label>
    </div>
</div>

<input type="file" id="campoContrato" class="bloqueia_carregando form-control" required>
<span class="help-block">Selecione o contrato do cliente para enviar.</span>
<label style="width:100%">
    <span class="hidden" id="carregando_contrato">  <i class="fa fa-spinner fa-pulse"></i> Carregando...</span>&nbsp;
</label>

</body>
<script type="text/javascript">
function executafuncao(id){
  if (id=='new'){
    document.getElementById("txtcnpj").value = "";
    document.getElementById('txtcnpj').disabled = false;
    document.getElementById("txtnome").value = "";
    document.getElementById("txtie").value = "";
    document.getElementById("txttributacao").value = "2";
    document.getElementById("txtendereco").value = "";
    document.getElementById("txtbairro").value = "";
    document.getElementById("txtcomplemento").value = "";
    document.getElementById("txtcep").value = "";
    document.getElementById("txtcidade").value = "0";
    document.getElementById("txtresponsavel").value = "";
    document.getElementById("txtemail").value = "";
    document.getElementById("txtcontabilidade").value = "0";
    document.getElementById("txtemailcontabilidade").value = "";
    document.getElementById("txttelefone").value = "";
    document.getElementById("txttelefone2").value = "";
    document.getElementById("txtobs2").value = "";
    document.getElementById("txtobs1").value = "";
    document.getElementById("txtservico").value = "CSV";
    document.getElementById("txtbase").value = "";
    document.getElementById("txtgxml").value = "0";
    document.getElementById("txtenvio").value = "0";
    document.getElementById("txtplacas").value = "0";
    document.getElementById("txtsped").value = "0";
    document.getElementById("txtcertificado").value = "1";
    document.getElementById("txtvencimento").value = "";
    document.getElementById("txtdata").value = "";
    document.getElementById("txtdata2").value = "";
    document.getElementById("txtstatus").value = "1";
    document.getElementById("cd_cliente").value = "";
    document.getElementById("txtaverbacao").value = "0";
    document.getElementById("txtusuarioaverba").value = "";
    document.getElementById("txtsenhaaverba").value = "";
    document.getElementById("txtatm").value = "";
    document.getElementById("txtobsaverba").value = "";
    document.getElementById("seldia").value = "0";
    document.getElementById('txtnome').focus();
    document.getElementById("txtintegracao").value = "N";
    document.getElementById("txtbloqueado").value = "N";
    document.getElementById("campoContrato").value = "";
    document.getElementById("btnExcluirContrato").classList.add('hidden');
    document.getElementById("linkContrato").innerHTML = '';
    document.getElementById("dsArquivo").value = '';

    document.getElementById("campoCertificado").value = "";
    document.getElementById("btnExcluirCertificado").classList.add('hidden');
    document.getElementById("linkCertificado").innerHTML = '';
    document.getElementById("dsCertificado").value = '';

  }
  else if (id=="save"){  
    var cnpj                = document.getElementById("txtcnpj").value;
    var nome                = document.getElementById("txtnome").value;
    var ie                  = document.getElementById("txtie").value;
    var tributacao          = document.getElementById("txttributacao").value;
    var endereco            = document.getElementById("txtendereco").value;
    var bairro              = document.getElementById("txtbairro").value;
    var complemento         = document.getElementById("txtcomplemento").value;
    var cep                 = document.getElementById("txtcep").value;
    var cidade              = document.getElementById("txtcidade").value;
    var responsavel         = document.getElementById("txtresponsavel").value;
    var email               = document.getElementById("txtemail").value;
    var contabilidade       = document.getElementById("txtcontabilidade").value;
    var emailcontabilidade  = document.getElementById("txtemailcontabilidade").value;
    var telefone            = document.getElementById("txttelefone").value;
    var telefone2           = document.getElementById("txttelefone2").value;
    var obs2                = document.getElementById("txtobs2").value;
    var obs                 = document.getElementById("txtobs1").value;
    var servico             = document.getElementById("txtservico").value;
    var base                = document.getElementById("txtbase").value;
    var gxml                = document.getElementById("txtgxml").value;
    var envio               = document.getElementById("txtenvio").value;
    var placas              = document.getElementById("txtplacas").value;
    var sped                = document.getElementById("txtsped").value;
    var certificado         = document.getElementById("txtcertificado").value;
    var vencimento          = document.getElementById("txtvencimento").value;
    var data                = document.getElementById("txtdata").value;
    var data2               = document.getElementById("txtdata2").value;
    var status              = document.getElementById("txtstatus").value;
    var codigo              = document.getElementById("cd_cliente").value;
    var txtaverbacao        = document.getElementById("txtaverbacao").value;
    var txtusuarioaverba    = document.getElementById("txtusuarioaverba").value;
    var txtsenhaaverba      = document.getElementById("txtsenhaaverba").value;
    var txtatm              = document.getElementById("txtatm").value;
    var txtobsaverba        = document.getElementById("txtobsaverba").value;
    var seldia              = document.getElementById("seldia").value;
    var txtintegracao       = document.getElementById("txtintegracao").value;
    var txtbloqueado        = document.getElementById("txtbloqueado").value;

    var campoContrato       = document.getElementById("carregando_contrato").value;
    var campoCertificado       = document.getElementById("carregando_certificado").value;

    if (nome != '') {
        nome = nome.replace("'", "");
    }
    if (endereco != '') {
        endereco = endereco.replace("'", "");
    }
    if (bairro != '') {
        bairro = bairro.replace("'", "");
    }
    if (complemento != '') {
        complemento = complemento.replace("'", "");
    }
    if (responsavel != '') {
        responsavel = responsavel.replace("'", "");
    }
    if (email != '') {
        email = email.replace("'", "");
    }
    if (emailcontabilidade != '') {
        emailcontabilidade = emailcontabilidade.replace("'", "");
    }
    if (obs2 != '') {
        obs2 = obs2.replace("'", "");
    }
    if (obs != '') {
        obs = obs.replace("'", "");
    }

    if (cnpj == '') {
        alert('Informe o CNPJ!');
        document.getElementById('cnpj').focus();
    } else if (nome == '') {
        alert('Informe o nome!');
        document.getElementById('txtnome').focus();
    } else if (ie == '') {
        alert('Informe a ie!');
        document.getElementById('txtie').focus();
    } else if (endereco == '') {
        alert('Informe o endereco!');
        document.getElementById('txtendereco').focus();
    } else if (bairro == '') {
        alert('Informe o bairro!');
        document.getElementById('txtbairro').focus();
    } else if (cidade == 0) {
        alert('Informe a cidade!');
        document.getElementById('txtcidade').focus();
    } else if (responsavel == '') {
        alert('Informe o responsavel!');
        document.getElementById('txtresponsavel').focus();
    } else if (email.length < 6) {
        alert('Informe o email do cliente!');
        document.getElementById('txtemail').focus();
    } else if (emailcontabilidade.length < 6){
        alert('Informe o email da contabilidade!');
        document.getElementById('txtemail').focus();
    } else if (servico == 0) {
        alert('Informe o servico!');
        document.getElementById('txtservico').focus();
    } else {
        if (codigo == '') {
            Tipo = "I"
        } else {
            Tipo = "A";
        }

        var arquivoContrato = $('#campoContrato')[0].files[0]; //Pega o primeiro arquivo do campo campoContrato (tipo file) e joga na variavel arquivoContrato
        var arquivoCertificado = $('#campoCertificado')[0].files[0]; //Pega o primeiro arquivo do campo campoContrato (tipo file) e joga na variavel arquivoContrato
        console.log(arquivoContrato);
        var formData = new FormData(); //Instancia um formData vazio
        formData.append('contrato', arquivoContrato); //Adiciona ao formData o arquivo capturado
        formData.append('certificado', arquivoCertificado); //Adiciona ao formData o arquivo capturado
        
        //Continua passando as demais informações através de variaveis GET
        var url = 'admin/clientes/acao.php?Tipo=' + Tipo + '&codigo=' + codigo + '&nome=' + nome + '&cnpj=' + cnpj + '&ie=' + ie + '&tributacao=' + tributacao + '&endereco=' + endereco + '&bairro=' + bairro + '&complemento=' + complemento + '&cep=' + cep + '&cidade=' + cidade + '&responsavel=' + responsavel + '&email=' + email  + '&contabilidade=' + contabilidade + '&emailcontabilidade=' + emailcontabilidade  + '&telefone=' + telefone + '&telefone2=' + telefone2 + '&obs2=' + obs2  + '&obs=' + obs  + '&servico=' + servico  + '&base=' + base + '&gxml=' + gxml + '&envio=' + envio + '&placas='+ placas + '&sped=' + sped + '&certificado=' + certificado + '&vencimento=' + vencimento + '&data=' + data + '&data2=' + data2 + '&status=' + status + '&txtaverbacao=' + txtaverbacao + '&txtusuarioaverba=' + txtusuarioaverba + '&txtsenhaaverba=' + txtsenhaaverba + '&txtatm=' + txtatm + '&txtobsaverba=' + txtobsaverba + '&seldia=' + seldia + '&txtintegracao=' + txtintegracao + '&txtbloqueado=' + txtbloqueado + '&carregando_contrato=' + carregando_contrato + '&carregando_certificado=' + carregando_certificado;
        console.log(url);
        //Executa a requisição através do AJAX do JQuery
        $.ajax({ 
            url: url, //Url que será requisitada
            type: 'post',  //Tipo da requisição (como estamos trabalhando com upload, precisa ser via POST)
            data: formData, //Manda o formData que definimos
            contentType: false, 
            processData: false, 
            success: function(response){ //Função que será executada quando a requisição obtiver sucesso, o parâmetro RESPONSE corresponde ao resultado da requisição
                document.getElementById('campoContrato').value = "";
                document.getElementById('campoCertificado').value = "";
                alert('Cliente alterado com sucesso!');
                executafuncao('new');
                consultar(0);
            },
            error: function (response) { //Função que será executada quando a requisição obtiver erro
                if(response.responseJSON && response.responseJSON.message){
                    alert(response.responseJSON.message);
                }else{
                    alert('Falha ao atualizar o cliente');
                }
                console.log("erro", response)
            }
        });
    }
  }
}

function excluirArquivo(){
    var codigo = document.getElementById("cd_cliente").value;
    var arquivo = document.getElementById('dsArquivo').value;
    if(confirm('Deseja realmente excluir o arquivo?')){
        var url = 'admin/clientes/acao.php?Tipo=excluirArquivo&arquivo=' + arquivo + '&codigo=' + codigo;
        
        $.get(url, function (response) {
            document.getElementById("btnExcluirContrato").classList.add('hidden');
            document.getElementById("linkContrato").innerHTML = '';
            document.getElementById("dsArquivo").value = '';
            alert("Arquivo excluído com sucesso!");
        })
    }
}

function excluirCertificado(){
    var codigo = document.getElementById("cd_cliente").value;
    var arquivo = document.getElementById('dsCertificado').value;
    if(confirm('Deseja realmente excluir o certificado?')){
        var url = 'admin/clientes/acao.php?Tipo=excluirCertificado&arquivo=' + arquivo + '&codigo=' + codigo;
        
        $.get(url, function (response) {
            document.getElementById("btnExcluirCertificado").classList.add('hidden');
            document.getElementById("linkCertificado").innerHTML = '';
            document.getElementById("dsCertificado").value = '';
            alert("Certificado excluído com sucesso!");
        })
    }
}
</script>