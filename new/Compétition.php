<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant qu'admin
if (!isset($_SESSION['admin_username'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ConnexionF.php");
    exit();
}

/*
$serveur = "localhost";
$utilisateur = "grp_6_10";
$motDePasse = "oPkO06vqDtnh";
$baseDeDonnees = "bdd_6_10";
*/

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Site web</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    main {
      margin: 20px;
    }

    h1 {
      text-align: center;
    }

    #contact {
      display: flex;
      flex-direction: column;
      max-width: 400px;
      margin: auto;
    }

    p {
      margin-top: 10px;
    }

    input, button {
      margin-top: 5px;
    }

    button {
      background-color: #008CBA;
      color: #fff;
      padding: 10px;
      cursor: pointer;
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
<?php include('MenuAdminF.php'); ?>

<?php
try {

    /*
    $connexion = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees", $utilisateur, $motDePasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    */

    require('database.php');

    // Vérifier si les équipes initiales sont déjà ajoutées
    $sql_count_teams = "SELECT COUNT(*) AS total FROM matchs";
    $stmt = $connexion->prepare($sql_count_teams);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $poules = array("A", "B", "C", "D");

    if ($result['total'] < 16) { // Il y a 16 équipes au total pour 4 poules de 4 équipes chacune
        // Ajouter les équipes à la table "matchs" pour chaque poule
        foreach ($poules as $poule) {
            $equipes = array("Equipe 1", "Equipe 2", "Equipe 3", "Equipe 4"); // Changez ici les noms des équipes si nécessaire
            $nombre_equipes = count($equipes);
            for ($i = 0; $i < $nombre_equipes - 1; $i++) {
                for ($j = $i + 1; $j < $nombre_equipes; $j++) {
                    $equipe1 = $equipes[$i] . "_" . ($poule); // Ajout du suffixe numérique
                    $equipe2 = $equipes[$j] . "_" . ($poule); // Ajout du suffixe numérique
                    // Vérifier si le match n'existe pas déjà
                    $sql_check_match = "SELECT COUNT(*) AS match_exist FROM matchs WHERE (equipe1 = '$equipe1' AND equipe2 = '$equipe2' AND poule = '$poule') OR (equipe1 = '$equipe2' AND equipe2 = '$equipe1' AND poule = '$poule')";
                    $stmt = $connexion->prepare($sql_check_match);
                    $stmt->execute();
                    $match_exist = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($match_exist['match_exist'] == 0) {
                        // Le match n'existe pas, on peut l'ajouter
                        $sql_insert_team = "INSERT INTO matchs (equipe1, equipe2, poule) VALUES ('$equipe1', '$equipe2', '$poule')";
                        $connexion->exec($sql_insert_team);
                    }
                }
            }
        }
    }

    // Initialisation du tableau en dehors de la boucle
    $equipes_top = array();

    // Traitement des scores pour chaque poule
    foreach ($poules as $poule) {
        // Vérifier si le formulaire de saisie des scores a été soumis pour cette poule
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST[$poule . "_submit"])) {
            // Traitement de la soumission du formulaire de saisie des scores pour cette poule
            $match_ids = $_POST[$poule . "_match_ids"];
            $score_equipes1 = $_POST[$poule . "_score_equipes1"];
            $score_equipes2 = $_POST[$poule . "_score_equipes2"];

            // Boucle sur les matchs pour mettre à jour les scores
            foreach ($match_ids as $key => $match_id) {
                $score_equipe1 = $score_equipes1[$key];
                $score_equipe2 = $score_equipes2[$key];
                // Déterminer l'équipe gagnante en fonction des scores
                if ($score_equipe1 > $score_equipe2) {
                    $equipe_gagnante = $_POST[$poule . "_equipes1"][$key];
                } elseif ($score_equipe1 < $score_equipe2) {
                    $equipe_gagnante = $_POST[$poule . "_equipes2"][$key];
                } else {
                    // En cas d'égalité, vous pouvez gérer cela selon vos besoins
                    $equipe_gagnante = "Egalité";
                }
                // Mettre à jour la progression dans le tournoi pour ce match
                $sql_update = "UPDATE matchs SET score_equipe1 = :score_equipe1, score_equipe2 = :score_equipe2, equipe_gagnante = :equipe_gagnante WHERE id = :match_id";
                $stmt = $connexion->prepare($sql_update);
                $stmt->bindParam(':score_equipe1', $score_equipe1);
                $stmt->bindParam(':score_equipe2', $score_equipe2);
                $stmt->bindParam(':equipe_gagnante', $equipe_gagnante);
                $stmt->bindParam(':match_id', $match_id);
                $stmt->execute();
            }
        }

        // Afficher les deux meilleures équipes de chaque poule
        $sql_best_teams = "SELECT equipe_gagnante, COUNT(*) AS victoires FROM matchs WHERE equipe_gagnante IS NOT NULL AND poule = '$poule' GROUP BY equipe_gagnante ORDER BY victoires DESC LIMIT 2";
        $stmt = $connexion->prepare($sql_best_teams);
        $stmt->execute();
        $best_teams = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<h3>Les deux meilleures équipes de la poule $poule sont :</h3>";
        foreach ($best_teams as $team) {
            echo $team['equipe_gagnante'] . " avec " . $team['victoires'] . " victoires<br>";
        }

        // Récupérer les deux meilleures équipes pour les configurations spécifiques
        $sql_top_teams = "SELECT equipe_gagnante FROM matchs WHERE equipe_gagnante IS NOT NULL AND poule = '$poule' GROUP BY equipe_gagnante ORDER BY COUNT(*) DESC LIMIT 2";
        $stmt = $connexion->prepare($sql_top_teams);
        $stmt->execute();
        $top_teams = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Condition spécifique pour chaque configuration
        if ($result['total'] == 6 || $result['total'] == 12 || $result['total'] == 18 || $result['total'] == 24) {
            // Ajouter les équipes au tableau
            foreach ($top_teams as $top_team) {
                $equipes_top[] = $top_team;
            }
        }
    }


    // Afficher l'arbre des matchs pour chaque poule
    foreach ($poules as $poule) {
        $sql = "SELECT * FROM matchs WHERE equipe_gagnante IS NULL AND poule = '$poule'";
        $resultat = $connexion->query($sql);

        if ($resultat->rowCount() > 0) {
            // Afficher les matchs sous forme d'arbre pour cette poule
            echo "<h3>Poule $poule</h3>";
            while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
                echo "Match " . $row["id"] . ": " . $row["equipe1"] . " vs " . $row["equipe2"] . "<br>";
                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='" . $poule . "_match_ids[]' value='" . $row["id"] . "'>";
                echo "<input type='hidden' name='" . $poule . "_equipes1[]' value='" . $row["equipe1"] . "'>";
                echo "<input type='hidden' name='" . $poule . "_equipes2[]' value='" . $row["equipe2"] . "'>";
                echo "Score de " . $row["equipe1"] . ": <input type='number' name='" . $poule . "_score_equipes1[]'><br>";
                echo "Score de " . $row["equipe2"] . ": <input type='number' name='" . $poule . "_score_equipes2[]'><br>";
                echo "<a href='ListmapsAdmin.php'> <p style='color:DodgerBlue;'>Choisir la carte</p></a>";
                echo "<input type='submit' name='" . $poule . "_submit' value='Valider le score'>";
                echo "</form>";
                echo "<br>";
            }
        } else {
            echo "Aucun match trouvé pour la poule $poule<br>";
        }
    }
    
    $sql_count_distinct = "SELECT COUNT(equipe_gagnante) AS count_distinct FROM matchs WHERE equipe_gagnante IS NOT NULL";
    $stmt = $connexion->prepare($sql_count_distinct);
    $stmt->execute();
    $result_count_distinct = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result_count_distinct['count_distinct'] == 24) {
        // Vérifier si les équipes initiales sont déjà ajoutées
        $sql_count_teams = "SELECT COUNT(*) AS total FROM matchs";
        $stmt = $connexion->prepare($sql_count_teams);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Ajouter de nouveaux matchs pour les quarts de finale, peu importe le nombre total de matchs déjà présents
        $quarts_de_finale = array(
            array($equipes_top[0], $equipes_top[3]),
            array($equipes_top[1], $equipes_top[2]),
            array($equipes_top[4], $equipes_top[7]),
            array($equipes_top[5], $equipes_top[6])
        );

        foreach ($quarts_de_finale as $key => $match) {
            $equipe1 = $match[0];
            $equipe2 = $match[1];
            $poule_equipe1 = substr($equipe1, -1);
            $poule_equipe2 = substr($equipe2, -1);

            //on peut l'ajouter
            $sql_insert_quart = "INSERT INTO matchs (equipe1, equipe2, poule) VALUES (:equipe1, :equipe2, :poule)";
            $stmt = $connexion->prepare($sql_insert_quart);
            $stmt->bindParam(':equipe1', $equipe1);
            $stmt->bindParam(':equipe2', $equipe2);
            $stmt->bindParam(':poule', $poule_equipe1); // Assigner une poule arbitrairement, puisqu'il s'agit des quarts de finale
            $stmt->execute();
        }

        
        // Afficher les nouveaux matchs de quarts de finale
        echo "<h3>Nouveaux matchs de quarts de finale :</h3>";
        foreach ($quarts_de_finale as $key => $match) {
            $equipe1 = $match[0];
            $equipe2 = $match[1];
            echo "Match " . ($key + 1) . ": $equipe1 vs $equipe2<br>";
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='new_match_ids[]' value='" . ($key + 1) . "'>";
            echo "<input type='hidden' name='new_match_equipes1[]' value='$equipe1'>";
            echo "<input type='hidden' name='new_match_equipes2[]' value='$equipe2'>";
            echo "Score de $equipe1 : <input type='number' name='new_match_score_equipes1[]'><br>";
            echo "Score de $equipe2 : <input type='number' name='new_match_score_equipes2[]'><br>";
            echo "<input type='submit' name='new_match_submit[]' value='Valider le score'>";
            echo "</form>";
            echo "<br>";
        }

        // Gestion de l'enregistrement des scores pour les nouveaux matchs
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Vérifier si des données ont été soumises pour les nouveaux matchs
            if (isset($_POST['new_match_ids']) && isset($_POST['new_match_equipes1']) && isset($_POST['new_match_equipes2']) && isset($_POST['new_match_score_equipes1']) && isset($_POST['new_match_score_equipes2'])) {
                // Traitement de la soumission du formulaire de saisie des scores pour les nouveaux matchs
                $new_match_ids = $_POST['new_match_ids'];
                $new_match_score_equipes1 = $_POST['new_match_score_equipes1'];
                $new_match_score_equipes2 = $_POST['new_match_score_equipes2'];

                // Récupérer les équipes pour les nouveaux matchs depuis le formulaire
                $new_equipes1 = $_POST['new_match_equipes1'];
                $new_equipes2 = $_POST['new_match_equipes2'];

                // Enregistrer les scores pour les nouveaux matchs
                foreach ($new_match_ids as $key => $new_match_id) {
                    $new_score_equipe1 = $new_match_score_equipes1[$key];
                    $new_score_equipe2 = $new_match_score_equipes2[$key];
                    // Déterminer l'équipe gagnante en fonction des scores
                    if ($new_score_equipe1 > $new_score_equipe2) {
                        $new_equipe_gagnante = $new_equipes1[$key];
                    } elseif ($new_score_equipe1 < $new_score_equipe2) {
                        $new_equipe_gagnante = $new_equipes2[$key];
                    } else {
                        // En cas d'égalité, vous pouvez gérer cela selon vos besoins
                        $new_equipe_gagnante = "Egalité";
                    }
                    // Extraire la poule de l'équipe gagnante
                    $poule_equipe_gagnante = substr($new_equipe_gagnante, -1);
                    // Mettre à jour la colonne "poule" dans la base de données
                    $sql_update_poule = "UPDATE matchs SET poule = :poule WHERE id = :match_id";
                    $stmt = $connexion->prepare($sql_update_poule);
                    $stmt->bindParam(':poule', $poule_equipe_gagnante);
                    $stmt->bindParam(':match_id', $new_match_id);
                    $stmt->execute();

                    // Mettre à jour les scores et l'équipe gagnante dans la base de données pour le nouveau match
                    $sql_update_new_match = "UPDATE matchs SET score_equipe1 = :score_equipe1, score_equipe2 = :score_equipe2, equipe_gagnante = :equipe_gagnante WHERE id = :match_id";
                    $stmt = $connexion->prepare($sql_update_new_match);
                    $stmt->bindParam(':score_equipe1', $new_score_equipe1);
                    $stmt->bindParam(':score_equipe2', $new_score_equipe2);
                    $stmt->bindParam(':equipe_gagnante', $new_equipe_gagnante);
                    $stmt->bindParam(':match_id', $new_match_id);
                    $stmt->execute();
                }
            }
        }
    }

    try {
        if ($result_count_distinct['count_distinct'] == 28) {
            // Requête SQL pour récupérer les noms des équipes gagnantes pour les lignes 25 à 28 (ce qui reprèsente les gagnants des quarts de final)
            $sql_equipes_gagnantes = "SELECT equipe_gagnante FROM matchs LIMIT 24, 4";
            $stmt = $connexion->prepare($sql_equipes_gagnantes);
            $stmt->execute();
            $equipes_gagnantes = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
            // Afficher les noms des équipes gagnantes dans un tableau
            echo "<h3>Équipes gagnantes des matchs 25 à 28 :</h3>";
            echo "<table border='1'>";
            echo "<tr><th>Équipe gagnante qualifiées en demie-finale</th></tr>";
            foreach ($equipes_gagnantes as $equipe) {
                echo "<tr><td>$equipe</td></tr>";
            }
            echo "</table>";
        }
    } catch (PDOException $e) {
        echo "Erreur PDO : " . $e->getMessage();
    }


    if ($result_count_distinct['count_distinct'] == 28) {
        // Vérifier si les équipes initiales sont déjà ajoutées
        $sql_count_teams = "SELECT COUNT(*) AS total FROM matchs";
        $stmt = $connexion->prepare($sql_count_teams);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Créer des paires d'équipes pour les matchs de demi-finales
        $demies_finales = array(
            array($equipes_gagnantes[0], $equipes_gagnantes[2]), // Première paire de demi-finales
            array($equipes_gagnantes[1], $equipes_gagnantes[3])  // Deuxième paire de demi-finales
        );

        foreach ($demies_finales as $key => $matchD) {
            $equipe1D = $matchD[0];
            $equipe2D = $matchD[1];
            // Vous pouvez définir la poule comme nécessaire
            $poule_equipe1D = substr($equipe1D, -1);
            $poule_equipe2D = substr($equipe2D, -1);

            //on peut l'ajouter
            $sql_insert_demie = "INSERT INTO matchs (equipe1, equipe2, poule) VALUES (:equipe1, :equipe2, :poule)";
            $stmt = $connexion->prepare($sql_insert_demie);
            $stmt->bindParam(':equipe1', $equipe1D);
            $stmt->bindParam(':equipe2', $equipe2D);
            $stmt->bindParam(':poule', $poule_equipe1D); // Assigner une poule arbitrairement, puisqu'il s'agit des quarts de finale
            $stmt->execute();
        }

        
        // Afficher les nouveaux matchs de demie finale
        echo "<h3>Nouveaux matchs de demie de finale :</h3>";
        foreach ($demies_finales as $key => $matchD) {
            $equipe1D = $matchD[0]; // Utiliser $matchD au lieu de $match
            $equipe2D = $matchD[1]; // Utiliser $matchD au lieu de $match
            echo "Match " . ($key + 1) . ": $equipe1D vs $equipe2D<br>";
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='demie_match_ids[]' value='" . ($key + 1) . "'>";
            echo "<input type='hidden' name='demie_match_equipes1[]' value='$equipe1D'>"; // Utiliser $equipe1D au lieu de $equipe1
            echo "<input type='hidden' name='demie_match_equipes2[]' value='$equipe2D'>"; // Utiliser $equipe2D au lieu de $equipe2
            echo "Score de $equipe1D : <input type='number' name='demie_match_score_equipes1[]'><br>";
            echo "Score de $equipe2D : <input type='number' name='demie_match_score_equipes2[]'><br>";
            echo "<input type='submit' name='demie_match_submit[]' value='Valider le score'>";
            echo "</form>";
            echo "<br>";
        }


        // Gestion de l'enregistrement des scores pour les matchs de demi-finale
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Vérifier si des données ont été soumises pour les matchs de demi-finale
            if (isset($_POST['demie_match_ids']) && isset($_POST['demie_match_score_equipes1']) && isset($_POST['demie_match_score_equipes2'])) {
                // Traitement de la soumission du formulaire de saisie des scores pour les matchs de demi-finale
                $demie_match_ids = $_POST['demie_match_ids'];
                $demie_match_score_equipes1 = $_POST['demie_match_score_equipes1'];
                $demie_match_score_equipes2 = $_POST['demie_match_score_equipes2'];

                // Enregistrer les scores pour les matchs de demi-finale
                foreach ($demie_match_ids as $key => $demie_match_id) {
                    $demie_score_equipe1 = $demie_match_score_equipes1[$key];
                    $demie_score_equipe2 = $demie_match_score_equipes2[$key];
                    // Mettre à jour les scores dans la base de données pour les matchs de demi-finale
                    $sql_update_demie_match = "UPDATE matchs SET score_equipe1 = :score_equipe1, score_equipe2 = :score_equipe2 WHERE id = :match_id";
                    $stmt = $connexion->prepare($sql_update_demie_match);
                    $stmt->bindParam(':score_equipe1', $demie_score_equipe1);
                    $stmt->bindParam(':score_equipe2', $demie_score_equipe2);
                    $stmt->bindParam(':match_id', $demie_match_id);
                    $stmt->execute();
                }
            }
        }
    }
    
    $connexion = null; // Fermeture de la connexion à la base de données
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>





<?php include('FooterF.php'); ?>
</body>
</html>