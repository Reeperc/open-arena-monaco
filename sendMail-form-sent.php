<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = '195.221.30.17'; // Adresse IP du serveur de messagerie
    $mail->SMTPAuth = false;
    $mail->CharSet = 'UTF-8';
    $mail->Port = 25; // ou 587 si vous utilisez TLS
    $mail->SMTPSecure = '';
    $mail->setFrom('noreply@arena-monaco.fr', 'Monaco Arena');

    // Récupérer les données du formulaire
    $mail->addAddress($_POST['to']); // Destinataire
    $mail->Subject = $_POST['subject']; // Objet
    $mail->Body    = $_POST['body']; // Corps du message
    $mail->isHTML(true); // Définir le format de l'email à HTML

    $mail->send();
    echo 'Message envoyé';
} catch (Exception $e) {
    echo 'Message non envoyé. Mailer Error: ', $mail->ErrorInfo;
}
