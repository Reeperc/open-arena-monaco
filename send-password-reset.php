<?php
// Assurez-vous que PHPMailer est installé et chargé
require 'vendor/autoload.php';

// Vérifie si l'email est fourni via POST
if (!isset($_POST["email"])) {
    die("L'email n'a pas été fourni.");
}

// Récupération de l'email depuis le formulaire
$email = $_POST["email"];

// Vérifie si l'email se termine par @arena-monaco.fr
if (!endsWith($email, '@arena-monaco.fr')) {
    echo "L'adresse email doit se terminer par @arena-monaco.fr";
    exit();
}

// Génération du token de réinitialisation
$token = bin2hex(openssl_random_pseudo_bytes(16));

// Configuration pour l'accès à l'Active Directory
$ldap_server = "ldaps://dc.arena-monaco.fr";
$ldap_user = 'cn=Administrateur,cn=Users,dc=arena-monaco,dc=fr';
$ldap_password = 'VotreMotDePasseLDAP';
$ldap_base_dn = 'dc=arena-monaco,dc=fr';

// Connexion à l'Active Directory
$ldap_conn = ldap_connect($ldap_server) or die("Impossible de se connecter au serveur LDAP.");
ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

if ($ldap_conn) {
    // Authentification LDAP
    $ldap_bind = @ldap_bind($ldap_conn, $ldap_user, $ldap_password);

    if ($ldap_bind) {
        // Recherche de l'utilisateur par email
        $filter = "(mail=$email)";
        $attributes = array("mail");
        $search = ldap_search($ldap_conn, $ldap_base_dn, $filter, $attributes);
        $entries = ldap_get_entries($ldap_conn, $search);

        if ($entries['count'] > 0) {
            // Mettre à jour le jeton de réinitialisation dans Active Directory
            $user_dn = $entries[0]['dn'];
            $update = ldap_mod_replace($ldap_conn, $user_dn, array('resetToken' => $token));

            if ($update) {
                // Envoi de l'email avec le lien de réinitialisation
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = '195.221.30.17';
                    $mail->SMTPAuth = false;
                    $mail->Port = 25;
                    $mail->CharSet = 'UTF-8';
                    $mail->SMTPSecure = '';
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );

                    // Configuration de l'email
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
            } else {
                echo "Erreur lors de la mise à jour du jeton de réinitialisation dans Active Directory.";
            }
        } else {
            echo "Utilisateur non trouvé dans Active Directory.";
        }
    } else {
        echo "Échec de l'authentification LDAP : " . ldap_error($ldap_conn);
    }

    // Fermeture de la connexion LDAP
    ldap_close($ldap_conn);
} else {    
    echo "Échec de la connexion au serveur LDAP.";
}

// Fonction utilitaire pour vérifier la fin d'une chaîne
function endsWith($string, $suffix) {
    return substr($string, -strlen($suffix)) === $suffix;
}
?>
