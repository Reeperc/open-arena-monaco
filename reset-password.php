<?php
// Démarrage de la session
session_start();

// Vérification de l'existence du token dans la session
if (!isset($_SESSION['reset_token']) || empty($_SESSION['reset_token'])) {
    die("Token de réinitialisation invalide ou expiré.");
}

// Récupération du token de la session
$session_token = $_SESSION['reset_token'];
$session_email = $_SESSION['reset_email'];

// Récupérer le token de l'URL
$url_token = $_GET["token"] ?? null;

if ($url_token === null || $session_token !== $url_token) {
    die("Token de réinitialisation invalide.");
}

// Connexion à LDAP
$ldap_server = "ldaps://dc.arena-monaco.fr"; // Adresse de votre serveur LDAP
$ldap_user = 'cn=Administrateur,cn=Users,dc=arena-monaco,dc=fr'; // Utilisateur LDAP
$ldap_password = '1234567890A@'; // Mot de passe LDAP
$ldap_base_dn = 'dc=arena-monaco,dc=fr'; // Base DN LDAP
$ldap_port = 636;

// Connexion LDAP
$ldap_conn = ldap_connect($ldap_server, $ldap_port) or die("Impossible de se connecter au serveur LDAP.");
ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

if ($ldap_conn) {
    // Authentification LDAP
    $ldap_bind = ldap_bind($ldap_conn, $ldap_user, $ldap_password);

    if ($ldap_bind) {
        // Vérifier si l'utilisateur existe dans AD et réinitialiser son mot de passe
        $user_dn = "CN=" . $session_email . ",OU=utilisateurs,$ldap_base_dn";

        // Interface utilisateur pour la réinitialisation du mot de passe
        ?>
        <!doctype html>
        <html lang="fr">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Réinitialisation de mot de passe</title>
        </head>
        <body>
            <h1>Réinitialisation de mot de passe</h1>
        
            <form method="post" action="process-reset-password.php">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($session_token); ?>">
        
                <label for="password">Nouveau mot de passe</label>
                <input type="password" id="password" name="password" required>
        
                <label for="password_confirmation">Répétez le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
        
                <button type="submit">Envoyer</button>
            </form>
        </body>
        </html>
        <?php
    } else {
        die("Échec de l'authentification LDAP.");
    }

    // Fermeture de la connexion LDAP
    ldap_close($ldap_conn);
} else {
    die("Échec de la connexion au serveur LDAP.");
}
?>
