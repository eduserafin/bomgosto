<style>
    .linha-divisoria {
        border-top: 1px solid black; /* Define a cor e a espessura da linha */
    }
</style>

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
        <div class="col-md-10">
            <label for="txtnome">NOME PÁGINA:</label>                    
            <input type="text" name="txtnome" id="txtnome" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;" placeholder="Nome da página web">
        </div>

        <div class="col-md-2">
            <label for="txtstatus">STATUS</label>                    
            <select id="txtstatus" class="form-control" style="background:#E0FFFF;">
                <option value='A'>ATIVO</option>
                <option value='I'>INATIVO</option>
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div id="msgexibe" class="alert alert-info fade in alert-dismissable" >
                <span class="glyphicon glyphicon-pencil"></span> Seções
            </div>
        </div>

        <div class="col-md-6">
            <label for="txtsecao1">SEÇÃO 1:</label>    
            <textarea id="txtsecao1" rows="5" class="form-control" maxlength="1000" placeholder="Descreva a apresentação da página."></textarea>
        </div>

        <div class="col-md-6">
            <label for="txtsubsecao1">SUBSEÇÃO 1:</label>   
            <textarea id="txtsubsecao1" rows="5" class="form-control" maxlength="1000" placeholder="Descreva o subtexto."></textarea>
        </div>
    </div>

    <hr class="linha-divisoria"> <!-- Linha divisória -->

    <div class="row">
        <div class="col-md-6">
            <label for="txtsecao2">SEÇÃO 2:</label>    
            <textarea id="txtsecao2" rows="5" class="form-control" maxlength="1000" placeholder="Descreva a apresentação da página."></textarea>
        </div>

        <div class="col-md-6">
            <label for="txtsubsecao2">SUBSEÇÃO 2:</label>   
            <textarea id="txtsubsecao2" rows="5" class="form-control" maxlength="1000" placeholder="Descreva o subtexto."></textarea>
        </div>
    </div>

    <hr class="linha-divisoria"> <!-- Linha divisória -->

    <div class="row">
        <div class="col-md-6">
            <label for="txtsecao3">SEÇÃO 3:</label>    
            <textarea id="txtsecao3" rows="5" class="form-control" maxlength="1000" placeholder="Descreva a apresentação da página."></textarea>
        </div>

        <div class="col-md-6">
            <label for="txtsubsecao3">SUBSEÇÃO 3:</label>   
            <textarea id="txtsubsecao3" rows="5" class="form-control" maxlength="1000" placeholder="Descreva o subtexto."></textarea>
        </div>
    </div>

    <hr class="linha-divisoria"> <!-- Linha divisória -->

    <div class="row">
        <div class="col-md-6">
            <label for="txtsecao4">SEÇÃO 4:</label>    
            <textarea id="txtsecao4" rows="5" class="form-control" maxlength="1000" placeholder="Descreva a apresentação da página."></textarea>
        </div>

        <div class="col-md-6">
            <label for="txtsubsecao4">SUBSEÇÃO 4:</label>   
            <textarea id="txtsubsecao4" rows="5" class="form-control"  maxlength="1000" placeholder="Descreva o subtexto."></textarea>
        </div>
    </div>

    <hr class="linha-divisoria"> <!-- Linha divisória -->

    <div class="row">
        <div class="col-md-6">
            <label for="txtsecao5">SEÇÃO 5:</label>    
            <textarea id="txtsecao5" rows="5" class="form-control" maxlength="1000" placeholder="Descreva a apresentação da página."></textarea>
        </div>

        <div class="col-md-6">
            <label for="txtsubsecao5">SUBSEÇÃO 5:</label>   
            <textarea id="txtsubsecao5" rows="5" class="form-control" maxlength="1000" placeholder="Descreva o subtexto."></textarea>
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
            document.getElementById("txtstatus").value = "A";
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
            var status = document.getElementById("txtstatus").value;
        
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

                window.open('gerenciador/site/acao.php?Tipo=' + Tipo + '&codigo=' + codigo + '&nome=' + nome + '&secao1=' + secao1 + '&subsecao1=' + subsecao1 + '&secao2=' + secao2 + '&subsecao2=' + subsecao2 + '&secao3=' + secao3 + '&subsecao3=' + subsecao3 + '&secao4=' + secao4 + '&subsecao4=' + subsecao4 + '&secao5=' + secao5 + '&subsecao5=' + subsecao5 + '&status=' + status, "acao");
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
                        
                        window.open("gerenciador/site/acao.php?Tipo=E&codigo="+codigo, "acao");

                    } else {

                        return false;

                    }
                });

            }
        }

    }

</script>