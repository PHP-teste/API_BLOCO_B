<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página de Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-image: url('fundo.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      background-attachment: fixed;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-wrapper {
      position: relative;
      width: 100%;
      max-width: 400px;
    }

    .logo-circle {
      position: absolute;
      top: -65px;
      left: 50%;
      transform: translateX(-50%);
      background-color: white;
      border-radius: 50%;
      padding: 0.1px;
      width: 130px;
      height: 130px;
      display: flex;
      justify-content: center;
      align-items: center;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
      z-index: 10;
    }

    .logo-circle img {
      max-width: 100%;
      height: auto;
    }

    .login-container {
      background-color: rgba(255, 255, 255, 0.6);
      padding: 2rem 1.5rem;
      border-radius: 1rem;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      padding-top: 80px;
      position: relative;
      z-index: 1;
    }
  </style>
</head>
<body>
  <div class="login-wrapper">
    <div class="logo-circle">
      <img src="logo.png" alt="Logo">
    </div>

    <div class="login-container text-center">
      <h2 class="mb-4">Login</h2>
      <div id="mensagem"></div>

      <!-- Formulário ÚNICO -->
      <form id="formLogin">
        <div class="mb-3 text-start">
          <label for="email" class="form-label">Email:</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3 text-start">
          <label for="senha" class="form-label">Senha:</label>
          <input type="password" class="form-control" id="senha" name="senha" required>
        </div>
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-primary">Entrar</button>
        </div>
      </form>

      <div class="row mt-3">
        <div class="col-6 d-grid">
          <button class="btn btn-outline-success" onclick="window.location.href='cad.html';">Cadastro</button>
        </div>
        <div class="col-6 d-grid">
          <button class="btn btn-outline-danger" onclick="window.location.href='recuperar_senha.html';">Recuperar Senha</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Aguarda o DOM estar carregado
    document.addEventListener('DOMContentLoaded', function () {
      document.getElementById('formLogin').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        fetch('processa_login.php', {
          method: 'POST',
          body: formData
        })
        .then(res => res.text())
        .then(mensagem => {
          if (mensagem.trim() === 'sucesso') {
            window.location.href = 'interface.html';
          } else {
            document.getElementById('mensagem').innerHTML = `
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ${mensagem}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
              </div>
            `;
          }
        })
        .catch(() => {
          document.getElementById('mensagem').innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Erro ao tentar fazer login.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
          `;
        });
      });
    });
  </script>
</body>
</html>
