<!DOCTYPE html>
<html>
<head>
    <title>Arbre de Tournois</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .tournament-tree img {
            max-width: 100%;
            max-height: 100%;
            display: block;
            margin: auto;
        }
    </style>
</head>
<body>
<?php include('MenuVisiteurF.php'); ?>
    <?php
        echo '<header class="tournament-tree">';
        echo '<img src="ArbreTournois.png" alt="Arbre du tournois">';
        echo '</header>';
    ?>
</body>
</html>
