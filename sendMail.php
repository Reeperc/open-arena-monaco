<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = '195.221.30.17'; // Adresse IP du serveur de messagerie
    $mail->SMTPAuth = false; // Activez SMTPAuth si nécessaire
    $mail->Port = 25; // ou 587 si vous utilisez TLS
    $mail->setFrom('noreply@arena-monaco.fr', 'Monaco Arena');
    $mail->addAddress('roger@arena-monaco.fr', 'Roger');
    $mail->Subject = 'Test Mail';
    $mail->Body    = 'This is the email body';
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
