<body onLoad="document.getElementById('txtempresa').focus();">
<input type="hidden" name="cd_financeiro" id="cd_financeiro" value="">
<div class="form-group col-md-12">
    <div class="row">
        <?php include "inc/botao_novo.php"; ?>
        <?php include "inc/botao_salvar.php"; ?>
        <?php include "inc/botao_excluir.php"; ?>
    </div>
</div>
    <div class="row">
        <div class="col-md-3">
            <label for="txtempresa">EMPRESA:</label>                     
                <select id="txtempresa" class="form-control" style="background:#E0FFFF;"
                onchange="javascript: usuarios(this.value, '', document.getElementById('txtquantidade').value);">
                    <option value='0'>Selecione uma empresa</option>
                    <?php
                        $sql = "SELECT nr_sequencial, ds_empresa
                                FROM empresas
                                WHERE st_status = 'A'
                                ORDER BY ds_empresa";
                        $res = mysqli_query($conexao, $sql);
                        while($lin=mysqli_fetch_row($res)){
                            $cdg = $lin[0];
                            $desc = $lin[1];

                            echo "<option value='$cdg'>$desc</option>";
                        }
                    ?>
                </select>
        </div>
        <div class="col-md-2">
            <label for="txtdatainicio">DATA INÍCIO:</label>
            <input type="date" class="form-control" id="txtdatainicio" size="10" maxlength="10" style="background:#E0FFFF;">
        </div>
        <div class="col-md-2">
            <label for="txtdatafim">DATA FIM:</label>
            <input type="date" class="form-control" id="txtdatafim" size="10" maxlength="10" style="background:#E0FFFF;">
        </div>
        <div class="col-md-2">
            <label for="txtquantidade">USUÁRIOS:</label>
            <input type="number" class="form-control" name="txtquantidade" id="txtquantidade" size="10" maxlength="10" style="background:#E0FFFF;" onchange="javascript: usuarios(document.getElementById('txtempresa').value, '', this.value);"> 
        </div>
        <div class="col-md-2">
            <label for="txtvalor">VALOR:</label>
            <input type="text" class="form-control" name="txtvalor" id="txtvalor" size="10" maxlength="20" style="text-align:right; background:#E0FFFF;" onkeypress="return formatar_moeda(this,'.',',',event);"> 
        </div>
    </div>

    <div class="row">
       
        <div class="col-md-3">
            <label for="txtforma">FORMA DE PAGAMENTO:</label>
            <select class="form-control" name="txtforma" id="txtforma" style="background:#E0FFFF;">
                <option value="">Selecione uma opção</option>
                <option value="D">Dinheiro</option>
                <option value="P">Pix</option>
                <option value="C">Cartão</option>
                <option value="B">Boleto</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="txtstatus">STATUS:</label>
            <select class="form-control" name="txtstatus" id="txtstatus" style="background:#E0FFFF;">
                <option value="">Selecione uma opção</option>
                <option value="A">Ativo</option>
                <option value="I">Inativo</option>
                <option value="P">Pendente</option>
                <option value="C">Cancelado</option>
                <option value="T">Teste</option>
            </select>
        </div>
        <div class="col-md-5">
            <label for="txtcomentario">OBSERVAÇÕES:</label>
            <textarea class="form-control" id="txtcomentario" name="txtcomentario" rows="1" maxlength="1000" placeholder="Escreva seu comentário..."></textarea>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4" id="divusuarios">
            <?php include 'usuarios.php'; ?>
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

    function usuarios(empresa, editar, quantidade){
        var url = 'cadastros/assinaturas/usuarios.php?consulta=sim&empresa=' + empresa + '&editar=' + editar + '&quantidade=' + quantidade;
        $.get(url, function(dataReturn) {
            $('#divusuarios').html(dataReturn);
        });
    }

    function limparTexto(texto) {
        return texto.replace(/[^\p{L}\p{N}\s]/gu, '');
    }

    function executafuncao(id){

        if (id=='new'){
            
            document.getElementById('cd_financeiro').value = "";
            document.getElementById('txtempresa').value = "0";
            document.getElementById('txtdatainicio').value = "";
            document.getElementById('txtdatafim').value = "";
            document.getElementById('txtvalor').value = "";
            document.getElementById('txtforma').value = "";
            document.getElementById('txtstatus').value = "";
            document.getElementById('txtcomentario').value = "";
            document.getElementById('txtquantidade').value = "";
            document.getElementById('txtempresa').focus();
            
        } else if (id == "save") {  
            
            var codigo = document.getElementById('cd_financeiro').value;
            var empresa = document.getElementById('txtempresa').value;
            var datai = document.getElementById('txtdatainicio').value;
            var dataf = document.getElementById('txtdatafim').value;
            var valor = document.getElementById('txtvalor').value;
            var forma = document.getElementById('txtforma').value;
            var observacao = limparTexto(document.getElementById('txtcomentario').value);
            var status = document.getElementById('txtstatus').value;
            var quantidade = parseInt(document.getElementById('txtquantidade').value);
            var usuariosMarcados = document.querySelectorAll('input[name="usuario[]"]:checked');
            var totalSelecionados = usuariosMarcados.length;
            var usuario = Array.from(usuariosMarcados).map(el => el.value).join(',');
        
            if (valor != '') {
                valor = valor.replace(/\./g, '');     // remove todos os pontos
                valor = valor.replace(',', '.');      // troca a vírgula por ponto
            } else {
                valor = 0;
            }
        
            if (empresa == 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe uma empresa!'
                });
                document.getElementById('txtempresa').focus();
            } else if (totalSelecionados === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Selecione ao menos um usuário!'
                });
                return;
            } else if (totalSelecionados > quantidade) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Atenção!',
                    text: 'Você selecionou mais usuários do que o permitido!'
                });
                return;
            } else if (datai == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a data de início!'
                });
                document.getElementById('txtdatainicio').focus();
            } else if (dataf == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a data fim!'
                });
                document.getElementById('txtdatafim').focus(); 
            } else if (status == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o status!'
                });
                document.getElementById('txtstatus').focus();
            } else if (isNaN(quantidade) || quantidade <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a quantidade válida de usuários!'
                });
                document.getElementById('txtquantidade').focus();
            } else {
                
                var Tipo = (codigo == '') ? "I" : "A";
        
                window.open('cadastros/assinaturas/acao.php?' + 'Tipo=' + Tipo + '&codigo=' + codigo + '&usuario=' + usuario + '&datai=' + datai + '&dataf=' + dataf + '&valor=' + valor + '&forma=' + forma + '&observacao=' + observacao + '&status=' + status + '&empresa=' + empresa + '&quantidade=' + quantidade, "acao");
            }
            
        } else if (id == "delete") {

            var codigo = document.getElementById('cd_financeiro').value;

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
                        
                        window.open("cadastros/assinaturas/acao.php?Tipo=E&codigo="+codigo, "acao");

                    } else {

                        return false;

                    }
                });

            }
        }
    }
</script>