<?php
session_start();
$nom = strtolower($_SESSION['joueur_sAMAccountName']);
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
        <h1></h1>
        <p>Joueur : <?php echo $nom ?> </p>

        <!-- Section des six boutons géantss -->
        <section class="button-grid">
            <a href="ConfigTouche.php" class="button-item-joueur">
                <img src="image.jpg" alt="">
                <p>Configurer les touches</p>
            </a>
        </section>
    </main>

</body>

</html>