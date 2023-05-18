<body onLoad="document.getElementById('txtprazo').focus();">
    <input type="hidden" name="cd_meses" id="cd_meses" value="">
    <div class="form-group col-md-12">
        <div class="row">
            <?php include "inc/botao_novo.php"; ?>
            <?php include "inc/botao_salvar.php"; ?>
            <?php include "inc/botao_excluir.php"; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <label for="txtprazo">PRAZOS:</label>                    
            <input type="number" name="txtprazo" id="txtprazo" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;" placeholder="Somente números inteiros">
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

            document.getElementById('cd_meses').value = "";
            document.getElementById('txtprazo').value = "";
            document.getElementById("ativo").value = 1;
            document.getElementById('txtprazo').focus();

        } else if (id=="save"){  

            var codigo = document.getElementById('cd_meses').value;
            var prazo = document.getElementById('txtprazo').value;
            var status = document.getElementById("ativo").value;
        
            if (prazo == "") {

                Swal.fire({
					icon: 'warning',
					title: 'Oops...',
					text: 'Informe uma descrição!'
				});
				document.getElementById('txtprazo').focus();
                
            } else {

                if (codigo == '') {
                    Tipo = "I"
                } else {
                    Tipo = "A";
                }

                window.open('parametros/meses/acao.php?Tipo=' + Tipo + '&codigo=' + codigo + '&prazo=' + prazo + '&status=' + status, "acao");
            }

        } else if (id == "delete") {

            var codigo = document.getElementById('cd_meses').value;

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
                        
                        window.open("parametros/meses/acao.php?Tipo=E&codigo="+codigo, "acao");

                    } else {

                        return false;

                    }
                });

            }
        }

    }

</script>