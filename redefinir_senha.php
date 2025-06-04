<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token'], $_POST['senha'])) {
    $token = $_POST['token'];
    $nova_senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $sql = "SELECT email FROM usuarios WHERE recuperacao_senha = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        $email = $usuario['email'];

        $sql = "UPDATE usuarios SET senha = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nova_senha, $email);
        $stmt->execute();

        echo '<script>alert("Senha alterada com Sucesso!");window.close();</script>';

    } else {
        echo "Token inválido.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
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
        .card {
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 16px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .form-control, .btn {
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4" style="max-width: 400px; width: 100%;">
            <h3 class="text-center mb-4">Redefinir Senha</h3>
            <form action="redefinir_senha.php" method="POST">
                <!-- Campo oculto para o token -->
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>">

                <div class="mb-3">
                    <label for="senha" class="form-label">Nova Senha:</label>
                    <input type="password" name="senha" id="senha" class="form-control" required placeholder="Digite sua nova senha">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Redefinir Senha</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

