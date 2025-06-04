<?php
include 'conexao.php';

$nome = "Usuario Teste";
$email = "usuario@email.com";
$senha = password_hash("123456", PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sss", $nome, $email, $senha);

    if ($stmt->execute()) {
        echo "Usuário registrado com sucesso!";
    } else {
        echo "Erro ao registrar usuário: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Erro ao preparar a query: " . $conn->error;
}

$conn->close();
?>