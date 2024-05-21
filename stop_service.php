<?php
include 'configSsh.php';

// Construction de la commande sshpass
$command = "sshpass -p 'quake' ssh -o StrictHostKeyChecking=no quake@195.221.30.65 'quit'";

// Exécution de la commande avec shell_exec
$output = shell_exec($command);

// Vérification du résultat de la commande
if ($output !== null) {
    echo '<div style="color: green; font-weight: bold;">Le service a été démarré.</div>';
} else {
    echo '<div style="color: red; font-weight: bold;">Échec du démarrage du service.</div>';
}
?>
