<?php

    if($_SESSION["ST_ADMIN"] == 'G'){
        $v_filtro_empresa = "AND ls.nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "";
        $hidden = '';
    } else if ($_SESSION["ST_ADMIN"] == 'C') {
        $v_filtro_empresa = "AND ls.nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "";
        $hidden = 'hidden';
    } else {
        $v_filtro_empresa = "";
        $hidden = '';
    }

?>
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
        <div class="col-md-3">
            <label>NOME CLIENTE: <font color='red'>*</font></label>
            <input type="text" name="txtnome" id="txtnome" size="10" maxlength="100" class="form-control">
        </div>
        <div class="col-md-2">
            <label>VALOR:</label>
            <input type="text" class="form-control" name="txtvalor" id="txtvalor" size="10" maxlength="20" style="text-align:right;" onkeypress="return formatar_moeda(this,'.',',',event);">
        </div>
        <div class="col-md-2">
            <label>CONTATO:</label>
            <input type="text" name="txtcontato" id="txtcontato" size="10" maxlength="15" class="form-control">
        </div>
        <div class="col-md-4">
            <label>E-MAIL:</label>
            <input type="text" name="txtemail" id="txtemail" size="10" maxlength="100" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3" <?php echo $hidden; ?>>
            <label for="txtvendedor">VENDEDOR:</label>                     
            <select id="txtvendedor" class="form-control">
                <option value='0'>Selecione um colaborador</option>
                    <?php
                        $sql = "SELECT u.nr_sequencial, c.ds_colaborador
                                FROM colaboradores c
                                INNER JOIN usuarios u ON c.nr_sequencial = u.nr_seq_colaborador
                                WHERE u.st_status = 'A'
                                $v_filtro_empresa
                                ORDER BY c.ds_colaborador";
                        $res = mysqli_query($conexao, $sql);
                        while($lin=mysqli_fetch_row($res)){
                            $cdg = $lin[0];
                            $desc = $lin[1];
                
                            if($cdg == $colaborador){ $sel = "selected"; }
                            else { $sel = ""; }

                            echo "<option value=$cdg $sel>$desc</option>";
                        }
                        
                    ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="txtmunicipio">CIDADE:</label>
            <select name="txtmunicipio" id="txtmunicipio" class="form-control">
                <option value="0">Selecione</option>
                <?php
                    $sel = "SELECT c.nr_sequencial, c.ds_municipio, e.sg_estado
                            FROM cidades c
                            INNER JOIN estados e ON c.nr_seq_estado = e.nr_sequencial
                            ORDER BY c.ds_municipio";
                    $res = mysqli_query($conexao, $sel);
                    while($lin=mysqli_fetch_row($res)){
                        $nr_cdgo = $lin[0];
                        $ds_munic = $lin[1];
                        $sg_estado = $lin[2];

                        echo "<option value=$nr_cdgo>$ds_munic - $sg_estado</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="txtsegmento">SEGMENTO:</label>
            <select name="txtsegmento" id="txtsegmento" class="form-control">
                <option value="0">Selecione</option>
                <?php
                    $sel = "SELECT nr_sequencial, ds_segmento
                            FROM segmentos
                            WHERE st_status = 'A'
                            AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "
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

</body>

<script type="text/javascript">

    $(document).ready(function() {
        $('#txtvendedor').select2();
    });

    $(document).ready(function() {
        $('#txtmunicipio').select2();
    });

    $(document).ready(function() {
        $('#txtsegmento').select2();
    });

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

    function limparTexto(texto) {
        return texto.replace(/[^\p{L}\p{N}\s]/gu, '');
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
            document.getElementById('txtvendedor').value = "0";
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
            var vendedor = document.getElementById('txtvendedor').value;

            if (valor != '') {
                valor = valor.replace(/\./g, '');     // remove todos os pontos
                valor = valor.replace(',', '.');      // troca a vírgula por ponto
            } else {
                valor = 0;
            }

            if (nome == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o nome!'
                });
                document.getElementById('txtnome').focus();
            } else {
                if (codigo == '') {
                    Tipo = "I"
                } else {
                    Tipo = "A";
                }

                window.open('crm/leads/acao.php?' + 'Tipo=' + Tipo + '&codigo=' + codigo + '&nome=' + nome + '&contato=' + contato + '&cidade=' + cidade + '&valor=' + valor + '&segmento=' + segmento + '&email=' + email + '&vendedor=' + vendedor, "acao");
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