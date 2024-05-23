<?php

function script_vainqueur_quart2($poule, $annee)
{

    try {
        require('database.php');
        $query = "SELECT equipe_gagnante FROM matchs WHERE poule = :poule AND annee = :annee";
        $stmt = $connexion->prepare($query);

        $stmt->bindParam(':poule', $poule);
        $stmt->bindParam(':annee', $annee);

        $stmt->execute();

        $equipe = $stmt->fetchColumn();

        echo $equipe;
        return $equipe;
    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion dans la DB'" . $e->getMessage();
    } finally {
        $connexion = null;
    }
}