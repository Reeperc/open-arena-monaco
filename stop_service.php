<?php
include 'configSsh.php';

// Construction de la commande sshpass pour arrêter le serveur OpenArena
$command = "sshpass -p 'quake' ssh -o StrictHostKeyChecking=no quake@195.221.30.65 'screen -S openarena-server -X quit'";

// Exécution de la commande avec shell_exec
$output = shell_exec($command);

// Vérification du résultat de la commande
if ($output !== null) {
    echo '<div style="color: green; font-weight: bold;">Le service a été arrêté.</div>';
} else {
    echo '<div style="color: red; font-weight: bold;">Échec de l\'arrêt du service.</div>';
}
?>
