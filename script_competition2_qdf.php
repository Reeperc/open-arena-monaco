<?php

function script_competition2_qdf($score1, $score2, $equipe1, $equipe2, $poule, $annee)
{
    //fonction pour update les matchs de quart, demi et finale
    try {
        require('database.php');

        if ($score1 > $score2) {
            $gagnant = $equipe1;
        } else {
            $gagnant = $equipe2;
        }

        $query = "UPDATE matchs SET equipe1= :equipe1, equipe2= :equipe2, score_equipe1 = :score1, score_equipe2 = :score2, equipe_gagnante= :gagnant, poule= :poule WHERE annee= :annee AND poule = :poule";
        $stmt = $connexion->prepare($query);

        $stmt->bindParam(':equipe1', $equipe1);
        $stmt->bindParam(':equipe2', $equipe2);
        $stmt->bindParam(':score1', $score1);
        $stmt->bindParam(':score2', $score2);
        $stmt->bindParam(':gagnant', $gagnant);
        $stmt->bindParam(':poule', $poule);
        $stmt->bindParam(':annee', $annee);

        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion dans la DB'" . $e->getMessage();
    } finally {
        $connexion = null;
    }
}
