<?php

if ($chave == "") {
    $chave = substr(md5(date("dmYHis")), 0, 7);
}

?>

<body onLoad="document.getElementById('txtnome').focus();">
    <input type="hidden" name="cd_proposta" id="cd_proposta" value="">
    <input type="hidden" name="chave" id="chave" value="<?php echo $chave; ?>">
    <div class="form-group col-md-12">
        <div class="row">
            <?php include "inc/botao_novo.php"; ?>
            <!--<?php include "inc/botao_salvar.php"; ?>
            <?php include "inc/botao_excluir.php"; ?>-->
        </div>
    </div>
    <div class="row" id="inicio">
        <div class="col-md-4">
            <label for="txtnome">NOME:</label>                    
            <input type="text" name="txtnome" id="txtnome" size="15" maxlength="100" class="form-control" style="background:#E0FFFF;">
        </div>

        <div class="col-md-2">
            <label for="txtcredito">CRÉDITO TOTAL:</label>                    
            <input type="number" name="txtcredito" id="txtcredito" size="15" maxlength="100" class="form-control" style="background:#E0FFFF; text-align: right;">
        </div>
        <div class="col-md-2"><br>
            <button type=button name="btsalvar" id="btsalvar" class="btn btn-success" onClick="javascript: Iniciar();"><span class="glyphicon glyphicon-ok"></span> INICIAR SIMULAÇÃO</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" id="simulador">
            
        </div>
    </div>
    <div class="row"><br>
        <div class="col-md-12" id="rscotas">
          
        </div>
    </div>

</body>

<script type="text/javascript">

    function Iniciar() {
        
        var codigo = document.getElementById('cd_proposta').value;
        var nome = document.getElementById('txtnome').value;
        var credito = document.getElementById('txtcredito').value;

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

        }else {

            if (codigo == '') {
                Tipo = "I"
            } else {
                Tipo = "A";
            }

            window.open('consorcios/simulador/acao.php?Tipo=' + Tipo + '&codigo=' + codigo + '&nome=' + nome + '&credito=' + credito, "acao");
        }

    }


    function simulador(nr_seq_proposta) {

        var url = 'consorcios/simulador/simulador.php?consulta=sim&nr_seq_proposta=' + nr_seq_proposta;
        $.get(url, function(dataReturn) {
            $('#simulador').html(dataReturn);
        });

    }

    function cotas(nr_seq_proposta) {

        var url = 'consorcios/simulador/cotas.php?consulta=sim&nr_seq_proposta=' + nr_seq_proposta;
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