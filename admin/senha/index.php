<?php
foreach ($_GET as $key => $value) {
    $$key = $value;
}
?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Modern Form Style -->
<style>
  body {
    background: #f0f2f5;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
  }

  .container {
    max-width: 450px;
    margin: 60px auto;
    padding: 30px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    transition: 0.3s;
  }

  .container h2 {
    text-align: center;
    margin-bottom: 25px;
    font-size: 24px;
    color: #333;
    letter-spacing: 0.5px;
  }

  .form-group {
    position: relative;
    margin-bottom: 25px;
  }

  .form-group input {
    width: 100%;
    padding: 14px 12px;
    background: #f9f9f9;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 15px;
    outline: none;
    transition: all 0.3s ease;
  }

  .form-group input:focus {
    background: #fff;
    border-color: #5b9bd5;
    box-shadow: 0 0 5px rgba(91, 155, 213, 0.3);
  }

  .form-group label {
    position: absolute;
    top: -10px;
    left: 12px;
    background: #fff;
    padding: 0 5px;
    font-size: 13px;
    color: #555;
    transition: 0.3s;
  }

  .nome-usuario {
    padding: 12px;
    background: #f1f3f6;
    border-radius: 8px;
    font-weight: 600;
    color: #333;
  }

  .button-wrapper {
    text-align: center;
    margin-top: 10px;
  }

  button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 12px 24px;
    font-size: 15px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.1s;
  }

  button:hover {
    background-color: #218838;
  }

  button:active {
    transform: scale(0.98);
  }

  @media (max-width: 500px) {
    .container {
      margin: 30px 15px;
    }
  }
</style>


<?php
foreach ($_GET as $key => $value) {
    $$key = $value;
}
?>
<iframe name="acao" width="0%" height="0" frameborder="0" marginheight="0" marginwidth="0" scrolling="auto"></iframe>

<body onload="document.getElementById('txtsenhaa').focus();">
  <div class="container">
    <h2>Alterar Senha</h2>

    <div class="form-group">
      <label>Usuário</label>
      <div class="nome-usuario"><?php echo $_SESSION["DS_USUARIO"]; ?></div>
    </div>

    <div class="form-group">
      <label for="txtsenhaa">Senha Atual</label>
      <input type="password" name="txtsenhaa" id="txtsenhaa" maxlength="20">
    </div>

    <div class="form-group">
      <label for="txtsenhan">Nova Senha</label>
      <input type="password" name="txtsenhan" id="txtsenhan" maxlength="20">
    </div>

    <div class="button-wrapper">
      <button type="button" onclick="executafuncao('save')">Salvar</button>
    </div>
  </div>

  <script>
    function executafuncao(id) {
      if (id === 'save') {
        let senhaa = document.getElementById('txtsenhaa').value.trim();
        let senhan = document.getElementById('txtsenhan').value.trim();

        if (senhaa === "") {
          Swal.fire("Atenção", "Informe a senha atual!", "warning").then(() => {
            document.getElementById('txtsenhaa').focus();
          });
        } else if (senhan === "") {
          Swal.fire("Atenção", "Informe a nova senha!", "warning").then(() => {
            document.getElementById('txtsenhan').focus();
          });
        } else if (senhaa === senhan) {
          Swal.fire("Atenção", "A NOVA SENHA está igual à SENHA ANTIGA!", "error").then(() => {
            document.getElementById('txtsenhaa').focus();
          });
        } else {
          senhaa = senhaa.replace(/'/g, "");
          senhan = senhan.replace(/'/g, "");

          Swal.fire({
            title: "Deseja alterar a senha?",
            text: "Você está prestes a alterar sua senha.",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sim, alterar",
            cancelButtonText: "Cancelar"
          }).then((result) => {
            if (result.isConfirmed) {
              window.open("admin/senha/acao.php?Alterar=OK&TxSenhaA=" + encodeURIComponent(senhaa) + "&TxSenhaN=" + encodeURIComponent(senhan), "acao");
            }
          });
        }
      }
    }
  </script>
</body>
