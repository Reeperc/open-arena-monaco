<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST['email'];

    // Configuration pour l'accès à l'Active Directory
    $ldap_server = 'ldap://195.221.30.4'; // Remplacez par votre serveur LDAP
    $ldap_bind_dn = 'cn=utilisateur,cn=Users,dc=arena-monaco,dc=fr'; // Remplacez par votre nom d'utilisateur LDAP
    $ldap_bind_password = '1234567890A@'; // Remplacez par votre mot de passe LDAP
    $ldap_base_dn = 'dc=arena-monaco,dc=fr'; // Base DN d
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
            $attributes_admin = array("cn"); // Attribut à récupérer (CN)
            $search_result_admin = ldap_search($ldap_conn, $ldap_base_dn_admin, $search_filter_admin, $attributes_admin);

            // Requête de recherche LDAP pour les organisateurs
            $search_filter_organisateur = "(mail=$email)";
            $attributes_organisateur = array("cn"); // Attribut à récupérer (CN)
            $search_result_organisateur = ldap_search($ldap_conn, $ldap_base_dn_organisateur, $search_filter_organisateur, $attributes_organisateur);

            // Requête de recherche LDAP avec le filtre d'adresse e-mail
            $search_filter = "(mail=$email)";
            $attributes = array("cn", "directoryName"); // Attribut à récupérer (CN)
            $search_result = ldap_search($ldap_conn, $ldap_base_dn, $search_filter, $attributes);

            if ($search_result_admin !== false && $search_result_organisateur !== false && $search_result != false) {
                // Récupération des entrées LDAP pour les administrateurs
                $entries_admin = ldap_get_entries($ldap_conn, $search_result_admin);

                // Récupération des entrées LDAP pour les organisateurs
                $entries_organisateur = ldap_get_entries($ldap_conn, $search_result_organisateur);

                //utilisateurs
                $entries = ldap_get_entries($ldap_conn, $search_result);



                if ($entries_admin['count'] == 1) {
                    // L'utilisateur est un administrateur
                    $_SESSION['admin_username'] = $entries_admin[0]['cn'][0];
                    $_SESSION['welcome_message'] = "Connexion réussie en tant qu'admin";
                    header("Location: AccueilAdminF.php");
                    exit();
                } elseif ($entries_organisateur['count'] == 1) {
                    // L'utilisateur est un organisateur
                    $_SESSION['organisateur_username'] = $entries_organisateur[0]['cn'][0];
                    $_SESSION['welcome_message'] = "Connexion réussie en tant qu'organisateur";
                    header("Location: AccueilOrganisateurF.php");
                    exit();
                } elseif ($entries['count'] == 1) {

                    // Récupérer le CN de l'utilisateur trouvé
                    $cn = $entries[0]['cn'][0];
                    $directoryName= $entries[0]['$directoryName'][0];

                    // Authentification réussie, enregistrer le nom d'utilisateur dans une variable de session
                    $_SESSION['joueur_username'] = $cn;
                    $_SESSION['joueur_directory'] = $directoryName;
                    $_SESSION['Welcome_message2'] = "Bienvenue ! Connexion réussie";

                    // Rediriger vers la page d'accueil après la connexion réussie
                    header("Location: AccueilJoueurF.php");
                    exit(); // Assurez-vous de terminer l'exécution du script après la redirection

                } else {
                    // il n'y a  rien
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
