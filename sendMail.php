<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = '195.221.30.17';
    $mail->SMTPAuth = true; // Changez à true si l'authentification est nécessaire
    $mail->Username = 'rt'; // Votre nom d'utilisateur SMTP
    $mail->Password = 'rt'; // Votre mot de passe SMTP
    $mail->SMTPSecure = 'tls'; // Ou 'ssl' si vous utilisez SSL
    $mail->Port = 25; // Port pour TLS
    $mail->setFrom('noreply@arena-monaco.fr', 'Monaco Arena');
    $mail->addAddress('roger@arena-monaco.fr', 'Roger');
    $mail->Subject = 'Test Mail';
    $mail->Body    = 'This is the email body';
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
