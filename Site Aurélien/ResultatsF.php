<?php
session_start();

if (isset($_SESSION['success_message'])) {
    echo "<p style='color: green;'>" . $_SESSION['success_message'] . "</p>";
    unset($_SESSION['success_message']); // Supprimer la variable de session après l'affichage
}

$serveur = "localhost";
$utilisateur = "grp_6_10";
$motDePasse = "oPkO06vqDtnh";
$baseDeDonnees = "bdd_6_10";

try {
    $connexion = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees", $utilisateur, $motDePasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Charger les sessions depuis la base de données
    $querySessions = "SELECT id, date, heure, jeu FROM session";
    $stmtSessions = $connexion->query($querySessions);
    $sessions = $stmtSessions->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
        if ($_POST['action'] === 'bookSession') {
            if (isset($_POST['session_id'])) {
                $session_id = $_POST['session_id'];
                $username = $_SESSION['visiteur_username'];

                // Récupérer l'ID du membre à partir du username
                $queryUserId = "SELECT id FROM Membre WHERE username = ?";
                $stmtUserId = $connexion->prepare($queryUserId);
                $stmtUserId->execute([$username]);
                $user = $stmtUserId->fetch();

                if ($user) {
                    $id_membre = $user['id'];

                    // Vérifier si le membre est déjà inscrit à cette session
                    $check_query = "SELECT * FROM inscriptions WHERE id_membre = ? AND id_session = ?";
                    $check_stmt = $connexion->prepare($check_query);
                    $check_stmt->execute([$id_membre, $session_id]);

                    if ($check_stmt->rowCount() == 0) {
                        // Ajouter l'inscription
                        $insert_query = "INSERT INTO inscriptions (id_membre, id_session) VALUES (?, ?)";
                        $insert_stmt = $connexion->prepare($insert_query);
                        $insert_stmt->execute([$id_membre, $session_id]);

                        echo '<p>Inscription réussie!</p>';
                    } else {
                        echo '<p>Vous êtes déjà inscrit à cette session.</p>';
                    }
                } else {
                    // Gérer le cas où l'utilisateur n'existe pas (peut-être une erreur?)
                    echo "Erreur : Impossible de trouver l'utilisateur.";
                    exit();
                }
            }
        }
    }
} catch (PDOException $e) {
    die("La connexion à la base de données a échoué : " . $e->getMessage());
}

$connexion = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats des matchs</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
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
<?php include('MenuVisiteurF.php'); ?>
<!-- Affichage du tableau des sessions -->
<h1>Résultats des matchs</h1>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Heure</th>
            <th>Jeu</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($sessions as $session): ?>
            <tr>
                <td><?= $session['date'] ?></td>
                <td><?= $session['heure'] ?></td>
                <td><?= $session['jeu'] ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="action" value="bookSession">
                        <input type="hidden" name="session_id" value="<?= $session['id'] ?>">
                        <button type="submit">S'inscrire</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Ajouter le bouton de retour ici -->
<button id="return-button" onclick="window.location.href='AccueilVisiteurF.php'">Retour</button>
<?php include('FooterF.php'); ?>
</body>
</html>
