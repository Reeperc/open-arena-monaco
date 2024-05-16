<?php
session_start();
// Vérifier si l'utilisateur est connecté en tant que admin
if (!isset($_SESSION['organisateur_username'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ConnexionF.php");
    exit();
}

if (isset($_SESSION['welcome_message'])) {
    echo "<p style='color: green;'>" . $_SESSION['welcome_message'] . "</p>";
    unset($_SESSION['welcome_message']); // Supprimer la variable de session après l'affichage
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Jeux</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #FF0000;
            /* Rouge */
            color: white;
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
            width: 100px;
            height: auto;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        header p {
            position: absolute;
            top: 80px;
            /* Ajustez la position verticale selon vos besoins */
            right: 10px;
            /* Place le texte tout à droite */
            margin: 0;
            /* Supprime les marges par défaut */
            background-color: white;
            color: red;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
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
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #FF4500;
            /* Orange-rouge */
        }

        .accueil-link {
            margin-left: auto;
        }

        .jeu-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }

        .jeu-image {
            max-width: 200px;
            max-height: 200px;
        }

        .btn-pdf {
            margin-top: 10px;
            display: block;
            background-color: #FF4500;
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            width: 150px;
            margin-left: auto;
            margin-right: auto;
        }

        #return-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php include('MenuOrganisateurF.php'); ?>

    <h1>Liste des Cartes</h1>

    <h1>Vous etes connecte en tant qu'admin, cliquer sur une carte la chargera sur le serveur</h1>

    <h2>Match à mort (Deathmatch)</h2>

    <h2>Match à mort en équipe (Team Deathmatch)</h2>

    <ul>
        <li>czest1dm </li>
        <li>chaos2 </li>
        <li>mlca1 </li>
        <li>oa_dm1 </li>
    </ul>

    <h2>Capture du drapeau (CTF)</h2>

    <ul>
        <li>am_lavactf</li>
        <li>am_lavactfxl</li>
        <li>am_underworks2</li>
        <li>cbctf1</li>
        <li>ctf_compromise</li>
        <li>ctf_gate1</li>
        <li>ctf_inyard</li>
        <li>delta</li>
        <li>hydronext2</li>
        <li>oa_bases3</li>
        <li>oa_bases7</li>
        <li>oa_ctf2</li>
    </ul>

    <h2>Domination</h2>

    <ul>
        <li>aggressor</li>
        <li>am_lavaarena</li>
        <li>ctf_gate1</li>
        <li>ctf_inyard</li>
        <li>mlca1</li>
    </ul>

    <h2>One-Flag CTF</h2>

    <ul>
        <li>am_lavactf</li>
        <li>am_lavactfxl</li>
        <li>ctf_inyard</li>
        <li>delta</li>
        <form action="Chargerdelta.php" method="get">
            <input type="submit" value="charger">
        </form>
        <li>hydronext2</li>
    </ul>

    <h2>Harvester</h2>

    <ul>
        <li>am_lavactf</li>
        <li>am_lavactf2</li>
        <li>delta</li>
        <li>hydronext2</li>
        <li>oa_bases3</li>
        <li>oa_Thor</li>
    </ul>
    <h2>Rocket Arena</h2>

    <h2>Instagib</h2>

    <button id="return-button" onclick="window.location.href='AccueilAdminF.php'">Retour</button>
    <?php include('FooterF.php'); ?>
</body>

</html>