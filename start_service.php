<?php
include 'configSsh.php';

// Construction de la commande sshpass
$command = "sshpass -p '$password' ssh -o StrictHostKeyChecking=no $username@$server 'openarena-server +set dedicated 2 +set net_port 27961 +set g_gametype 1 +map delta +set sv_hostname \"Tournois Monaco\"'";

// Exécution de la commande avec shell_exec
$output = shell_exec($command);

// Vérification du résultat de la commande
if ($output !== null) {
    echo '<div style="color: green; font-weight: bold;">Le service a été démarré.</div>';
} else {
    echo '<div style="color: red; font-weight: bold;">Échec du démarrage du service.</div>';
}
?>
