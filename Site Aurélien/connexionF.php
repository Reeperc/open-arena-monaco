<?php
session_start();

if (isset($_SESSION['success_message'])) {
    echo "<p style='color: green;'>".$_SESSION['success_message']."</p>";
    unset($_SESSION['success_message']); // Supprimer la variable de session après l'affichage
}

// Définir les informations de connexion à la base de données
$serveur = "localhost";
$utilisateur = "aurelien";
$motDePasse = "Pa$$w0rd";
$baseDeDonnees = "bdd_monaco";

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

        // Vérifier d'abord dans la table "Membre"
        $queryMembre = "SELECT * FROM Membre WHERE username = ?";
        $stmtMembre = $connexion->prepare($queryMembre);
        $stmtMembre->execute([$username]);
        $membre = $stmtMembre->fetch();

        // Si les identifiants sont dans la table "Membre" et le mot de passe est correct
        if ($membre && password_verify($password, $membre['password'])) {
            // Définir la variable de session pour le membre
            $_SESSION['visiteur_username'] = $username;
            $_SESSION['welcome_message'] = "Bienvenue, $username ! Connexion réussie.";
            // Redirection vers la page AccueilMembreF.php
            header("Location: AccueilVisiteurF.php");
            exit();
        }

        // Vérifier dans la table "Admin"
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
        }

        // Vérifier dans la table "Joueur"
        $queryJoueur = "SELECT * FROM Joueur WHERE username = ?";
        $stmtJoueur = $connexion->prepare($queryJoueur);
        $stmtJoueur->execute([$username]);
        $joueur = $stmtJoueur->fetch();

        // Si les identifiants sont dans la table "Joueur" et le mot de passe est correct
        if ($joueur && password_verify($password, $joueur['password'])) {
            // Définir la variable de session pour le joueur
            $_SESSION['joueur_username'] = $username;
            $_SESSION['welcome_message'] = "Bienvenue, $username ! Connexion réussie.";
            // Redirection vers la page d'accueil des joueurs
            header("Location: AccueilJoueurF.php");
            exit();
        }

        // Vérifier dans la table "Organisateur"
        $queryOrganisateur = "SELECT * FROM Organisateur WHERE username = ?";
        $stmtOrganisateur = $connexion->prepare($queryOrganisateur);
        $stmtOrganisateur->execute([$username]);
        $organisateur = $stmtOrganisateur->fetch();

        // Si les identifiants sont dans la table "Organisateur" et le mot de passe est correct
        if ($organisateur && password_verify($password, $organisateur['password'])) {
            // Définir la variable de session pour l'organisateur
            $_SESSION['organisateur_username'] = $username;
            $_SESSION['welcome_message'] = "Bienvenue, $username ! Connexion réussie.";
            // Redirection vers la page d'accueil des organisateurs
            header("Location: AccueilOrganisateurF.php");
            exit();
        }

        // Afficher un message d'erreur si les informations de connexion sont incorrectes
        echo "Identifiant ou mot de passe incorrect.";
    }

} catch (PDOException $e) {
    // En cas d'erreur, affichez l'erreur
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
        background-color: #2C6CC2
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
        <label for="username">Nom d'utilisateur :</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Mot de passe :</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Connexion</button>
    </form>
    </main>
  </body>
</html>
