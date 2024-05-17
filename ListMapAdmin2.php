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
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Cartes</title>
</head>

<body class="body2">
    <link rel="stylesheet" href="style.css">
    <?php include('MenuOrganisateurF.php'); ?>
    <video autoplay loop muted playsinline id="background-video">
        <source src="videos/video2.mp4" type="video/mp4">
    </video>

    <main class="main2">
        <h1>Liste des Cartes</h1>
        <div class="grid-container">
            <!-- Match à mort -->
            <section class="game-type">
                <h2>Match à mort (Deathmatch)</h2>
                <ul>
                    <li>czest1dm</li>
                    <li>chaos2</li>
                    <li>mlca1</li>
                    <li>oa_dm1</li>
                </ul>
            </section>

            <!-- Capture du drapeau -->
            <section class="game-type">
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
                </ul>
            </section>

            <!-- Domination -->
            <section class="game-type">
                <h2>Domination</h2>
                <ul>
                    <li>aggressor</li>
                    <li>am_lavaarena</li>
                    <li>ctf_gate1</li>
                    <li>ctf_inyard</li>
                    <li>mlca1</li>
                </ul>
            </section>

            <!-- One-Flag CTF -->
            <section class="game-type">
                <h2>One-Flag CTF</h2>
                <ul>
                    <li>am_lavactf</li>
                    <li>am_lavactfxl</li>
                    <li>ctf_inyard</li>
                    <li>delta</li>
                    <form action="Chargerdelta.php" method="get">
                        <input type="submit" value="charger">
                    </form>
                    <li>delta2</li>
                    <form action='' method="post">
                        <input type="submit" name="map" value="delta">
                    </form>
                    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $map = $_POST["map"];
                        charger_map($map);
                    }

                    ?>
                    <li>hydronext2</li>
                </ul>
            </section>

            <!-- Harvester -->
            <section class="game-type">
                <h2>Harvester</h2>
                <ul>
                    <li>am_lavactf</li>
                    <li>am_lavactf2</li>
                    <li>delta</li>
                    <li>hydronext2</li>
                    <li>oa_bases3</li>
                    <li>oa_Thor</li>
                </ul>
            </section>

            <!-- Rocket Arena -->
            <section class="game-type">
                <h2>Rocket Arena</h2>
                <ul>
                    <li>aggressor</li>
                    <li>am_lavaarena</li>
                    <li>mlca1</li>
                </ul>
            </section>

            <!-- Instagib -->
            <section class="game-type">
                <h2>Instagib</h2>
                <ul>
                    <li>aggressor</li>
                    <li>oa_dm1</li>
                </ul>
            </section>
        </div>
    </main>

    <!-- 
    <h1>Liste des Cartes</h1>

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
        <li>delta
            <form action="Chargerdelta.php" method="get">
                <input type="submit" value="charger">
            </form>
        </li>
        <li>delta <button type="button"> Charger </button>
        </li>
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

    <h2>Instagib</h2> -->

    <!-- <button class="form-button-retour" id="return-button" onclick="window.location.href='AccueilVisiteurF.php'">Retour</button> -->
    <!-- <?php include('FooterF.php'); ?> -->
</body>

</html>