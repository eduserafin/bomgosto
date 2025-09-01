
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('img/fundo3.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }
        .form-recover {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            max-width: 400px;
            width: 100%;
        }
        .form-recover h3 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }
        .btn-submit {
            background: #612db5;
            color: #fff;
            border: none;
            padding: 12px;
            width: 100%;
            font-weight: 500;
            font-size: 15px;
            border-radius: 12px;
            transition: background 0.3s ease;
        }
        .btn-submit:hover {
            background: #4e2391;
        }

        .swal-compact {
            max-width: 300px !important; /* ou ajuste como quiser */
            padding: 1.5em !important;
        }

    </style>
</head>
<body>

<div class="form-recover">
    <form id="form-recover">
        <h3>Recuperar Senha</h3>
        <div class="mb-3">
            <label for="email" class="form-label">Digite seu e-mail</label>
            <input type="email" name="email" id="email" class="form-control" required placeholder="seuemail@exemplo.com">
        </div>
        <button type="submit" class="btn-submit">Enviar link de recuperação</button>
    </form>
</div>

</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('form-recover').addEventListener('submit', function(event) {
        event.preventDefault(); // Evita o envio tradicional

        const formData = new FormData(this);

        fetch('processa.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire({
                icon: data.status,
                title: data.title,
                text: data.message,
                confirmButtonText: 'OK'
            }).then(() => {
                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            });
        })
       .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Não foi possível enviar o e-mail. Tente novamente.',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'swal-compact'
                }
            });
            console.error('Erro:', error);
        });
    });
</script>

