<?php
header('Content-Type: application/json');

$ldap_server = 'ldap://195.221.30.4'; // Remplacez par votre serveur LDAP
$ldap_user = 'cn=Administrateur, cn=Users, dc=arena-monaco, dc=fr'; // Remplacez par votre nom d'utilisateur LDAP
$ldap_password = '1234567890A@'; // Remplacez par votre mot de passe LDAP
$ldap_base_dn = 'DC=arena-monaco, DC=fr'; // Remplacez par votre base DN

$ldap_conn = ldap_connect($ldap_server) or die(json_encode(['error' => 'Impossible de se connecter au serveur LDAP.']));
ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

if ($ldap_conn) {
    $ldap_bind = ldap_bind($ldap_conn, $ldap_user, $ldap_password);

    if ($ldap_bind) {
        $filter = "(objectClass=user)";
        $attributes = array("samaccountname");
        $search = ldap_search($ldap_conn, $ldap_base_dn, $filter, $attributes);
        $entries = ldap_get_entries($ldap_conn, $search);

        $users = array();
        for ($i = 0; $i < $entries['count']; $i++) {
            $users[] = $entries[$i]['samaccountname'][0];
        }
        echo json_encode($users);
    } else {
        echo json_encode(['error' => 'Échec de l\'authentification LDAP.']);
    }
    ldap_close($ldap_conn);
} else {
    echo json_encode(['error' => 'Échec de la connexion au serveur LDAP.']);
}
?>
