<?php
        // Connexion SSH
        $connexion = ssh2_connect('195.221.30.48', 22);
        if ($connexion) {
            // Authentification SSH
            if (ssh2_auth_password($connexion, 'oxidized', 'azertyuiop')) {
                // Transfert du fichier via SCP
                $resultat = ssh2_exec($connexion, 'oxidized');
                if ($resultat) {
                    echo "Fichier envoyé avec succès !";
                } else {
                    echo "Une erreur s'est produite lors de l'envoi du fichier.";
                }
            } else {
                echo "Échec de l'authentification SSH.";
            }
        } else {
            echo "Échec de la connexion SSH.";
        }
?>