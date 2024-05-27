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
        // Requête pour récupérer tous les utilisateurs avec un sAMAccountName
        $filter = "(sAMAccountName=*)";
        $attributes = array("sAMAccountName");
        $search = ldap_search($ldap_conn, $ldap_base_dn, $filter, $attributes);
        $entries = ldap_get_entries($ldap_conn, $search);

        // Génération des options pour la liste déroulante
        echo "<select>";
        for ($i = 0; $i < $entries['count']; $i++) {
            $sAMAccountName = $entries[$i]['samaccountname'][0];
            echo "<option value='$sAMAccountName'>$sAMAccountName</option>";
        }
        echo "</select>";
    } else {
        echo "Échec de l'authentification LDAP.";
    }

    // Fermeture de la connexion LDAP
    ldap_close($ldap_conn);
} else {
    echo "Échec de la connexion au serveur LDAP.";
}
?>
