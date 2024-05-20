<?php
session_start();
// Vérifier si l'utilisateur est connecté en tant que admin
if (!isset($_SESSION['organisateur_username'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ConnexionF.php");
    exit();
}

if (isset($_SESSION['welcome_message9'])) {
    echo "<p style='color: green;'>" . $_SESSION['welcome_message9'] . "</p>";
    unset($_SESSION['welcome_message9']); // Supprimer la variable de session après l'affichage
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'envoi d'email</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styles/style-mail.css">
    <!-- <?php include('MenuOrganisateurF.php'); ?> -->
    <style>

    </style>
</head>

<body>
    <link rel="stylesheet" href="style.css">
    <video autoplay loop muted playsinline id="background-video">
        <source src="videos/video10.mp4" type="video/mp4">
    </video>
    <link rel="stylesheet" href="style.css">
    <?php include('MenuOrganisateurF.php'); ?>
    <main class="main-mail">
        <div class="form-container-mail">
            <h2>Envoyer un Email</h2>
            <form action="sendMail-form-sent.php" method="post">
                <label for="to">À :</label>
                <input type="email" id="to" name="to" required multiple>

                <label for="subject">Objet :</label>
                <input type="text" id="subject" name="subject" required>

                <label for="body">Message :</label>
                <textarea id="body" name="body" required></textarea>

                <button type="submit">Envoyer le mail</button>
            </form>
        </div>
    </main>
</body>

</html>