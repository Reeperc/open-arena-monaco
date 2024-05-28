<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password']; // Récupérer le mot de passe saisi par l'utilisateur

    // Configuration pour l'accès à l'Active Directory
    $ldap_server = 'ldap://195.221.30.4'; // Remplacez par votre serveur LDAP
    $ldap_bind_dn = 'cn=utilisateur,cn=Users,dc=arena-monaco,dc=fr'; // Remplacez par votre nom d'utilisateur LDAP
    $ldap_bind_password = '1234567890A@'; // Remplacez par votre mot de passe LDAP
    $ldap_base_dn = 'dc=arena-monaco,dc=fr'; // Base DN des utilisateurs
    $ldap_base_dn_admin = 'cn=Users,dc=arena-monaco,dc=fr'; // Base DN des administrateurs
    $ldap_base_dn_organisateur = 'ou=organisateurs,dc=arena-monaco,dc=fr'; // Base DN des organisateurs

    // Connexion à l'Active Directory
    $ldap_conn = ldap_connect($ldap_server) or die("Impossible de se connecter au serveur LDAP.");
    ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

    if ($ldap_conn) {
        // Authentification avec l'utilisateur LDAP
        $ldap_bind = ldap_bind($ldap_conn, $ldap_bind_dn, $ldap_bind_password);

        if ($ldap_bind) {
            // Requête de recherche LDAP pour les administrateurs
            $search_filter_admin = "(mail=$email)";
            $attributes_admin = array("cn", "dn", "sAMAccountName"); // Ajouter sAMAccountName
            $search_result_admin = ldap_search($ldap_conn, $ldap_base_dn_admin, $search_filter_admin, $attributes_admin);

            // Requête de recherche LDAP pour les organisateurs
            $search_filter_organisateur = "(mail=$email)";
            $attributes_organisateur = array("cn", "dn", "sAMAccountName"); // Ajouter sAMAccountName
            $search_result_organisateur = ldap_search($ldap_conn, $ldap_base_dn_organisateur, $search_filter_organisateur, $attributes_organisateur);

            // Requête de recherche LDAP avec le filtre d'adresse e-mail pour les utilisateurs
            $search_filter = "(mail=$email)";
            $attributes = array("cn", "dn", "sAMAccountName"); // Ajouter sAMAccountName
            $search_result = ldap_search($ldap_conn, $ldap_base_dn, $search_filter, $attributes);

            if ($search_result_admin !== false && $search_result_organisateur !== false && $search_result != false) {
                // Récupération des entrées LDAP pour les administrateurs
                $entries_admin = ldap_get_entries($ldap_conn, $search_result_admin);

                // Récupération des entrées LDAP pour les organisateurs
                $entries_organisateur = ldap_get_entries($ldap_conn, $search_result_organisateur);

                // Récupération des entrées LDAP pour les utilisateurs
                $entries = ldap_get_entries($ldap_conn, $search_result);

                // Tentative de liaison avec le DN et le mot de passe fourni par l'utilisateur
                if ($entries_admin['count'] == 1) {
                    $user_dn = $entries_admin[0]['dn'];
                } elseif ($entries_organisateur['count'] == 1) {
                    $user_dn = $entries_organisateur[0]['dn'];
                } elseif ($entries['count'] == 1) {
                    $user_dn = $entries[0]['dn'];
                } else {
                    $user_dn = null;
                }

                if ($user_dn) {
                    // Tenter de lier avec le DN et le mot de passe de l'utilisateur
                    if (@ldap_bind($ldap_conn, $user_dn, $password)) {
                        // Authentification réussie
                        if ($entries_admin['count'] == 1) {
                            // L'utilisateur est un administrateur
                            $_SESSION['admin_username'] = $entries_admin[0]['cn'][0];
                            $_SESSION['admin_sAMAccountName'] = $entries_admin[0]['sAMAccountName'][0]; // Récupérer sAMAccountName
                            $_SESSION['welcome_message'] = "Connexion réussie en tant qu'admin";
                            header("Location: AccueilAdminF.php");
                            exit();
                        } elseif ($entries_organisateur['count'] == 1) {
                            // L'utilisateur est un organisateur
                            $_SESSION['organisateur_username'] = $entries_organisateur[0]['cn'][0];
                            $_SESSION['organisateur_sAMAccountName'] = $entries_organisateur[0]['sAMAccountName'][0]; // Récupérer sAMAccountName
                            $_SESSION['welcome_message'] = "Connexion réussie en tant qu'organisateur";
                            header("Location: AccueilOrganisateurF.php");
                            exit();
                        } elseif ($entries['count'] == 1) {
                            // L'utilisateur est un joueur
                            $_SESSION['joueur_username'] = $entries[0]['cn'][0];
                            $_SESSION['joueur_sam'] = $entries[0]['sAMAccountName'][0]; // Récupérer sAMAccountName
                            $_SESSION['Welcome_message2'] = "Bienvenue ! Connexion réussie";
                            header("Location: AccueilJoueurF.php");
                            exit();
                        }
                    } else {
                        echo "<p style='color: red;'>Mot de passe incorrect.</p>";
                    }
                } else {
                    echo "<p style='color: red;'>Aucun utilisateur trouvé avec cette adresse e-mail.</p>";
                }
            } else {
                echo "<p style='color: red;'>Erreur de recherche LDAP.</p>";
            }
        } else {
            echo "<p style='color: red;'>Échec de l'authentification LDAP.</p>";
        }

        // Fermeture de la connexion LDAP
        ldap_close($ldap_conn);
    } else {
        echo "<p style='color: red;'>Échec de la connexion au serveur LDAP.</p>";
    }
}
?>
