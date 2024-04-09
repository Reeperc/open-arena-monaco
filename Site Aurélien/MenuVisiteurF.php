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
            background-color: #003462; /* Bleu */
            color: #BA9E12; /* Doré tirant vers le marron clair */
        }

        header {
            background-color: #BA9E12; /* Doré */
            color: #003462; /* Bleu */
            padding: 15px;
            text-align: center;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            position: relative;
        }

        header img {
            width: 100px; /* Ajustez la taille du logo selon vos besoins */
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
            padding-left: 120px; /* Ajout d'un espace pour le logo avant les liens */
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            overflow: hidden;
        }

        nav a {
            color: #054C8A;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #2C6CC2; /* Orange-rouge */
        }

        .accueil-link {
            margin-left: auto;
        }
    </style>
</head>
<body>
    <header>
        <a href="index.php">
            <img src="logo site.png" alt="Logo du site">
        </a>
        <nav>
            <a href="CréationCompteF.php" class="accueil-link">Inscription</a>
            <a href="connexionF.php" class="accueil-link">Connexion</a>
        </nav>
    </header>
</body>
</html>
