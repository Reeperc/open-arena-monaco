<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion des Bots</title>
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
            background-image: url('images/hannah-oates-brick-wall-wip.jpg'); /* Assurez-vous que le chemin est correct */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
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

        main {
            flex: 1;
            padding: 20px;
            text-align: center;
            color: #333;
        }

        .bot-form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .bot-form h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .bot-form label {
            display: block;
            margin-bottom: 10px;
            color: #666;
        }

        .bot-form input[type="text"],
        .bot-form input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .bot-form input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .bot-form input[type="submit"]:hover {
            background-color: #45a049;
        }

        .bot-list {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .bot-list h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .bot-list ul {
            list-style: none;
            padding: 0;
        }

        .bot-list li {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            color: #666;
        }

        .bot-list li:last-child {
            border-bottom: none;
        }
    </style>
</head>

<body>
    <?php
    // Header include
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
    ?>

    <main>
        <div class="bot-form">
            <h2>Ajouter un Bot</h2>
            <form action="ajouter_bot.php" method="post">
                <label for="bot-name">Nom du Bot:</label>
                <input type="text" id="bot-name" name="bot_name" required>

                <label for="bot-level">Niveau du Bot:</label>
                <input type="number" id="bot-level" name="bot_level" min="1" max="10" required>

                <input type="submit" value="Ajouter">
            </form>
        </div>

        <div class="bot-list">
            <h2>Liste des Bots</h2>
            <ul>
                <!-- Exemples de bots, remplacer par la récupération réelle de la base de données -->
                <li>Bot 1 - Niveau 5</li>
                <li>Bot 2 - Niveau 3</li>
                <li>Bot 3 - Niveau 7</li>
            </ul>
        </div>
    </main>
</body>

</html>
