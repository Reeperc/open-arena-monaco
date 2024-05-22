<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $command = "sshpass -p 'quake' ssh -o StrictHostKeyChecking=no quake@195.221.30.65 'screen -dmS openarena-server openarena-server +g_warmup)=0";
    
    $output = shell_exec($command);

    // Vous pouvez rediriger l'utilisateur vers une page de confirmation ou afficher un message
    echo "Partie lancée";
    
} else {
    // Redirige vers la page principale si l'accès n'est pas via POST
    echo "Echec";
    exit;
}
?>
