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

    // Vérification
    $portOpen = isPortOpen($serverIP, $port);

    // Générer le message de statut
    $statusMessage = "<div style='text-align: center; margin: 20px; font-family: Arial, sans-serif;'>";
    $statusMessage .= "<h3>Statut du serveur:</h3>";

    if ($portOpen) {
        $statusMessage .= "<p style='color: green;'>Le port $port est ouvert. Une partie est en cours.</p>";
    } else {
        $statusMessage .= "<p style='color: red;'>Le port $port est fermé. Aucune partie en cours.</p>";
    }

    $statusMessage .= "</div>";

    echo $statusMessage;
}
?>
