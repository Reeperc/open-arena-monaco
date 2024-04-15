<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant que admin
if (!isset($_SESSION['admin_username'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ConnexionF.php");
    exit();
}

$serveur = "localhost";
$utilisateur = "grp_6_10";
$motDePasse = "oPkO06vqDtnh";
$baseDeDonnees = "bdd_6_10";

try {
    $connexion = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees", $utilisateur, $motDePasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Échec de la connexion : " . $e->getMessage();
}

// Fonction pour récupérer les équipes et les matchs depuis la base de données
function getMatches() {
    global $conn;
    $sql = "SELECT * FROM matches";
    $result = $conn->query($sql);
    $matches = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $matches[] = $row;
        }
    }
    return $matches;
}

// Fonction pour mettre à jour les scores des matchs
function updateScore($match_id, $team1_score, $team2_score) {
    global $conn;
    $sql = "UPDATE matches SET team1_score=$team1_score, team2_score=$team2_score WHERE id=$match_id";
    if ($conn->query($sql) === TRUE) {
        echo "Scores mis à jour avec succès";
    } else {
        echo "Erreur lors de la mise à jour des scores: " . $conn->error;
    }
}

// Traitement des actions de l'administrateur
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['match_id']) && isset($_POST['team1_score']) && isset($_POST['team2_score'])) {
        updateScore($_POST['match_id'], $_POST['team1_score'], $_POST['team2_score']);
    }
}

// Récupérer les matchs
$matches = getMatches();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arbre des matchs</title>
    <!-- Styles CSS pour l'arbre des matchs -->
    <style>
        /* Ajoutez vos styles CSS ici */
    </style>
</head>
<body>
    <h1>Arbre des matchs</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <?php foreach($matches as $match): ?>
        <div>
            <p><?php echo $match['team1']; ?> vs <?php echo $match['team2']; ?></p>
            <input type="hidden" name="match_id" value="<?php echo $match['id']; ?>">
            Score <?php echo $match['team1']; ?>: <input type="number" name="team1_score" value="<?php echo $match['team1_score']; ?>">
            Score <?php echo $match['team2']; ?>: <input type="number" name="team2_score" value="<?php echo $match['team2_score']; ?>">
            <input type="submit" value="Valider les scores">
        </div>
    <?php endforeach; ?>
    </form>
</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>
