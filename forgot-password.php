<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Réinitialisation de mot de passe</title>
</head>
<body>
    <h1>Réinitialisation de mot de passe</h1>

    <form method="post" action="send-password-reset.php">
        <label for="email">Adresse email</label>
        <input type="email" id="email" name="email" required>

        <button type="submit">Envoyer</button>
    </form>
</body>
</html>
