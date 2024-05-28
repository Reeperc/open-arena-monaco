<?php
// Inclure le fichier de connexion à la base de données
require('database.php');

// Récupération des données du formulaire
$token = $_POST["token"] ?? null;
$password = $_POST["password"] ?? null;
$password_confirmation = $_POST["password_confirmation"] ?? null;

// Validation des mots de passe
if ($password !== $password_confirmation) {
    die("Les mots de passe ne correspondent pas");
}

// Génération du hash du mot de passe
$password_hash = password_hash($password, PASSWORD_DEFAULT);

try {
    // Mettre à jour le mot de passe dans la base de données locale
    $sql_update = "UPDATE Joueur SET password = :password_hash, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE reset_token_hash = :token_hash";
    $stmt_update = $connexion->prepare($sql_update);
    $stmt_update->bindParam(':password_hash', $password_hash);
    $stmt_update->bindParam(':token_hash', $token);
    
    if ($stmt_update->execute()) {
        echo "Mot de passe réinitialisé avec succès dans la base de données locale.";

        // Configuration pour l'accès à l'Active Directory
        $ldap_server = "ldaps://dc.arena-monaco.fr";
        $ldap_user = 'cn=Administrateur, cn=Users, dc=arena-monaco, dc=fr';
        $ldap_password = '1234567890A@';
        $ldap_base_dn = 'dc=arena-monaco, dc=fr';
        $ldap_port = 636;

        // Connexion à l'Active Directory
        $ldap_conn = ldap_connect($ldap_server, $ldap_port) or die("Impossible de se connecter au serveur LDAP.");
        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

        if ($ldap_conn) {
            // Authentification
            $ldap_bind = ldap_bind($ldap_conn, $ldap_user, $ldap_password);

            if ($ldap_bind) {
                // Rechercher l'utilisateur dans l'Active Directory
                $search_filter = "(mail=" . $user['Email'] . ")";
                $search_result = ldap_search($ldap_conn, $ldap_base_dn, $search_filter);
                $entry = ldap_first_entry($ldap_conn, $search_result);

                if ($entry) {
                    // Mettre à jour le mot de passe dans l'Active Directory
                    $dn = ldap_get_dn($ldap_conn, $entry);
                    $unicodePwd = mb_convert_encoding("\"$password\"", 'UTF-16LE');
                    $userdata = array('unicodePwd' => $unicodePwd);
                    $ldap_update = ldap_modify($ldap_conn, $dn, $userdata);

                    if ($ldap_update) {
                        echo "Mot de passe réinitialisé avec succès dans l'Active Directory.";
                    } else {
                        echo "Échec de la réinitialisation du mot de passe dans l'Active Directory : " . ldap_error($ldap_conn);
                    }
                } else {
                    echo "Utilisateur non trouvé dans l'Active Directory.";
                }
            } else {
                echo "Échec de l'authentification LDAP.";
            }

            // Fermeture de la connexion LDAP
            ldap_close($ldap_conn);
        } else {
            echo "Échec de la connexion au serveur LDAP.";
        }
    } else {
        die("Erreur lors de la réinitialisation du mot de passe dans la base de données.");
    }

} catch (PDOException $e) {
    die("Erreur lors de la mise à jour du mot de passe : " . $e->getMessage());
}
?>
