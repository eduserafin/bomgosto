<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Venda de Consórcios</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <header class="bg-primary text-white text-center py-5">
    <h1>Venda de Consórcios</h1>
    <p>Realize o sonho da sua casa própria, carro novo ou viagens incríveis!</p>
  </header>

  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6">
        <h2>Consórcio de Imóveis</h2>
        <p>Realize o sonho da casa própria através do nosso consórcio de imóveis. Sem juros e com planos flexíveis.</p>
        <a href="#contato" class="btn btn-primary">Entre em contato</a>
      </div>
      <div class="col-md-6">
        <h2>Consórcio de Automóveis</h2>
        <p>Adquira seu carro novo com nosso consórcio de automóveis. Parcelas que cabem no seu bolso e sem burocracia.</p>
        <a href="#contato" class="btn btn-primary">Entre em contato</a>
      </div>
    </div>
  </div>

  <section id="contato" class="bg-light py-5">
    <div class="container">
      <h2>Entre em Contato</h2>
      <p>Preencha o formulário abaixo e entraremos em contato com você.</p>

      <form>
        <div class="form-group">
          <label for="nome">Nome:</label>
          <input type="text" class="form-control" id="nome" required>
        </div>
        <div class="form-group">
          <label for="email">E-mail:</label>
          <input type="email" class="form-control" id="email" required>
        </div>
        <div class="form-group">
          <label for="mensagem">Mensagem:</label>
          <textarea class="form-control" id="mensagem" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
      </form>
    </div>
  </section>

  <footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2023 Venda de Consórcios. Todos os direitos reservados.</p>
  </footer>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
