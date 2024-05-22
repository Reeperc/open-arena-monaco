<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $map = escapeshellarg($_POST['selected-map']);
    $mode = escapeshellarg($_POST['selected-mode']);
    
    $command = "sshpass -p 'quake' ssh -o StrictHostKeyChecking=no quake@195.221.30.65 'screen -dmS openarena-server openarena-server +set dedicated 2 +set net_port 27961 +set g_gametype $mode +map $map +set sv_hostname \"Tournois Monaco\"'";
    
    $output = shell_exec($command);

    // Vous pouvez rediriger l'utilisateur vers une page de confirmation ou afficher un message
    echo "Le serveur a été démarré avec la map $map et le mode $mode.";
} else {
    // Redirige vers la page principale si l'accès n'est pas via POST
    echo "Le serveur n'a pas démarré avec la map $map et le mode $mode.";
    exit;
}
?>
