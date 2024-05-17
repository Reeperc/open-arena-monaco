<!DOCTYPE html>
<html lang="fr">

<head>

    <title>Header Membre</title>

</head>

<body>
    <?php
    //Vérifier si l'utilisateur est connecté en tant qu'admin
    //if (isset($_SESSION['admin_username'])) {
    // Afficher un message de bienvenue pour l'admin
    echo '<header>';
    echo '<a href="AccueilAdminF.php">';
    echo '<img src="images/akalogo.png" alt="Logo du site">';
    echo '</a>';
    echo '<nav>';
    // echo '<a href="LancerJeu.php">Lancer le jeu</a>';
    // echo '<a href="DemarrerService.php">Démarrer le service</a>';
    // echo '<a href="ArretJeu.php">Arrêter le service</a>';
    // echo '<a href="StatutService.php">Statut du service</a>';
    // echo '<a href="CréationCompteJoueur.php">Créer un compte joueur</a>';
    // echo '<a href="CompétitionTEST.php">Arbre de compétition</a>';
    // echo '<a href="ListmapsAdmin.php">Liste des cartes</a>';
    // echo '<p>' . $_SESSION['admin_username'] . '</p>';
    echo '<a href="DeconnexionF.php" class="accueil-link bouton-rouge-foncé">Déconnexion</a>';
    echo '</nav>';
    echo '</header>';
    //}
    ?>
</body>

</html>