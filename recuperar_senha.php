<?php

require __DIR__ . '/PHPMailer-master/src/Exception.php';
require __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/PHPMailer-master/src/SMTP.php';

// Configura o PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $sql = "SELECT * FROM usuarios WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $token = bin2hex(random_bytes(16));

                $sql = "UPDATE usuarios SET recuperacao_senha = ? WHERE email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $token, $email);
                $stmt->execute();

                try {
                    // Configurações do servidor SMTP
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'email.teste.php01@gmail.com';
                    $mail->Password = 'yxeh haws bwhb atfw';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    // Remetente e destinatário
                    $mail->setFrom('email.teste.php01@gmail.com', 'robertinho');
                    $mail->addAddress($email);

                    // Conteúdo do e-mail
                    $mail->isHTML(false);
                    $mail->Subject = 'Recuperacao de Senha';
                    $mail->Body = "Use este link para redefinir sua senha: http://localhost/redefinir_senha.php?token=$token";

                    // Envia o e-mail
                    $mail->send();
                    echo '<script>alert("email de recuperação de senha enviado Sucesso!");</script>';
                    header("Location: index.php?status=success");
                    exit();
                    
                } catch (Exception $e) {
                    echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
                }
            } else {
                echo "E-mail não encontrado no banco de dados.";
            }
        } else {
            echo "E-mail inválido: " . $email;
        }
    } else {
        echo "E-mail não foi enviado no formulário.";
    }

    $stmt->close();
    $conn->close();
}
?>
