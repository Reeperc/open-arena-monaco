<?php
        // Connexion SSH
        //$command='oxidized';
        $connexion = ssh2_connect('195.221.30.48', 22);
        if ($connexion) {
            // Authentification SSH
            if (ssh2_auth_password($connexion, 'oxidized', 'azertyuiop')) {
                $resultat = ssh2_exec($connexion, 'oxidized');
                if ($resultat) {
                    stream_set_blocking($resultat, true);
                    $out = ssh2_fetch_stream($resultat, SSH2_STREAM_STDIO);
                    echo stream_get_contents($out);
                    echo "configuration enregistrer";
                } else {
                    echo "Une erreur s'est produite lors de l'envoi du fichier.";
                }
            } else {
                echo "Échec de l'authentification SSH.";
            }
          //  header("Location: AccueilAdminF.php");
        } else {
            echo "Échec de la connexion SSH.";
        }
        header("Location: AccueilAdminF.php"); 
?>