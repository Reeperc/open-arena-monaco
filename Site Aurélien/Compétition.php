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
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        .match {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 10px auto;
            background-color: #fff;
            width: 50%;
            max-width: 600px;
        }
        .match p {
            margin: 5px 0;
        }
        .match input[type="number"] {
            width: 50px;
        }
        .match input[type="submit"] {
            margin-top: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        .match input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Arbre des matchs</h1>
    <div class="match">
        <p>Équipe A vs Équipe B</p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="match_id" value="1">
            Score Équipe A: <input type="number" name="team1_score" value="0">
            Score Équipe B: <input type="number" name="team2_score" value="0">
            <input type="submit" value="Valider les scores">
        </form>
    </div>
    <!-- Ajoutez d'autres matchs similaires ici -->
</body>
</html>


<?php
// Fermer la connexion à la base de données
$conn->close();
?>
