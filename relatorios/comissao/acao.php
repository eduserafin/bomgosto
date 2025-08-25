<?php

    foreach($_GET as $key => $value){
        $$key = $value;
    }

    session_start(); 
    include "../../conexao.php";

?>

<?php

   //=====================================-GRAVA o STUTUS DO PAGAMENTO-=========================================

    if ($Tipo == "STATUS") {

        if ($status == "") { // AGUARDANDO

            if($ano_mes != ""){

                // Monta data como dia 10
                $data = $ano_mes . '-10';
                $data_base = new DateTime($data);

                // Buscar a data da parcela anterior
                $busca_anterior = "SELECT dt_parcela 
                                FROM pagamentos 
                                WHERE nr_seq_lead = $lead 
                                AND nr_parcela < (SELECT nr_parcela FROM pagamentos WHERE nr_sequencial = $id)
                                ORDER BY nr_parcela DESC
                                LIMIT 1";
                $res_anterior = mysqli_query($conexao, $busca_anterior);
                $row_anterior = mysqli_fetch_assoc($res_anterior);

                if ($row_anterior) {
                    $dt_anterior = new DateTime($row_anterior['dt_parcela']);
                    
                    // Não pode ser igual ou anterior à parcela anterior
                    if ($data_base <= $dt_anterior) {
                        echo "<script language='JavaScript'>
                                window.parent.Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'A data da parcela não pode ser igual ou anterior à parcela anterior ({$dt_anterior->format('m/Y')})!'
                                });
                                window.parent.AbrirModal('relatorios/comissao/parcelas.php?lead={$lead}parcela={$parcela}');
                                window.parent.consultar(0);
                            </script>";
                        exit;
                    }
                }

                 // Atualiza a parcela informada
                $update = "UPDATE pagamentos SET st_status = '', dt_status = NULL, dt_parcela = '$data', vl_estorno = 0 WHERE nr_sequencial = $id";
                $rss_update = mysqli_query($conexao, $update);
                echo $update . "<br>";

                // Pega a quantidade de parcelas seguintes para atualizar
                $busca_parcelas = "SELECT nr_parcela FROM pagamentos WHERE nr_seq_lead = $lead AND nr_sequencial > $id ORDER BY nr_parcela ASC";
                $rss_parcelas = mysqli_query($conexao, $busca_parcelas);
                while ($linha = mysqli_fetch_assoc($rss_parcelas)) {
                    $nr_parcela_atual = $linha['nr_parcela'];

                    $data_base->modify('+1 month');
                    $data_proxima = $data_base->format('Y-m-10');
    
                    $update_prox = "UPDATE pagamentos SET st_status = '', dt_status = NULL, dt_parcela = '$data_proxima', vl_estorno = 0 WHERE nr_seq_lead = $lead AND nr_parcela = $nr_parcela_atual";
                    $rss_update_prox = mysqli_query($conexao, $update_prox);
                    echo $update_prox . "<br>";
                }


            } else {

                // Atualiza a parcela informada
                $update = "UPDATE pagamentos SET st_status = '', dt_status = NULL, vl_estorno = 0 WHERE nr_sequencial = $id";
                $rss_update = mysqli_query($conexao, $update);
                echo $update . "<br>";

            }

        }

        if($status == "P"){ //PAGO VENDEDOR

            // Atualiza a parcela informada
            $update = "UPDATE pagamentos SET st_status = 'P', dt_status = CURDATE(), vl_estorno = 0 WHERE nr_sequencial = $id";
            $rss_update = mysqli_query($conexao, $update);
            echo $update . "<br>";

        }

        if($status == "C"){ //CANCELADO

            // Atualiza todas parcelas, dessa lead
            $update = "UPDATE pagamentos SET st_status = 'C', dt_status = CURDATE(), vl_estorno = 0 WHERE nr_seq_lead = $lead";
            $rss_update = mysqli_query($conexao, $update);
            echo $update . "<br>";

        }

        if ($status == "E") { // ESTORNO

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
                    $insert = "INSERT INTO pagamentos 
                                (nr_seq_lead, nr_parcela, st_status, dt_status, dt_parcela, vl_percentual, vl_estorno, tp_tipo) 
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
                            SET st_status = 'E', dt_status = CURDATE()
                            WHERE nr_sequencial >= $id 
                            AND nr_seq_lead = $lead";
                $rss_update = mysqli_query($conexao, $update);
            }
        }

        if($status == "T"){ //PENDENTE CLIENTE

            // Atualiza as parcealas atual e futuras
            $update = "UPDATE pagamentos SET st_status = 'T', dt_status = CURDATE(), vl_estorno = 0 WHERE nr_sequencial >= $id AND nr_seq_lead = $lead";
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
                    window.parent.AbrirModal('relatorios/comissao/parcelas.php?lead={$lead}parcela={$parcela}');
                    window.parent.consultar(0);
                </script>";
        } else {
            echo "<script language='JavaScript'>
                    window.parent.Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Problemas ao gravar!'
                    });
                    window.parent.AbrirModal('relatorios/comissao/parcelas.php?lead={$lead}parcela={$parcela}');
                    window.parent.consultar(0);
                </script>";
        }
    }

?>