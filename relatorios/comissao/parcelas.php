<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pagamentos</title>
    <style>
        .pag-container {
            font-family: Arial, sans-serif;
            background-color: #fafafa;
            padding: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .pag-title {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .pag-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .pag-table th,
        .pag-table td {
            padding: 10px 12px;
            text-align: center;
            border: 1px solid #ccc;
        }

        .pag-table th {
            background-color: #3f51b5;
            color: #fff;
        }

        .pag-table tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .pag-table tr:hover {
            background-color: #e0e0e0;
        }

        .pag-totais {
            background-color: #dcdcdc;
            font-weight: bold;
        }

        .pag-input-date {
            width: 100%;
            padding: 6px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .swal2-container {
            z-index: 99999 !important; /* bem alto para ficar acima de qualquer modal */
        }

        .swal2-popup {
            z-index: 999999 !important;
        }

        .linha-destaque {
            background-color: #dbefff !important; /* azul bem fraquinho */
            font-weight: bold;
        }

        .select-bloqueado {
            background-color: #f0f0f0;  /* cinza leve */
            color: #6c757d;             /* texto mais apagado */
            cursor: not-allowed;
        }

    </style>
</head>
<body>

    <?php
        require_once '../../conexao.php';
        $lead = isset($_GET['lead']) ? intval($_GET['lead']) : 0;
        $parcela = isset($_GET['parcela']) ? intval($_GET['parcela']) : 0;
        $colaborador = isset($_GET['colaborador']) ? intval($_GET['colaborador']) : 0;
        $administradora = isset($_GET['administradora']) ? intval($_GET['administradora']) : 0;

        $vl_estorno_config = "";
        $SQL = "SELECT vl_estorno
                FROM comissoes
                WHERE nr_seq_colaborador = $colaborador
                AND nr_seq_administradora = $administradora";
        //echo "<pre>$SQL</pre>";
        $RSS = mysqli_query($conexao, $SQL);
        while ($linha = mysqli_fetch_row($RSS)) {
            $vl_estorno_config = $linha[0];
        }
    ?>

    <input type="hidden" nome="estorno" id="estorno" value="<?php echo $vl_estorno_config;?>">
    <div class="pag-container">

        <!-- Parcelas Normais -->
        <table class="pag-table">
            <tr>
                <th colspan=7>Parcelas Normais</th>
            </tr>
            <tr>
                <th>Parcela</th>
                <th>Comissão %</th>
                <th>Valor Comissão</th>
                <th>Data Parcela</th>
                <th>Data Status</th>
                <th>Status</th>
                <th>Importação</th>
            </tr>

            <?php
                $total_comissao = 0;
                $total_parcela = 0;
                $total_cancelamneto = 0;
                $primeira_parcela_status = null;
                $primeiro_T_liberado = false;
                $tem_estorno = "";
                $tem_cancelamento = false;

                $SQL = "SELECT nr_sequencial, nr_parcela, vl_comissao, vl_parcela, dt_status, dt_parcela, st_status, st_importacao
                        FROM pagamentos
                        WHERE nr_seq_lead = $lead
                        AND tp_tipo = 'N'
                        ORDER BY dt_parcela, nr_parcela";
                $RSS = mysqli_query($conexao, $SQL);
                while ($linha = mysqli_fetch_row($RSS)) {
                    $nr_seq_pagamento = $linha[0];
                    $nr_parcela = $linha[1];
                    $vl_comissao = $linha[2];
                    $vl_parcela  = $linha[3];
                    $dt_status = $linha[4];
                    $dt_parcela = $linha[5];
                    $st_status  = $linha[6];
                    $st_importacao  = $linha[7];

                    if ($st_importacao == 'N') {
                        $icone = '<span style="color: red;">&#10006;</span>'; // ícone de X vermelho
                    } elseif ($st_importacao == 'S') {
                        $icone = '<span style="color: green;">&#10004;</span>'; // ícone de check verde
                    } else {
                        $icone = '<span style="color: gray;">?</span>'; // caso seja outro valor
                    }

                    if ($dt_status != "") {
                        $dt_status = date('d/m/Y', strtotime($dt_status));
                    }
                    if ($dt_parcela != "") {
                        $dt_parcela = date('d/m/Y', strtotime($dt_parcela));
                    }

                    if ($st_status == "E") {
                        $vl_comissao_fmt = number_format(0, 2, ',', '.');
                        $vl_parcela_fmt  = number_format(0, 2, ',', '.');
                        $tem_estorno = "S";
                    } else {
                        $total_comissao += $vl_comissao;
                        $total_parcela  += $vl_parcela;

                        $vl_comissao_fmt = number_format($vl_comissao, 2, ',', '.');
                        $vl_parcela_fmt  = number_format($vl_parcela, 2, ',', '.');
                    }

                    if ($primeira_parcela_status === null) {
                        $primeira_parcela_status = $st_status;
                    }

                    // --- Regras de bloqueio ---
                    $disabled = "";

                    if ($primeira_parcela_status == "C" && $nr_parcela != 1) {
                        $disabled = "disabled";
                    }

                    if ($st_status == "T") {
                        if ($primeiro_T_liberado) {
                            $disabled = "disabled";
                        } else {
                            $primeiro_T_liberado = true; 
                        }
                    }

                    if ($st_status == "E") {
                        $disabled = "disabled";
                    }

                    if ($st_status == "A") {
                        $disabled = "disabled";
                    }

                    $select_class = ($disabled != "") ? "select-bloqueado" : "";
                    ?>
                    <tr <?php if ($parcela == $nr_parcela) echo "class='linha-destaque'"; ?>>
                        <td><?php echo $nr_parcela; ?></td>
                        <td><?php echo $vl_comissao_fmt; ?></td>
                        <td><?php echo $vl_parcela_fmt; ?></td>
                        <td><?php echo $dt_parcela; ?></td>
                        <td><?php echo $dt_status; ?></td>
                        <td style="text-align: center; vertical-align: middle;">
                            <select class="form-control <?php echo $select_class; ?>" name="selstatus" style="width: 200px; margin: 0 auto; display: block;"
                            onchange="AlterarStatus(this.value, <?php echo $nr_parcela; ?>, '<?php echo $st_status; ?>', <?php echo $lead; ?>, <?php echo $parcela; ?>, '<?php echo $dt_parcela; ?>');"
                            <?php echo $disabled; ?>>
                                <option value="" <?php if($st_status == '') echo 'selected'; ?>>AGUARDANDO</option>
                                <option value="P" <?php if($st_status == 'P') echo 'selected'; ?>
                                    <?php if($st_status == 'T' || $st_status == 'E' || $parcela != $nr_parcela) echo 'disabled'; ?>>
                                    PAGO AO VENDEDOR <?php if($st_status == 'T' || $st_status == 'E' || $parcela != $nr_parcela) echo '(bloqueado)'; ?>
                                </option>
                                <option value="T" <?php if($st_status == 'T') echo 'selected'; ?>
                                    <?php if($st_status == 'T' || $st_status == 'E' || $parcela != $nr_parcela) echo 'disabled'; ?>>
                                    PENDENTE CLIENTE <?php if($st_status == 'T' || $st_status == 'E' || $parcela != $nr_parcela) echo '(bloqueado)'; ?>
                                </option>
                                <option value="A" <?php if($st_status == 'A') echo 'selected'; ?>
                                    <?php if($st_status == 'T' || $st_status == 'E' || $parcela != $nr_parcela) echo 'disabled'; ?>>
                                    RATEIO <?php if($st_status == 'T' || $st_status == 'E' || $parcela != $nr_parcela) echo '(bloqueado)'; ?>
                                </option>
                                <option value="E" <?php if($st_status == 'E') echo 'selected'; ?>
                                    <?php if($st_status == 'T' || $st_status == 'E' || $parcela != $nr_parcela) echo 'disabled'; ?>>
                                    ESTORNO <?php if($st_status == 'T' || $st_status == 'E' || $parcela != $nr_parcela) echo '(bloqueado)'; ?>
                                </option>
                                <option value="C" <?php if($st_status == 'C') echo 'selected'; ?>
                                    <?php if($st_status == 'T' || $st_status == 'E') echo 'disabled'; ?>>
                                    CANCELADO <?php if($st_status == 'T' || $st_status == 'E') echo '(bloqueado)'; ?>
                                </option>
                            </select>
                        </td>
                        <td><?php echo $icone; ?></td>
                    </tr>
                <?php } ?>

                <?php if($tem_estorno == "S") { ?>
                    <tr>
                        <th colspan=7>Parcelas Estorno</th>
                    </tr>
                    <tr>
                        <th>Parcela</th>
                        <th>Percentual %</th>
                        <th>Valor Estorno</th>
                        <th>Data Parcela</th>
                        <th>Data Status</th>
                        <th colspan="2">Status</th>
                    </tr>
                        <?php

                            $total_estorno = 0;
                            $total_percentual = 0;
                            $SQL = "SELECT nr_sequencial, nr_parcela, vl_percentual, vl_estorno, dt_status, dt_parcela, st_status
                                    FROM pagamentos
                                    WHERE nr_seq_lead = $lead
                                    AND tp_tipo = 'E'
                                    ORDER BY dt_parcela, nr_parcela";
                            $RSS = mysqli_query($conexao, $SQL);
                            while ($linha = mysqli_fetch_row($RSS)) {
                                $nr_seq_estorno = $linha[0];
                                $nr_parcela_estorno = $linha[1];
                                $vl_percentual = $linha[2];
                                $vl_estorno  = $linha[3];
                                $dt_status_estorno = $linha[4];
                                $dt_parcela_estorno = $linha[5];
                                $st_status_estorno  = $linha[6];

                                $total_percentual += $vl_percentual;
                                $total_estorno  += $vl_estorno;

                                $vl_percentual_fmt = number_format($vl_percentual, 2, ',', '.');
                                $vl_estorno_fmt  = number_format($vl_estorno, 2, ',', '.');

                                if ($dt_status_estorno != "") {
                                    $dt_status_estorno = date('d/m/Y', strtotime($dt_status_estorno));
                                }
                                if ($dt_parcela_estorno != "") {
                                    $dt_parcela_estorno = date('d/m/Y', strtotime($dt_parcela_estorno));
                                }

                                ?>
                                <tr>
                                    <td><?php echo $nr_parcela_estorno; ?></td>
                                    <td><?php echo $vl_percentual_fmt; ?></td>
                                    <td><?php echo $vl_estorno_fmt; ?></td>
                                    <td><?php echo $dt_parcela_estorno; ?></td>
                                    <td><?php echo $dt_status_estorno; ?></td>
                                    <td colspan="2" style="text-align: center; vertical-align: middle;">
                                        <select class="form-control" name="selstatusestorno" style="width: 200px; margin: 0 auto; display: block;"
                                        onchange="AlterarStatusEstorno(this.value, <?php echo $nr_seq_estorno; ?>, <?php echo $lead; ?>, <?php echo $parcela; ?>);">
                                            <option value="" <?php if($st_status_estorno == '') echo 'selected'; ?>>AGUARDANDO</option>
                                            <option value="R" <?php if($st_status_estorno == 'R') echo 'selected'; ?>>RECEBIDO</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php } ?>
                    <?php } ?>       
                <tr>
                    <th colspan=7>Totais</th>
                </tr>
                <tr class="pag-totais">
                    <td colspan=3>Total Comissão</td>
                    <td colspan=2><?php echo number_format($total_comissao, 2, ',', '.'); ?></td>
                    <td colspan=2><?php echo number_format($total_parcela, 2, ',', '.'); ?></td>
                </tr>
                <tr class="pag-totais">
                    <td colspan=3>Total Estorno</td>
                    <td colspan=2><?php echo number_format($total_percentual, 2, ',', '.'); ?></td>
                    <td colspan=2><?php echo number_format($total_estorno, 2, ',', '.'); ?></td>
                </tr>
                <tr class="pag-totais">
                    <td colspan=3>Total líquido</td>
                    <td colspan=2><?php echo number_format($total_comissao - $total_percentual, 2, ',', '.'); ?></td>
                    <td colspan=2><?php echo number_format($total_parcela - $total_estorno, 2, ',', '.'); ?></td>
                </tr>
            </table>
    </div>

    <script language="javascript">

        function AlterarStatusEstorno(status, id, lead, parcela) {
            window.open('relatorios/comissao/acao.php?Tipo=ESTORNO'+ '&status=' + status + '&id=' + id + '&lead=' + lead + '&parcela=' + parcela, "acao");
        }

        function AlterarStatus(status, nrparcela, ultimo, lead, parcela, data) {

            function recarregarModal() {
                AbrirModal('relatorios/comissao/parcelas.php?lead=' + lead + '&parcela=' + parcela);
            }

            // Converte a data para "YYYY-MM" (compatível com input type="month")
            let partes = data.includes('/') ? data.split('/') : data.split('-');
            let minAnoMes;
            if (data.includes('/')) {
                // DD/MM/YYYY -> YYYY-MM
                minAnoMes = partes[2] + '-' + partes[1].padStart(2, '0');
            } else {
                // YYYY-MM-DD -> YYYY-MM
                minAnoMes = partes[0] + '-' + partes[1].padStart(2, '0');
            }
            console.log('minAnoMes:', minAnoMes);

            function validarMes(inputMonth) {
                const [anoSelecionado, mesSelecionado] = inputMonth.value.split('-').map(Number);
                const [anoMin, mesMin] = minAnoMes.split('-').map(Number);
                return anoSelecionado > anoMin || (anoSelecionado === anoMin && mesSelecionado >= mesMin);
            }

            if ((ultimo === 'T' || ultimo === 'C') && status === "") {
                Swal.fire({
                    title: 'Informe o mês para atualização dessa parcela',
                    html: `<input id="ano_mes" type="month" class="swal2-input" value="${minAnoMes}">`,
                    showCancelButton: true,
                    confirmButtonText: 'Confirmar',
                    cancelButtonText: 'Cancelar',
                    didOpen: () => {
                        const inputMonth = Swal.getPopup().querySelector('#ano_mes');
                        const confirmBtn = Swal.getConfirmButton();

                        // Inicialmente bloqueia o botão se for menor que o mínimo
                        if (!validarMes(inputMonth)) confirmBtn.disabled = true;

                        inputMonth.addEventListener('input', () => {
                            if (!validarMes(inputMonth)) {
                                Swal.showValidationMessage(
                                    `O mês/ano informado (${inputMonth.value}) não pode ser menor que ${minAnoMes}`
                                );
                                confirmBtn.disabled = true;
                            } else {
                                Swal.resetValidationMessage();
                                confirmBtn.disabled = false;
                            }
                        });
                    },
                    preConfirm: () => {
                        const ano_mes = document.getElementById('ano_mes').value;
                        return ano_mes;
                    }
                }).then((result) => {
                    if (result.isConfirmed && result.value) {
                        let ano_mes = result.value;
                        window.open(
                            'relatorios/comissao/acao.php?Tipo=STATUS'
                            + '&status=' + encodeURIComponent(status)
                            + '&lead=' + encodeURIComponent(lead)
                            + '&ano_mes=' + encodeURIComponent(ano_mes)
                            + '&nrparcela=' + encodeURIComponent(nrparcela)
                            + '&parcela=' + encodeURIComponent(parcela),
                            "acao"
                        );
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'Alteração cancelada',
                            text: 'Você cancelou a alteração de status.'
                        });
                        recarregarModal();
                    }
                });

            } else if (status === 'E') {
                let valorEstorno = parseFloat(document.getElementById("estorno").value) || 0;

                Swal.fire({
                    title: 'Configurar Estorno',
                    html: `
                        <label>Quantidade de parcelas:</label><br>
                        <input id="qtd_parcelas" type="number" min="1" class="swal2-input" placeholder="Ex: 3"><br>
                        <label>Mês/Ano da primeira parcela:</label><br>
                        <input id="ano_mes" type="month" class="swal2-input" value="${minAnoMes}"><br>
                        <small><strong>Valor do estorno configurado: % ${valorEstorno.toFixed(2)}</strong></small>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Confirmar Estorno',
                    cancelButtonText: 'Cancelar',
                    focusConfirm: false,
                    didOpen: () => {
                        const inputMonth = Swal.getPopup().querySelector('#ano_mes');
                        const confirmBtn = Swal.getConfirmButton();

                        if (!validarMes(inputMonth)) confirmBtn.disabled = true;

                        inputMonth.addEventListener('input', () => {
                            if (!validarMes(inputMonth)) {
                                Swal.showValidationMessage(
                                    `O mês/ano informado (${inputMonth.value}) não pode ser menor que ${minAnoMes}`
                                );
                                confirmBtn.disabled = true;
                            } else {
                                Swal.resetValidationMessage();
                                confirmBtn.disabled = false;
                            }
                        });
                    },
                    preConfirm: () => {
                        const qtd_parcelas = parseInt(document.getElementById('qtd_parcelas').value);
                        const ano_mes = document.getElementById('ano_mes').value;

                        if (!qtd_parcelas) {
                            Swal.showValidationMessage('Informe a quantidade de parcelas!');
                            return false;
                        }

                        return { qtd_parcelas, ano_mes };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let dados = result.value;
                        window.open(
                            'relatorios/comissao/acao.php?Tipo=STATUS'
                            + '&status=' + encodeURIComponent(status)
                            + '&lead=' + encodeURIComponent(lead)
                            + '&nrparcela=' + encodeURIComponent(nrparcela)
                            + '&parcela=' + encodeURIComponent(parcela)
                            + '&qtd_parcelas=' + encodeURIComponent(dados.qtd_parcelas)
                            + '&ano_mes=' + encodeURIComponent(dados.ano_mes),
                            "acao"
                        );
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'Alteração cancelada',
                            text: 'Você cancelou a alteração de status.'
                        });
                        recarregarModal();
                    }
                });

            } else {
                // Status normal, abre direto
                window.open(
                    'relatorios/comissao/acao.php?Tipo=STATUS'
                    + '&status=' + encodeURIComponent(status)
                    + '&lead=' + encodeURIComponent(lead)
                    + '&nrparcela=' + encodeURIComponent(nrparcela)
                    + '&parcela=' + encodeURIComponent(parcela),
                    "acao"
                );
            }
        }

    </script>

</body>
</html>


