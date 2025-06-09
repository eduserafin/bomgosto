<body onLoad="document.getElementById('txtnome').focus();">
    <input type="hidden" name="cd_parametro" id="cd_parametro" value="">
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
                <label>COLABORADOR:</label>
                <select size="1" name="selcolaborador" id="selcolaborador" class="form-control" style="background:#E6FFE0;">
                    <option selected value=0>Selecione</option>
                    <?php
                        $SQL = "SELECT nr_sequencial, ds_colaborador
                                FROM colaboradores
                                WHERE st_status = 'A'
                                AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . " 
                                ORDER BY ds_colaborador";
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
                <label>COMISSÃO:</label>
                <input type="number" name="txtcomissao" id="txtcomissao" maxlength="10" class="form-control" style="background:#E6FFE0;">
            </div>

            <div class="col-md-2">
                <label>PARCELAS:</label>
                <input type="number" name="txtparcelas" id="txtparcelas" maxlength="10" class="form-control" style="background:#E6FFE0;" onChange="javascript: BuscarComissao(this.value, '');">
            </div>

            <div class="col-md-3">
                <label>ADMINISTRADORA:</label>
                <select size="1" name="seladministradora" id="seladministradora" class="form-control" style="background:#E6FFE0;">
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
        </div>
        <div class="row"><br>
            <div class="col-md-6" id="rscomissoes">
                <?php include "comissao.php"; ?>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript">

    /*
    $(document).ready(function() {
        $('#selcolaborador').select2();
    });

    $(document).ready(function() {
        $('#seladministradora').select2();
    });
    */
    function executafuncao(id){

        if (id=='new'){
            document.getElementById('cd_parametro').value = "";
            location.reload();
            document.getElementById('txtcomissao').focus();
        }
        else if (id=="save"){  
            var codigo = document.getElementById('cd_parametro').value;
            var colaborador = document.getElementById('selcolaborador').value;
            var comissao = document.getElementById('txtcomissao').value;
            var parcelas = document.getElementById('txtparcelas').value;
            var administradora = document.getElementById('seladministradora').value;
            var comissoes = "";
            var comissoesPorParcela = [];
            var somaComissoes = 0;

            for (var i = 1; i <= parcelas; i++) {
                var valor = document.getElementById('txtcomissaoparcela' + i).value.replace(',', '.'); // tratar vírgulas
                var numero = parseFloat(valor) || 0;
                somaComissoes += numero;
                comissoesPorParcela.push(valor);
            }

            comissoes = comissoesPorParcela.join(',');
           
            if (colaborador == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe um colaborador!'
                });
                document.getElementById('selcolaborador').focus();
            } 
            else if (comissao == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a comissão total!'
                });
                document.getElementById('txtcomissao').focus();
            } 
            else if (parcelas == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a quantidade de parcelas'
                });
                document.getElementById('sexo').focus();
            }
            else if (administradora == 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a administradora!'
                });
                document.getElementById('seladministradora').focus();
            } 
            else if (Math.abs(somaComissoes - parseFloat(comissao)) > 0.01) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'A soma das comissões por parcela (' + somaComissoes.toFixed(2).replace('.', ',') + ') difere da comissão total informada (' + parseFloat(comissao).toFixed(2).replace('.', ',') + '). Verifique!'
                });
            }
            else {
                if (codigo == '') {
                    Tipo = "I"
                } else {
                    Tipo = "A";
                }

                window.open('cadastros/comissoes/acao.php?' + 'Tipo=' + Tipo + '&codigo=' + codigo + '&colaborador=' + colaborador + '&comissao=' + comissao + '&parcelas=' + parcelas + '&administradora=' + administradora + '&comissoes=' + encodeURIComponent(comissoes), "acao");

            }
        } else if (id == "delete") {

            var codigo = document.getElementById('cd_parametro').value;

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
                        
                        window.open("cadastros/comissoes/acao.php?Tipo=E&codigo="+codigo, "acao");

                    } else {

                        return false;

                    }
                });

            }
        }
    }
</script>