<?php

function script_recuperer_resultat2($equipe, $match_id) {

    try {
        require('database.php');
        $query = "SELECT score_equipe2 FROM matchs WHERE equipe2 = '$equipe' AND id='$match_id'";
        $stmt = $connexion->prepare($query);

        $stmt->execute([]);
        
        $score=$stmt->fetchColumn();

        echo $score;

    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion dans la DB'" . $e->getMessage();
    } finally {
        $connexion=null;
    }


}


?>