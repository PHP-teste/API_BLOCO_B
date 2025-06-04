<?php
// Inclui manualmente o PHPMailer
require __DIR__ . '/PHPMailer-master/src/Exception.php';
require __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cria uma instância do PHPMailer
$mail = new PHPMailer(true);

try {
    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Servidor SMTP do Gmail
    $mail->SMTPAuth = true;
    $mail->Username = 'email.teste.php01@gmail.com';
    $mail->Password = 'Teste.php@123';
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
    echo "E-mail de recuperacao enviado.";
} catch (Exception $e) {
    echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
}
?>