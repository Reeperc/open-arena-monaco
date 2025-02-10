<?php

function script_second_demi2($annee) {

    try {
        require('database.php');
        $query = "SELECT equipe_gagnante, COUNT(*) AS victoires FROM matchs WHERE equipe_gagnante IS NOT NULL AND poule = 'F' AND annee = :annee GROUP BY equipe_gagnante ORDER BY victoires DESC LIMIT 1, 1";
        $stmt = $connexion->prepare($query);

        $stmt->bindParam(':annee', $annee);

        $stmt->execute();
        
        $equipe1=$stmt->fetchColumn();

        echo $equipe1;
        return $equipe1;

    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion dans la DB'" . $e->getMessage();
    } finally {
        $connexion=null;
    }


}


?>