<body onLoad="document.getElementById('txtnome').focus();">
    <input type="hidden" name="cd_tipo" id="cd_tipo" value="">
    <div class="form-group col-md-12">
        <div class="row">
            <?php include "inc/botao_novo.php"; ?>
            <?php include "inc/botao_salvar.php"; ?>
            <?php include "inc/botao_excluir.php"; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="txtnome">TIPO DE LANCE:</label>                    
            <input type="text" name="txtnome" id="txtnome" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;" placeholder="Descreva">
        </div>

        <div class="col-md-2">
            <label for="ativo">STATUS:</label>
            <?php include "inc/ativos.php";?>
        </div>
    </div>
</body>

<script type="text/javascript">

    function executafuncao(id){

        if (id=='new'){

            document.getElementById('cd_tipo').value = "";
            document.getElementById('txtnome').value = "";
            document.getElementById("ativo").value = 1;
            document.getElementById('txtnome').focus();

        } else if (id=="save"){  

            var codigo = document.getElementById('cd_tipo').value;
            var nome = document.getElementById('txtnome').value;
            var status = document.getElementById("ativo").value;
        
            if (nome != "") {
                nome = nome.replace("'", "");
            }
        
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

                window.open('parametros/tipos/acao.php?Tipo=' + Tipo + '&codigo=' + codigo + '&nome=' + nome + '&status=' + status, "acao");
            }

        } else if (id == "delete") {

            var codigo = document.getElementById('cd_tipo').value;

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
                        
                        window.open("parametros/tipos/acao.php?Tipo=E&codigo="+codigo, "acao");

                    } else {

                        return false;

                    }
                });

            }
        }

    }

</script>