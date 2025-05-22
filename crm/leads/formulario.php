<body onLoad="document.getElementById('txtnome').focus();">
<input type="hidden" name="cd_lead" id="cd_lead" value="">
<div class="form-group col-md-12">
    <div class="row">
        <?php include "inc/botao_novo.php"; ?>
        <?php include "inc/botao_salvar.php"; ?>
        <?php include "inc/botao_excluir.php"; ?>
    </div>
</div>
    <div class="row">
        <div class="col-md-4">
            <label>NOME:</label>
            <input type="text" name="txtnome" id="txtnome" size="10" maxlength="100" style="background:#E6FFE0;" class="form-control">
        </div>
        <div class="col-md-4">
            <label for="txtmunicipio">CIDADE:</label>
            <select name="txtmunicipio" id="txtmunicipio" class="form-control" style="background:#E0FFFF;">
                <option value="0">Selecione</option>
                <?php
                    $sel = "SELECT cd_municipioibge, ds_municipioibge
                            FROM municipioibge
                            ORDER BY ds_municipioibge";
                    $res = mysqli_query($conexao, $sel);
                    while($lin=mysqli_fetch_row($res)){
                        $nr_cdgo = $lin[0];
                        $ds_munic = $lin[1];
                        echo "<option value=$nr_cdgo>$ds_munic</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="txtsegmento">SEGMENTO:</label>
            <select name="txtsegmento" id="txtsegmento" class="form-control" style="background:#E0FFFF;">
                <option value="0">Selecione</option>
                <?php
                    $sel = "SELECT nr_sequencial, ds_segmento
                            FROM segmentos
                            ORDER BY ds_segmento";
                    $res = mysqli_query($conexao, $sel);
                    while($lin=mysqli_fetch_row($res)){
                        $nr_cdgo = $lin[0];
                        $ds_desc = $lin[1];
                        echo "<option value=$nr_cdgo>$ds_desc</option>";
                    }
                ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <label>VALOR:</label>
            <input type="number" name="txtvalor" id="txtvalor" size="10" maxlength="10" style="background:#E6FFE0;" class="form-control">
        </div>
        <div class="col-md-2">
            <label>CONTATO:</label>
            <input type="text" name="txtcontato" id="txtcontato" size="10" maxlength="15" style="background:#E6FFE0;" class="form-control">
        </div>
        <div class="col-md-4">
            <label>E-MAIL:</label>
            <input type="text" name="txtemail" id="txtemail" size="10" maxlength="100" class="form-control">
        </div>
    </div>

</body>

<script type="text/javascript">

    $(document).ready(function() {
        $('#txtmunicipio').select2();
    });

    $(document).ready(function() {
        $('#txtsegmento').select2();
    });

    function limparTexto(texto) {
        return texto.replace(/[^a-zA-Z0-9\s]/g, '');
    }

    function executafuncao(id){

        if (id=='new'){
            document.getElementById('cd_lead').value = "";
            document.getElementById('txtnome').value = "";
            document.getElementById('txtcontato').value = "";
            document.getElementById('txtmunicipio').value = "0";
            document.getElementById('txtvalor').value = "";
            document.getElementById('txtsegmento').value = "0";
            document.getElementById('txtemail').value = "";
            document.getElementById('txtnome').focus();
        }
        else if (id=="save"){  
            var codigo = document.getElementById('cd_lead').value;
            var nome = limparTexto(document.getElementById('txtnome').value);
            var contato = document.getElementById('txtcontato').value;
            var cidade = document.getElementById('txtmunicipio').value;
            var valor = document.getElementById('txtvalor').value;
            var segmento = document.getElementById('txtsegmento').value;
            var email = document.getElementById('txtemail').value;

            if (nome == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o nome!'
                });
                document.getElementById('txtnome').focus();
            } else if (contato == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe um contato!'
                });
                document.getElementById('txtcontato').focus();
            } else if (cidade == 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe uma cidade!'
                });
                document.getElementById('txtmunicipio').focus();
            } else if (valor == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o valor!'
                });
                document.getElementById('txtvalor').focus();
            } else {
                if (codigo == '') {
                    Tipo = "I"
                } else {
                    Tipo = "A";
                }

                window.open('crm/leads/acao.php?' + 'Tipo=' + Tipo + '&codigo=' + codigo + '&nome=' + nome + '&contato=' + contato + '&cidade=' + cidade + '&valor=' + valor + '&segmento=' + segmento + '&email=' + email, "acao");

            }
        } else if (id == "delete") {

            var codigo = document.getElementById('cd_lead').value;

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
                        
                        window.open("crm/leads/acao.php?Tipo=E&codigo="+codigo, "acao");

                    } else {

                        return false;

                    }
                });

            }
        }
    }
</script>