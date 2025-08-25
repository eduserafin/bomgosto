<body onLoad="document.getElementById('seladministradora').focus();">
    <input type="hidden" name="cd_cota" id="cd_cota" value="">
    <div class="form-group col-md-12">
        <div class="row">
            <?php include "inc/botao_novo.php"; ?>
            <?php include "inc/botao_salvar.php"; ?>
            <?php include "inc/botao_excluir.php"; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-3">
                <label for="seladministradora">ADMINISTRADORA:</label>
                <select size="1" name="seladministradora" id="seladministradora" class="form-control" style="background:#E0FFFF;">
                    <option selected value=0>Selecione</option>
                    <?php
                        $SQL = "SELECT nr_sequencial, ds_administradora
                                FROM administradoras
                                WHERE st_status = 'A'
                                AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . " 
                                ORDER BY ds_administradora";
                        $RES = mysqli_query($conexao, $SQL);
                        while($lin=mysqli_fetch_row($RES)){
                            $nr_cdgo = $lin[0];
                            $ds_desc = $lin[1];
                            echo "<option value=$nr_cdgo>$ds_desc</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="col-md-2">
                <label for="txtgrupo">GRUPO:</label>
                <input type="text" name="txtgrupo" id="txtgrupo" maxlength="10" class="form-control" style="background:#E0FFFF;">
            </div>

            <div class="col-md-2">
                <label for="txtcota">COTA:</label>
                <input type="number" name="txtcota" id="txtcota" maxlength="10" class="form-control" style="background:#E0FFFF;">
            </div>

            <div class="col-md-2">
                <label for="txtvalor">VALOR DO CRÉDITO:</label>
                <input type="text" class="form-control" name="txtvalor" id="txtvalor" size="10" maxlength="20" style="text-align:right; background:#E0FFFF;" onkeypress="return formatar_moeda(this,'.',',',event);"> 
            </div>

            <div class="col-md-2">
                <label for="txtvalorentrada">VALOR DA ENTRADA:</label>
                <input type="text" class="form-control" name="txtvalorentrada" id="txtvalorentrada" size="10" maxlength="20" style="text-align:right; background:#E0FFFF;" onkeypress="return formatar_moeda(this,'.',',',event);"> 
            </div>

            <div class="col-md-2">
                <label for="txtprazo">PRAZO:</label>
                <input type="number" name="txtprazo" id="txtprazo" maxlength="10" class="form-control" style="background:#E0FFFF;">
            </div> 

            <div class="col-md-2">
                <label for="txtvalorparcela">VALOR DA PARCELA:</label>
                <input type="text" class="form-control" name="txtvalorparcela" id="txtvalorparcela" size="10" maxlength="20" style="text-align:right; background:#E0FFFF;" onkeypress="return formatar_moeda(this,'.',',',event);"> 
            </div>

            <div class="col-md-3">
                <label for="txtnome">NOME DO CONSORCIADO:</label>
                <input type="text" name="txtnome" id="txtnome" maxlength="100" class="form-control">
            </div>

            <div class="col-md-2">
                <label for="txtstatus">STATUS:</label>
                <select class="form-control" name="txtstatus" id="txtstatus" style="background:#E0FFFF;">
                    <option value="">Selecione</option>
                    <option value="A">Ativa</option>
                    <option value="V">Vendida</option>
                </select>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript">

    function formatar_moeda(campo, separador_milhar, separador_decimal, tecla) {
        var sep = 0;
        var key = '';
        var i = j = 0;
        var len = len2 = 0;
        var strCheck = '0123456789';
        var aux = aux2 = '';
        var whichCode = (window.Event) ? tecla.which : tecla.keyCode;

        if (whichCode == 13) return true; // Tecla Enter
        if (whichCode == 8) return true; // Tecla Delete
        key = String.fromCharCode(whichCode); // Pegando o valor digitado
        if (strCheck.indexOf(key) == -1) return false; // Valor inv�lido (n�o inteiro)
        len = campo.value.length;
        for(i = 0; i < len; i++)
        if ((campo.value.charAt(i) != '0') && (campo.value.charAt(i) != separador_decimal)) break;
        aux = '';
        for(; i < len; i++)
        if (strCheck.indexOf(campo.value.charAt(i))!=-1) aux += campo.value.charAt(i);
        aux += key;
        len = aux.length;
        if (len == 0) campo.value = '';
        if (len == 1) campo.value = '0'+ separador_decimal + '0' + aux;
        if (len == 2) campo.value = '0'+ separador_decimal + aux;

        if (len > 2) {
            aux2 = '';

            for (j = 0, i = len - 3; i >= 0; i--) {
                if (j == 3) {
                    aux2 += separador_milhar;
                    j = 0;
                }
                aux2 += aux.charAt(i);
                j++;
            }

            campo.value = '';
            len2 = aux2.length;
            for (i = len2 - 1; i >= 0; i--)
            campo.value += aux2.charAt(i);
            campo.value += separador_decimal + aux.substr(len - 2, len);
        }

        return false;
    }

    function executafuncao(id){

        if (id=='new'){
            document.getElementById('cd_cota').value = "";
            location.reload();
            document.getElementById('seladministradora').focus();
        }
        else if (id=="save"){  
            var codigo = document.getElementById('cd_cota').value;
            var administradora = document.getElementById('seladministradora').value;
            var grupo = document.getElementById('txtgrupo').value;
            var cota = document.getElementById('txtcota').value;
            var credito = document.getElementById('txtvalor').value;
            var entrada = document.getElementById('txtvalorentrada').value;
            var prazo = document.getElementById('txtprazo').value;
            var parcela = document.getElementById('txtvalorparcela').value;
            var nome = document.getElementById('txtnome').value;
            var status = document.getElementById('txtstatus').value;

            if (credito != '') {
                credito = credito.replace(/\./g, '');
                credito = credito.replace(',', '.');
            } else {
                credito = 0;
            }

            if (entrada != '') {
                entrada = entrada.replace(/\./g, '');
                entrada = entrada.replace(',', '.');
            } else {
                entrada = 0;
            }

            if (parcela != '') {
                parcela = parcela.replace(/\./g, '');
                parcela = parcela.replace(',', '.');
            } else {
                parcela = 0;
            }

            if (administradora == 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe uma administradora!'
                });
                document.getElementById('seladministradora').focus();
            } 
            else if (grupo == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o grupo!'
                });
                document.getElementById('txtgrupo').focus();
            } 
            else if (cota == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a cota!'
                });
                document.getElementById('txtcota').focus();
            } 
            else if (credito == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o valor do crédito!'
                });
                document.getElementById('txtvalor').focus();
            }
            else if (entrada == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o valor da entrada!'
                });
                document.getElementById('txtvalorentrada').focus();
            } 
            else if (prazo == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o prazo!'
                });
                document.getElementById('txtprazo').focus();
            } 
            else if (parcela == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o valor da parcela!'
                });
                document.getElementById('txtvalorparcela').focus();
            } 
            else if (status == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o status!'
                });
                document.getElementById('txtstatus').focus();
            } 
            else {
                if (codigo == '') {
                    Tipo = "I"
                } else {
                    Tipo = "A";
                }

                window.open('cadastros/cotas/acao.php?' + 'Tipo=' + Tipo + '&codigo=' + codigo + '&administradora=' + administradora + '&grupo=' + grupo + '&cota=' + cota + '&credito=' + credito + '&entrada=' + entrada + '&prazo=' + prazo + '&parcela=' + parcela + '&nome=' + nome + '&status=' + status, "acao");

            }
        } else if (id == "delete") {

            var codigo = document.getElementById('cd_cota').value;

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
                        
                        window.open("cadastros/cotas/acao.php?Tipo=E&codigo="+codigo, "acao");

                    } else {

                        return false;

                    }
                });

            }
        }
    }
</script>