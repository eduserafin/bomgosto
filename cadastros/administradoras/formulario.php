<body onLoad="document.getElementById('txtnome').focus();">
<input type="hidden" name="cd_administradora" id="cd_administradora" value="">
<div class="form-group col-md-12">
    <div class="row">
        <?php include "inc/botao_novo.php"; ?>
        <?php include "inc/botao_salvar.php"; ?>
        <?php include "inc/botao_excluir.php"; ?>
    </div>
</div>
    <div class="row">
        <div class="col-md-9">
            <label>ADMINISTRADORA:</label>
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
            document.getElementById('cd_administradora').value = "";
            document.getElementById('txtnome').value = "";
            document.getElementById('txtstatus').value = "A";
            document.getElementById('txtnome').focus();
        }
        else if (id=="save"){  
            var codigo = document.getElementById('cd_administradora').value;
            var administradora = limparTexto(document.getElementById('txtnome').value);
            var status = document.getElementById('txtstatus').value;
            
            if (administradora == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o nome da administradora!'
                });
                document.getElementById('txtnome').focus();
            } else {
                if (codigo == '') {
                    Tipo = "I"
                } else {
                    Tipo = "A";
                }

                window.open('cadastros/administradoras/acao.php?' + 'Tipo=' + Tipo + '&codigo=' + codigo + '&administradora=' + administradora + '&status=' + status, "acao");

            }
        } else if (id == "delete") {

            var codigo = document.getElementById('cd_administradora').value;

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
                        
                        window.open("cadastros/administradoras/acao.php?Tipo=E&codigo="+codigo, "acao");

                    } else {

                        return false;

                    }
                });

            }
        }
    }
</script>