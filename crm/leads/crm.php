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

    if ($lead != "") { 
        
        $SQL = "SELECT ls.nr_sequencial, ls.ds_nome, ls.vl_valor, ls.dt_cadastro, s.ds_segmento, ls.nr_telefone, 
                CONCAT(c.ds_municipio, ' - ', e.sg_estado) AS municipio_estado, st.ds_situacao, 
                ls.ds_email, ls.dt_agenda, ls.nr_seq_situacao, ls.nr_seq_administradora, ls.ds_grupo,
                ls.nr_cota, ls.pc_reduzido, ls.vl_contratado, ls.vl_considerado, ls.nr_seq_segmento
                FROM lead ls
                LEFT JOIN cidades c ON c.nr_sequencial = ls.nr_seq_cidade
                LEFT JOIN estados e ON c.nr_seq_estado = e.nr_sequencial
                LEFT JOIN segmentos s ON ls.nr_seq_segmento = s.nr_sequencial
                LEFT JOIN situacoes st ON ls.nr_seq_situacao = s.nr_sequencial
                WHERE ls.nr_sequencial = $lead";
        //echo "<pre>$SQL</pre>";
        $RSS = mysqli_query($conexao, $SQL);
        while ($linha = mysqli_fetch_row($RSS)) {
            $nr_sequencial = $linha[0];
            $ds_nome = $linha[1];
            $vl_valor = $linha[2]; 
            $valor = number_format($vl_valor, 2, ',', '.');
            $dt_cadastro = date('d/m/Y', strtotime($linha[3]));
            $ds_segmento = $linha[4];
            $nr_telefone = $linha[5];
            $municipio_estado = $linha[6];
            $ds_situacao = $linha[7];
            $ds_email = $linha[8];
            $dt_agenda = $linha[9];
            $nr_seq_situacao = $linha[10];
            $nr_seq_situacao = isset($nr_seq_situacao) ? $nr_seq_situacao : 0;
            $nr_seq_administradora = $linha[11];
            $nr_seq_administradora = isset($nr_seq_administradora) ? $nr_seq_administradora : 0;
            $ds_grupo = $linha[12];
            $nr_cota = $linha[13];
            $pc_reduzido = $linha[14];
            $vl_contratado = $linha[15];
            $valor_contratado = number_format($vl_contratado, 2, ',', '.');
            $vl_considerado = $linha[16];
            $valor_considerado = number_format($vl_considerado, 2, ',', '.');
            $nr_seq_segmento = $linha[17];
            
            // Se não estiver vazio, ajustar o formato
            if (!empty($dt_agenda)) {
                // Se vier no formato 'DD/MM/YYYY'
                if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $dt_agenda)) {
                    $dateObj = DateTime::createFromFormat('d/m/Y', $dt_agenda);
                    $dt_agenda = $dateObj ? $dateObj->format('Y-m-d') : '';
                }
                // Se vier no formato 'DD-MM-YYYY'
                elseif (preg_match('/^\d{2}-\d{2}-\d{4}$/', $dt_agenda)) {
                    $dateObj = DateTime::createFromFormat('d-m-Y', $dt_agenda);
                    $dt_agenda = $dateObj ? $dateObj->format('Y-m-d') : '';
                }
                // Se vier no formato correto, mantém
                elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dt_agenda)) {
                    // ok
                }
                else {
                    $dt_agenda = ''; // limpa caso seja inválido
                }
            }
            
            $disabled = "";
            if($nr_seq_situacao == 1){
                $disabled = 'disabled';
            }

        }
        
        ?>

        <style>
           /* Painéis mais modernos */
            .panel {
                border-radius: 8px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                border: none;
            }

            .panel-heading-custom {
                background: linear-gradient(90deg, #5bc0de, #0056b3);
                color: #fff !important;
                font-weight: bold;
                font-size: 14px;
                border-radius: 8px 8px 0 0;
                padding: 10px 15px;
            }

            /* Labels e inputs com mais espaçamento */
            label {
                margin-top: 10px;
                font-weight: 600;
                color: #333;
            }

            input.form-control, select.form-control, textarea.form-control {
                border-radius: 6px;
                border-color: #ccc;
                box-shadow: none;
                transition: all 0.3s ease-in-out;
            }

            input.form-control:focus, select.form-control:focus, textarea.form-control:focus {
                border-color: #5bc0de;
                box-shadow: 0 0 5px rgba(0,123,255,0.4);
            }

            /* Botões mais modernos */
            .btn-primary {
                background: #007bff;
                border-color: #007bff;
                font-weight: bold;
                border: none;
                padding: 8px 16px;
                border-radius: 6px;
                transition: background 0.3s;
            }

            .btn-primary:hover {
                background: #5bc0de;
                border-color: #004085;
            }

            /* Comentários */
            .panel-comment textarea {
                background-color: #f8f9fa;
                border: 1px solid #ddd;
                border-radius: 6px;
                resize: none;
                font-size: 13px;
            }

            /* Histórico */
            .section-title {
                font-size: 14px;
                font-weight: bold;
                margin-top: 15px;
                margin-bottom: 5px;
                color: #5bc0de;
            }

            textarea#txtcomentario {
                resize: vertical;
            }

            /* Botões de arquivos */
            #divcomentarios a.btn {
                margin-bottom: 8px;
            }

            /* Texto de alerta */
            .text-danger {
                font-size: 13px;
            }

            /* Responsivo extra */
            @media (max-width: 768px) {
                .pull-right {
                    float: none !important;
                    display: block;
                    width: 100%;
                    margin-top: 10px;
                }

                .panel-body input, .panel-body select, .panel-body textarea {
                    margin-bottom: 10px;
                }
            }
        </style>

        <div class="row">
            <!-- Hidden inputs -->
            <input type="hidden" name="nr_seq_lead" id="nr_seq_lead" value="<?php echo $lead; ?>">
            <input type="hidden" name="chave" id="chave" value="<?php echo $chave; ?>">

            <!-- Lado esquerdo -->
            <div class="col-md-4">
                <!-- Status -->
                <div class="panel panel-primary">
                    <div class="panel-heading panel-heading-custom text-center">
                        <span class="glyphicon glyphicon-star" style="margin-right: 5px;"></span> STATUS LEAD
                    </div>
                    <div class="panel-body">
                        <label>Status:</label>
                        <select class="form-control" name="selstatus" id="selstatus" onchange="AlteraStatus(this);" <?php echo $disabled; ?>>
                            <option value="0">Selecione...</option>
                            <?php
                            $sel = "SELECT nr_sequencial, ds_situacao 
                                    FROM situacoes 
                                    WHERE st_status = 'A'  
                                    ORDER BY ds_situacao";
                            $res = mysqli_query($conexao, $sel);
                            while($lin = mysqli_fetch_row($res)){
                                $selecionado = $lin[0] == $nr_seq_situacao ? "selected" : "";
                                echo "<option $selecionado value=$lin[0]>$lin[1]</option>";
                            }
                            ?>
                        </select>

                        <label class="mt-2">Agendar Conversa:</label>
                        <input type="date" id="dataagenda" name="dataagenda" class="form-control" onchange="AlteraAgenda(this.value);" value="<?php echo $dt_agenda; ?>" <?php echo $disabled; ?>>
                    </div>
                </div>

                <!-- Valor do Crédito -->
                <div class="panel panel-primary">
                     <div class="panel-heading panel-heading-custom text-center" style="cursor: pointer;" onclick="togglePanelBody(this)">
                        <span class="glyphicon glyphicon-usd" style="margin-right: 5px;"></span> CRÉDITO CONTRATADO
                        <span class="pull-right glyphicon glyphicon-chevron-down" style="margin-top: 3px;"></span>
                    </div>
                    <div class="panel-body" style="display: none;">
                        <p><strong>Valor Solicitado:</strong> <?php echo $valor; ?></p>
                        <p><strong>Tipo do Crédito:</strong> <?php echo $ds_segmento; ?></p>
                        
                        <label class="mt-2">Segmento: <font color='red'>*</font></label>
                        <select class="form-control" name="selsegmentocrm" id="selsegmentocrm">
                            <option value="0">Selecione...</option>
                            <?php
                                $sel = "SELECT nr_sequencial, ds_segmento
                                        FROM segmentos
                                        WHERE st_status = 'A'
                                        AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "
                                        ORDER BY ds_segmento";
                                $res = mysqli_query($conexao, $sel);
                                while($lin = mysqli_fetch_row($res)){
                                    $selecionado = $lin[0] == $nr_seq_segmento ? "selected" : "";
                                    echo "<option $selecionado value=$lin[0]>$lin[1]</option>";
                                }
                            ?>
                        </select>

                        <label>Grupo: <font color='red'>*</font></label>
                        <input type="text" name="txtgrupo" id="txtgrupo" class="form-control" value="<?php echo $ds_grupo; ?>">

                        <label class="mt-2">Cota: <font color='red'>*</font></label>
                        <input type="number" name="txtcota" id="txtcota" class="form-control" value="<?php echo $nr_cota; ?>">

                        <label class="mt-2">Administradora: <font color='red'>*</font></label>
                        <select class="form-control" name="seladministradora" id="seladministradora">
                            <option value="0">Selecione...</option>
                            <?php
                                $sel = "SELECT nr_sequencial, ds_administradora 
                                        FROM administradoras 
                                        WHERE st_status = 'A' 
                                        AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . " 
                                        ORDER BY ds_administradora";
                                $res = mysqli_query($conexao, $sel);
                                while($lin = mysqli_fetch_row($res)){
                                    $selecionado = $lin[0] == $nr_seq_administradora ? "selected" : "";
                                    echo "<option $selecionado value=$lin[0]>$lin[1]</option>";
                                }
                            ?>
                        </select>

                        <label class="mt-2">Valor Contratado: <font color='red'>*</font></label>
                        <input type="text" class="form-control" name="txtvalorcontratado" id="txtvalorcontratado" size="10" maxlength="20" style="text-align:right;" onkeypress="return formatar_moeda(this,'.',',',event);" value="<?php echo $valor_contratado; ?>"> 

                        <label class="mt-2">% Crédito Reduzido:</label>
                        <input type="number" name="txtpercentual" id="txtpercentual" step="0.01" class="form-control" value="<?php echo $pc_reduzido; ?>">

                        <label class="mt-2">Valor Final:</label>
                        <input type="text" class="form-control" name="txtvalorfinal" id="txtvalorfinal" readonly style="text-align:right;" value="<?php echo $valor_considerado; ?>">

                        <button class="btn btn-primary btn-sm pull-right" style="margin-top:10px;" onclick="Contratar();" <?php echo $disabled; ?>>
                            <span class="glyphicon glyphicon-ok" style="margin-right: 5px;"></span> Salvar
                        </button>

                    </div>
                </div>

                <!-- Cliente -->
                <div class="panel panel-primary">
                    <div class="panel-heading panel-heading-custom text-center">
                        <span class="glyphicon glyphicon-user" style="margin-right: 5px;"></span> CLIENTE
                    </div>
                    <div class="panel-body">
                        <p><strong>Nome:</strong> <?php echo $ds_nome; ?></p>
                        <p><strong>Cidade e Estado:</strong> <?php echo $municipio_estado; ?></p>
                        <p><strong>Email:</strong> <?php echo $ds_email; ?></p>
                        <p><strong>Telefone:</strong> <?php echo $nr_telefone; ?></p>
                    </div>
                </div>
            </div>

            <!-- Lado direito -->
            <div class="col-md-7">
                <!-- Comentários -->
                <div class="panel panel-primary">
                    <div class="panel-heading panel-heading-custom">
                        <span class="glyphicon glyphicon-comment" style="margin-right: 5px;"></span> OBSERVAÇÕES
                    </div>
                    <div class="panel-body">
                        <textarea class="form-control" id="txtcomentario" name="txtcomentario" rows="5" maxlength="1000" placeholder="Escreva seu comentário..."></textarea>
                        <button class="btn btn-primary btn-sm pull-right" style="margin-top:10px;" onclick="enviaComentario();">
                            <span class="glyphicon glyphicon-upload" style="margin-right: 5px;"></span> Enviar Comentário
                        </button>
                        <div class="clearfix"></div>
                        <p class="text-danger" style="margin-top:15px;">
                            <strong>Os arquivos são enviados automaticamente após selecioná-los!</strong>
                        </p>
                        <input type="file" multiple id="campoAnexoComercial" onchange="verificaExtensaoGeral(this);">
                        <label class="text-muted file-info" id="enviandoArquivo" style="display:none;">
                            <span class="glyphicon glyphicon-refresh spinning" style="margin-right: 5px;"></span> Enviando arquivo...
                        </label>
                    </div>
                </div>

                <!-- Histórico de Comentários -->
                <div class="panel panel-primary">
                    <div class="panel-heading panel-heading-custom">
                        <span class="glyphicon glyphicon-time" style="margin-right: 5px;"></span> HISTÓRICO
                    </div>
                    <div class="panel-body" id="divcomentarios">
                        <?php
                            $comentarios = 0;
                            $SQL0 = "SELECT COUNT(nr_sequencial) FROM anexos_lead WHERE nr_seq_lead = $lead";
                            $RS0 = mysqli_query($conexao, $SQL0);
                            while ($linha0 = mysqli_fetch_row($RS0)) {
                                $comentarios = $linha0[0];
                            }

                            if ($comentarios == 0) {
                                echo '<div class="alert alert-info text-center">SEM OBSERVAÇÕES</div>';
                            } else {
                                $SQL1 = "SELECT DISTINCT(DATE(dt_cadastro)) FROM anexos_lead WHERE nr_seq_lead = $lead ORDER BY DATE(dt_cadastro) DESC";
                                $RS1 = mysqli_query($conexao, $SQL1);

                                while ($linha1 = mysqli_fetch_row($RS1)) {
                                    $dt_cadastro = $linha1[0];
                                    echo '<div>';
                                    echo '<div class="section-title"><span class="glyphicon glyphicon-calendar"></span> ' . date('d/m/Y', strtotime($dt_cadastro)) . '</div>';

                                    $SQL = "SELECT nr_sequencial, UPPER(ds_comentario), ds_arquivo FROM anexos_lead WHERE nr_seq_lead = $lead AND DATE(dt_cadastro) = DATE('$dt_cadastro') ORDER BY nr_sequencial DESC";
                                    $RS = mysqli_query($conexao, $SQL);

                                    while ($linha = mysqli_fetch_row($RS)) {
                                        $nr_sequencial = $linha[0];
                                        $ds_comentario = $linha[1];
                                        $ds_arquivo = $linha[2];

                                        if ($ds_comentario != "") {
                                            echo '<div class="panel panel-default panel-comment">';
                                            echo '<div class="panel-body"><textarea class="form-control" rows="3" disabled>' . $ds_comentario . '</textarea></div></div>';
                                        }

                                        if ($ds_arquivo != "") {
                                            echo '<a class="btn btn-default btn-sm" href="crm/leads/arquivos/' . $ds_arquivo . '" target="_blank">';
                                            echo '<span class="glyphicon glyphicon-file"></span> ' . $ds_arquivo . '</a><br>';
                                        }
                                    }
                                    echo '</div>';
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <script>

            let statusAnterior = document.getElementById("selstatus").value;

            function AlteraStatus(selectElement) {
                const status = selectElement.value;
                const codigo = document.getElementById("nr_seq_lead").value;
                const grupo = document.getElementById("txtgrupo").value;
                const cota = document.getElementById("txtcota").value.trim();
                const valorcontratado = document.getElementById("txtvalorcontratado").value.trim();
                const percentual = document.getElementById("txtpercentual").value.trim();
                const administratadora = document.getElementById("seladministradora").value;
                const valorfinal = document.getElementById("txtvalorfinal").value.trim();
                const segmento = document.getElementById("selsegmentocrm").value.trim();

                // Validação única para status 1 (CONTRATADA)
                if (status == 1) {
                    const camposInvalidos = (
                        grupo == "" ||
                        cota == "" ||
                        valorcontratado == "" ||
                        administratadora == 0 ||
                        segmento == 0
                    );

                    if (camposInvalidos) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Campos obrigatórios!',
                            text: 'Preencha todos os campos obrigatórios (*) antes de alterar para esse status.'
                        });
                        selectElement.value = statusAnterior;
                        return;
                    }
                }

                // Atualiza status anterior após validação
                statusAnterior = status;

                window.open('crm/leads/acao.php?Tipo=STATUS&codigo=' + codigo + '&status=' + status, "acao");
            }

            function AlteraAgenda(data) {
                if (!data || !/^\d{4}-\d{2}-\d{2}$/.test(data)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Informe a data correta!'
                    });
                    document.getElementById('dataagenda').focus();
                    return;
                }
                var codigo = document.getElementById("nr_seq_lead").value;
                window.open('crm/leads/acao.php?Tipo=AGENDA&codigo=' + codigo + '&data=' + data, "acao");
            }

            function limparMascara(valor) {
                return parseFloat(valor.replace(/\./g, '').replace(',', '.'));
            }

            function formatarParaMoedaBrasileira(valor) {
                return valor.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }

            function atualizarValorFinal() {
                const campoValor = document.getElementById('txtvalorcontratado');
                const campoPercentual = document.getElementById('txtpercentual');
                const campoFinal = document.getElementById('txtvalorfinal');

                const valorBruto = campoValor.value;
                const percentual = parseFloat(campoPercentual.value);
                const valorContratado = limparMascara(valorBruto);

                if (!isNaN(valorContratado)) {
                    if (!isNaN(percentual)) {
                        const desconto = valorContratado * (percentual / 100);
                        const valorFinal = valorContratado - desconto;
                        campoFinal.value = formatarParaMoedaBrasileira(valorFinal);
                    } else {
                        campoFinal.value = formatarParaMoedaBrasileira(valorContratado);
                    }
                } else {
                    campoFinal.value = '';
                }
            }

            // Eventos com máscara funcionando
            document.getElementById('txtvalorcontratado').addEventListener('keyup', function () {
                setTimeout(atualizarValorFinal, 100); // espera a máscara aplicar
            });
            document.getElementById('txtpercentual').addEventListener('input', atualizarValorFinal);

            function Contratar() {
                var codigo = document.getElementById("nr_seq_lead").value;
                var grupo = document.getElementById("txtgrupo").value;
                var cota = document.getElementById("txtcota").value;
                var valorcontratado = document.getElementById("txtvalorcontratado").value;
                var percentual = document.getElementById("txtpercentual").value;
                var administratadora = document.getElementById("seladministradora").value;
                var valorfinal = document.getElementById("txtvalorfinal").value;
                var segmento = document.getElementById("selsegmentocrm").value;

                if (valorcontratado != '') {
                    valorcontratado = valorcontratado.replace(/\./g, '');     // remove todos os pontos
                    valorcontratado = valorcontratado.replace(',', '.');      // troca a vírgula por ponto
                } else {
                    valorcontratado = 0;
                }

                if (valorfinal != '') {
                    valorfinal = valorfinal.replace(/\./g, '');     // remove todos os pontos
                    valorfinal = valorfinal.replace(',', '.');      // troca a vírgula por ponto
                } else {
                    valorfinal = 0;
                }

                if (segmento == 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Informe o Segmento!'
                    });
                    document.getElementById('selsegmentocrm').focus();
                    return;
                } 
                else if (grupo == "") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Informe o Grupo!'
                    });
                    document.getElementById('txtgrupo').focus();
                    return;
                } 
                else if (cota == "") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Informe a Cota!'
                    });
                    document.getElementById('txtcota').focus();
                    return;
                } 
                else if (valorcontratado == "") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Informe o valor Contratado!'
                    });
                    document.getElementById('txtvalorcontratado').focus();
                    return;
                } 
                else if (administratadora == 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Informe a Administradora!'
                    });
                    document.getElementById('seladministradora').focus();
                    return;
                } 
                else{

                    window.open('crm/leads/acao.php?Tipo=CONTRATAR&codigo=' + codigo + '&grupo=' + grupo + '&cota=' + cota + '&valorcontratado=' + valorcontratado + '&percentual=' + percentual + '&administratadora=' + administratadora + '&valorfinal=' + valorfinal + '&segmento=' + segmento, "acao");

                }
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

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Show...',
                                text: data.mensagem
                            });
                            buscaComercial(data.codigo);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: data.mensagem
                            });
                        }
                    },
                    error: function (xhr) {
                        console.log("Erro AJAX: ", xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Falha ao enviar os arquivos.'
                        });
                    },
                    complete: function () {
                        campo.value = '';
                        document.getElementById('enviandoArquivo').classList.add('hidden');
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                });

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
            
            function togglePanelBody(header) {
                const panelBody = $(header).next(".panel-body");
                const icon = $(header).find(".glyphicon-chevron-down, .glyphicon-chevron-up");
            
                panelBody.slideToggle(200);
            
                if (icon.hasClass("glyphicon-chevron-down")) {
                    icon.removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up");
                } else {
                    icon.removeClass("glyphicon-chevron-up").addClass("glyphicon-chevron-down");
                }
            }

        </script>

   
<?php } ?>