<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant que joueur
if (!isset($_SESSION['joueur_username'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ConnexionF.php");
    exit();
}

if (isset($_SESSION['welcome_message5'])) {
    echo "<p style='color: green;'>" . $_SESSION['welcome_message5'] . "</p>";
    unset($_SESSION['welcome_message5']); // Supprimer la variable de session après l'affichage
}

// Le reste de votre code pour la page AccueilJoueurF.php
?>


<!doctype html>
<html lang="fr">

<head>


    <title>Menu Joueur</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include('MenuJoueurF.php'); ?>

    <video autoplay loop muted playsinline id="background-video">
        <source src="videos/video6.mp4" type="video/mp4">
    </video>
    <main>

        <h2>Formulaire de génération de fichier</h2>

        <form action="config.php" method="post">
            <label for="t_droite">Droite :</label>
            <input type="text" id="t_droite" name="t_droite" maxlength="1"><br>

            <label for="t_avancer">Avancer :</label>
            <input type="text" id="t_avancer" name="t_avancer" maxlength="1"><br>

            <label for="t_gauche">Gauche :</label>
            <input type="text" id="t_gauche" name="t_gauche" maxlength="1"><br>

            <label for="t_reculer">Reculer :</label>
            <input type="text" id="t_reculer" name="t_reculer" maxlength="1"><br>
            <button type="submit">enregistrer les touches</button>
        </form>

    </main>

</body>

</html>