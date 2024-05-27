<?php
// Connexion au serveur Active Directory (exemple avec LDAP)
$ldapServer = 'ldap://dc.arena-monaco.fr';
$ldapUser = 'cn=Administrateur,cn=Users,dc=arena-monaco,dc=fr';
$ldapPass = '1234567890A@';
$ldapBaseDn = 'dc=arena-monaco,dc=fr';

$ldapConn = ldap_connect($ldapServer);
ldap_bind($ldapConn, $ldapUser, $ldapPass);

// Recherche des utilisateurs dans l'AD
$searchResult = ldap_search($ldapConn, $ldapBaseDn, '(objectClass=user)');
$users = [];

if ($searchResult) {
    $entries = ldap_get_entries($ldapConn, $searchResult);
    for ($i = 0; $i < $entries['count']; $i++) {
        $users[] = $entries[$i]['cn'][0];
    }
}

// Fermeture de la connexion LDAP
ldap_close($ldapConn);

// Renvoyer la liste des utilisateurs sous forme de JSON
header('Content-Type: application/json');
echo json_encode($users);
?>
