<?php
session_start();

include('database.php');

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournois</title>
    <link rel="stylesheet" type="text/css" href="styles/style-aure.css">
    <link rel="stylesheet" type="text/css" href="styles/styles-aure.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <link rel="stylesheet" href="style.css">
    <?php include('MenuVisiteurF.php'); ?>
    <video autoplay loop muted playsinline id="background-video">
        <source src="videos/video6.mp4" type="video/mp4">
    </video>


    <div class="container justtxtcolor">
        <h1>Matchs de poules</h1>
        <?php
        // Récupération des données des matchs pour chaque poule
        $poules = ['A', 'B', 'C', 'D'];

        foreach ($poules as $poule) {
            echo "<div class='poule'>";
            echo "<h2>Poule $poule</h2>";

            $sql = "SELECT equipe1, equipe2, score_equipe1, score_equipe2 FROM matchs WHERE poule = '$poule'";
            $result = $connexion->query($sql);

            if ($result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='match'>";
                    echo "<span>{$row['equipe1']}</span>";
                    echo "<span>{$row['score_equipe1']} - {$row['score_equipe2']}</span>";
                    echo "<span>{$row['equipe2']}</span>";
                    echo "</div>";
                }
            } else {
                echo "Aucun match trouvé pour la poule $poule";
            }

            echo "</div>"; // Fin de la poule
        }
        ?>
    </div>
    <article id="container" class="justtxtcolor">
        <h1>Phases finales</h1>

        <section>
            <?php
            $equipes_top = array();
            $poules = array("A", "B", "C", "D");

            foreach ($poules as $poule) {
                // Récupérer les deux meilleures équipes pour cette poule
                $sql_top_teams = "SELECT equipe_gagnante, COUNT(*) AS nb_victoires FROM matchs WHERE equipe_gagnante IS NOT NULL AND poule = '$poule' GROUP BY equipe_gagnante ORDER BY nb_victoires DESC LIMIT 2";
                $stmt = $connexion->prepare($sql_top_teams);
                $stmt->execute();
                $top_teams = $stmt->fetchAll(PDO::FETCH_COLUMN);

                // Ajouter les équipes au tableau $equipes_top
                foreach ($top_teams as $top_team) {
                    $equipes_top[] = $top_team;
                }
            }

            // Ajouter de nouveaux matchs pour les quarts de finale, peu importe le nombre total de matchs déjà présents
            $quarts_de_finale = array(
                array($equipes_top[0], $equipes_top[3]),
                array($equipes_top[1], $equipes_top[2]),
                array($equipes_top[4], $equipes_top[7]),
                array($equipes_top[5], $equipes_top[6])
            );
            // Afficher les équipes gagnantes
            foreach ($quarts_de_finale as $match) {
                echo "<div>";
                echo "Équipe: " . $match[0] . "<br>";
                echo "</div>";
                echo "<div>";
                echo "Équipe: " . $match[1] . "<br>";
                echo "</div>";
            }
            ?>
        </section>

        <div class="connecter">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>

        <div class="line">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>

        <section id="quarterFinals">
            <?php
            // Sélectionner les équipes gagnantes
            $sql_equipes_gagnantes = "SELECT equipe_gagnante FROM matchs LIMIT 24, 1";
            $stmt = $connexion->prepare($sql_equipes_gagnantes);
            $stmt->execute();
            $equipes_gagnantes = $stmt->fetchAll(PDO::FETCH_COLUMN);
            // Afficher les équipes gagnantes
            foreach ($equipes_gagnantes as $equipe) {
                echo "<div>$equipe</div>";
            }
            ?>
            <?php
            // Sélectionner les équipes gagnantes
            $sql_equipes_gagnantes = "SELECT equipe_gagnante FROM matchs LIMIT 26, 1";
            $stmt = $connexion->prepare($sql_equipes_gagnantes);
            $stmt->execute();
            $equipes_gagnantes = $stmt->fetchAll(PDO::FETCH_COLUMN);
            // Afficher les équipes gagnantes
            foreach ($equipes_gagnantes as $equipe) {
                echo "<div>$equipe</div>";
            }
            ?>
            <?php
            // Sélectionner les équipes gagnantes
            $sql_equipes_gagnantes = "SELECT equipe_gagnante FROM matchs LIMIT 25, 1";
            $stmt = $connexion->prepare($sql_equipes_gagnantes);
            $stmt->execute();
            $equipes_gagnantes = $stmt->fetchAll(PDO::FETCH_COLUMN);
            // Afficher les équipes gagnantes
            foreach ($equipes_gagnantes as $equipe) {
                echo "<div>$equipe</div>";
            }
            ?>
            <?php
            // Sélectionner les équipes gagnantes
            $sql_equipes_gagnantes = "SELECT equipe_gagnante FROM matchs LIMIT 27, 1";
            $stmt = $connexion->prepare($sql_equipes_gagnantes);
            $stmt->execute();
            $equipes_gagnantes = $stmt->fetchAll(PDO::FETCH_COLUMN);
            // Afficher les équipes gagnantes
            foreach ($equipes_gagnantes as $equipe) {
                echo "<div>$equipe</div>";
            }
            ?>
        </section>

        <div class="connecter" id="conn2">
            <div></div>
            <div></div>
        </div>

        <div class="line" id="line2">
            <div></div>
            <div></div>
        </div>

        <section id="semiFinals">
            <?php
            // Sélectionner les équipes gagnantes
            $sql_equipes_gagnantes = "SELECT equipe_gagnante FROM matchs LIMIT 42, 2";
            $stmt = $connexion->prepare($sql_equipes_gagnantes);
            $stmt->execute();
            $equipes_gagnantes = $stmt->fetchAll(PDO::FETCH_COLUMN);
            // Afficher les équipes gagnantes
            foreach ($equipes_gagnantes as $equipe) {
                echo "<div>$equipe</div>";
            }
            ?>
        </section>

        <div class="connecter" id="conn3">
            <div></div>
        </div>

        <div class="line" id="line3">
            <div></div>
        </div>

        <section id="final">
            <?php
            // Sélectionner les équipes gagnantes
            $sql_equipes_gagnantes = "SELECT equipe_gagnante FROM matchs LIMIT 48, 1";
            $stmt = $connexion->prepare($sql_equipes_gagnantes);
            $stmt->execute();
            $equipes_gagnantes = $stmt->fetchAll(PDO::FETCH_COLUMN);
            // Afficher les équipes gagnantes
            foreach ($equipes_gagnantes as $equipe) {
                echo "<div>$equipe</div>";
            }
            ?>
        </section>

    </article>
</body>

</html>