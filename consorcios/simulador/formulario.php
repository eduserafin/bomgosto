<body onLoad="document.getElementById('txtnome').focus();">
    <input type="hidden" name="cd_proposta" id="cd_proposta" value="">
    <div class="form-group col-md-12">
        <div class="row">
            <?php include "inc/botao_novo.php"; ?>
            <?php include "inc/botao_salvar.php"; ?>
            <?php include "inc/botao_excluir.php"; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label for="txtnome">NOME:</label>                    
            <input type="text" name="txtnome" id="txtnome" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;">
        </div>

        <div class="col-md-2">
            <label for="txtcredito">CRÉDITO:</label>                    
            <input type="number" name="txtcredito" id="txtcredito" size="15" maxlength="100" class="form-control" style="background:#E0FFFF; text-align: right;" require onchange="javascript: parcelas(document.getElementById('selplano').value);">
        </div>

        <div class="col-md-3">
            <label for="selmes">QUANTIDADE DE MÊS:</label>                    
            <select id="selmes" class="form-control" style="background:#E0FFFF;" 
            require onchange="javascript: parcelas(document.getElementById('selplano').value);">
                <option value="0">Selecione uma opção</option>
                <?php
                    $sql = "SELECT nr_sequencial, nr_quantidade
                                FROM consorcio_quantidade_mes
                                WHERE st_status = 1
                            ORDER BY nr_quantidade DESC";
                    $res = mysqli_query($conexao, $sql);
                    while($lin=mysqli_fetch_row($res)){
                        $codigo = $lin[0];
                        $desc = $lin[1];

                        echo "<option value='$codigo'>$desc</option>";
                    }
                ?>
            </select>
        </div>

        <div class="col-md-3">
            <label for="selprazo">PRAZO DO GRUPO:</label>                    
            <select id="selprazo" class="form-control" style="background:#E0FFFF;">
                <option value="0">Selecione uma opção</option>
                <?php
                    $sql = "SELECT nr_sequencial, nr_quantidade
                                FROM consorcio_prazo_grupo
                                WHERE st_status = 1
                            ORDER BY nr_quantidade DESC";
                    $res = mysqli_query($conexao, $sql);
                    while($lin=mysqli_fetch_row($res)){
                        $codigo = $lin[0];
                        $desc = $lin[1];

                        echo "<option value='$codigo'>$desc</option>";
                    }
                ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <label for="txttaxa">TX. ADM:</label>                    
            <input type="number" name="txttaxa" id="txttaxa" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;" require onchange="javascript: parcelas(document.getElementById('selplano').value);">
        </div>

        <div class="col-md-3">
            <label for="selplano">PLANO:</label>                    
            <select id="selplano" class="form-control" style="background:#E0FFFF;"
            require onchange="javascript: parcelas(this.value);">
                <option value="0">Selecione uma opção</option>
                <?php
                    $sql = "SELECT nr_sequencial, ds_plano
                                FROM consorcio_planos
                                WHERE st_status = 1
                            ORDER BY ds_plano";
                    $res = mysqli_query($conexao, $sql);
                    while($lin=mysqli_fetch_row($res)){
                        $codigo = $lin[0];
                        $desc = $lin[1];

                        echo "<option value='$codigo'>$desc</option>";
                    }
                ?>
            </select>
        </div>  

        <div class="col-md-3">
            <label for="txtseguro">SEGURO PRESTAMISTA:</label>                    
            <input type="number" name="txtseguro" id="txtseguro" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;" require onchange="javascript: parcelas(document.getElementById('selplano').value);">
        </div>

        <div class="col-md-4" id="rsparcelas">
            <?php include "parcelas.php" ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <label for="txtlance">% LANCE EMBUTIDO:</label>                    
            <input type="number" name="txtlance" id="txtlance" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;" require onchange="javascript: cotas(document.getElementById('txtcotas').value, document.getElementById('txtparcela1').value, document.getElementById('txtparcela2').value);">
        </div>

        <div class="col-md-2">
            <label for="txtconvertidadas">PARCELAS CONVERTIDAS:</label>                    
            <input type="number" name="txtconvertidadas" id="txtconvertidadas" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;" require onchange="javascript: cotas(document.getElementById('txtcotas').value, document.getElementById('txtparcela1').value, document.getElementById('txtparcela2').value);">
        </div>

        <div class="col-md-3">
            <label for="txtreduzida">PARCELAS REDUZIDAS:</label>                                       
            <select id="txtreduzida" class="form-control" style="background:#E0FFFF;"
                require onchange="javascript: cotas(document.getElementById('txtcotas').value, document.getElementById('txtparcela1').value, document.getElementById('txtparcela2').value);">
                <option value="0">Selecione uma opção</option>
                <?php
                    $sql = "SELECT nr_sequencial, ds_plano
                                FROM consorcio_parcelas_reduzidas
                                WHERE st_status = 1
                            ORDER BY ds_plano";
                    $res = mysqli_query($conexao, $sql);
                    while($lin=mysqli_fetch_row($res)){
                        $codigo = $lin[0];
                        $desc = $lin[1];

                        echo "<option value='$codigo'>$desc</option>";
                    }
                ?>
            </select>
        </div>  
        
        <div class="col-md-2">
            <label for="txttipo">TIPO DE LANCE:</label>                    
            <select id="txttipo" class="form-control" style="background:#E0FFFF;"
                require onchange="javascript: cotas(document.getElementById('txtcotas').value, document.getElementById('txtparcela1').value, document.getElementById('txtparcela2').value);">
                <option value="0">Selecione uma opção</option>
                <?php
                    $sql = "SELECT nr_sequencial, ds_tipo
                                FROM consorcio_tipo_lance
                                WHERE st_status = 1
                            ORDER BY ds_tipo";
                    $res = mysqli_query($conexao, $sql);
                    while($lin=mysqli_fetch_row($res)){
                        $codigo = $lin[0];
                        $desc = $lin[1];

                        echo "<option value='$codigo'>$desc</option>";
                    }
                ?>
            </select>
        </div>  

        <div class="col-md-2">
            <label for="txtcotas">COTAS:</label>                    
            <input type="number" name="txtcotas" id="txtcotas" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;" require onchange="javascript: cotas(document.getElementById('txtcotas').value, document.getElementById('txtparcela1').value, document.getElementById('txtparcela2').value);">
        </div>
    </div>

    <div class="row">
        <br><br>
        <div class="col-md-12" id="rscotas">
          
        </div>
    </div>

