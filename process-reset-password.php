<?php
// Inclure le fichier de connexion à la base de données
require('database.php');

// Récupération des données du formulaire
$token = $_POST["token"] ?? null;
$password = $_POST["password"] ?? null;
$password_confirmation = $_POST["password_confirmation"] ?? null;

// Validation des mots de passe
if ($password !== $password_confirmation) {
    die("Les mots de passe ne correspondent pas");
}

// Génération du hash du mot de passe
$password_hash = password_hash($password, PASSWORD_DEFAULT);

try {
    // Mettre à jour le mot de passe dans la base de données
    $sql_update = "UPDATE Joueur SET password = :password_hash, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE reset_token_hash = :token_hash";
    $stmt_update = $connexion->prepare($sql_update);
    $stmt_update->bindParam(':password_hash', $password_hash);
    $stmt_update->bindParam(':token_hash', $token);
    
    if ($stmt_update->execute()) {
        echo "Mot de passe réinitialisé avec succès.";
        // Redirection vers une page de succès ou affichage d'un message approprié
    } else {
        die("Erreur lors de la réinitialisation du mot de passe.");
    }

} catch (PDOException $e) {
    die("Erreur lors de la mise à jour du mot de passe : " . $e->getMessage());
}
?>
