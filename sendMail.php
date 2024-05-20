<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // à verifier

$mail = new PHPMailer(true);
try {
    // Configuration de PHPMailer pour utiliser SMTP
    $mail->isSMTP();
    $mail->Host = '195.221.30.17'; // adresse IP de du serveur SMTP
    $mail->SMTPAuth = false; // ou true s'il faut s'authentifier
    // $mail->Username = 'username'; //  nom d'utilisateur SMTP
    // $mail->Password = 'password'; // mot de passe SMTP
    $mail->Port = 25; // port 25, port 587 pr tls
    $mail->SMTPSecure = ''; // Désactivé, utiliser 'tls' ou 'ssl' si besoin
    $mail->SMTPOptions = array( //ser t à désactiver la vérification des certificats SSL
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
    // 3= le niveau de debugging le plus détaillé
    $mail->SMTPDebug = 3;

    // Expéditeur
    $mail->setFrom('noreply@arena-monaco.fr', 'Monaco Arena');

    // Destinataire
    $mail->addAddress('roger@arena-monaco.fr', 'Roger'); // Modifier par l'adresse de votre destinataire

    // Contenu de l'email
    $mail->isHTML(true); // Définir le format de l'email à HTML
    $mail->Subject = 'Test Mail depuis le site';
    $mail->Body    = 'Ce message a été envoyé depuis le site web <b>en gras!!!!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
}
