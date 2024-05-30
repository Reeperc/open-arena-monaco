<?php
session_start();

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Extraire la partie avant le "@" de l'email
    $email_parts = explode('@', $email);
    $username = $email_parts[0];

    // Informations de connexion SSH
    $ssh_host = '195.221.30.4'; // Remplacez par l'adresse de votre serveur
    $ssh_port = 22; // Port par défaut pour SSH
    $ssh_user = 'votre_utilisateur_ssh'; // Remplacez par le nom d'utilisateur SSH
    $ssh_password = 'votre_mot_de_passe_ssh'; // Remplacez par le mot de passe SSH

    // Connexion SSH
    $connection = ssh2_connect($ssh_host, $ssh_port);
    if (ssh2_auth_password($connection, $ssh_user, $ssh_password)) {
        // Commande pour ajouter l'utilisateur
        $command = "sudo adduser --quiet --disabled-password --gecos '' $username";

        // Exécuter la commande sur le serveur distant
        $stream = ssh2_exec($connection, $command);
        stream_set_blocking($stream, true);
        $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
        $result = stream_get_contents($stream_out);
        fclose($stream);

        // Créer le répertoire utilisateur
        $home_dir_command = "sudo mkdir /home/$username";
        $stream_home = ssh2_exec($connection, $home_dir_command);
        stream_set_blocking($stream_home, true);
        $stream_home_out = ssh2_fetch_stream($stream_home, SSH2_STREAM_STDIO);
        $home_result = stream_get_contents($stream_home_out);
        fclose($stream_home);

        if ($result && $home_result) {
            $_SESSION['message'] = "Utilisateur $username créé avec succès et répertoire créé.";
        } else {
            $_SESSION['message'] = "Erreur lors de la création de l'utilisateur ou du répertoire.";
        }
    } else {
        $_SESSION['message'] = "Échec de la connexion SSH.";
    }

    header('Location: InscrivezJoueur.php');
    exit;
}
