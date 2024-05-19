<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Header Membre</title>
    <style>
        /* Inclure les styles CSS directement dans le fichier HTML pour simplifier */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            color: #0088ff;
            height: 100%;
        }

        header {
            background-color: rgba(0, 0, 0, 0.1);
            color: #003462;
            padding: 15px;
            text-align: center;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            position: relative;
        }

        header a {
            display: block;
        }

        header img {
            width: 140px;
            height: auto;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            padding-left: 120px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            overflow: hidden;
        }

        nav a {
            color: #ffffff;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #6d0000;
        }

        .active {
            background-color: #4CAF50; /* couleur de l'élément actif */
        }

        .accueil-link {
            margin-left: auto;
        }
    </style>
</head>
<body>
    <?php
    // Vérifier si l'utilisateur est connecté en tant qu'admin
    // if (isset($_SESSION['admin_username'])) {
        // Afficher un message de bienvenue pour l'admin
        echo '<header>';
        echo '<a href="AccueilAdminF.php">';
        echo '<img src="images/akalogo.png" alt="Logo du site">';
        echo '</a>';
        echo '<nav>';

        $current_page = basename($_SERVER['PHP_SELF']); // Obtenir le nom de la page actuelle

        $menu_items = [
            'ConfigurationServeur.php' => 'Lancement et arrêt de la partie',
            'GestionBots.php' => 'Gestion des bots',
            'GestionMaps.php' => 'Gestion des maps',
            'GestionModes.php' => 'Gestion des modes',
        ];

        foreach ($menu_items as $url => $label) {
            $active_class = ($current_page == $url) ? 'active' : '';
            echo '<a href="' . $url . '" class="accueil-link bouton-rouge-foncé ' . $active_class . '">' . $label . '</a>';
        }

        echo '<a href="DeconnexionF.php" class="accueil-link bouton-rouge-foncé">Déconnexion</a>';
        echo '</nav>';
        echo '</header>';
    // }
    ?>
</body>
</html>
