<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header Membre</title>

</head>

<body>
    <?php
    // Vérifier si l'utilisateur est connecté en tant qu'orga
    if (isset($_SESSION['organisateur_username'])) {
        // Afficher un message de bienvenue pour l'orga
        echo '<header>';
        echo '<a href="AccueilOrganisateurF.php">';
        echo '<img src="images/akalogo.png" alt="Logo du site">';
        echo '</a>';
        echo '<nav>';
        echo '<p>' . $_SESSION['organisateur_username'] . '</p>';
        echo '<a href="DeconnexionF.php" class="accueil-link">Déconnexion</a>';
        echo '</nav>';
        echo '</header>';
    }
    ?>
</body>

</html>