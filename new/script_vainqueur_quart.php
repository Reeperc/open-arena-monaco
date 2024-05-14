<?php

function script_vainqueur_quart($match_id) {

    try {
        require('database.php');
        $query = "SELECT equipe_gagnante FROM matchs WHERE id='$match_id'";
        $stmt = $connexion->prepare($query);

        $stmt->execute([$match_id]);
        
        $equipe=$stmt->fetchColumn();

        echo $equipe;
        return $equipe;

    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion dans la DB'" . $e->getMessage();
    } finally {
        $connexion=null;
    }


}


?>