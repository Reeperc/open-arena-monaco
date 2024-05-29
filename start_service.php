<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les informations de la première Raspberry
    $user1 = escapeshellarg($_POST['listeNoms1']);
    $pass1 = escapeshellarg($_POST['pass1']);

    // Récupérer les informations de la deuxième Raspberry
    $user2 = escapeshellarg($_POST['listeNoms2']);
    $pass2 = escapeshellarg($_POST['pass2']);

    // Commande SSH pour la première Raspberry
    $command1 = "sshpass -p $pass1 ssh -o StrictHostKeyChecking=no $user1@195.221.30.2 << INNER_EOF &
export DISPLAY=:0
openarena +set cl_renderer opengl1 +set r_mode -1 +set r_customwidth 1280 +set r_customheight 720 +r_fullscreen 1 +connect 195.221.30.65:27961
INNER_EOF";

    // Commande SSH pour la deuxième Raspberry
    $command2 = "sshpass -p $pass2 ssh -o StrictHostKeyChecking=no $user2@195.221.30.1 << INNER_EOF &
export DISPLAY=:0
openarena +set cl_renderer opengl1 +set r_mode -1 +set r_customwidth 1280 +set r_customheight 720 +r_fullscreen 1 +connect 195.221.30.65:27961
INNER_EOF";

    // Exécuter les commandes SSH
    $output1 = shell_exec($command1);
    $output2 = shell_exec($command2);

    // Afficher un message de confirmation
    echo "Le jeu a été lancé sur les Raspberry Pi de $user1 et $user2.";
    +++
} else {
    // Rediriger vers la page principale si l'accès n'est pas via POST
    echo "La partie n'a pas démarré.";
    exit;
}
?>
