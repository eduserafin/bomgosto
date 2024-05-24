<?php
    foreach($_GET as $key => $value){
        $$key = $value;
    }
?>
<?php

    $consulta = "";
    if (isset($_GET["consulta"])) {
        $consulta = $_GET["consulta"];
    }

    if ($consulta == "sim") {
        $ant = "../../";
        include "../../conexao.php";
    }

    if ($chave == "") {
        $chave = substr(md5(date("dmYHis")), 0, 7);
    }

    //require_once $ant.'conexao.php';

    if ($lead != "") { ?>

        <div class="row"><br>
            <input type="hidden" name="nr_seq_lead" id="nr_seq_lead" value="<?php echo $lead; ?>">
            <input type="hidden" name="chave" id="chave" value="<?php echo $chave; ?>">

            <!-- DETALHES DO CLIENTE-->
            <div class="col-md-4">

                        <?php

                            $SQL = "SELECT ls.nr_sequencial, ls.ds_nome, ls.vl_valor, ls.dt_cadastro, 
                                        ps.ds_produto, ls.nr_whatsapp, ls.nr_telefone,
                                        CONCAT(m.ds_municipioibge, ' - ', m.sg_estado) AS municipio_estado,
                                        ls.tp_tipo, ls.st_situacao, ls.ds_mensagem, ls.ds_email, ls.dt_agenda
                                        FROM lead_site ls
                                        INNER JOIN municipioibge m ON m.cd_municipioibge = ls.nr_seq_cidade
                                        LEFT JOIN produtos_site ps ON ls.nr_seq_produto = ps.nr_sequencial
                                    WHERE ls.nr_sequencial = $lead";
                                    //echo "<pre>$SQL</pre>";
                            $RSS = mysqli_query($conexao, $SQL);
                            while ($linha = mysqli_fetch_row($RSS)) {
                                $nr_sequencial = $linha[0];
                                $ds_nome = $linha[1];
                                $vl_valor = $linha[2]; 
                                $valor = number_format($vl_valor / 100, 2, ',', '.');
                                $dt_cadastro = date('d/m/Y', strtotime($linha[3]));
                                $ds_produto = $linha[4];
                                $nr_whatsapp = $linha[5];
                                $nr_telefone = $linha[6];
                                $municipio_estado = $linha[7];
                                $tp_tipo = $linha[8];
                                $st_situacao = $linha[9];
                                $ds_mensagem = $linha[10];
                                $ds_email = $linha[11];
                                $dt_agenda = $linha[12];

                                $dstipo = '';
                                if($tp_tipo == 'S'){
                                $dstipo = 'SIMULAÇÃO';
                                } else if ($tp_tipo == 'C'){
                                $dstipo = 'CONTATO';
                                } else {
                                $dstipo = '';
                                }
                            }

                        ?>

                <table width="100%" class="table table-bordered table-striped">
                    <thead>
                        <tr class="bottom-bordered-dark">
                            <td class="border-right-dark bg-info" style="text-align:center;"><font size=3><strong>STATUS LEAD</strong> <i class="fa fa-star" aria-hidden="true"></i></font></td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;"><b>STATUS:</b>
                            <select class="form-control" name="selstatus" id="selstatus" onchange="javascript: AlteraStatus(this.value);">
                                <option value="" <?php echo $st_situacao == '' ? 'selected' : ''; ?>></option>
                                <option value="N" <?php echo $st_situacao == 'N' ? 'selected' : ''; ?>>NOVOS</option>
                                <option value="C" <?php echo $st_situacao == 'C' ? 'selected' : ''; ?>>ENTRAR EM CONTATO</option>
                                <option value="P" <?php echo $st_situacao == 'P' ? 'selected' : ''; ?>>PERDIDA</option>
                                <option value="E" <?php echo $st_situacao == 'E' ? 'selected' : ''; ?>>EM ANDAMENTO</option>
                                <option value="T" <?php echo $st_situacao == 'T' ? 'selected' : ''; ?>>CONTRATADA</option>
                            </select>
                        </td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;"><b>AGENDA CONVERSA:</b>
                            <input type="date" id="dataagenda" name="dataagenda" class="form-control" onchange="javascript: AlteraAgenda(this.value);" value="<?php echo $dt_agenda; ?>">
                        </td>
                        </tr>
                    </thead>
                </table>

                <table width="100%" class="table table-bordered table-striped">
                    <thead>
                        <tr class="bottom-bordered-dark">
                            <td class="border-right-dark bg-info" style="text-align:center;"><font size=3><strong>VALOR DO CRÉDITO</strong> <i class="fa fa-money" aria-hidden="true"></i></font></td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;"><b>VALOR:</b> <?php echo $valor;?></td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;"><b>CONSÓRCIO:</b> <?php echo $ds_produto;?></td>
                        </tr>
                    </thead>
                </table>

                <table width="100%" class="table table-bordered table-striped">
                    <thead>
                        <tr class="bottom-bordered-dark">
                            <td class="border-right-dark bg-info" style="text-align:center;"><font size=3><strong>DETALHES DO CLIENTE</strong> <i class="fa fa-user" aria-hidden="true"></i></font></td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;"><b>NOME:</b> <?php echo $ds_nome;?></td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;"><b>CIDADE E ESTADO:</b> <?php echo $municipio_estado?></td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;"><b>MENSAGEM:</b> <?php echo $ds_mensagem;?></td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;"><b>TIPO:</b> <?php echo $dstipo;?></td>
                        </tr>
                    </thead>
                </table>

                <table width="100%" class="table table-bordered table-striped">
                    <thead>
                        <tr class="bottom-bordered-dark">
                            <td class="border-right-dark bg-info" style="text-align:center;"><font size=3><strong>INFORMAÇÕES DO CONTATO</strong> <i class="fa fa-phone-square"></i> </font></td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;"><b>E-MAIL:</b> <?php echo $ds_email;?></td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;"><b>TELEFONE:</b> <?php echo $nr_telefone;?></td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;"><b>WHATSAPP:</b> <?php echo $nr_whatsapp;?></td>
                        </tr>
                    </thead>
                </table>

            </div>

            <!--ITERAÇÕES COM O CLIENTE-->
            <div class="col-md-8">
                <div class="row-100">

                    <h3><b>COMENTÁRIOS</b> <i class="fa fa-commenting" aria-hidden="true"></i></h3>

                    <div class="row">
                        <textarea class="form-control" id="txtcomentario" name="txtcomentario" rows="8" maxlength="1000"></textarea>
                    </div>
                    <div class="row">
                        <button class="btn btn-primary" id="btnEnviar" onclick="enviaComentario();"><i class="fa fa-upload"></i> Enviar Comentário</button>
                    </div> 
                    <br>
                    <div class="col-md-8">
                        <p><b><font color='red'>Os arquivos são enviados automaticamente após selecionar eles!</font></b></p>
                        <input type="file" multiple="true" id="campoAnexoComercial" onchange="verificaExtensaoGeral(this);">
                        <label class="w-100 hidden" id="enviandoArquivo">
                            <i class="fa fa-spin fa-pulse"></i> Enviando arquivo...
                        </label>
                    </div>

                    <div class="w-100" hidden>
                        <div class="w-100" id="listaArquivos">
                            <?php include 'listaanexos.php'; ?>
                        </div>
                    </div>
                </div> 
                
                <br><br><br>

                <div class="col-md-12 table-responsive" id="divcomentarios" style="height: 450px; overflow-y:auto">
                    <div class="row">
                        <h3><b>HISTÓRICO</b> <i class="fa fa-history" aria-hidden="true"></i></h3>
                    </div>

                    <?php 

                    $comentarios = 0;
                    $SQL0 = "SELECT COUNT(nr_sequencial)
                                FROM lead_anexos  
                            WHERE nr_seq_lead = $lead"; //echo $SQL0;
                    $RS0 = mysqli_query($conexao, $SQL0);
                    while ($linha0 =  mysqli_fetch_row($RS0)) {
                        $comentarios = $linha0[0];
                    }

                    if($comentarios == 0) { ?>
                        <div class="row"><br>
                            <textarea style="text-align:center" class="form-control" id="historico" name="historico" rows="1" maxlength="1000" disabled>SEM COMENTÁRIOS</textarea>
                        </div>
                    <?php } else {

                        $SQL1 = "SELECT DISTINCT(DATE(dt_cadastro))
                                    FROM lead_anexos  
                                WHERE nr_seq_lead = $lead
                                ORDER BY DATE(dt_cadastro) DESC"; //echo $SQL1;
                        $RS1 = mysqli_query($conexao, $SQL1);
                        while ($linha1 =  mysqli_fetch_row($RS1)) {
                            $dt_cadastro = $linha1[0];

                            ?>

                            <div class="row"><br>
                                <pre><?php echo date('d/m/Y', strtotime($dt_cadastro)); ?></pre>
                            </div>

                            <?php

                            $ds_comentario = "";
                            $ds_arquivo = "";
                            $SQL = "SELECT nr_sequencial, UPPER(ds_comentario), ds_arquivo
                                        FROM lead_anexos  
                                    WHERE nr_seq_lead = $lead
                                    AND DATE(dt_cadastro) = DATE('$dt_cadastro')
                                    ORDER BY nr_sequencial DESC"; //echo $SQL;
                            $RS = mysqli_query($conexao, $SQL);
                            while ($linha =  mysqli_fetch_row($RS)) {
                                $nr_sequencial = $linha[0];
                                $ds_comentario = $linha[1];
                                $ds_arquivo = $linha[2];

                                ?>

                                <?php if($ds_comentario != "") { ?>
                                    <div class="row"><br>
                                        <textarea class="form-control" id="historico" name="historico" rows="6" maxlength="1000" disabled><?php echo $ds_comentario; ?></textarea>
                                    </div>
                                <?php } ?>
                                <?php if($ds_arquivo != "") { ?>
                                    <div class="row"><br>
                                        <div class="btn btn-default" style="margin: 5px 0">
                                            <a data-toggle='tooltip' title="Abrir arquivo" href="crm/leads/arquivos/<?php echo $ds_arquivo ?>" target="_blank"><?php echo $ds_arquivo ?></a>
                                            <!--<a onclick="removerArquivo('<?php echo $ds_arquivo?>', '<?php echo $nr_sequencial ?>', '<?php echo $cd_cliente ?>')" class="text-danger cursor-pointer"><i class="fa fa-trash" data-toggle='tooltip' title="Excluir arquivo"></i></a>
                                            <i class="fa fa-pulse fa-spinner hidden" id="excluindoarquivo"></i> -->
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </div>
    
            </div>

        </div>

        <script>

            function AlteraStatus(status) {

                var codigo = document.getElementById("nr_seq_lead").value;
                window.open('crm/leads/acao.php?Tipo=STATUS&codigo=' + codigo + '&status=' + status, "acao");

            }

            function AlteraAgenda(data) {

                var codigo = document.getElementById("nr_seq_lead").value;
                window.open('crm/leads/acao.php?Tipo=AGENDA&codigo=' + codigo + '&data=' + data, "acao");

            }



            function enviaComentario(campo) {

                var codigo = document.getElementById("nr_seq_lead").value;
                var comentario = document.getElementById("txtcomentario").value;
                    comentario = comentario.replace("'", "");
                    comentario = comentario.replace("*", "");
                    comentario = comentario.replace("+", "");
                    comentario = comentario.replace("&", "");

                    if (comentario == "") {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'Escreva um comentário!'
                        });
                        document.getElementById('txtcomentario').focus();

                    } else{

                        window.open('crm/leads/acao.php?Tipo=enviaComentario&codigo=' + codigo + '&comentario=' + comentario, "acao");
            
                    }
            }

            function enviaAnexo(campo) {

                var codigo = document.getElementById("nr_seq_lead").value;
                var files = campo.files; 
    
                if(!files){
                    return false;
                }

                var formData = new FormData(); 

                var ins = files.length;
                
                for (var x = 0; x < ins; x++) {
                    formData.append("file_"+x+"", files[x]);
                }

                formData.append("totalFiles", ins);

                var url = `crm/leads/acao.php?Tipo=enviarArquivo&codigo=${codigo}`;

                document.getElementById('enviandoArquivo').classList.remove('hidden');
                document.getElementById('btnEnviar').setAttribute('disabled', true);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(data) {
                        console.log(data);
                        carregarAnexos(codigo);
                        buscaComercial(codigo);
                    },
                    error: function (response) {
                        console.log(response.responseJSON);
                        if(response.responseJSON && response.responseJSON.message){
                            alert(response.responseJSON.message)
                        }else{
                            alert('Oops! Falha ao enviar os arquivos.');
                        }
                        
                        return false;
                    },
                    complete: function () {
                        campo.value = '';
                        document.getElementById('enviandoArquivo').classList.add('hidden');
                        document.getElementById('btnEnviar').removeAttribute('disabled');
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                }); 

            }

            function carregarAnexos(codigo){
                //var codigo = document.getElementById("nr_seq_cliente").value;

                var url = `crm/leads/listaanexos.php?codigo=${codigo}`;
                document.getElementById('listaArquivos').innerHTML = 'Aguarde, carregando...';
                $.get(url, function (htmlRetorno) {
                    document.getElementById('listaArquivos').innerHTML = htmlRetorno;
                })
            }

            function removerArquivo(arquivo, nr_sequencial, codigo){
                if(!confirm('Deseja realmente excluir o arquivo?')){
                    return false;
                }

                var url = `crm/leads/acao.php?Tipo=removerArquivo&arquivo=${arquivo}&nr_sequencial=${nr_sequencial}`;
                document.getElementById('excluindoarquivo').classList.remove('hidden')
                $.get(url, function (htmlRetorno) {
                    $(".tooltip").tooltip("hide");
                })

            }

            $('#campoAnexoComercial').change(function () {
                var files = this.files; // SELECIONA OS ARQUIVOS
                var tamanho = 0;

                tamanho = files[0].size/1024;
                console.log(tamanho);
                if (tamanho >= 3000) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Arquivo não pode exceder o tamanho máximo de 3mb!'
                    });
                    document.getElementById('campoAnexoComercial').value = "";
                    return false;            
                } else {
                    return true;
                    //enviaAnexo(this);
                }
            });

            function verificaExtensaoGeral($input) {
                var extPermitidas = ['xlsx', 'xls', 'jpg', 'png', 'pdf', 'txt', 'doc', 'docx', 'jpeg', 'XLSX', 'XLS', 'JPG', 'PNG', 'PDF', 'TXT', 'DOC', 'DOCX', 'JPEG'];
                var extArquivo = $input.value.split('.').pop();

                if(typeof extPermitidas.find(function(ext){ return extArquivo == ext; }) == 'undefined') {
                Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Extensão "' + extArquivo + '" não permitida!'
                    });
                document.getElementById('campoAnexoComercial').value = "";
                } else {
                    enviaAnexo($input)
                }
            }

        </script>

   
<?php } else { ?>

    <pre>Selecione um registro na aba LISTA!</pre>

<?php } ?>