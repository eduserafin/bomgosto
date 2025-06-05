<body onLoad="document.getElementById('txtnome').focus();">
<input type="hidden" name="cd_situacao" id="cd_situacao" value="">
<div class="form-group col-md-12">
    <div class="row">
        <?php include "inc/botao_novo.php"; ?>
        <?php include "inc/botao_salvar.php"; ?>
        <?php include "inc/botao_excluir.php"; ?>
    </div>
</div>
    <div class="row">
        <div class="col-md-9">
            <label>SITUAÇÃO:</label>
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
        return texto.replace(/[^\p{L}\p{N}\s]/gu, '');
    }

    function executafuncao(id){

        if (id=='new'){
            document.getElementById('cd_situacao').value = "";
            document.getElementById('txtnome').value = "";
            document.getElementById('txtstatus').value = "A";
            document.getElementById('txtnome').focus();
        }
        else if (id=="save"){  
            var codigo = document.getElementById('cd_situacao').value;
            var situacao = limparTexto(document.getElementById('txtnome').value);
            var status = document.getElementById('txtstatus').value;
            
            if (situacao == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o nome da situação!'
                });
                document.getElementById('txtnome').focus();
            } else {
                if (codigo == '') {
                    Tipo = "I"
                } else {
                    Tipo = "A";
                }

                window.open('cadastros/situacoes/acao.php?' + 'Tipo=' + Tipo + '&codigo=' + codigo + '&situacao=' + situacao + '&status=' + status, "acao");

            }
        } else if (id == "delete") {

            var codigo = document.getElementById('cd_situacao').value;

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
                        
                        window.open("cadastros/situacoes/acao.php?Tipo=E&codigo="+codigo, "acao");

                    } else {

                        return false;

                    }
                });

            }
        }
    }
</script>