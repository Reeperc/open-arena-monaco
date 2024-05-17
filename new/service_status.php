<?php
include 'configSsh.php';

// Connexion SSH
$connection = ssh2_connect($server, 22);
if (!$connection) {
    die('Impossible d\'établir la connexion SSH.');
}

// Authentification SSH
if (!ssh2_auth_password($connection, $username, $password)) {
    die('Échec de l\'authentification SSH.');
}

// Exécution de la commande à distance
$command = 'sudo systemctl status openarena-server';
$stream = ssh2_exec($connection, $command);
stream_set_blocking($stream, true);
$output = stream_get_contents($stream);
fclose($stream);

// Fermeture de la connexion SSH
ssh2_disconnect($connection);

// Affichagge du contenu brut du terminal pour voir si ça corresp bien
echo '<pre>' . nl2br(htmlentities($output)) . '</pre>';

// Traitement du résultat pour extraire le statut
if (strpos($output, 'active (running)') == true) {
    echo '<div style="color: green; font-weight: bold;">Le service OpenArena est actif.</div>';
} else {
    echo '<div style="color: red; font-weight: bold;">Le service OpenArena n\'est pas actif.</div>';
}
