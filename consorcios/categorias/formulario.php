<body onLoad="document.getElementById('txtcategoria').focus();">
    <input type="hidden" name="cd_categoria" id="cd_categoria" value="">
    <div class="form-group col-md-12">
        <div class="row">
            <?php include "inc/botao_novo.php"; ?>
            <?php include "inc/botao_salvar.php"; ?>
            <?php include "inc/botao_excluir.php"; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="txtcategoria">CATEGORIA:</label>                    
            <input type="text" name="txtcategoria" id="txtcategoria" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;"></td>
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

            document.getElementById('cd_categoria').value = "";
            document.getElementById('txtcategoria').value = "";
            document.getElementById("ativo").value = 1;
            document.getElementById('txtcategoria').focus();

        } else if (id=="save"){  

            var codigo = document.getElementById('cd_categoria').value;
            var categoria = document.getElementById('txtcategoria').value;
            var status = document.getElementById("ativo").value;
        
            if (categoria != "") {
                categoria = categoria.replace("'", "");
            }
        
            if (categoria == 0) {

                Swal.fire({
					icon: 'warning',
					title: 'Oops...',
					text: 'Informe uma categoria!'
				});
				document.getElementById('txtcategoria').focus();
                
            } else {

                if (codigo == '') {
                    Tipo = "I"
                } else {
                    Tipo = "A";
                }

                window.open('produtos/categorias/acao.php?Tipo=' + Tipo + '&codigo=' + codigo + '&categoria=' + categoria + '&status=' + status, "acao");
            }

        } else if (id == "delete") {

            var codigo = document.getElementById('cd_categoria').value;

            if(codigo==''){  

                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Selecione uma categoria para realizar a exclusão!'
                }); 

            } else {

                Swal.fire({
                    title: 'Deseja excluir a categoria selecionada?',
                    text: "Não tem como reverter esta ação!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, excluir!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        
                        window.open("produtos/categorias/acao.php?Tipo=E&codigo="+codigo, "acao");

                    } else {

                        return false;

                    }
                });

            }
        }

    }

</script>