<?php
//afficher toutes les erreurs dans le navigateur
ini_set('display_errors', 1);
error_reporting(E_ALL);

// include('ConfigurationServeur.php');


//chargement des classes PHPMailerrr
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // à verifier

//creation d'une instance de PHPMailer et config SMTP
$mail = new PHPMailer(true);
try {
    // Configuration de PHPMailer pour utiliser SMTP
    $mail->isSMTP(); //indique à PHPMailer d'utiliser smtp pour envoyer les mails
    $mail->Host = '195.221.30.17'; // adresse IP de du serveur SMTP (serveur mail quoi)
    $mail->SMTPAuth = false; // ou true s'il faut s'authentifier
    // $mail->Username = 'username'; //  nom d'utilisateur SMTP
    // $mail->Password = 'password'; // mot de passe SMTP
    $mail->Port = 25; // port 25, port 587 pr tls
    $mail->CharSet = 'UTF-8';
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
    // 1 = messages client 
    // 2 = messages client et serveurs 
    // 3= le niveau de debugging le plus détaillé .
    $mail->SMTPDebug = 3;

    // Expéditeur
    $mail->setFrom('noreply@arena-monaco.fr', 'Monaco Arena');

    // Destinataire
    $user1 = isset($_POST['user1']) ? $_POST['user1'] : '';
    $user2 = isset($_POST['user2']) ? $_POST['user2'] : '';

    $mail->addAddress($user1);
    $mail->addAddress($user2);
    // $mail->addAddress('roger@arena-monaco.fr'); //exemple pr un utuilisateur (pour qui ça marche mais pas de l'AD)

    // contenu de l'email
    $mail->isHTML(true); // définir le format de l'email à HTML
    $mail->Subject = 'Allez vous échauffez!'; //on evite les accents car non lus sur OE
    $mail->Body    = 'La<b> Monaco Arena </b> est ouverte et la partie va bientot debuter. Vous pouvez vous echauffer avec les autres joueurs';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
}
