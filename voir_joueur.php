<?php
// Configuration pour l'accès à l'Active Directory
$ldap_server = 'ldap://195.221.30.4'; // Remplacez par votre serveur LDAP
$ldap_user = 'cn=Administrateur, cn=Users, dc=arena-monaco, dc=fr'; // Remplacez par votre nom d'utilisateur LDAP
$ldap_password = '1234567890A@'; // Remplacez par votre mot de passe LDAP
$ldap_base_dn = 'DC=arena-monaco, DC=fr'; // Remplacez par votre base DN

// Connexion à l'Active Directory
$ldap_conn = ldap_connect($ldap_server) or die("Impossible de se connecter au serveur LDAP.");
ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

if ($ldap_conn) {
    // Authentification
    $ldap_bind = ldap_bind($ldap_conn, $ldap_user, $ldap_password);

    if ($ldap_bind) {
        // Requête pour récupérer tous les utilisateurs
        $filter = "(objectClass=user)";
        $attributes = array("cn", "mail", "sn", "givenName");
        $search = ldap_search($ldap_conn, $ldap_base_dn, $filter, $attributes);
        $entries = ldap_get_entries($ldap_conn, $search);

        // Affichage des utilisateurs
        echo "<h2>Liste des utilisateurs :</h2>";
        echo "<ul>";
        for ($i = 0; $i < $entries['count']; $i++) {
            $cn = isset($entries[$i]['cn'][0]) ? $entries[$i]['cn'][0] : "N/A";
            $email = isset($entries[$i]['mail'][0]) ? $entries[$i]['mail'][0] : "N/A";
            $nom = isset($entries[$i]['sn'][0]) ? $entries[$i]['sn'][0] : "N/A";
            $prenom = isset($entries[$i]['givenname'][0]) ? $entries[$i]['givenname'][0] : "N/A";
            echo "<li>Nom complet : $prenom $nom - Email : $email</li>";
        }
        echo "</ul>";
    } else {
        echo "Échec de l'authentification LDAP.";
    }

    // Fermeture de la connexion LDAP
    ldap_close($ldap_conn);
} else {
    echo "Échec de la connexion au serveur LDAP.";
}
?>
