<body onLoad="document.getElementById('txtnome').focus();">
<input type="hidden" name="cd_segmento" id="cd_segmento" value="">
<div class="form-group col-md-12">
    <div class="row">
        <?php include "inc/botao_novo.php"; ?>
        <?php include "inc/botao_salvar.php"; ?>
        <?php include "inc/botao_excluir.php"; ?>
    </div>
</div>
    <div class="row">
        <div class="col-md-9">
            <label>SEGMENTO:</label>
            <input type="text" name="txtnome" id="txtnome" size="10" maxlength="100" style="background:#E6FFE0;" class="form-control">
        </div>
        <div class="col-md-3">
            <label for="txtstatus">STATUS:</label>
            <select class="form-control" name="txtstatus" id="txtstatus" style="background:#E0FFFF;">
                <option value="A">ATIVO</option>
                <option value="I">INATIVO</option>
            </select>
        </div>
    </div>

</body>

<script type="text/javascript">

    function limparTexto(texto) {
        return texto.replace(/[^a-zA-Z0-9\s]/g, '');
    }

    function executafuncao(id){

        if (id=='new'){
            document.getElementById('cd_segmento').value = "";
            document.getElementById('txtnome').value = "";
            document.getElementById('txtstatus').value = "A";
            document.getElementById('txtnome').focus();
        }
        else if (id=="save"){  
            var codigo = document.getElementById('cd_segmento').value;
            var segmento = limparTexto(document.getElementById('txtnome').value);
            var status = document.getElementById('txtstatus').value;
            
            if (segmento == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o nome do segmento!'
                });
                document.getElementById('txtnome').focus();
            } else {
                if (codigo == '') {
                    Tipo = "I"
                } else {
                    Tipo = "A";
                }

                window.open('cadastros/segmentos/acao.php?' + 'Tipo=' + Tipo + '&codigo=' + codigo + '&segmento=' + segmento + '&status=' + status, "acao");

            }
        } else if (id == "delete") {

            var codigo = document.getElementById('cd_segmento').value;

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
                        
                        window.open("cadastros/segmentos/acao.php?Tipo=E&codigo="+codigo, "acao");

                    } else {

                        return false;

                    }
                });

            }
        }
    }
</script>