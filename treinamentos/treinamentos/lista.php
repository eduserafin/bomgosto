<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Treinamento</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #3b82f6;
            --secondary-color: #1e293b;
            --text-color: #334155;
            --light-bg: #f8fafc;
            --card-bg: #ffffff;
            --border-radius: 12px;
        }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: var(--light-bg);
            margin: 0;
            padding: 0;
        }
        .container-lista {
            width: 100%;
            max-width: 1400px;
            background: var(--card-bg);
            margin: 30px auto;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            animation: fadeIn 0.4s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .header-treinamento {
            display: flex;
            align-items: center;
            margin-bottom: 18px;
        }
        .header-treinamento i {
            font-size: 3.8rem;
            color: var(--primary-color);
            margin-right: 12px;
        }
        .header-treinamento h2 {
            font-size: 3.6rem;
            color: var(--secondary-color);
            margin: 0;
        }
        .info-topo {
            display: flex;
            align-items: center;
            font-size: 1.8rem;
            color: var(--text-color);
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 8px;
        }
        .info-topo i {
            color: var(--primary-color);
            margin-right: 6px;
        }
        .data-cadastro {
            font-size: 1rem;
            color: #64748b;
            margin-top: 5px;
        }
        .conteudo-flex {
            display: flex;
            gap: 20px;
            align-items: flex-start;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .descricao-lista {
            flex: 0 0 40%;
            max-width: 40%;
            background: var(--light-bg);
            padding: 18px;
            border-radius: var(--border-radius);
            font-size: 1.1rem;
            color: var(--text-color);
            line-height: 1.7;
        }
        .video-container-lista {
            flex: 0 0 50%;
            max-width: 60%;
            position: relative;
            padding-bottom: 34%;
            height: 0;
            overflow: hidden;
            border-radius: var(--border-radius);
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }
        .video-container-lista iframe {
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            border: none;
            border-radius: var(--border-radius);
        }
        @media (max-width: 900px) {
            .conteudo-flex {
                flex-direction: column;
            }
            .descricao-lista, .video-container-lista {
                flex: 0 0 100%;
                max-width: 100%;
            }
            .video-container-lista {
                padding-bottom: 56.25%;
            }
        }
        @media (max-width: 600px) {
            .container-lista {
                padding: 20px;
            }
            .header-treinamento h2 {
                font-size: 1.4rem;
            }
            .info-topo {
                font-size: 1rem;
            }
            .descricao-lista {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
<?php
require_once '../../conexao.php';

$id_menu = isset($_GET['id_menu']) ? intval($_GET['id_menu']) : 0;
$id_smenu = isset($_GET['id_smenu']) ? intval($_GET['id_smenu']) : 0;

$SQL = "SELECT t.nr_sequencial, t.nr_seq_menu, t.nr_seq_smenu, t.ds_link, t.ds_descricao, 
        t.dt_cadastro, m.ds_menu, m.ic_menu, s.ds_smenu, s.ic_smenu
        FROM treinamentos t
        INNER JOIN menus m ON t.nr_seq_menu = m.nr_sequencial
        INNER JOIN submenus s ON t.nr_seq_smenu = s.nr_sequencial
        WHERE t.nr_seq_menu = $id_menu 
        AND t.nr_seq_smenu = $id_smenu
        LIMIT 1";
$RSS = mysqli_query($conexao, $SQL);
$treinamento = mysqli_fetch_assoc($RSS);

if (!$treinamento) {
    echo "<p style='font-family: Arial; padding: 20px;'>Treinamento não encontrado.</p>";
    exit;
}

$ds_link = $treinamento['ds_link'];
$ds_descricao = $treinamento['ds_descricao'];
$ds_menu = $treinamento['ds_menu'];
$ds_smenu = $treinamento['ds_smenu'];
$ic_menu = $treinamento['ic_menu'];
$ic_smenu = $treinamento['ic_smenu'];
$dt_cadastro = date('d/m/Y', strtotime($treinamento['dt_cadastro']));
?>

<div class="container-lista">
    <div class="header-treinamento">
        <i class="fa fa-chalkboard-teacher"></i>
        <h2>Treinamento</h2>
    </div>

    <div class="info-topo">
        <div><i class="fa <?php echo htmlspecialchars($ic_menu); ?>"></i> <?php echo htmlspecialchars($ds_menu); ?></div>
        <span>-</span>
        <div><i class="fa <?php echo htmlspecialchars($ic_smenu); ?>"></i> <?php echo htmlspecialchars($ds_smenu); ?></div>
    </div>
    <div class="data-cadastro">Atualizado em: <?php echo $dt_cadastro; ?></div>

    <div class="conteudo-flex">
        <div class="descricao-lista">
            <?php echo $ds_descricao; ?>
        </div>

        <?php if($ds_link != "") { ?>
            <div class="video-container-lista">
                <?php echo $ds_link; ?>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>
