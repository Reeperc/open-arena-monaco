<?php
header('Content-Type: application/json');

$ldap_server = 'ldap://195.221.30.4'; // Remplacez par votre serveur LDAP
$ldap_user = 'cn=Administrateur, cn=Users, dc=arena-monaco, dc=fr'; // Remplacez par votre nom d'utilisateur LDAP
$ldap_password = '1234567890A@'; // Remplacez par votre mot de passe LDAP
$ldap_base_dn = 'ou=utilisateurs,dc=arena-monaco,dc=fr'; // Base DN pour le dossier "utilisateurs"

// Connexion au serveur LDAP
$ldap_conn = ldap_connect($ldap_server) or die(json_encode(['error' => 'Impossible de se connecter au serveur LDAP.']));
ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

if ($ldap_conn) {
    // Authentification avec les identifiants LDAP
    $ldap_bind = ldap_bind($ldap_conn, $ldap_user, $ldap_password);

    if ($ldap_bind) {
        // Recherche des utilisateurs avec le filtre objectClass=user
        $filter = "(objectClass=user)";
        $attributes = array("mail");
        $search = ldap_search($ldap_conn, $ldap_base_dn, $filter, $attributes);
        $entries = ldap_get_entries($ldap_conn, $search);

        // Récupération des adresses mail
        $emails = array();
        for ($i = 0; $i < $entries['count']; $i++) {
            if (isset($entries[$i]['mail'][0])) {
                $emails[] = $entries[$i]['mail'][0];
            }
        }
        // Encodage en JSON et affichage
        echo json_encode($emails);
    } else {
        echo json_encode(['error' => 'Échec de l\'authentification LDAP.']);
    }
    // Fermeture de la connexion LDAP
    ldap_close($ldap_conn);
} else {
    echo json_encode(['error' => 'Échec de la connexion au serveur LDAP.']);
}
