<?php

    foreach($_GET as $key => $value){
        $$key = $value;
    }

    session_start(); 
    include "../../conexao.php";

?>

<?php

   //================================================-GRAVA STUTUS DAS PARCELAS NORMAIS-=========================================

    if ($Tipo == "STATUS") {

        if ($status == "") { //========================================================AGUARDANDO=================================================================================

            if($ano_mes != "") {

                // Monta a data inicial como dia 10
                $data_base = new DateTime($ano_mes . '-10');

                // Buscar a data da parcela anterior
                $busca_anterior = "SELECT dt_parcela 
                                    FROM pagamentos 
                                    WHERE nr_seq_lead = $lead 
                                    AND nr_parcela < $nrparcela
                                    AND tp_tipo = 'N'
                                    ORDER BY nr_parcela DESC
                                    LIMIT 1";
                $res_anterior = mysqli_query($conexao, $busca_anterior);
                $row_anterior = mysqli_fetch_assoc($res_anterior);

                if ($row_anterior) {
                    $dt_anterior = new DateTime($row_anterior['dt_parcela']);
                    if ($data_base <= $dt_anterior) {
                        echo "<script language='JavaScript'>
                                window.parent.Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'A data da parcela não pode ser igual ou anterior à parcela anterior ({$dt_anterior->format('m/Y')})!'
                                });
                                window.parent.AbrirModal('relatorios/comissao/parcelas.php?lead={$lead}&parcela={$parcela}');
                                window.parent.consultar(0);
                            </script>";
                        exit;
                    }
                }

                // Buscar todas as parcelas a partir da escolhida
                $busca_parcelas = "SELECT nr_parcela, st_status 
                                    FROM pagamentos 
                                    WHERE nr_seq_lead = $lead 
                                    AND nr_parcela >= $nrparcela 
                                    AND tp_tipo = 'N' 
                                    ORDER BY nr_parcela ASC";
                $rss_parcelas = mysqli_query($conexao, $busca_parcelas);

                while ($linha = mysqli_fetch_assoc($rss_parcelas)) {
                    $nr_parcela_atual = $linha['nr_parcela'];

                    // Se a parcela está com status 'A', não atualiza, mas ainda assim avança a data-base
                    if ($linha['st_status'] === 'A') {
                        $data_base->modify('+1 month');
                        continue;
                    }

                    // Atualiza a parcela com a data corrente do data_base
                    $data_proxima = $data_base->format('Y-m-10');

                    $update = "UPDATE pagamentos 
                                SET st_status = '', 
                                    dt_status = NULL, 
                                    dt_parcela = '$data_proxima' 
                                WHERE nr_seq_lead = $lead 
                                AND nr_parcela = $nr_parcela_atual 
                                AND tp_tipo = 'N'";
                    $rss_update = mysqli_query($conexao, $update);
                    echo $update . "<br>";

                    // Incrementa 1 mês para a próxima parcela
                    $data_base->modify('+1 month');
                }

            } else {

                // Atualiza apenas a parcela informada, se não for 'A'
                $update = "UPDATE pagamentos 
                            SET st_status = '', 
                                dt_status = NULL 
                            WHERE nr_seq_lead = $lead 
                            AND nr_parcela = $nrparcela 
                            AND tp_tipo = 'N'
                            AND st_status != 'A'";
                $rss_update = mysqli_query($conexao, $update);
                echo $update . "<br>";
            }
        }

        if($status == "P"){ //=====================================================PAGO VENDEDOR================================================================================

            // Atualiza a parcela informada
            $update = "UPDATE pagamentos 
                        SET st_status = 'P', 
                            dt_status = CURDATE() 
                        WHERE nr_seq_lead = $lead 
                        AND nr_parcela = $nrparcela 
                        AND tp_tipo = 'N'
                        AND st_status != 'A'";
            $rss_update = mysqli_query($conexao, $update);
            echo $update . "<br>";

        }

        if($status == "C"){ //======================================================CANCELADO==================================================================================

            // Atualiza todas parcelas, dessa lead para canceladas
            $update = "UPDATE pagamentos 
                        SET st_status = 'C', 
                            dt_status = CURDATE() 
                        WHERE nr_seq_lead = $lead 
                        AND tp_tipo = 'N'";
            $rss_update = mysqli_query($conexao, $update);
            echo $update . "<br>";

        }

         if($status == "T"){ //================================================PENDENTE CLIENTE===============================================================================

            // Atualiza as parcealas atual e futuras, sem alterar parcelas de RATEIO
            $update = "UPDATE pagamentos 
                        SET st_status = 'T', 
                            dt_status = CURDATE() 
                        WHERE nr_seq_lead = $lead 
                        AND nr_parcela >= $nrparcela 
                        AND tp_tipo = 'N'
                        AND st_status != 'A'";
            $rss_update = mysqli_query($conexao, $update);
            echo $update . "<br>";

        }

        if($status == "A"){ //====================================================RATEIO==================================================================================

            // Busca informações da parcela dessa lead
            $sql1 = "SELECT nr_sequencial, vl_comissao, vl_parcela
                            FROM pagamentos
                            WHERE nr_seq_lead = $lead
                            AND nr_parcela = $nrparcela
                            AND tp_tipo = 'N'";
            $res1 = mysqli_query($conexao, $sql1);
            if ($lin1 = mysqli_fetch_row($res1)) {
                $nr_seq_parcela = $lin1[0];
                $vl_comissao = $lin1[1];
                $vl_parcela = $lin1[2];
            }

            // Busca informações da ultima parcela dessa lead
            $sql2 = "SELECT nr_parcela, dt_parcela
                            FROM pagamentos
                            WHERE nr_seq_lead = $lead
                            AND tp_tipo = 'N'
                            ORDER BY nr_parcela DESC LIMIT 1";
            $res2 = mysqli_query($conexao, $sql2);
            if ($lin2 = mysqli_fetch_row($res2)) {
                $ultima_parcela = $lin2[0];
                $dt_ultima_parcela = $lin2[1];
            }

            $nova_parcela = $ultima_parcela + 1;
            $nova_data = date('Y-m-d', strtotime($dt_ultima_parcela . ' +1 month'));
            $inseriu = false;

            // Insere uma nova parcela após a ultima parcela cadastrada
            $insert = "INSERT INTO pagamentos (nr_seq_lead, nr_parcela, st_status, dt_status, dt_parcela, vl_comissao, vl_parcela, tp_tipo) 
                        VALUES ($lead, $nova_parcela, '', NULL, '$nova_data', $vl_comissao, $vl_parcela, 'N')";
            if (mysqli_query($conexao, $insert)) {
                $inseriu = true;
            } else {
                echo "Erro no INSERT: " . mysqli_error($conexao);
            }

            if ($inseriu) {

                // Após inserir a parcela nova, atualiza a parcela atual zerando os valores e incluindo status RATEIO
                $update = "UPDATE pagamentos 
                            SET st_status = 'A', 
                                vl_comissao = 0, 
                                vl_parcela = 0, 
                                dt_status = CURDATE()
                            WHERE nr_sequencial = $nr_seq_parcela ";
                $rss_update = mysqli_query($conexao, $update);
                echo $update . "<br>";

            }

        }

        if ($status == "E") { // =====================================================ESTORNO======================================================================================

            // Busca informações da lead
            $sql = "SELECT c.nr_sequencial, l.nr_seq_administradora, l.vl_considerado
                    FROM lead l
                    INNER JOIN usuarios u ON l.nr_seq_usercadastro = u.nr_sequencial
                    INNER JOIN colaboradores c ON u.nr_seq_colaborador = c.nr_sequencial
                    WHERE l.nr_sequencial = $lead";
            $res = mysqli_query($conexao, $sql);
            if ($linha = mysqli_fetch_row($res)) {
                $nr_seq_colaborador    = $linha[0];
                $nr_seq_administradora = $linha[1];
                $vl_considerado        = $linha[2];
            }

            // Busca percentual de estorno configurado
            $vl_estorno = 0;
            $sql_estorno = "SELECT vl_estorno
                            FROM comissoes
                            WHERE nr_seq_colaborador = $nr_seq_colaborador 
                            AND nr_seq_administradora = $nr_seq_administradora";
            $res_estorno = mysqli_query($conexao, $sql_estorno);
            if ($lin_estorno = mysqli_fetch_row($res_estorno)) {
                $vl_estorno = $lin_estorno[0];
            }

            // Valor total do estorno em dinheiro
            $valor_estorno = ($vl_estorno / 100) * $vl_considerado;

            // Percentual total do estorno
            $percentual_total = $vl_estorno;

            // Base de cada parcela (sem ajuste ainda)
            $valor_base = $valor_estorno / $qtd_parcelas;
            $percentual_base = $percentual_total / $qtd_parcelas;

            $inseriu = false;

            // Acumuladores para controlar diferença
            $soma_valor = 0;
            $soma_percentual = 0;

            if ($qtd_parcelas > 0 && $ano_mes != "") {
                list($ano, $mes) = explode("-", $ano_mes);

                for ($i = 0; $i < $qtd_parcelas; $i++) {
                    $mesAtual = $mes + $i;
                    $anoAtual = $ano;

                    // Ajusta quando passar dezembro
                    while ($mesAtual > 12) {
                        $mesAtual -= 12;
                        $anoAtual++;
                    }

                    // Define vencimento (10º dia do mês)
                    $dt_parcela = sprintf("%04d-%02d-10", $anoAtual, $mesAtual);

                    if ($i < $qtd_parcelas - 1) {
                        // Arredonda normalmente
                        $vl_parcela = round($valor_base, 2);
                        $pc_parcela = round($percentual_base, 2);

                        $soma_valor += $vl_parcela;
                        $soma_percentual += $pc_parcela;
                    } else {
                        // Última parcela recebe ajuste para fechar o valor exato
                        $vl_parcela = round($valor_estorno - $soma_valor, 2);
                        $pc_parcela = round($percentual_total - $soma_percentual, 2);
                    }

                    // Insere a parcela de estorno
                    $insert = "INSERT INTO pagamentos (nr_seq_lead, nr_parcela, st_status, dt_status, dt_parcela, vl_percentual, vl_estorno, tp_tipo) 
                                VALUES ($lead, $i + 1, '', CURDATE(), '$dt_parcela', $pc_parcela, $vl_parcela, 'E')";
                    if (mysqli_query($conexao, $insert)) {
                        $inseriu = true;
                    } else {
                        echo "Erro no INSERT: " . mysqli_error($conexao);
                    }
                }
            }

            // Atualiza as parcelas correspondentes para ESTORNO apenas se houve insert
            if ($inseriu) {
                $update = "UPDATE pagamentos 
                            SET st_status = 'E', 
                                dt_status = CURDATE()
                            WHERE nr_seq_lead = $lead 
                            AND nr_parcela >= $nrparcela
                            AND tp_tipo = 'N'
                            AND st_status != 'A'";
                $rss_update = mysqli_query($conexao, $update);
            }
        }

       //=====================================================================================================================================================================

        if ($rss_update) {
            echo "<script language='JavaScript'>
                    window.parent.Swal.fire({
                        icon: 'success',
                        title: 'Show...',
                        text: 'Alteração registrada com sucesso!'
                    });
                    window.parent.AbrirModal('relatorios/comissao/parcelas.php?lead={$lead}&parcela={$parcela}');
                    window.parent.consultar(0);
                </script>";
        } else {
            echo "<script language='JavaScript'>
                    window.parent.Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Problemas ao gravar!'
                    });
                    window.parent.AbrirModal('relatorios/comissao/parcelas.php?lead={$lead}&parcela={$parcela}');
                    window.parent.consultar(0);
                </script>";
        }
    }

    //================================================-GRAVA STUTUS DAS PARCELAS DE ESTORNO-=========================================

    if ($Tipo == "ESTORNO") {

        if ($status == "R") { //=================================RECEBIDO=================================================================================================
            
            // Atualiza a parcela de estorno correspondente com o status RECEBIDO
            $update = "UPDATE pagamentos 
                        SET st_status = 'R', 
                            dt_status = CURDATE()
                        WHERE nr_sequencial = $id 
                        AND tp_tipo = 'E'";
            $rss_update = mysqli_query($conexao, $update);
            echo $update . "<br>";

        }

        if ($status == "") { //=================================AGUARDANDO=================================================================================================

            // Atualiza a parcela de estorno correspondente com o status VAZIU
            $update = "UPDATE pagamentos 
                        SET st_status = '', 
                            dt_status = NULL
                        WHERE nr_sequencial = $id 
                        AND tp_tipo = 'E'";
            $rss_update = mysqli_query($conexao, $update);
            echo $update . "<br>";
        }

        if ($rss_update) {
            echo "<script language='JavaScript'>
                    window.parent.Swal.fire({
                        icon: 'success',
                        title: 'Show...',
                        text: 'Alteração registrada com sucesso!'
                    });
                    window.parent.AbrirModal('relatorios/comissao/parcelas.php?lead={$lead}&parcela={$parcela}');
                    window.parent.consultar(0);
                </script>";
        } else {
            echo "<script language='JavaScript'>
                    window.parent.Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Problemas ao gravar!'
                    });
                    window.parent.AbrirModal('relatorios/comissao/parcelas.php?lead={$lead}&parcela={$parcela}');
                    window.parent.consultar(0);
                </script>";
        }
    }

?>