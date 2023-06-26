<body onLoad="document.getElementById('txtnome').focus();">
    <input type="hidden" name="cd_configuracao" id="cd_configuracao" value="">
    <div class="form-group col-md-12">
        <div class="row">
            <?php include "inc/botao_novo.php"; ?>
            <?php include "inc/botao_salvar.php"; ?>
            <?php include "inc/botao_excluir.php"; ?>
        </div>
    </div>
    <div class="row">

        <div class="col-md-12">
            <label for="txtnome">NOME PÁGINA:</label>                    
            <input type="text" name="txtnome" id="txtnome" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;" placeholder="Nome da página web">
        </div>

        <div class="col-md-6">
            <label for="txtsecao1">SEÇÃO INICIAL:</label>    
            <textarea id="txtsecao1" rows="3" class="form-control" maxlength="500" placeholder="Descreva a apresentação da página."></textarea>
        </div>

        <div class="col-md-6">
            <label for="txtsubsecao1">SUBSEÇÃO INICIAL:</label>   
            <textarea id="txtsubsecao1" rows="3" class="form-control" maxlength="500" placeholder="Descreva o subtexto."></textarea>
        </div>

        <div class="col-md-6">
            <label for="txtsecao2">SEÇÃO PRODUTOS:</label>    
            <textarea id="txtsecao2" rows="3" class="form-control" maxlength="500" placeholder="Descreva a apresentação da página."></textarea>
        </div>

        <div class="col-md-6">
            <label for="txtsubsecao2">SUBSEÇÃO PRODUTOS:</label>   
            <textarea id="txtsubsecao2" rows="3" class="form-control" maxlength="500" placeholder="Descreva o subtexto."></textarea>
        </div>

        <div class="col-md-6">
            <label for="txtsecao3">SEÇÃO CAMPANHA:</label>    
            <textarea id="txtsecao3" rows="3" class="form-control" maxlength="500" placeholder="Descreva a apresentação da página."></textarea>
        </div>

        <div class="col-md-6">
            <label for="txtsubsecao3">SUBSEÇÃO CAMPANHA:</label>   
            <textarea id="txtsubsecao3" rows="3" class="form-control" maxlength="500" placeholder="Descreva o subtexto."></textarea>
        </div>

        <div class="col-md-6">
            <label for="txtsecao4">SEÇÃO LIVRE:</label>    
            <textarea id="txtsecao4" rows="3" class="form-control" maxlength="500" placeholder="Descreva a apresentação da página."></textarea>
        </div>

        <div class="col-md-6">
            <label for="txtsubsecao4">SUBSEÇÃO LIVRE:</label>   
            <textarea id="txtsubsecao4" rows="3" class="form-control"  maxlength="500" placeholder="Descreva o subtexto."></textarea>
        </div>

        <div class="col-md-6">
            <label for="txtsecao5">SEÇÃO CONTATO:</label>    
            <textarea id="txtsecao5" rows="3" class="form-control" maxlength="500" placeholder="Descreva a apresentação da página."></textarea>
        </div>

        <div class="col-md-6">
            <label for="txtsubsecao5">SUBSEÇÃO CONTATO:</label>   
            <textarea id="txtsubsecao5" rows="3" class="form-control" maxlength="500" placeholder="Descreva o subtexto."></textarea>
        </div>
    </div>

    <div class="row"><br>

        <div class="col-md-12">
            <div id="msgexibe" class="alert alert-info fade in alert-dismissable" >
                <span class="glyphicon glyphicon-pencil"></span> Cards de produtos
            </div>
        </div>

        <div class="row-100">
            <div class="col-md-2">
                <label for="txtquantidadeprodutos">QUANTIDADE:</label>                    
                <input type="number" name="txtquantidadeprodutos" id="txtquantidadeprodutos" size="15" maxlength="10" class="form-control" style="background:#E0FFFF;" onchange="javascript: BuscaProdutos(this.value, document.getElementById('cd_configuracao').value);">
            </div>
        </div>

        <div class="row-100">
            <div class="row-100" id="divProdutos">
            
            </div>
        </div>  

    </div>

    <div class="row"><br>

        <div class="col-md-12">
            <div id="msgexibe" class="alert alert-info fade in alert-dismissable" >
                <span class="glyphicon glyphicon-pencil"></span> Cards de Campanhas
            </div>
        </div>

        <div class="row-100">
            <div class="col-md-2">
                <label for="txtquantidadecampanhas">QUANTIDADE:</label>                    
                <input type="number" name="txtquantidadecampanhas" id="txtquantidadecampanhas" size="15" maxlength="10" class="form-control" style="background:#E0FFFF;" onchange="javascript: BuscaCampanhas(this.value, document.getElementById('cd_configuracao').value);">
            </div>
        </div>

        <div class="row-100">
            <div class="row-100" id="divCampanhas">
            
            </div>
        </div>  

    </div>

    <div class="row"><br>

        <div class="col-md-12">
            <div id="msgexibe" class="alert alert-info fade in alert-dismissable" >
                <span class="glyphicon glyphicon-pencil"></span> Sobre a empresa
            </div>
        </div>

        <div class="col-md-6">
            <label for="txttitulo">TÍTULO:</label>                    
            <input type="text" name="txttitulo" id="txttitulo" size="15" maxlength="100" class="form-control" placeholder="Título">
        </div>

        <div class="col-md-6">
            <label for="txtsobre">DESCRIÇÃO:</label>     
            <textarea name="txtsobre" rows="3" class="form-control" maxlength="1000" placeholder="Descreva a apresentação da empresa."></textarea>
        </div>

    </div>

    <div class="row"><br>

        <div class="col-md-12">
            <div id="msgexibe" class="alert alert-info fade in alert-dismissable" >
                <span class="glyphicon glyphicon-pencil"></span> Redes Sociais
            </div>
        </div>

        <div class="col-md-4">
            <label for="txtfacebook">FACEBOOK:</label>                    
            <input type="text" name="txtfacebook" id="txtfacebook" size="15" maxlength="100" class="form-control" placeholder="Facebook">
        </div>

        <div class="col-md-4">
            <label for="txtinstagran">INSTAGRAN:</label>                    
            <input type="text" name="txtinstagran" id="txtinstagran" size="15" maxlength="100" class="form-control" placeholder="Instagran">
        </div>

        <div class="col-md-4">
            <label for="txtlinkedin">LINKEDIN:</label>                    
            <input type="text" name="txtlinkedin" id="txtlinkedin" size="15" maxlength="100" class="form-control" placeholder="Linkedin">
        </div>

    </div>

