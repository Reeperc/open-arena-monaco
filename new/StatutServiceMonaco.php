<?php
//Mettre ici les Infos du serveur jeu de chaque ville
//Monaco:
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

// Affichage du résultat
echo "Résultat de la commande '$command' sur le serveur distant : <br>";
echo nl2br($output); // Affiche le résultat avec des sauts de ligne

// Fermeture de la connexion SSH
ssh2_disconnect($connection);
