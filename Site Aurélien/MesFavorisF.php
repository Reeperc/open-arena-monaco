<?php
session_start();

$serveur = "localhost";
$utilisateur = "grp_6_10";
$motDePasse = "oPkO06vqDtnh";
$baseDeDonnees = "bdd_6_10";

try {
    $connexion = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees", $utilisateur, $motDePasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Échec de la connexion à la base de données : " . $e->getMessage());
}

// Assurez-vous que $_SESSION['membre_username'] est défini
if (isset($_SESSION['joueur_username'])) {
    // Utilisez une requête SQL pour obtenir l'ID du membre à partir de son username
    $stmt = $connexion->prepare("SELECT id FROM Membre WHERE username = :username");
    $stmt->bindParam(':username', $_SESSION['membre_username']);
    $stmt->execute();
    
    // Récupérez l'ID du membre
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $membre_id = $result['id'];

    // Utilisez $membre_id dans vos requêtes pour obtenir les jeux favoris du membre
    $stmt = $connexion->prepare("SELECT Jeu.Nom
                                 FROM favoris
                                 JOIN Jeu ON favoris.id_jeu = Jeu.id
                                 WHERE favoris.id_membre = :id_membre");
    $stmt->bindParam(':id_membre', $membre_id);
    $stmt->execute();
} else {
    // Redirigez l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: ConnexionF.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeux Favoris</title>
    <style>
        #return-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php include('MenuJoueurF.php'); ?>

<h1>Les modes de jeux dans OpenArena</h1>
    <h2>combat à mort</h2>
        <p>combat à mort : blablablbalbalba</p>
    <h2>combat par équipe</h2>
        <p>blablablablbalblablablablbalbla</p>
    <h2>capture du drapeau</h2>
        <p>blab lalbalbalb albla bl abla lablabl</p>
    <h2>tournoi</h2>   
        <p>blabl blablablablbalbalblab labl bl ablbalbala</p>

<?php
// Vérifiez s'il y a des jeux favoris pour afficher
//if ($stmt->rowCount() > 0) {
    // Affichez les noms des jeux favoris dans une liste
//    echo '<ul>';
//    
//    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//        echo '<li>' . $row['Nom'] . '</li>';
//    }
//    
//    echo '</ul>';
//} else {
//    echo 'Aucun jeu favori trouvé pour ce membre.';
//}
?>
<button id="return-button" onclick="window.location.href='AccueilMembreF.php'">Retour</button>
<?php include('FooterF.php'); ?>

</body>
</html>
