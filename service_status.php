<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serverIP = $_POST['server_ip'];
    $port = $_POST['port'];
    $website = $_POST['website'];

    // Fonction pour vérifier l'état du port avec fsockopen
    function isPortOpen($serverIP, $port) {
        $connection = @fsockopen($serverIP, $port, $errno, $errstr, 2);
        if ($connection) {
            fclose($connection);
            return true;
        } else {
            error_log("Erreur fsockopen: $errstr ($errno)");
            return false;
        }
    }

    // Fonction pour vérifier si le serveur répond au ping
    function isServerUp($serverIP) {
        $pingresult = shell_exec("ping -c 1 " . escapeshellarg($serverIP));
        error_log("Ping result: $pingresult");
        if (strpos($pingresult, '1 received') !== false) {
            return true;
        } else {
            return false;
        }
    }

    // Fonction pour vérifier si le site web répond au ping
    function isWebsiteUp($website) {
        $hostname = parse_url($website, PHP_URL_HOST);
        if ($hostname === null) {
            error_log("Invalid URL: $website");
            return false;
        }
        $pingresult = shell_exec("ping -c 1 " . escapeshellarg($hostname));
        error_log("Website ping result: $pingresult");
        if (strpos($pingresult, '1 received') !== false) {
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
        } else if ($port != 27961) {
            // Seulement afficher ce message si le port n'est pas 27961
            $statusMessage .= "<p style='color: red;'>Le port $port est fermé. Aucune partie en cours.</p>";
        }

        if ($websiteUp) {
            // Seulement afficher ce message si l'URL n'est pas celle à exclure
            if ($website !== "http://195.221.30.16") {
                $statusMessage .= "<p style='color: green;'>Le site web est UP. <a href=\"$website\" target=\"_blank\">Visitez le site web</a>.</p>";
            }
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
