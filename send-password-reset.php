<?php
// Afficher toutes les erreurs dans le navigateur pour le débogage
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Définir le fuseau horaire par défaut
date_default_timezone_set('Europe/Paris');

// Vérifier si PHPMailer est installé
if (!file_exists('vendor/autoload.php')) {
    die('PHPMailer non installé. Exécutez `composer install`.');
}

// Charger les classes PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Charger les dépendances Composer

// Récupération de l'email depuis le formulaire
if (!isset($_POST["Email"])) {
    die("L'email n'a pas été fourni.");
}
$Email = $_POST["Email"];

// Génération du token et du hash
$token = bin2hex(openssl_random_pseudo_bytes(16));
$token_hash = hash("sha256", $token);

// Calcul de la date d'expiration
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

// Inclusion du fichier de connexion à la base de données
require('database.php');

try {
    // Préparation de la requête de mise à jour
    $sql = "UPDATE joueur 
            SET reset_token_hash = :token_hash,
                reset_token_expires_at = :expiry
            WHERE Email = :email";

    $stmt = $connexion->prepare($sql);

    // Liaison des paramètres
    $stmt->bindParam(':token_hash', $token_hash);
    $stmt->bindParam(':expiry', $expiry);
    $stmt->bindParam(':email', $Email);

    // Exécution de la requête
    $stmt->execute();

    // Vérification du nombre de lignes affectées
    if ($stmt->rowCount() > 0) {
        // Envoi de l'email en cas de succès de la mise à jour
        $mail = new PHPMailer(true);
        try {
            // Configuration de PHPMailer pour utiliser SMTP
            $mail->isSMTP(); // Indique à PHPMailer d'utiliser SMTP pour envoyer les mails
            $mail->Host = '195.221.30.17'; // Adresse IP du serveur SMTP
            $mail->SMTPAuth = false; // Ou true s'il faut s'authentifier
            $mail->Port = 25; // Port 25, port 587 pour TLS
            $mail->CharSet = 'UTF-8';
            $mail->SMTPSecure = ''; // Désactivé, utiliser 'tls' ou 'ssl' si besoin
            $mail->SMTPOptions = array( // Sert à désactiver la vérification des certificats SSL
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
            // 3 = le niveau de debugging le plus détaillé.
            $mail->SMTPDebug = 0; // Réduire le niveau de débogage pour la production

            // Expéditeur
            $mail->setFrom('noreply@arena-monaco.fr', 'Monaco Arena');

            // Destinataire
            $mail->addAddress($Email); // Utiliser l'email fourni par le formulaire

            // Contenu de l'email
            $mail->isHTML(true); // Définir le format de l'email à HTML
            $mail->Subject = "Password Reset";
            $mail->Body    = <<<END
            <p>Bonjour,</p>
            <p>Cliquez sur le lien suivant pour réinitialiser votre mot de passe :</p>
            <p><a href="http://195.221.30.16/reset-password.php?token=$token">Réinitialiser votre mot de passe</a></p>
            <p>Ce lien expirera dans 30 minutes.</p>
            <p>Cordialement,<br>Monaco Arena</p>
            END;
            $mail->AltBody = "Cliquez sur le lien suivant pour réinitialiser votre mot de passe : http://195.221.30.16/reset-password.php?token=$token";

            $mail->send();
            echo 'Le message a été envoyé.';
        } catch (Exception $e) {
            echo 'Le message n\'a pas pu être envoyé. Erreur de Mailer: ' . $mail->ErrorInfo;
        }
    } else {
        echo "Aucune mise à jour n'a été effectuée. Vérifiez que l'adresse e-mail est correcte.";
    }
} catch (PDOException $e) {
    echo "Erreur lors de la mise à jour du token : " . $e->getMessage();
}
