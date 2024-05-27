<?php
require 'vendor/autoload.php'; // Assurez-vous que PHPMailer est chargé

// Vérifie si l'email est fourni via POST
if (!isset($_POST["email"])) {
    die("L'email n'a pas été fourni.");
}

// Récupération de l'email depuis le formulaire
$email = $_POST["email"];

// Vérifie si l'email se termine par @arena-monaco.fr (si nécessaire)
if (!endsWith($email, '@arena-monaco.fr')) {
    echo "L'adresse email doit se terminer par @arena-monaco.fr";
    exit();
}

// Génération du token de réinitialisation
$token = bin2hex(openssl_random_pseudo_bytes(16));

// Configuration de PHPMailer pour l'envoi d'email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = '195.221.30.17'; // Adresse IP du serveur SMTP
    $mail->SMTPAuth = false; // Ou true s'il faut s'authentifier
    $mail->Port = 25; // Port 25, port 587 pour TLS
    $mail->CharSet = 'UTF-8';
    $mail->SMTPSecure = ''; // Désactivé, utiliser 'tls' ou 'ssl' si nécessaire
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    // Expéditeur
    $mail->setFrom('noreply@arena-monaco.fr', 'Monaco Arena');

    // Destinataire
    $mail->addAddress($email);

    // Contenu de l'email
    $mail->isHTML(true); // Définir le format de l'email à HTML
    $mail->Subject = "Réinitialisation de mot de passe";
    $mail->Body = "
        <p>Bonjour,</p>
        <p>Cliquez sur le lien suivant pour réinitialiser votre mot de passe :</p>
        <p><a href='http://votre-site.com/reset-password.php?token=$token'>Réinitialiser votre mot de passe</a></p>
        <p>Ce lien expirera dans 30 minutes.</p>
        <p>Cordialement,<br>Monaco Arena</p>
    ";

    // Envoyer l'email
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
