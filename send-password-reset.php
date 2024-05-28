<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Assurez-vous que ce chemin est correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Connexion à Active Directory
    $ldapconn = ldap_connect("ldaps://dc.arena-monaco.fr") or die("Could not connect to LDAP server.");
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

    $ldaprdn = 'cn=Administrateur, cn=Users, dc=arena-monaco, dc=fr';
    $ldappass = '1234567890A@';

    // Authentification LDAP
    if (@ldap_bind($ldapconn, $ldaprdn, $ldappass)) {
        // Recherche de l'utilisateur par email
        $result = ldap_search($ldapconn, "dc=arena-monaco, dc=fr", "(mail=$email)");
        $entries = ldap_get_entries($ldapconn, $result);

        if ($entries["count"] > 0) {
            $dn = $entries[0]["dn"];

            // Génération du token
            $token = bin2hex(random_bytes(16));

            // Stockage du token dans Active Directory (utilisation d'un attribut existant ou personnalisé)
            $entry = ["extensionAttribute1" => $token];
            if (ldap_modify($ldapconn, $dn, $entry)) {
                // Envoi de l'e-mail avec le lien de réinitialisation
                $reset_link = "http://195.221.30.16/reset-password.php?token=$token&email=" . urlencode($email);
                $subject = "Réinitialisation de votre mot de passe";
                $message = "Veuillez cliquer sur le lien suivant pour réinitialiser votre mot de passe: <a href=\"$reset_link\">$reset_link</a>";
                $alt_message = "Veuillez cliquer sur le lien suivant pour réinitialiser votre mot de passe: $reset_link";

                // Envoi de l'e-mail avec PHPMailer
                $mail = new PHPMailer(true);
                try {
                    // Configuration de PHPMailer pour utiliser SMTP
                    $mail->isSMTP();
                    $mail->Host = '195.221.30.17';
                    $mail->SMTPAuth = false;
                    $mail->Port = 25;
                    $mail->CharSet = 'UTF-8';
                    $mail->SMTPSecure = '';
                    $mail->SMTPOptions = [
                        'ssl' => [
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        ]
                    ];

                    // Expéditeur
                    $mail->setFrom('no-reply@arena-monaco.fr', 'Monaco Arena');

                    // Destinataire
                    $mail->addAddress($email);

                    // Contenu de l'e-mail
                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body    = $message;
                    $mail->AltBody = $alt_message;

                    $mail->send();
                    echo 'Un e-mail de réinitialisation de mot de passe a été envoyé.';
                } catch (Exception $e) {
                    echo "L'e-mail n'a pas pu être envoyé. Erreur de l'expéditeur : {$mail->ErrorInfo}";
                }
            } else {
                echo "Erreur lors de la modification de l'utilisateur.";
            }
        } else {
            echo "Aucun utilisateur trouvé avec cet e-mail.";
        }
    } else {
        echo "Échec de l'authentification LDAP.";
    }
    ldap_close($ldapconn);
}
?>
