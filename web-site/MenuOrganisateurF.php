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

        .actives {
            background-color: #4CAF50; /* couleur de l'élément actif */
        }

        .accueil-link {
            margin-left: auto;
        }
    </style>
</head>
<body>
    <?php
    echo '<header>';
    echo '<a href="AccueilOrganisateurF.php">';
    echo '<img src="images/akalogo.png" alt="Logo du site">';
    echo '</a>';

    $current_page = basename($_SERVER['PHP_SELF']); // Obtenir le nom de la page actuelle

    $menu_items = [
        'AccueilOrganisateurF.php' => 'Accueil',
        'Competition5.php' => 'Arbre de compétition',
        'ListMapAdmin2.php' => 'Liste des cartes',
        'StatutDesServeursBis.php' => 'Statut des serveurs',
        'sendMail-form.php' => 'Envoyer des mails',
        'ConfigurationServeur.php' => 'Lancement du tournois',
        'assigner_joueur.php' => 'Assigner un joueur à un raspberry',
    ];

    $allowed_pages = array_keys($menu_items); // Obtenir les clés du tableau des items de menu (les URLs)

    if (in_array($current_page, $allowed_pages)) {
        echo '<nav>';
        foreach ($menu_items as $url => $label) {
            $actives_class = ($current_page == $url) ? 'actives' : '';
            echo '<a href="' . $url . '" class="accueil-link bouton-rouge-foncé ' . $actives_class . '">' . $label . '</a>';
        }
        echo '<a href="DeconnexionF.php" class="accueil-link bouton-rouge-foncé">Déconnexion</a>';
        echo '</nav>';
    }
    
    echo '</header>';
    ?>
</body>
</html>
