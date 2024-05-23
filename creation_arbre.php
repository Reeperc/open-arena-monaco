<?php

    function creation_arbre($annee) {

        try {

            require('database.php');

            // Vérifier si les équipes initiales sont déjà ajoutées
            $sql_count_teams = "SELECT COUNT(*) AS total FROM matchs WHERE annee = :annee";
            $stmt = $connexion->prepare($sql_count_teams);

            $stmt->bindParam(':annee', $annee);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            //echo $result['total'];

            $poules = array("A", "B", "C", "D");

            if ($result['total'] < 16) { // Il y a 16 équipes au total pour 4 poules de 4 équipes chacune
                // Ajouter les équipes à la table "matchs" pour chaque poule
                foreach ($poules as $poule) {
                    $equipes = array("1", "2", "3", "4"); // Changez ici les noms des équipes si nécessaire
                    $nombre_equipes = count($equipes);
                    for ($i = 0; $i < $nombre_equipes - 1; $i++) {
                        for ($j = $i + 1; $j < $nombre_equipes; $j++) {
                            $equipe1 = ($poule) . "_" . $equipes[$i]; // Ajout du suffixe numérique
                            $equipe2 = ($poule) . "_" . $equipes[$j]; // Ajout du suffixe numérique
                            // Vérifier si le match n'existe pas déjà
                            $sql_check_match = "SELECT COUNT(*) AS match_exist FROM matchs WHERE (equipe1 = :equipe1 AND equipe2 = :equipe2 AND poule = :poule AND annee = :annee) OR (equipe1 = :equipe2 AND equipe2 = :equipe1 AND poule = :poule AND annee = :annee)";
                            $stmt = $connexion->prepare($sql_check_match);

                            $stmt->bindParam(':equipe1', $equipe1);
                            $stmt->bindParam(':equipe2', $equipe2);
                            $stmt->bindParam(':poule', $poule);
                            $stmt->bindParam(':annee', $annee);

                            $stmt->execute();
                            $match_exist = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($match_exist['match_exist'] == 0) {
                                // Le match n'existe pas, on peut l'ajouter
                                $sql_insert_team = "INSERT INTO matchs (equipe1, equipe2, poule, annee) VALUES ('$equipe1', '$equipe2', '$poule', '$annee')";
                                $connexion->exec($sql_insert_team);
                            }
                        }
                    }
                }
                for ($i=0; $i<4;$i++) {
                    $poule = "E" . $i;
                    $sql_insert_match_quart = "INSERT INTO matchs (poule, annee) VALUES ('$poule', '$annee)";
                    $connexion->exec($sql_insert_match_quart);
                }
                
            }
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion dans la DB'" . $e->getMessage();
        } finally {
            $connexion = null;
        }

    
    }
    

    ?>