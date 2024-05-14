<?php

function script_recuperer_resultat1($equipe, $match_id) {

    try {
        require('database.php');
        $query = "SELECT score_equipe1 FROM matchs WHERE equipe1 = '$equipe' AND id='$match_id'";
        $stmt = $connexion->prepare($query);

        $stmt->execute([]);
        
        $score=$stmt->fetchColumn();

        echo  $score ;

    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion dans la DB'" . $e->getMessage();
    } finally {
        $connexion=null;
    }


}


?>