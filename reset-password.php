<!-- reset_password.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe</title>
</head>
<body>
    <form method="post" action="reset_password.php">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
        <label for="password">Nouveau mot de passe:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Réinitialiser le mot de passe</button>
    </form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST["token"];
    $email = $_POST["email"];
    $new_password = $_POST["password"];

    // Connexion à Active Directory
    $ldapconn = ldap_connect("ldaps://dc.arena-monaco.fr") or die("Could not connect to LDAP server.");
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

    $ldaprdn = 'cn=Administrateur, cn=Users, dc=arena-monaco, dc=fr';
    $ldappass = '1234567890A@';

    // Authentification LDAP
    if (@ldap_bind($ldapconn, $ldaprdn, $ldappass)) {
        // Recherche de l'utilisateur par email
        $result = ldap_search($ldapconn, "dc=yourdomain,dc=com", "(mail=$email)");
        $entries = ldap_get_entries($ldapconn, $result);

        if ($entries["count"] > 0) {
            $dn = $entries[0]["dn"];
            $stored_token = $entries[0]["extensionattribute1"][0];

            if ($token === $stored_token) {
                // Réinitialisation du mot de passe
                $entry = ["userPassword" => ldap_hash_password($new_password)];
                if (ldap_modify($ldapconn, $dn, $entry)) {
                    // Suppression du token après réinitialisation du mot de passe
                    $entry = ["extensionAttribute1" => []];
                    ldap_modify($ldapconn, $dn, $entry);

                    echo "Votre mot de passe a été réinitialisé avec succès.";
                } else {
                    echo "Erreur lors de la réinitialisation du mot de passe.";
                }
            } else {
                echo "Token invalide.";
            }
        } else {
            echo "Aucun utilisateur trouvé avec cet e-mail.";
        }
    } else {
        echo "Échec de l'authentification LDAP.";
    }
    ldap_close($ldapconn);
}

function ldap_hash_password($password) {
    return "{SHA}" . base64_encode(pack("H*", sha1($password)));
}
?>
