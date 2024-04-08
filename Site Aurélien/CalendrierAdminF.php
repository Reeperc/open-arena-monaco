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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'creer_partie') {
    // Récupérer les données du formulaire
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $jeu = $_POST['jeu'];

    // Insérer les données dans la base de données
    $sql = "INSERT INTO session (date, heure, jeu) VALUES (:date, :heure, :jeu)";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':heure', $heure);
    $stmt->bindParam(':jeu', $jeu);

    if ($stmt->execute()) {
        echo '<p>Partie créée avec succès!</p>';
    } else {
        echo '<p>Erreur lors de la création de la partie.</p>';
    }
}

// Récupérer les jeux depuis la base de données
try {
    $query = "SELECT Id, Nom FROM Jeu";
    $stmt = $connexion->query($query);
    $jeux = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de Parties</title>
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

    <?php include('MenuAdminF.php'); ?>
    
    <h1>Création de Parties</h1>
    <form action="" method="post">
        <label for="date">Date de la partie :</label>
        <input type="date" id="date" name="date" required>

        <label for="heure">Heure de la partie :</label>
        <input type="time" id="heure" name="heure" required>

        <label for="jeu">Nom du jeu :</label>
        <select id="jeu" name="jeu" required>
            <?php foreach ($jeux as $jeu): ?>
                <option value="<?php echo $jeu['Nom']; ?>"><?php echo $jeu['Nom']; ?></option>
            <?php endforeach; ?>
        </select>

        <input type="hidden" name="action" value="creer_partie">
        <input type="submit" value="Créer la partie">
    </form>
    <button id="return-button" onclick="window.location.href='AccueilAdminF.php'">Retour</button>
    <?php include('FooterF.php'); ?>
</body>
</html>
