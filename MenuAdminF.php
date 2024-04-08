<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header Membre</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #FF0000; /* Rouge */
            color: white;
            padding: 15px;
            text-align: center;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            position: relative;
        }

        header a {
            display: block; /* Transforme l'élément en bloc pour occuper toute la largeur */
        }

        header img {
            width: 100px; /* Ajustez la taille du logo selon vos besoins */
            height: auto;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        header p {
             background-color: white;
             color: red;
             padding: 10px;
            border-radius: 5px;
             font-weight: bold;
             margin-top: 10px;
             margin-right: 10px;
            }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            padding-left: 120px; /* Ajout d'un espace pour le logo avant les liens */
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            overflow: hidden;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #FF4500; /* Orange-rouge */
        }

        .accueil-link {
            margin-left: auto; /* Déplace le bouton Déconnexion tout à droite */
        }
    </style>
</head>
<body>
    <?php
    // Vérifier si l'utilisateur est connecté en tant qu'admin
    if (isset($_SESSION['admin_username'])) {
        // Afficher un message de bienvenue pour l'admin
        echo '<header>';
        echo '<a href="AccueilAdminF.php">';
        echo '<img src="logo esigelec.png" alt="Logo du site">';
        echo '</a>';
        echo '<nav>';
        echo '<a href="CalendrierAdminF.php">Calendrier des parties</a>';
        echo '<a href="ModifjeuxF.php">Edition de jeu</a>';
        echo '<a href="CréationCompteAdminF.php">Créer un compte administrateur</a>';
        echo '<p>' . $_SESSION['admin_username'] . '</p>';
        echo '<a href="DeconnexionF.php" class="accueil-link">Déconnexion</a>';
        echo '</nav>';
        echo '</header>';
    }
    ?>
</body>
</html>
