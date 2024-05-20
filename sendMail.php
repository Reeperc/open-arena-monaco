<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Assurez-vous que ce chemin est correct

$mail = new PHPMailer(true);
try {
    // Configuration de PHPMailer pour utiliser SMTP
    $mail->isSMTP();
    $mail->Host = '195.221.30.17'; // L'adresse IP de votre serveur SMTP
    $mail->SMTPAuth = false; // Défini à true si une authentification est nécessaire
    $mail->Port = 25; // Utilisation du port 25, ajustez selon votre configuration serveur
    $mail->SMTPSecure = ''; // Désactivé, utilisez 'tls' ou 'ssl' si nécessaire
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    // Active le débogage SMTP
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 2;

    // Expéditeur
    $mail->setFrom('noreply@arena-monaco.fr', 'Monaco Arena');

    // Destinataire
    $mail->addAddress('roger@arena-monaco.fr', 'Roger'); // Modifier par l'adresse de votre destinataire

    // Contenu de l'email
    $mail->isHTML(true); // Définir le format de l'email à HTML
    $mail->Subject = 'Test Mail';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
}
