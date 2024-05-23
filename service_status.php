<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serverIP = $_POST['server_ip'];
    $port = $_POST['port'];
    $website = $_POST['website'];

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
        $pingresult = shell_exec("ping -c 1 " . escapeshellarg($serverIP));
        if (strpos($pingresult, '1 received')) {
            return true;
        } else {
            return false;
        }
    }

    // Fonction pour vérifier si le site web répond au ping
    function isWebsiteUp($website) {
        $pingresult = shell_exec("ping -c 1 " . escapeshellarg(parse_url($website, PHP_URL_HOST)));
        if (strpos($pingresult, '1 received')) {
            return true;
        } else {
            return false;
        }
    }

    // Vérifications
    $serverUp = isServerUp($serverIP);
    $portOpen = isPortOpen($serverIP, $port);
    $websiteUp = isWebsiteUp($website);

    // Générer le message de statut
    $statusMessage = "<div style='text-align: center; margin: 20px; font-family: Arial, sans-serif;'>";
    $statusMessage .= "<h3>Statut du serveur:</h3>";

    if ($serverUp) {
        $statusMessage .= "<p style='color: green;'>Le serveur de jeu est UP.</p>";
        if ($portOpen) {
            $statusMessage .= "<p style='color: green;'>Le port $port est ouvert. Une partie est en cours.</p>";
        } else {
            $statusMessage .= "<p style='color: red;'>Le port $port est fermé. Aucune partie en cours.</p>";
        }

        if ($websiteUp) {
            $statusMessage .= "<p style='color: green;'>Le site web est UP. <a href=\"$website\" target=\"_blank\">Visitez le site web</a>.</p>";
        } else {
            $statusMessage .= "<p style='color: red;'>Le site web est DOWN.</p>";
        }
    } else {
        $statusMessage .= "<p style='color: red;'>Le serveur de jeu est DOWN.</p>";
    }

    $statusMessage .= "</div>";

    echo $statusMessage;
}
?>
