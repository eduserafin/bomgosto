<?php
session_start();
include "conexao.php";

$id_usuario = $_SESSION["CD_USUARIO"]; 
$hoje = date('Y-m-d');

$sql = "SELECT * FROM lead WHERE nr_seq_usercadastro = '$id_usuario' AND dt_agenda = '$hoje'";
$result = mysqli_query($conexao, $sql);

$qtd_agendamentos = mysqli_num_rows($result);

if ($qtd_agendamentos > 0):
?>
    <div id="alerta-agendamento" style="
        position: fixed;
        top: 20px;
        right: 20px;
        background: #fffbcc;
        color: #333;
        padding: 15px 20px;
        border: 1px solid #f0e68c;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0,0,0,0.2);
        z-index: 9999;
    ">
        📅 Você possui <strong><?php echo $qtd_agendamentos; ?></strong> agendamentos para hoje!
        <button onclick="fecharAlerta()" style="
            background: transparent;
            border: none;
            font-size: 16px;
            font-weight: bold;
            color: #555;
            margin-left: 15px;
            cursor: pointer;
        ">✖</button>
    </div>

    <script>
        // Verifica se já foi exibido hoje no localStorage
        const hoje = '<?php echo $hoje; ?>';
        if (localStorage.getItem('alerta_agendamento') === hoje) {
            document.getElementById('alerta-agendamento').style.display = 'none';
        }

        function fecharAlerta() {
            document.getElementById('alerta-agendamento').style.display = 'none';
            localStorage.setItem('alerta_agendamento', hoje);
        }
    </script>
<?php
endif;
?>
