<?php 
function creer_nouvelle_table($id) {

        try {

            require('database.php');

                $matchid= "match" . $id ;

                $query= "INSERT INTO MatchID ('match') VALUES :matchid ;";
                $stmt=$connexion->prepare($query);

                $stmt->bindParam(':matchid', $matchid);

                $stmt->execute();
        }   catch (PDOException $e) {
                echo "Erreur lors de l'insertion dans la DB'" . $e->getMessage();
        }   finally {
                $connexion = null;
        }
    

}