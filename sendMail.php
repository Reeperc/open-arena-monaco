<?php
function sendMail($to, $subject, $message, $headers)
{
    // Utilisation de la fonction mail() pour envoyer l'email
    return mail($to, $subject, $message, $headers);
}

// Récupération des adresses e-mail sélectionnées à partir du POST
$selectedUsers = json_decode($_POST['selectedUsers']);

$subject = 'Notification de démarrage de partie';
$message = 'La partie va commencer. Rejoignez-nous!';
$headers = 'From: noreply@arena-monaco.fr' . "\r\n" .
    'Reply-To: noreply@arena-monaco.fr' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

$success = true;

foreach ($selectedUsers as $to) {
    if (!sendMail($to, $subject, $message, $headers)) {
        $success = false;
        error_log('Échec de l\'envoi de l\'email à ' . $to);
    }
}

if ($success) {
    echo 'Emails envoyés avec succès à tous les utilisateurs sélectionnés.';
} else {
    echo 'Échec de l\'envoi de certains emails. Veuillez vérifier les logs pour plus de détails.';
}
