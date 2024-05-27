<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Assurez-vous que PHPMailer est installé et chargé
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Vérifie si l'email est fourni via POST
if (!isset($_POST["email"])) {
    die("L'email n'a pas été fourni.");
}

// Récupération de l'email depuis le formulaire
$email = $_POST["email"];

// Vérifie si l'email se termine par @arena-monaco.fr
if (!endsWith($email, '@arena-monaco.fr')) {
    die("L'adresse email doit se terminer par @arena-monaco.fr");
}

// Génération du token de réinitialisation
$token = bin2hex(openssl_random_pseudo_bytes(16));

// Démarrage de la session
session_start();

// Stockage du token dans la session
$_SESSION['reset_token'] = $token;
$_SESSION['reset_email'] = $email; // Sauvegarde de l'email pour la réinitialisation
$_SESSION['reset_token_expire'] = time() + (30 * 60); // 30 minutes d'expiration

// Envoi de l'email avec le lien de réinitialisation
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = '195.221.30.17'; // Assurez-vous que le serveur SMTP est correctement configuré
    $mail->Port = 25; // Port SMTP
    $mail->CharSet = 'UTF-8';
    $mail->SMTPSecure = ''; // Type de sécurité SMTP (ssl/tls), laissez vide pour le port 25
    $mail->SMTPAuth = false; // Pas d'authentification SMTP requise selon votre configuration
    $mail->setFrom('noreply@arena-monaco.fr', 'Monaco Arena');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = "Réinitialisation de mot de passe";
    $mail->Body = "
        <p>Bonjour,</p>
        <p>Cliquez sur le lien suivant pour réinitialiser votre mot de passe :</p>
        <p><a href='http://votre-site.com/reset-password.php?token=$token'>Réinitialiser votre mot de passe</a></p>
        <p>Ce lien expirera dans 30 minutes.</p>
        <p>Cordialement,<br>Monaco Arena</p>
    ";

    $mail->send();
    echo 'Email envoyé avec succès.';
} catch (Exception $e) {
    echo "Erreur lors de l'envoi de l'email : " . $mail->ErrorInfo;
}

// Fonction utilitaire pour vérifier la fin d'une chaîne
function endsWith($string, $suffix) {
    return substr($string, -strlen($suffix)) === $suffix;
}
?>
