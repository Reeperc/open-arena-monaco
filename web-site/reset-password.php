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
<head>1
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Réinitialisation de mot de passe</title>
</head>
<body>
<link rel="stylesheet" href="style.css">
<?php include('MenuVisiteurF.php'); ?>
<video autoplay loop muted playsinline id="background-video">
    <source src="videos/video5.mp4" type="video/mp4">
  </video>
  <main class='background-transparent'>
    <h1>Réinitialisation de mot de passe</h1>

    <form method="post" class="login-form" action="process-reset-password.php">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <label class="form-label" for="password">Nouveau mot de passe</label>
        <input class="form-input" type="password" id="password" name="password" required>

        <label class="form-label" for="password_confirmation">Répétez le mot de passe</label>
        <input class="form-input" type="password" id="password_confirmation" name="password_confirmation" required>

        <button class="form-button" type="submit">Envoyer</button>
    </form>
</main>
</body>
</html>
