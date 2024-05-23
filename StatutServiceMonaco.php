<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serverIP = '195.221.30.65'; // IP du serveur de jeu
    $port = 27961; // Port à vérifier

    // Fonction pour vérifier l'état du port avec netcat
    function isPortOpen($serverIP, $port) {
        $connection = @fsockopen($serverIP, $port, $errno, $errstr, 2);
        if ($connection) {
            fclose($connection);
            return true;
        } else {
            return false;
        }
    }

    // Fonction pour vérifier si le serveur répond au ping
    function isServerUp($serverIP) {
        $pingresult = shell_exec("ping -c 1 " . $serverIP);
        if (strpos($pingresult, '1 received')) {
            return true;
        } else {
            return false;
        }
    }


    // Vérifications
    $serverUp = isServerUp($serverIP);
    $portOpen = isPortOpen($serverIP, $port);

    // Générer le message de statut
    $statusMessage = "Statut du serveur:<br>";

    if ($serverUp) {
        $statusMessage .= "Le serveur de jeu est UP.<br>";
        if ($portOpen) {
            $statusMessage .= "Le port $port est ouvert. Une partie est en cours.<br>";
        } else {
            $statusMessage .= "Le port $port est fermé. Aucune partie en cours.<br>";
        }
    } else {
        $statusMessage .= "Le serveur de jeu est DOWN.<br>";
    }

    echo $statusMessage;
}
?>
