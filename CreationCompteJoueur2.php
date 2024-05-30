<?php
session_start(); // Démarrer la session

// Inclure l'autoloader de Composer
require 'vendor/autoload.php';

use phpseclib3\Net\SSH2;

// Afficher le message de la variable de session
if (isset($_SESSION['message'])) {
    echo "<p>{$_SESSION['message']}</p>";
    // Supprimer le message de la session pour ne pas l'afficher à nouveau
    unset($_SESSION['message']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Récupérer la partie avant @ de l'email
    $username = explode('@', $email)[0];

    // Concaténer le nom complet pour l'argument Nom
    $nom_complet = $prenom . ' ' . $nom;

    // Informations de connexion SSH
    $server_ip = '195.221.30.4';
    $ssh_username = 'rt';
    $ssh_password = 'rt';

    // Initialiser la connexion SSH
    $ssh = new SSH2($server_ip);
    if (!$ssh->login($ssh_username, $ssh_password)) {
        exit('Login Failed');
    }

    // Commandes à exécuter
    $commands = [
        "echo '$ssh_password' | sudo -S adduser $username --force-badname",
        "echo -e '$mot_de_passe\n$mot_de_passe\n$nom_complet\n1\n1\n1\n1\nO' | sudo adduser $username --force-badname"
    ];

    // Exécuter les commandes
    foreach ($commands as $command) {
        $ssh->exec($command);
    }

    // Rediriger avec un message de succès
    $_SESSION['message'] = "L'utilisateur $username a été créé avec succès.";
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Site web</title>
    <link rel="stylesheet" href="styles/style-antoine.css">
    <link rel="stylesheet" href="styles/style-antoine-compte.css">
</head>

<body>
    <?php include('MenuAdminF.php'); ?>
    <main>
        <h1>Inscrivez le joueur</h1>
        <form action="" method="post">
            <div id="contact">
                <p id="content"> Prenom <input type="text" name="prenom" placeholder="Jean" required> </p>
                <p id="content"> Nom <input type="text" name="nom" placeholder="DUPONT" required></p>
                <p id="content"> Email <input type="email" name="email" placeholder="Ex : joueur@arena-monaco.fr" required></p>
                <p id="content"> Nouveau Mot de passe : <input type="password" name="mot_de_passe" required> </p>
                <button type="submit"> Enregistrer les données </button>
                <button type="button" onclick="window.location.href='AccueilAdminF.php'"> Retour </button>
            </div>
        </form>
    </main>
    <button id="return-button" onclick="window.location.href='AccueilAdminF.php'">Retour</button>
    <button type="button" onclick="window.location.href='voir_joueur.php'"> Afficher les joueurs </button>
    <button type="button" onclick="window.location.href='supprimerJoueur.php'"> Supprimer un joueur </button>
</body>

</html>