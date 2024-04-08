<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant que membre
if (!isset($_SESSION['membre_username'])) {
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

    // Récupérer la liste des jeux depuis la base de données
    $query = "SELECT id, Nom, Image, PDF FROM Jeu";
    $resultats = $connexion->query($query);

    // Traitement de l'ajout en favoris
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajouter_en_favoris'])) {
    $id_jeu = $_POST['id_jeu'];

    // Récupérer l'id du membre à partir de la base de données
    $username = $_SESSION['membre_username'];
    $queryMembreId = "SELECT id FROM Membre WHERE username = ?";
    $stmtMembreId = $connexion->prepare($queryMembreId);
    $stmtMembreId->execute([$username]);
    $membreId = $stmtMembreId->fetchColumn();

    if ($membreId) {
        // Vérifier si le jeu n'est pas déjà en favoris
        $check_query = "SELECT * FROM favoris WHERE id_membre = ? AND id_jeu = ?";
        $check_stmt = $connexion->prepare($check_query);
        $check_stmt->execute([$membreId, $id_jeu]);

        if ($check_stmt->rowCount() == 0) {
            // Ajouter en favoris
            $insert_query = "INSERT INTO favoris (id_membre, id_jeu) VALUES (?, ?)";
            $insert_stmt = $connexion->prepare($insert_query);
            $insert_stmt->execute([$membreId, $id_jeu]);

            $_SESSION['successfavoris_message'] = "Le jeu a été ajouté en favoris avec succès !";
        } else {
            $_SESSION['errorfavoris_message'] = "Le jeu est déjà en favoris.";
        }
        } else {
            $_SESSION['errorfavoris_message'] = "Le jeu est déjà en favoris.";
        }
    }
} catch (PDOException $e) {
    die("La connexion à la base de données a échoué : " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Jeux</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #FF0000; /* Rouge */
            color: white;
            padding: 15px;
            text-align: center;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            position: relative;
        }

        header a {
            display: block;
        }

        header img {
            width: 100px;
            height: auto;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        header p {
            position: absolute;
            top: 80px; /* Ajustez la position verticale selon vos besoins */
            right: 10px; /* Place le texte tout à droite */
            margin: 0; /* Supprime les marges par défaut */
            background-color: white;
            color: red;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            padding-left: 120px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            overflow: hidden;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #FF4500; /* Orange-rouge */
        }

        .accueil-link {
            margin-left: auto;
        }

        .jeu-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }

        .jeu-image {
            max-width: 200px;
            max-height: 200px;
        }

        .btn-pdf {
            margin-top: 10px;
            display: block;
            background-color: #FF4500;
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            width: 150px;
            margin-left: auto;
            margin-right: auto;
        }

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
    <?php include('MenuMembreF.php'); ?>

    <h1>Liste des Jeux</h1>

    <?php
    if (isset($_SESSION['successfavoris_message'])) {
        echo "<p style='color: green;'>" . $_SESSION['successfavoris_message'] . "</p>";
        unset($_SESSION['successfavoris_message']);
    } elseif (isset($_SESSION['errorfavoris_message'])) {
        echo "<p style='color: red;'>" . $_SESSION['errorfavoris_message'] . "</p>";
        unset($_SESSION['errorfavoris_message']);
    }

    while ($jeu = $resultats->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="jeu-container">';
        echo '<h2>' . $jeu['Nom'] . '</h2>';
        echo '<img class="jeu-image" src="data:image/jpeg;base64,' . base64_encode($jeu['Image']) . '" alt="Image du jeu">';
        echo '<a class="btn-pdf" href="data:application/pdf;base64,' . base64_encode($jeu['PDF']) . '" download>Télécharger le PDF</a>';

        // Formulaire pour ajouter en favoris
        echo '<form method="post">';
        echo '<input type="hidden" name="id_jeu" value="' . $jeu['id'] . '">';
        echo '<button type="submit" name="ajouter_en_favoris">Ajouter en favoris</button>';
        echo '</form>';

        echo '</div>';
    }

    $connexion = null;
    ?>
<button id="return-button" onclick="window.location.href='AccueilMembreF.php'">Retour</button>
    <?php include('FooterF.php'); ?>
</body>
</html>
