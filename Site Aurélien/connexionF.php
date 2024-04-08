<?php
session_start();

if (isset($_SESSION['success_message'])) {
    echo "<p style='color: green;'>".$_SESSION['success_message']."</p>";
    unset($_SESSION['success_message']); // Supprimer la variable de session après l'affichage
}


//Ecole :
$serveur = "localhost";
$utilisateur = "grp_6_10";
$motDePasse = "oPkO06vqDtnh";
$baseDeDonnees = "bdd_6_10";

//Maison :
//$serveur = "localhost";
//$utilisateur = "root";
//$motDePasse = "root";
//$baseDeDonnees = "mabdd";

try {
    // Créer une connexion PDO
    $connexion = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees", $utilisateur, $motDePasse);

    // Définir le mode d'erreur sur PDO
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si des données ont été soumises via le formulaire
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les données du formulaire de manière sécurisée
        $username = $_POST['username'];
        $password = $_POST['password'];

        try {
            // Vérifier d'abord dans la table "Membre"
            $queryMembre = "SELECT * FROM Membre WHERE username = ?";
            $stmtMembre = $connexion->prepare($queryMembre);
            $stmtMembre->execute([$username]);
            $membre = $stmtMembre->fetch();

            // Si les identifiants sont dans la table "Membre" et le mot de passe est correct
            if ($membre && password_verify($password, $membre['password'])) {
                // Définir la variable de session pour le membre
                $_SESSION['membre_username'] = $username;
                $_SESSION['welcome_message'] = "Bienvenue, $username ! Connexion réussie.";
                // Redirection vers la page AccueilMembreF.php
                header("Location: AccueilMembreF.php");
                exit();
            } else {
                // Si les identifiants ne sont pas dans la table "Membre", vérifier dans la table "Admin"
                $queryAdmin = "SELECT * FROM Admin WHERE username = ?";
                $stmtAdmin = $connexion->prepare($queryAdmin);
                $stmtAdmin->execute([$username]);
                $admin = $stmtAdmin->fetch();

                // Si les identifiants sont dans la table "Admin" et le mot de passe est correct
                if ($admin && password_verify($password, $admin['password'])) {
                    // Définir la variable de session pour l'admin
                    $_SESSION['admin_username'] = $username;
                    $_SESSION['welcome_message2'] = "Bienvenue, $username ! Connexion réussie.";
                    // Redirection vers la page AccueilAdminF.php
                    header("Location: AccueilAdminF.php");
                    exit();
                } else {
                    // Afficher un message d'erreur si les informations de connexion sont incorrectes
                    echo "Identifiant ou mot de passe incorrect.";
                }
            }
        } catch (PDOException $e) {
            // En cas d'erreur, affichez l'erreur
            die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
        } finally {
            // Fermer les statements
            $stmtMembre = null;
            $stmtAdmin = null;
        }
    }

} catch (PDOException $e) {
    die("La connexion à la base de données a échoué : " . $e->getMessage());
}

// Fermer la connexion à la base de données à la fin du script (si nécessaire)
$connexion = null;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Site web</title>
    <style>
      /* Ajoutez ici le contenu de votre fichier connexion.css */
      main {
        background-color: rgb(255, 0, 0); /* Fond blanc */
        width: 30%; /* Largeur de 30% de la largeur de la fenêtre */
        position: absolute; /* Position absolue pour superposer sur les images */
        top: 32%; /* Positionné à 50% de la hauteur de la fenêtre */
        left: 32%; /* Positionné à 50% de la largeur de la fenêtre */
        padding: 20px; /* Ajoute un espacement intérieur pour l'apparence */
      }

    </style>
  </head>
  <body>
  <?php include('MenuVisiteurF.php'); ?>
    <main>
    <form method="post">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Connexion</button>
      </form>
    </main>
  </body>
</html>
