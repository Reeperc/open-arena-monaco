<?php
session_start();

// Stocker le message de déconnexion dans une variable temporaire
$logoutMessage = "Vous avez été déconnecté avec succès.";

// Détruire toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion avec le message en paramètre
header("Location: index.php?logout_message=" . urlencode($logoutMessage));
exit();
?>
