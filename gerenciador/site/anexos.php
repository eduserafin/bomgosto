<?php

//20/08/2021 Eduardo Serafin
//criado aba para salvar documentos dos colaboradores

foreach($_GET as $key => $value){
	$$key = $value;
}

session_start();

//echo "xx" . $consultar . "|" . $_SESSION["CD_USUARIO"] . "xx";

if ($consultar == "sim") {
    include "../../cabecalho.php";
    require_once '../../inc/verifica_is_monitor.php';
}

$sql_perfil = "SELECT COALESCE(tp_perfil,'N') FROM g_usuarios WHERE nr_sequencial = '" . $_SESSION["CD_USUARIO"] . "'";
$rss_perfil = pg_query($conexao, $sql_perfil);
while ($line_perfil = pg_fetch_row($rss_perfil)) {
    $perfil = $line_perfil[0];
}

if ($perfil == 'RH' or $perfil == 'GE') {

    if ($nr_clifor != "") {  
        
        ?>
        <input type="hidden" name="cd_clifor_doc" id="cd_clifor_doc" value="<?php echo $nr_clifor; ?>">
                
                <div class="col-md-12"><br>
            
                    <div class="row text-center">
                        <div class="col-md-12 text-center" style="margin-bottom:10px;">
                            <h4 class="bg-gray" style="padding: 10px 0px;">ANEXAR DOCUMENTOS</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 text-left">
                            <label>TIPO DO DOCUMENTO</label>
                            <select id="txttipodocumento" name="txttipodocumento" class="form-control" style="background:#E0FFFF;" 
                                required onChange="javascript: BuscarDatas(document.getElementById('txttipodocumento').value);">
                                <option value="0">Selecione um documento</option>
                                <?php
                                $sql = "SELECT nr_sequencial, ds_docto
                                            FROM doctos_colab
                                        WHERE st_cadastro = 'A'
                                        ORDER BY ds_docto";
                                $res = pg_query($conexao, $sql);
                                while($lin=pg_fetch_row($res)){
                                    $nr_docto = $lin[0];
                                    $ds_docto = $lin[1];
                                    echo "<option value=$nr_docto>$ds_docto</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-8 text-left">
                            <label for="txtdescricao">DESCRIÇÃO:</label>
                            <input type="text" name="txtdescricao" id="txtdescricao" size="20" maxlength="100"  class="form-control">
                        </div>

                        <div class="col-md-12" id="rsDatas">                    

                        </div>  

                        <div class="col-md-12 text-left"> 
                            <label>DOCUMENTO</label>
                            <input type="file" id="campoDocumento1" onchange="verificaExtensao(this)" class="bloqueia_carregando form-control" required>
                            <span class="help-block">Selecione um anexo.</span>
                            <label style="width:100%">
                                <span class="hidden" id="carregando_documento1">  <i class="fa fa-spinner fa-pulse"></i> Carregando...</span>&nbsp;
                            </label>
                        </div>

                        <div class="col-md-12 text-left">
                            <button type=button name="btsalvar" id="btsalvar" class="btn btn-success" onClick="javascript: salvarDocumento();"><span class="glyphicon glyphicon-ok"></span> SALVAR ANEXO</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-left">
                        <table width="100%" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="vertical-align:middle;">DOCUMENTO</th>
                                <th style="vertical-align:middle;">CADASTRADO EM</th>
                                <th style="vertical-align:middle;">DESCRIÇÃO</th>
                                <th style="vertical-align:middle;">#</th>
                                <th style="vertical-align:middle;">#</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php

                                    $sql = "SELECT d.nr_sequencial, c.ds_docto, d.ds_descricao, d.dt_cadastro, 
                                    string_agg(d.ds_arquivo, '|') AS anexos, d.cd_usercadastro, d.ds_local
                                            FROM colab_doctos d INNER JOIN doctos_colab c ON d.nr_seq_tipo_documento = c.nr_sequencial
                                            WHERE d.nr_seq_colab = $nr_clifor
                                            GROUP BY d.nr_sequencial, c.ds_docto, d.ds_descricao, d.dt_cadastro, d.cd_usercadastro, d.ds_local
                                            ORDER BY d.dt_cadastro DESC, c.ds_docto"; //echo $sql;
                                    $res = pg_query($conexao, $sql);
                                    while($lin = pg_fetch_row($res)){
                                        $nr_documento = $lin[0];
                                        $ds_documento = $lin[1];
                                        $ds_descricao = $lin[2];
                                        $dt_cadastro = date('d/m/Y H:i',strtotime($lin[3]));
                                        $ds_arquivo = explode('|', $lin[4]); 
                                        $dsusuario = $lin[5];
                                        $local = $lin[6];

                                ?>
                                    <tr>
                                        <td><?php echo $ds_documento; ?></td>
                                        <td><?php echo $dt_cadastro; ?></td>
                                        <td><?php echo $ds_descricao; ?></td>
                                        <td width="5%" align="center">
                                            <?php if(strlen($ds_arquivo[0]) > 0) { ?>
                                            <div class="btn-group">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-save"></span></button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <?php foreach($ds_arquivo as $anexo) { ?>
                                                    <?php 
                                                        if($local == 'C'){
                                                        ?>
                                                        <li><a href="cadastros/colab/arquivoscolab/<?php echo $anexo ?>" target='_blank'><?php echo $anexo ?></a></li>
                                                    <?php } else {
                                                        ?>
                                                        <li><a href="cadastros/controle_exames/documentos/<?php echo $anexo ?>" target='_blank'><?php echo $anexo ?></a></li>
                                                        <?php
                                                    } 
                                                    } 
                                                    ?>
                                                </ul>
                                            </div>
                                            <?php } ?>
                                        </td>
                                        <?php
                                            if($dsusuario == $_SESSION["CD_USUARIO"] or $IS_MONITOR){
                                                ?>
                                                <td width='5%' align='center'><button type="button" name="btexcluir" id="btexcluir" class="btn btn-danger" onclick="javascript: excluirDocumentoD(<?php echo $nr_documento; ?>);" title="Excluir" alt="Excluir"><span class="glyphicon glyphicon-remove"></span></button></td>
                                                <?php
                                            }
                                        ?>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
}
?>

<script language="javascript">

    function BuscarDatas(tipo) {

        if(tipo == 21){
            var url = 'cadastros/colab/datas.php?consulta=sim&tipo='+tipo;
            $.get(url, function (dataReturn) {
                $('#rsDatas').html(dataReturn);
            });

        }
    }

    function ClicaD(id) {
        var nrcolab = document.getElementById('cd_clifor_doc').value;
        window.open('cadastros/colab/listaarquivo.php?dsarquivo=' + document.getElementById(id).value+'&nrcolab='+nrcolab, "mensagemrel");
        document.getElementById("clickModal").click();
    }

    function DownloadD(id) {
        var nrcolab = document.getElementById('cd_clifor_doc').value;
        window.open('cadastros/colab/download.php?dsarquivo=' + document.getElementById(id).value+'&nrcolab='+nrcolab, "acao");
    }

    function excluirDocumentoD(id){
        if (!confirm("Deseja excluir o registro selecionado?")) {
          return false;
        } 
        else {
            var nrcolab = document.getElementById('cd_clifor_doc').value;
            var id_smenu = '<?php echo $id_smenu;?>';
            window.open('cadastros/colab/acao.php?Tipo=ExcluirDocumento&codigo=' + id + '&nrcolab=' + nrcolab + '&id_smenu=' + id_smenu, 'acao');
        }
    }

    function salvarDocumento() {
        var nrcolab = document.getElementById('cd_clifor_doc').value;
        var tpdocumento = document.getElementById('txttipodocumento').value;
        var descricao = document.getElementById('txtdescricao').value;
        var id_smenu = '<?php echo $id_smenu;?>';

        if(tpdocumento == 21){
            var pedido = document.getElementById('txtpedido').value;
            var resultado = document.getElementById('txtresultado').value;
            var periodo = document.getElementById('txtperiodo').value;
            var refazer = document.getElementById('txtrefazer').value;
        }

        var campoDocumento = document.getElementById("carregando_documento1").value;

        var arquivoDoc = $('#campoDocumento1')[0].files[0]; //Pega o primeiro arquivo do campo campoContrato (tipo file) e joga na variavel arquivoContrato

        var formData = new FormData(); //Instancia um formData vazio
        formData.append('documento', arquivoDoc); //Adiciona ao formData o arquivo capturado

        if (tpdocumento == "0") {
            Swal.fire({
				icon: 'warning',
				title: 'Oops...',
				text: 'Informe o tipo do documento!'
			});
            document.getElementById('txttipodocumento').focus();
            return;
        } else if (tpdocumento == 21) {

            if (pedido == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a data do pedido!'
                });
                document.getElementById('txtpedido').focus();
                return;
            }
            if (resultado == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a data do resultado!'
                });
                document.getElementById('txtresultado').focus();
                return;
            }
            if (periodo == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o periodo do exame!'
                });
                document.getElementById('txtperiodo').focus();
                return;
            }
            if (refazer == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a data para refazer o exame!'
                });
                document.getElementById('txtrefazer').focus();
                return;
            }
        }
            
        var url = 'cadastros/colab/acao.php?Tipo=AdicionarDocumento&tpdocumento=' + tpdocumento + '&descricao=' + descricao + '&nrcolab=' + nrcolab + '&pedido=' + pedido + '&resultado=' + resultado + '&periodo=' + periodo + '&refazer=' + refazer + '&id_smenu=' + id_smenu;

        $.ajax({ 
            url: url, //Url que será requisitada
            type: 'post',  //Tipo da requisição (como estamos trabalhando com upload, precisa ser via POST)
            data: formData, //Manda o formData que definimos
            contentType: false, 
            processData: false, 
            success: function(response){ //Função que será executada quando a requisição obtiver sucesso, o parâmetro RESPONSE corresponde ao resultado da requisição
                document.getElementById('campoDocumento1').value = "";
                Swal.fire({
                    icon: 'success',
                    title: 'Show...',
                    text: 'Documento gravado com sucesso!'
                });
                CarregarLoad("cadastros/colab/formulario_documentos.php?consultar=sim&nr_clifor=" + nrcolab + "&id_smenu=" + id_smenu, "formulario_documentos");
            },
            error: function (response) { //Função que será executada quando a requisição obtiver erro
                if(response.responseJSON && response.responseJSON.message){
                    Swal.fire({
				icon: 'warning',
				title: 'Oops...',
				text: response.responseJSON.message
			});
                }else{
                    Swal.fire({
				icon: 'warning',
				title: 'Oops...',
				text: 'Falha ao gravar o documento!'
			});
                }
                console.log("erro", response)
            }
        });
    }

    $('#campoDocumento1').change(function () {
        var files = this.files; // SELECIONA OS ARQUIVOS
        var tamanho = 0;

        tamanho = files[0].size/1024;
        console.log(tamanho);
        if (tamanho >= 20000) {
            Swal.fire({
				icon: 'warning',
				title: 'Oops...',
				text: 'Arquivo não pode exceder o tamanho máximo de 20mb!'
			});
            document.getElementById('campoDocumento1').value = "";
            return false;            
        } else {
            return true;
        }
    });

    function verificaExtensao($input) {
        var extPermitidas = ['jpg', 'png', 'pdf', 'txt', 'doc', 'docx', 'jpeg', 'JPG', 'PNG', 'PDF', 'TXT', 'DOC', 'DOCX', 'JPEG'];
        var extArquivo = $input.value.split('.').pop();

        if(typeof extPermitidas.find(function(ext){ return extArquivo == ext; }) == 'undefined') {
        Swal.fire({
				icon: 'warning',
				title: 'Oops...',
				text: 'Extensão "' + extArquivo + '" não permitida!'
			});
        document.getElementById('campoDocumento1').value = "";
        }
    }
</script>