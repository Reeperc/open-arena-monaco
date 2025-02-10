<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $map = escapeshellarg($_POST['selected-map']);
    $mode = escapeshellarg($_POST['selected-mode']);
    $warmup = escapeshellarg($_POST['selected-warmup']);

    $command = "sshpass -p 'quake' ssh -o StrictHostKeyChecking=no quake@195.221.30.65 'screen -dmS openarena-server openarena-server +set dedicated 2 +set net_port 27961 +set g_gametype $mode +map $map +g_dowarmup 1 +g_warmup $warmup +set sv_hostname \"Tournois Monaco\"'";

    $output = shell_exec($command);
     // Vous pouvez rediriger l'utilisateur vers une page de confirmation ou afficher un message
    echo "La partie a été démarré avec la map $map et le mode $mode avec un warmup de $warmup seconde(s).";
    } else {
    // Redirige vers la page principale si l'accès n'est pas via POST
    echo "La partie n'a pas démarré avec la map $map et le mode $mode avec un warmup de $warmup seconde(s).";
        exit;
}
?>
