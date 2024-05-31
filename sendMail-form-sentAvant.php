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
    $mail->Port = 25; // ou 587 si vous utilisez TLS

    $mail->CharSet = 'UTF-8';
    $mail->SMTPSecure = '';
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->SMTPDebug = 3;

    $mail->setFrom('noreply@arena-monaco.fr', 'Monaco Arena');

    // Récupérer les données du formulaire-------------------------------------------
    // Traitement des adresses email multiples
    $to = explode(',', $_POST['to']); // Sépare les adresses par des virgules
    foreach ($to as $address) {
        $mail->addAddress(trim($address)); // Ajoute chaque adresse au message
    }
    // $mail->addAddress($_POST['to']); // pr une seule addresse
    $mail->Subject = $_POST['subject']; // Objet
    $mail->Body    = $_POST['body']; // Corps du message
    $mail->isHTML(true); // Définir le format de l'email à HTML

    $mail->send();
    echo 'Message envoyé';
} catch (Exception $e) {
    echo 'Message non envoyé. Mailer Error: ', $mail->ErrorInfo;
}
