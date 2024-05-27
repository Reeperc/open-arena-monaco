<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serverIP = $_POST['server_ip'];
    $website = $_POST['website'];

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
    $websiteUp = isWebsiteUp($website);

    // Générer le message de statut
    $statusMessage = "<div style='text-align: center; margin: 20px; font-family: Arial, sans-serif;'>";
    $statusMessage .= "<h3>Statut du serveur:</h3>";

    if ($serverUp) {
        $statusMessage .= "<p style='color: green;'>Le serveur de jeu est UP.</p>";
    } else {
        $statusMessage .= "<p style='color: red;'>Le serveur de jeu est DOWN.</p>";
    }

    if ($websiteUp) {
        $statusMessage .= "<p style='color: green;'>Le site web est UP</p>";
    } else {
        $statusMessage .= "<p style='color: red;'>Le site web est DOWN.</p>";
    }

    $statusMessage .= "</div>";

    echo $statusMessage;
}
?>
