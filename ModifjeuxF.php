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

    // Traitement de la soumission du formulaire d'ajout/modification/suppression
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['ajouter_jeu'])) {
            $nom = $_POST['nom'];
            $imageData = file_get_contents($_FILES['image']['tmp_name']);
            $pdfData = file_get_contents($_FILES['pdf']['tmp_name']);

            $query = "INSERT INTO Jeu (Nom, Image, PDF) VALUES (?, ?, ?)";
            $stmt = $connexion->prepare($query);
            $stmt->execute([$nom, $imageData, $pdfData]);

            $_SESSION['successgame_message'] = "Le jeu a été ajouté avec succès !";
            header("Location: ModifjeuxF.php");
            exit();
        } elseif (isset($_POST['modifier_jeu'])) {
            // Code pour la modification du jeu ici
            $nom_modif = $_POST['nom_modif'];
            $imageData_modif = isset($_FILES['image_modif']) ? file_get_contents($_FILES['image_modif']['tmp_name']) : null;
            $pdfData_modif = isset($_FILES['pdf_modif']) ? file_get_contents($_FILES['pdf_modif']['tmp_name']) : null;
            $jeu_id = $_POST['jeu_a_modifier'];

            try {
                $query = "UPDATE Jeu SET Nom = ?, Image = ?, PDF = ? WHERE Id = ?";
                $stmt = $connexion->prepare($query);
                $stmt->execute([$nom_modif, $imageData_modif, $pdfData_modif, $jeu_id]);

                // Ajoutez un message de succès si nécessaire
                $_SESSION['successgame_message'] = "Le jeu a été modifié avec succès !";
                header("Location: ModifjeuxF.php");
                exit();
            } catch (PDOException $e) {
                die("Erreur lors de la modification du jeu : " . $e->getMessage());
            }
            
        } elseif (isset($_POST['supprimer_jeu'])) {
            // Code pour la modification du jeu ici
            $jeu_id = $_POST['jeu_a_modifier'];

           try {
               $query = "DELETE FROM Jeu WHERE Id = ?";
               $stmt = $connexion->prepare($query);
               $stmt->execute([$jeu_id]);

               // Ajoutez un message de succès si nécessaire
               $_SESSION['successgame_message'] = "Le jeu a été supprimé avec succès !";
               header("Location: ModifjeuxF.php");
               exit();
            } catch (PDOException $e) {
                die("Erreur lors de la suppression du jeu : " . $e->getMessage());
            }
        }
    }

    // Récupération de la liste des jeux existants
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
    <title>Modifier les Jeux</title>
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

    <h1>Gestion des Jeux</h1>

    <?php
    if (isset($_SESSION['successgame_message'])) {
        echo "<p style='color: green;'>".$_SESSION['successgame_message']."</p>";
        unset($_SESSION['successgame_message']);
    }
    ?>

    <!-- Formulaire d'ajout -->
    <h2>Ajouter un Nouveau Jeu</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="nom">Nom du Jeu :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="image">Image du Jeu :</label>
        <input type="file" id="image" name="image" accept="image/*" required>

        <label for="pdf">Règles en PDF :</label>
        <input type="file" id="pdf" name="pdf" accept=".pdf" required>

        <button type="submit" name="ajouter_jeu">Ajouter le Jeu</button>
    </form>

    <!-- Formulaire de modification/suppression -->
    <h2>Modifier/Supprimer Jeu</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="jeu_a_modifier">Sélectionner un Jeu :</label>
        <select id="jeu_a_modifier" name="jeu_a_modifier">
            <?php foreach ($jeux as $jeu): ?>
                <option value="<?php echo $jeu['Id']; ?>"><?php echo $jeu['Nom']; ?></option>
            <?php endforeach; ?>
        </select>


        <button type="submit" name="charger_donnees">Charger les Données</button>

        <?php
        // Code pour pré-remplir le formulaire avec les données du jeu sélectionné
        if (isset($_POST['charger_donnees'])) {
            $jeu_id = $_POST['jeu_a_modifier'];
            $query = "SELECT * FROM Jeu WHERE Id = ?";
            $stmt = $connexion->prepare($query);
            $stmt->execute([$jeu_id]);
            $jeu = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            
            <!-- Champs du formulaire pré-remplis -->
            <label for="nom_modif">Nom du Jeu :</label>
            <input type="text" id="nom_modif" name="nom_modif" value="<?php echo $jeu['Nom']; ?>" required>

            <label for="image_modif">Image du Jeu :</label>
            <input type="file" id="image_modif" name="image_modif" accept="image/*">

            <label for="pdf_modif">Règles en PDF :</label>
            <input type="file" id="pdf_modif" name="pdf_modif" accept=".pdf">

            <button type="submit" name="modifier_jeu">Modifier le Jeu</button>
            <button type="submit" name="supprimer_jeu">Supprimer le Jeu</button>

            <?php
        }
        ?>
    </form>
    <button id="return-button" onclick="window.location.href='AccueilAdminF.php'">Retour</button>
    <?php include('FooterF.php'); ?>
</body>
</html>
