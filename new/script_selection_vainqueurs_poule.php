<?php

function script_selecion_vainqueur_poule($poule) {

    try {
        require('database.php');
        $query = "SELECT equipe_gagnante, COUNT(*) AS victoires FROM matchs WHERE equipe_gagnante IS NOT NULL AND poule = '$poule' GROUP BY equipe_gagnante ORDER BY victoires DESC LIMIT 2";
        $stmt = $connexion->prepare($query);

        $stmt->execute([$poule]);
        
        $equipe1=$stmt->fetchColumn();
        $equipe2=$stmt->fetchColumn(1);

        echo $equipe1;
        return $equipe1;

    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion dans la DB'" . $e->getMessage();
    } finally {
        $connexion=null;
    }


}


?>