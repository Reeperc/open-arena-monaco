<?php
session_start();

if (isset($_SESSION['success_message'])) {
  echo "<p style='color: green;'>" . $_SESSION['success_message'] . "</p>";
  unset($_SESSION['success_message']); // Supprimer la variable de session après l'affichage
}

// informations de connexion à la base de données

//BDD Localhost Personel
// $serveur = "localhost";
// $utilisateur = "root";
// $motDePasse = "root";
// $baseDeDonnees = "bdd_6_10";

//BDD Localhost Serveur Web
// $serveur = "localhost";
// $utilisateur = "mo";
// $motDePasse = "mdp";
// $baseDeDonnees = "bdd_6_10";

//BDD moduleweb
// $serveur = "moduleweb.esigelec.fr";
// $utilisateur = "grp_6_10";
// $motDePasse = "oPkO06vqDtnh";
// $baseDeDonnees = "bdd_6_10";
include("database.php");

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
</head>

<body>
  <link rel="stylesheet" href="style.css">
  <?php include('MenuVisiteurF.php'); ?>
  <video autoplay loop muted playsinline id="background-video">
    <source src="videos/video5.mp4" type="video/mp4">
  </video>
  <main class='background-transparent'>
    <form method="post" class="login-form">
      <label for="username" class="form-label">Nom d'utilisateur :</label><br>
      <input type="text" id="username" name="username" required class="form-input"><br><br>

      <label for="password" class="form-label">Mot de passe :</label><br>
      <input type="password" id="password" name="password" required class="form-input"><br><br>

      <button type="submit" class="form-button">Connexion</button>
    </form>
  </main>
</body>

</html>