<?php
session_start(); // Démarrer la session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'identifiant de l'utilisateur à supprimer (par exemple, son adresse e-mail)
    $email_utilisateur = $_POST["email_utilisateur"];

    // Configuration pour l'accès à l'Active Directory
    $ldap_server = 'ldap://195.221.30.4'; // Remplacez par votre serveur LDAP
    $ldap_user = 'cn=Administrateur,cn=Users,dc=arena-monaco,dc=fr'; // Remplacez par votre nom d'utilisateur LDAP
    $ldap_password = '1234567890A@'; // Remplacez par votre mot de passe LDAP
    $ldap_base_dn = 'DC=arena-monaco,DC=fr'; // Remplacez par votre base DN

    // Connexion à l'Active Directory
    $ldap_conn = ldap_connect($ldap_server) or die("Impossible de se connecter au serveur LDAP.");
    ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

    if ($ldap_conn) {
        // Authentification
        $ldap_bind = ldap_bind($ldap_conn, $ldap_user, $ldap_password);

        if ($ldap_bind) {
            // Recherche de l'utilisateur à supprimer
            $filter = "(mail=$email_utilisateur)";
            $search = ldap_search($ldap_conn, $ldap_base_dn, $filter);
            $entries = ldap_get_entries($ldap_conn, $search);

            // Debugging: afficher les entrées trouvées
            echo "<pre>";
            print_r($entries);
            echo "</pre>";

            if ($entries['count'] > 0) {
                // Suppression de l'utilisateur trouvé
                $dn_utilisateur = $entries[0]['dn'];
                $result = ldap_delete($ldap_conn, $dn_utilisateur);

                if ($result) {
                    // Message de succès dans une variable de session
                    $_SESSION['message'] = "Suppression de l'utilisateur $email_utilisateur réussie.";
                } else {
                    $_SESSION['message'] = "Échec de la suppression de l'utilisateur dans l'Active Directory.";
                }
            } else {
                $_SESSION['message'] = "Utilisateur non trouvé dans l'Active Directory.";
            }
        } else {
            $_SESSION['message'] = "Échec de l'authentification LDAP.";
        }

        // Fermeture de la connexion LDAP
        ldap_close($ldap_conn);
    } else {
        $_SESSION['message'] = "Échec de la connexion au serveur LDAP.";
    }

    // Rediriger vers la page CréationCompteJoueur.php
    header("Location: supprimerJoueur.php");
    exit();
}
?>
