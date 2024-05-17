<?php
function isMachineConnected($ip)
{
    // Exécute la commande ping pour vérifier la connectivité
    $output = [];
    $result = 0;

    // Pinger l'adresse IP une seule fois (-c 1) avec un délai d'attente de 1 seconde (-W 1)
    exec("ping -c 1 -W 1 $ip", $output, $result);

    // Le résultat 0 signifie que la machine a répondu au ping
    if ($result === 0) {
        return true;
    } else {
        return false;
    }
}

// Exemple d'utilisation
$ipAddress = '195.221.20.27'; // Remplace cette IP par celle que tu veux tester
if (isMachineConnected($ipAddress)) {
    echo "La serveur est actif.";
} else {
    echo "Le serveur n'est pas actif.";
}
