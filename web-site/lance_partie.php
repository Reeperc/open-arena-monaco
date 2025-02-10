<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Exécutez la commande pour arrêter le warmup et démarrer la partie
    $command = "sshpass -p 'quake' ssh -o StrictHostKeyChecking=no quake@195.221.30.65 'screen -S openarena-server -X stuff \"g_doWarmup \\\"0\\\"; wait; map_restart^M\"'";
    $output = shell_exec($command);

    // Vous pouvez rediriger l'utilisateur vers une page de confirmation ou afficher un message
    echo "Partie lancée";
    
} else {
    // Redirige vers la page principale si l'accès n'est pas via POST
    echo "Echec";
    exit;
}
?>
