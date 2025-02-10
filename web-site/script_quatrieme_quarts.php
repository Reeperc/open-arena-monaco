<?php

function script_quatrieme_quarts() {

    try {
        require('database.php');
        $query = "SELECT equipe_gagnante, COUNT(*) AS victoires FROM matchs WHERE equipe_gagnante IS NOT NULL AND poule = 'E' GROUP BY equipe_gagnante ORDER BY victoires DESC LIMIT 3, 3";
        $stmt = $connexion->prepare($query);

        $stmt->execute([]);
        
        $equipe1=$stmt->fetchColumn();

        echo $equipe1;

    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion dans la DB'" . $e->getMessage();
    } finally {
        $connexion=null;
    }


}


?>