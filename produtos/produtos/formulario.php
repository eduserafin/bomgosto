<body onLoad="document.getElementById('txtproduto').focus();">
    <input type="hidden" name="cd_produto" id="cd_produto" value="">
    <div class="form-group col-md-12">
        <div class="row">
            <?php include "inc/botao_novo.php"; ?>
            <?php include "inc/botao_salvar.php"; ?>
            <?php include "inc/botao_excluir.php"; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="txtproduto">PRODUTO:</label>                    
            <input type="text" name="txtproduto" id="txtproduto" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;"></td>
        </div>

        <div class="col-md-3">
            <label for="selcategoria">CATEGORIA:</label>                    
            <select id="selcategoria" class="form-control" style="background:#E0FFFF;">
                <option value='0'>Selecione uma categoria</option>
                <?php
                    $sql = "SELECT nr_sequencial, ds_categoria
                                FROM categorias
                            ORDER BY ds_categoria";
                    $res = mysqli_query($conexao, $sql);
                    while($lin=mysqli_fetch_row($res)){
                        $codigo = $lin[0];
                        $desc = $lin[1];

                        echo "<option value='$codigo'>$desc</option>";
                    }
                ?>
            </select>
        </div>

        <div class="col-md-6">
            <label for="txtunidade">UNIDADE/TAMANHO:</label>                    
            <input type="number" name="txtunidade" id="txtunidade" size="15" maxlength="10" class="form-control" style="background:#E0FFFF;"></td>
        </div>

        <div class="col-md-6">
            <label for="txtvalor">VALOR R$:</label>                    
            <input type="number" name="txtvalor" id="txtvalor" size="15" maxlength="10" class="form-control" style="background:#E0FFFF;"></td>
        </div>

        <div class="col-md-6">
            <label for="txtdescricao">DESCRIÇÃO DO PRODUTO:</label>                    
            <input type="text" name="txtdescricao" id="txtdescricao" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;"></td>
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

            document.getElementById('cd_produto').value = "";
            document.getElementById('txtcategoria').value = "";
            document.getElementById("ativo").value = 1;
            document.getElementById('txtcategoria').focus();

        } else if (id=="save"){  

            var codigo = document.getElementById('cd_produto').value;
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

            var codigo = document.getElementById('cd_produto').value;

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