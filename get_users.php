<?php
// Configuration pour l'accès à l'Active Directory
$ldap_server = 'ldap://195.221.30.4'; // Remplacez par votre serveur LDAP
$ldap_bind_dn = 'cn=utilisateur,cn=Users,dc=arena-monaco,dc=fr'; // Remplacez par votre nom d'utilisateur LDAP
$ldap_bind_password = '1234567890A@'; // Remplacez par votre mot de passe LDAP
$ldap_base_dn = 'ou=utilisateurs,dc=arena-monaco,dc=fr'; // Base DN du groupe "utilisateurs"

// Connexion à l'Active Directory
$ldap_conn = ldap_connect($ldap_server) or die("Impossible de se connecter au serveur LDAP.");
ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

if ($ldap_conn) {
    // Authentification avec l'utilisateur LDAP
    $ldap_bind = ldap_bind($ldap_conn, $ldap_bind_dn, $ldap_bind_password);

    if ($ldap_bind) {
        // Requête de recherche LDAP pour les utilisateurs du groupe "utilisateurs"
        $search_filter = "(objectClass=user)";
        $attributes = array("sAMAccountName"); // Attribut à récupérer
        $search_result = ldap_search($ldap_conn, $ldap_base_dn, $search_filter, $attributes);

        if ($search_result !== false) {
            // Récupération des entrées LDAP
            $entries = ldap_get_entries($ldap_conn, $search_result);

            $usernames = array();
            for ($i = 0; $i < $entries['count']; $i++) {
                $usernames[] = $entries[$i]['samaccountname'][0];
            }

            // Retourner les noms d'utilisateur en format JSON
            header('Content-Type: application/json');
            echo json_encode($usernames);
        } else {
            echo json_encode(array("error" => "Erreur de recherche LDAP."));
        }
    } else {
        echo json_encode(array("error" => "Échec de l'authentification LDAP."));
    }

    // Fermeture de la connexion LDAP
    ldap_close($ldap_conn);
} else {
    echo json_encode(array("error" => "Échec de la connexion au serveur LDAP."));
}
?>
