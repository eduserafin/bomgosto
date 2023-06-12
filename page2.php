<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consórcios - Sua Chance de Realizar seus Sonhos</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <style>
    body {
      padding-top: 60px;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">Logo</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="#about">Sobre</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#benefits">Benefícios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#contact">Contato</a>
        </li>
      </ul>
    </div>
  </nav>

  <header class="jumbotron text-center">
    <h1 class="display-4">Consórcios - Sua Chance de Realizar seus Sonhos</h1>
    <p class="lead">Conquiste seu carro novo, sua casa própria ou seu negócio próprio através de um consórcio. Descubra como!</p>
    <a href="#contact" class="btn btn-primary btn-lg">Entre em Contato</a>
  </header>

  <div class="container" id="about">
    <section>
      <h2>Sobre</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam id ornare justo. Duis consequat pharetra mauris, ut pharetra enim ultrices in. Sed mattis eu elit id ultricies. Proin laoreet pellentesque purus, auctor tempor lacus porta ut. Curabitur efficitur, tortor sit amet faucibus vestibulum, ante nunc fermentum sem, a fermentum nibh enim a justo. Aliquam auctor justo dolor, sed semper ligula iaculis at. Proin consectetur diam quis ex congue, id ultricies lacus consequat. Duis ac facilisis nisi, id egestas metus.</p>
    </section>

    <section id="benefits">
      <h2>Benefícios</h2>
      <div class="row">
        <div class="col-md-4">
          <div class="card mb-4">
            <img src="path-to-image.jpg" class="card-img-top" alt="Benefício 1">
            <div class="card-body">
              <h5 class="card-title">Benefício 1</h5>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam id ornare justo.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4">
            <img src="path-to-image.jpg" class="card-img-top" alt="Benefício 2">
            <div class="card-body">
              <h5 class="card-title">Benefício 2</h5>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam id ornare justo.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4">
            <img src="path-to-image.jpg" class="card-img-top" alt="Benefício 3">
            <div class="card-body">
              <h5 class="card-title">Benefício 3</h5>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam id ornare justo.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="contact">
      <h2>Contato</h2>
      <p>Preencha o formulário abaixo para receber mais informações:</p>
      <form>
        <div class="form-group">
          <label for="name">Nome:</label>
          <input type="text" class="form-control" id="name" required>
        </div>
        <div class="form-group">
          <label for="email">E-mail:</label>
          <input type="email" class="form-control" id="email" required>
        </div>
        <div class="form-group">
          <label for="message">Mensagem:</label>
          <textarea class="form-control" id="message" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
      </form>
    </section>
  </div>

  <footer class="bg-dark text-white text-center p-3 mt-5">
    <p>&copy; 2023 Nome da Empresa. Todos os direitos reservados.</p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
