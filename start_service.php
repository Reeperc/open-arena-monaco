<?php
include 'configSsh.php';

// Construction de la commande sshpass
$command = "sshpass -p 'quake' ssh -o StrictHostKeyChecking=no quake@195.221.30.65 'openarena-server +set dedicated 2 +set net_port 27960 +set g_gametype 1 +map delta +set sv_hostname "Tournois Monaco"'";

// Exécution de la commande
$output = null;
$return_var = null;
exec($command, $output, $return_var);

// Vérification du résultat de la commande
if ($return_var === 0) {
    echo '<div style="color: green; font-weight: bold;">Le service a été démarré.</div>';
} else {
    echo '<div style="color: red; font-weight: bold;">Échec du démarrage du service.</div>';
}
?>
