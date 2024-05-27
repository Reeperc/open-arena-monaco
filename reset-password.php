<?php
// Récupérer le token de l'URL
$token = $_GET["token"] ?? null;

if ($token === null) {
    die("Token non fourni");
}

// Générer le hash du token
$token_hash = hash("sha256", $token);

// Inclure le fichier de connexion à la base de données
require('database.php');

try {
    // Préparer la requête SQL pour récupérer l'utilisateur avec le token fourni
    $sql = "SELECT * FROM joueur WHERE reset_token_hash = :token_hash";
    $stmt = $connexion->prepare($sql);

    // Lier les paramètres
    $stmt->bindParam(':token_hash', $token_hash);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer les résultats
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user === false) {
        die("Token non trouvé");
    }

    if (strtotime($user["reset_token_expires_at"]) <= time()) {
        die("Le token a expiré");
    }

    // Connexion à l'Active Directory pour vérifier et réinitialiser le mot de passe
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
            $user_dn = "CN=" . $user["prenom"] . " " . $user["nom"] . ",OU=utilisateurs,$ldap_base_dn";

            // Interface utilisateur pour la réinitialisation du mot de passe
            echo <<<HTML
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
                    <input type="hidden" name="token" value="{$token}">
            
                    <label for="password">Nouveau mot de passe</label>
                    <input type="password" id="password" name="password" required>
            
                    <label for="password_confirmation">Répétez le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
            
                    <button type="submit">Envoyer</button>
                </form>
            </body>
            </html>
HTML;
        } else {
            die("Échec de l'authentification LDAP.");
        }

        // Fermeture de la connexion LDAP
        ldap_close($ldap_conn);
    } else {
        die("Échec de la connexion au serveur LDAP.");
    }
} catch (PDOException $e) {
    die("Erreur lors de la vérification du token : " . $e->getMessage());
}
?>
