<?php
session_start();

include('database.php');

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modes de jeu</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>

<body>
    <link rel="stylesheet" href="style.css">
    <?php include('MenuVisiteurF.php'); ?>
    <video autoplay loop muted playsinline id="background-video">
        <source src="videos/video3.mp4" type="video/mp4">
    </video>

    <h4>Modes de jeu</h4>
    <div class="cards-container">
        <div class="card">
            <h2>Match à mort (Deathmatch)</h2>
            <p>Les joueurs s'affrontent pour obtenir le plus de frags possible. Le premier joueur à atteindre un nombre de frags prédéterminé remporte la partie.</p>
        </div>
        <div class="card">
            <h2>Match à mort en équipe (Team Deathmatch)</h2>
            <p>Deux équipes s'affrontent pour obtenir le plus de frags possible. La première équipe à atteindre un nombre de frags prédéterminé remporte la partie.</p>
        </div>
        <div class="card">
            <h2>Capture du drapeau (CTF)</h2>
            <p>Deux équipes s'affrontent pour capturer le drapeau de l'autre équipe et le ramener à leur base. La première équipe à capturer le drapeau un certain nombre de fois remporte la partie.</p>
        </div>
        <div class="card">
            <h2>Domination</h2>
            <p>Les joueurs s'affrontent pour contrôler des points stratégiques sur la carte. L'équipe qui contrôle le plus de points à la fin du temps imparti remporte la partie.</p>
        </div>
        <div class="card">
            <h2>One-Flag CTF</h2>
            <p>Variante de Capture the Flag où il n'y a qu'un seul drapeau à capturer. La première équipe à capturer le drapeau et le ramener à sa base remporte la partie.</p>
        </div>
        <div class="card">
            <h2>Harvester</h2>
            <p>Les joueurs s'affrontent pour collecter des âmes en tuant des ennemis et en ramassant des âmes qui apparaissent sur la carte. La première équipe à atteindre un nombre d'âmes prédéterminé remporte la partie.</p>
        </div>
        <div class="card">
            <h2>Rocket Arena</h2>
            <p>Les joueurs s'affrontent uniquement avec des lance-roquettes. Le premier joueur à atteindre un nombre de frags prédéterminé remporte la partie.</p>
        </div>
        <div class="card">
            <h2>Instagib</h2>
            <p>Un mode de jeu où toutes les armes tuent en un seul coup. Le premier joueur à atteindre un nombre de frags prédéterminé remporte la partie.</p>
        </div>
    </div>

    <!-- <button id="return-button" onclick="window.location.href='AccueilVisiteurF.php'">Retour</button> -->
    <?php include('FooterF.php'); ?>

</body>

</html>