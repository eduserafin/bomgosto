<?php 

    $usuario = $_GET['usuario'];
    $empresa = $_GET['empresa'];

    $filtro = "";
    if($usuario != ""){
        $filtro = "AND nr_seq_usercadastro = $usuario";
    }

    $contadorInseridos = 0;
    $contadorNaoInseridos = 0;

    $SQL = "SELECT nr_sequencial, nr_seq_administradora, nr_seq_usercadastro, vl_considerado
            FROM lead
            WHERE nr_seq_empresa = $empresa
            " . $filtro . "";
    echo "<pre>$SQLU</pre>";
    $RSS = mysqli_query($conexao, $SQL);
    while ($linha = mysqli_fetch_row($RSS)) {
        $codigo = $linha[0];
        $administratadora = $linha[1];
        $usuario = $linha[2];
        $valorfinal = $linha[3];

        $delete = "DELETE FROM pagamentos WHERE nr_seq_lead = " . $codigo . "";
        $result = mysqli_query($conexao, $delete);

        $mes_atual = date('m');
        $ano_atual = date('Y');

        //BUSCA O CÓDIGO DO COLABORADOR
        $nr_seq_colaborador = "";
        $SQLU = "SELECT nr_seq_colaborador
                FROM usuarios
                WHERE nr_sequencial = $usuario";
        echo "<pre>$SQLU</pre>";
        $RSSU = mysqli_query($conexao, $SQLU);
        while ($linhau = mysqli_fetch_row($RSSU)) {
            $nr_seq_colaborador = $linhau[0];
        }

        $SQLC = "SELECT pc.nr_parcela, pc.vl_comissao
                FROM parcelas_comissoes pc
                INNER JOIN comissoes c ON c.nr_sequencial = pc.nr_seq_comissao
                WHERE c.nr_seq_colaborador = $nr_seq_colaborador
                AND c.nr_seq_administradora = $administratadora
                ORDER BY pc.nr_parcela ASC";
        echo "<pre>$SQLC</pre>";
        $RSSC = mysqli_query($conexao, $SQLC);
        while ($linhac = mysqli_fetch_row($RSSC)) {
            $nr_parcela = $linhac[0];
            $vl_comissao = $linhac[1];

            //calcula o valor da parcela
            $vl_parcela = ($vl_comissao / 100) * $valorfinal;

            // Calcula o mês e ano da parcela
            $data_parcela = new DateTime();
            $data_parcela->setDate($ano_atual, $mes_atual, 10); // sempre dia 10 do mês atual
            $data_parcela->modify("+".($nr_parcela - 1)." months");

            $dt_parcela = $data_parcela->format("Y-m-d"); // formato para salvar no banco

            $insert = "INSERT INTO pagamentos (nr_seq_lead, nr_parcela, vl_comissao, vl_parcela, dt_parcela) 
                        VALUES (" . $codigo . ", " . $nr_parcela . ", " . $vl_comissao . ", " . $vl_parcela . ", '" . $dt_parcela . "')";
            $rss_insert = mysqli_query($conexao, $insert);   echo "<pre>$insert</pre>";

            if ($rss_insert) {

                $contadorInseridos++;

                $update = "UPDATE lead 
                            SET nr_seq_situacao = 1,
                                dt_alterado = CURRENT_TIMESTAMP,
                                dt_contratada = CURRENT_TIMESTAMP
                        WHERE nr_sequencial = " . $codigo . "";
                echo"<pre> $update</pre>";
                $rss_update = mysqli_query($conexao, $update);

            } else {

                $contadorNaoInseridos++;

            }


        }

    }

// Mensagem final
$msg_js = json_encode(
    "Inseridos: $contadorInseridos\n Não inseridos por erro: $contadorNaoInseridos"
);
$icon = 'success';
$title = 'Comissões processadas!';

echo "<script>
    parent.Swal.fire({
        icon: '$icon',
        title: " . json_encode($title) . ",
        text: `$msg_js`,
        confirmButtonColor: '#28a745',
        width: 600
    });
</script>";
