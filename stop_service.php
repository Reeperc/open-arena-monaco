<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'configSsh.php';

    // Construction de la commande sshpass pour arrêter le serveur OpenArena
    $command = "sshpass -p 'quake' ssh -o StrictHostKeyChecking=no quake@195.221.30.65 'screen -S openarena-server -X quit'";

    // Exécution de la commande avec shell_exec
    shell_exec($command);

    // Pause pour donner au serveur le temps de s'arrêter
    sleep(2);

    // Vérification de l'état du port 27961
    $portCommand = "nc -zv 195.221.30.65 27961 2>&1";
    $portOutput = shell_exec($portCommand);

    // Vérification du résultat de la commande de port
    if (strpos($portOutput, 'succeeded') !== false) {
        echo '<div style="color: red; font-weight: bold;">Échec de l\'arrêt du service.</div>';
    } else {
        echo '<div style="color: green; font-weight: bold;">La partie a été arrêté.</div>';
    }
} else {
    echo '<div style="color: red; font-weight: bold;">Requête invalide.</div>';
}
?>
