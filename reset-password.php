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
    $sql = "SELECT * FROM Joueur WHERE reset_token_hash = :token_hash";
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

    echo "Le token est valide et n'a pas expiré";
} catch (PDOException $e) {
    die("Erreur lors de la vérification du token : " . $e->getMessage());
}
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

    <form method="post">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <label for="password">Nouveau mot de passe</label>
        <input type="password" id="password" name="password" required>

        <label for="password_confirmation">Répétez le mot de passe</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>

        <button type="submit">Envoyer</button>
    </form>
</body>
</html>

<?php
// Afficher toutes les erreurs dans le navigateur pour le débogage
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Vérifier si PHPMailer est installé
if (!file_exists('vendor/autoload.php')) {
    die('PHPMailer non installé. Exécutez `composer install`.');
}

// Charger les classes PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Charger les dépendances Composer

// Récupération des données du formulaire
$token = $_POST["token"];
$password = $_POST["password"];
$password_confirmation = $_POST["password_confirmation"];

// Validation des mots de passe
if ($password !== $password_confirmation) {
    die("Les mots de passe ne correspondent pas");
}

// Génération du hash du mot de passe
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Inclure le fichier de connexion à la base de données
require('database.php');

try
?>