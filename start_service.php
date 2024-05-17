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

// Exécution de la commande à distance pour démarrer le service
$command = 'sudo systemctl start openarena-server';
$stream = ssh2_exec($connection, $command);
stream_set_blocking($stream, true);
$output = stream_get_contents($stream);
fclose($stream);

// Fermeture de la connexion SSH
ssh2_disconnect($connection);

// Affichage du résultat
echo '<div style="color: green; font-weight: bold;">Le service a été démarré.</div>';
