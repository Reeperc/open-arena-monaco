<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $botName = $_POST['bot_name'];

    // Construction de la commande sshpass pour supprimer le bot dans le screen
    $command = "sshpass -p 'quake' ssh -o StrictHostKeyChecking=no quake@195.221.30.65 'screen -S openarena-server -X stuff \"kick \\\"$botName\\\"^M\"'";

    // Exécution de la commande avec shell_exec
    $output = shell_exec($command);

    // Vérification du résultat de la commande
    echo '<div style="color: red; font-weight: bold;">Bot supprimé avec succès.</div>';
}
?>
