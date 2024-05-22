<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $botName = $_POST['bot_name'];
    $botLevel = $_POST['bot_level'];

    // Construction de la commande sshpass pour ajouter le bot dans le screen
    $command = "sshpass -p 'quake' ssh -o StrictHostKeyChecking=no quake@195.221.30.65 'screen -S openarena-server -X stuff \"addbot \\\"$botName\\\" \\\"$botLevel\\\"^M\"'";


    // Exécution de la commande avec shell_exec
    $output = shell_exec($command);

    // Vérification du résultat de la commande
    if ($output !== null) {
        echo '<div style="color: green; font-weight: bold;">Bot ajouté avec succès.</div>';
    } else {
        echo '<div style="color: red; font-weight: bold;">Échec de l\'ajout du bot.</div>';
    }
} else {
    echo '<div style="color: red; font-weight: bold;">Requête invalide.</div>';
}
?>
