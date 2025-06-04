<?php
// Início do processamento
include 'conexao.php';

$mensagem = "";
$tipo = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    // Verifica se o e-mail já está cadastrado
    $verifica = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $verifica->bind_param("s", $email);
    $verifica->execute();
    $verifica->store_result();

    if ($verifica->num_rows > 0) {
        $mensagem = "Este e-mail já está cadastrado.";
        $tipo = "warning";
    } else {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nome, $email, $senha_hash);

        if ($stmt->execute()) {
            $mensagem = "Cadastro realizado com sucesso!";
            $tipo = "success";
        } else {
            $mensagem = "Erro ao cadastrar: " . $stmt->error;
            $tipo = "danger";
        }

        $stmt->close();
    }

    $verifica->close();
    $conn->close();
    
} else {
    $mensagem = "Método inválido.";
    $tipo = "danger";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado do Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
      background-image: url('fundo.jpg'); 
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      background-attachment: fixed;
    }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="alert alert-<?php echo $tipo; ?>" role="alert">
                    <?php echo $mensagem; ?>
                </div>
                <a href="index.php" class="btn btn-primary">Voltar</a>
            </div>
        </div>
    </div>
</body>
</html>