</body>

<script type="text/javascript">

    function BuscaProdutos(quantidade, configuracao) {

        var url = 'gerenciador/site/produtos.php?consulta=sim&quantidade=' + quantidade + '&configuracao=' + configuracao;
        $.get(url, function (dataReturn) {
            $('#divProdutos').html(dataReturn);
        });

    }

    function BuscaCampanhas(quantidade, configuracao) {

        var url = 'gerenciador/site/campanhas.php?consulta=sim&quantidade=' + quantidade + '&configuracao=' + configuracao;
        $.get(url, function (dataReturn) {
            $('#divCampanhas').html(dataReturn);
        });

    }

    function executafuncao(id){

        if (id=='new'){

            document.getElementById('cd_configuracao').value = "";
            document.getElementById('txtnome').value = "";
            document.getElementById("txtsecao1").value = "";
            document.getElementById('txtsubsecao1').value = "";
            document.getElementById("txtsecao2").value = "";
            document.getElementById('txtsubsecao2').value = "";
            document.getElementById("txtsecao3").value = "";
            document.getElementById('txtsubsecao3').value = "";
            document.getElementById("txtsecao4").value = "";
            document.getElementById('txtsubsecao4').value = "";
            document.getElementById("txtsecao5").value = "";
            document.getElementById('txtsubsecao5').value = "";
            document.getElementById("txtquantidadeprodutos").value = "";
            document.getElementById('txtquantidadecampanhas').value = "";
            document.getElementById("txttitulo").value = "";
            document.getElementById("txtsobre").value = "";
            document.getElementById("txtfacebook").value = "";
            document.getElementById("txtinstagran").value = "";
            document.getElementById("txtlinkedin").value = "";
            document.getElementById('txtnome').focus();

        } else if (id=="save"){  

            var codigo = document.getElementById('cd_configuracao').value;
            var nome = document.getElementById('txtnome').value;
            var secao1 = document.getElementById("txtsecao1").value;
            var subsecao1 = document.getElementById('txtsubsecao1').value;
            var secao2 = document.getElementById("txtsecao2").value;
            var subsecao2 = document.getElementById('txtsubsecao2').value;
            var secao3 = document.getElementById("txtsecao3").value;
            var subsecao3 = document.getElementById('txtsubsecao3').value;
            var secao4 = document.getElementById("txtsecao4").value;
            var subsecao4 = document.getElementById('txtsubsecao4').value;
            var secao5 = document.getElementById("txtsecao5").value;
            var subsecao5 = document.getElementById('txtsubsecao5').value;
            var qtdprodutos = document.getElementById("txtquantidadeprodutos").value;
            var qtdcampanhas = document.getElementById('txtquantidadecampanhas').value;
            var titulo = document.getElementById("txttitulo").value;
            var sobre = document.getElementById("txtsobre").value;
            var facebook = document.getElementById("txtfacebook").value;
            var instagran= document.getElementById("txtinstagran").value;
            var linkedin = document.getElementById("txtlinkedin").value;
        
            if (nome == "") {

                Swal.fire({
					icon: 'warning',
					title: 'Oops...',
					text: 'Informe uma descrição!'
				});
				document.getElementById('txtnome').focus();
                
            } else {

                if (codigo == '') {
                    Tipo = "I"
                } else {
                    Tipo = "A";
                }

                window.open('gerenciador/site/acao.php?Tipo=' + Tipo + '&codigo=' + codigo + '&nome=' + nome + '&secao1=' + secao1 + '&subsecao1=' + subsecao1 + '&secao2=' + secao2 + '&subsecao2=' + subsecao2 + '&secao3=' + secao3 + '&subsecao3=' + subsecao3 + '&secao4=' + secao4 + '&subsecao4=' + subsecao4 + '&secao5=' + secao5 + '&subsecao5=' + subsecao5 + '&subsecao5=' + subsecao5 + '&qtdprodutos=' + qtdprodutos + '&qtdcampanhas=' + qtdcampanhas + '&titulo=' + titulo + '&sobre=' + sobre + '&facebook=' + facebook + '&instagran=' + instagran + '&linkedin=' + linkedin, "acao");
            }

        } else if (id == "delete") {

            var codigo = document.getElementById('cd_configuracao').value;

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
                        
                        window.open("parametros/grupos/acao.php?Tipo=E&codigo="+codigo, "acao");

                    } else {

                        return false;

                    }
                });

            }
        }

    }

</script>