</body>

<script type="text/javascript">

    function parcelas(tipo) {

        var credito = document.getElementById('txtcredito').value;
        credito = credito.replace(",", ".");
        var taxa = document.getElementById("txttaxa").value;
        taxa = taxa.replace(",", ".");
        var seguro = document.getElementById("txtseguro").value;
        seguro = seguro.replace(",", ".");
        var mes = document.getElementById("selmes").value;
        var quantidade = document.getElementById("txtcotas").value;

        var url = 'consorcios/simulador/parcelas.php?consulta=sim&tipo=' + tipo + '&credito=' + credito + '&taxa=' + taxa + '&seguro=' + seguro + '&seq_mes=' + mes;
        $.get(url, function(dataReturn) {
            $('#rsparcelas').html(dataReturn);
        });

        if(quantidade > 0) {
            cotas(quantidade, '', '');
        }

    }

    function cotas(quantidade, parcela1, parcela2) {

        var credito = document.getElementById('txtcredito').value;
        credito = credito.replace(",", ".");
        var plano = document.getElementById("selplano").value;
        var lance = document.getElementById("txtlance").value;
        var convertidada = document.getElementById("txtconvertidadas").value;
        var reduzida = document.getElementById("txtreduzida").value;
        var tipo = document.getElementById("txttipo").value;
        var mes = document.getElementById("selmes").value;
        var taxa = document.getElementById("txttaxa").value;
        taxa = taxa.replace(",", ".");
        var seguro = document.getElementById("txtseguro").value;
        
        var url = 'consorcios/simulador/cotas.php?consulta=sim&quantidade=' + quantidade + '&credito=' + credito + '&parcela1=' + parcela1 + '&parcela2=' + parcela2 + '&lance=' + lance + '&convertidada=' + convertidada + '&plano=' + plano + '&reduzida=' + reduzida + '&tipo=' + tipo + '&mes=' + mes + '&taxa=' + taxa + '&seguro=' + seguro;
        $.get(url, function(dataReturn) {
            $('#rscotas').html(dataReturn);
        });

    }

    function Pdf() {

        var credito = document.getElementById('txtcredito').value;
        credito = credito.replace(",", ".");
        var plano = document.getElementById("selplano").value;
        var lance = document.getElementById("txtlance").value;
        var convertidada = document.getElementById("txtconvertidadas").value;
        var reduzida = document.getElementById("txtreduzida").value;
        var tipo = document.getElementById("txttipo").value;
        var mes = document.getElementById("selmes").value;
        var taxa = document.getElementById("txttaxa").value;
        taxa = taxa.replace(",", ".");
        var seguro = document.getElementById("txtseguro").value;
        var quantidade = document.getElementById("txtcotas").value;
        var parcela1 = document.getElementById("txtparcela1").value;
        var parcela2 = document.getElementById("txtparcela2").value;    
        var nome = document.getElementById("txtnome").value;

        window.open('consorcios/simulador/pdf.php?quantidade=' + quantidade + '&credito=' + credito + '&parcela1=' + parcela1 + '&parcela2=' + parcela2 + '&lance=' + lance + '&convertidada=' + convertidada + '&plano=' + plano + '&reduzida=' + reduzida + '&tipo=' + tipo + '&mes=' + mes + '&taxa=' + taxa + '&seguro=' + seguro + '&nome=' + nome, "mensagemrel");
        document.getElementById("clickModal").click();

    }

    function executafuncao(id){

        if (id=='new'){

            location.reload();
            
        } else if (id=="save"){  

            var codigo = document.getElementById('cd_proposta').value;
            var nome = document.getElementById('txtnome').value;
            var credito = document.getElementById('txtcredito').value;
            credito = credito.replace(",", ".");
            var cotas = document.getElementById("txtcotas").value;
            var mes = document.getElementById("selmes").value;
            var prazo = document.getElementById("selprazo").value;
            var taxa = document.getElementById("txttaxa").value;
            taxa = taxa.replace(",", ".");
            var plano = document.getElementById("selplano").value;
            var seguro = document.getElementById("txtseguro").value;
            seguro = seguro.replace(",", ".");
            var parcela1 = document.getElementById("txtparcela1").value;
            parcela1 = parcela1.replace(",", ".");
            var parcela2 = document.getElementById("txtparcela2").value;
            parcela2 = parcela2.replace(",", ".");
            var lance = document.getElementById("txtlance").value;
            var convertidada = document.getElementById("txtconvertidadas").value;
            var reduzida = document.getElementById("txtreduzida").value;
            var tipo = document.getElementById("txttipo").value;
            
            if (nome == "") {

                Swal.fire({
					icon: 'warning',
					title: 'Oops...',
					text: 'Informe um nome!'
				});
				document.getElementById('txtnome').focus();
                
            } else if (credito == "") {

                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o valor do crédito!'
                });
                document.getElementById('txtcredito').focus();

            } else if (cotas == "") {

                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a quantidade de cotas!'
                });
                document.getElementById('txtcotas').focus();

            } else if (mes == 0) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a quantidade de mêses!'
                });
                document.getElementById('selmes').focus();

            } else if (prazo == 0) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o prazo do grupo!'
                });
                document.getElementById('selprazo').focus();

            } else if (taxa == "") {

                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a porcentagem da taxa administrativa!'
                });
                document.getElementById('txttaxa').focus();

            } else if (plano == 0) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe um plano!'
                });
                document.getElementById('selplano').focus();

            } else if (seguro == "") {

                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a porcentagem do seguro!'
                });
                document.getElementById('txtseguro').focus();

            }
            else if (lance == "") {

                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a % do lance embutido!'
                });
                document.getElementById('txtlance').focus();

            } else if (convertidada == "") {

                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a quantidade de parcelas convertidas!'
                });
                document.getElementById('txtconvertidadas').focus();

            }
            else if (reduzida == 0) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe se é parcela reduzida!'
                });
                document.getElementById('txtreduzida').focus();

            } else if (tipo == 0) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o tipo de lance!'
                });
                document.getElementById('txttipo').focus();

            } else {

                if (codigo == '') {
                    Tipo = "I"
                } else {
                    Tipo = "A";
                }

                window.open('consorcios/simulador/acao.php?Tipo=' + Tipo + '&codigo=' + codigo + '&nome=' + nome + '&credito=' + credito + '&cotas=' + cotas + '&mes=' + mes + '&prazo=' + prazo + '&taxa=' + taxa + '&plano=' + plano + '&seguro=' + seguro + '&parcela1=' + parcela1 + '&parcela2=' + parcela2 + '&lance=' + lance + '&convertidada=' + convertidada + '&reduzida=' + reduzida + '&tipo=' + tipo, "acao");
            }

        } else if (id == "delete") {

            var codigo = document.getElementById('cd_proposta').value;

            if(codigo==''){  

                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Selecione uma proposta para realizar a exclusão!'
                }); 

            } else {

                Swal.fire({
                    title: 'Deseja excluir a proposta selecionada?',
                    text: "Não tem como reverter esta ação!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, excluir!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        
                        window.open("consorcios/simulador/acao.php?Tipo=E&codigo="+codigo, "acao");

                    } else {

                        return false;

                    }
                });

            }
        }

    }

</script>