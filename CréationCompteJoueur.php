<?php
session_start(); // Démarrer la session

// Afficher le message de la variable de session
if (isset($_SESSION['message'])) {
  echo "<p>{$_SESSION['message']}</p>";
  // Supprimer le message de la session pour ne pas l'afficher à nouveau
  unset($_SESSION['message']);
}
/*
// Afficher le message d'erreur de creation de compte s'il est présent dans l'URL
if (isset($_GET['errorMessage'])) {
  echo "<script>window.onload = function() { alert('" . $_GET['errorMessage'] . "'); }</script>";
}
*/

require('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Récupérer les données du formulaire
  $nom = $_POST["nom"];
  $prenom = $_POST["prenom"];
  $pseudo = $_POST["pseudo"];
  $mot_de_passe = password_hash($_POST["mot_de_passe"], PASSWORD_DEFAULT);


  try {
    // Établir la connexion à la base de données

    /*
        $serveur = "localhost";
        $utilisateur = "grp_6_10";
        $motDePasse = "oPkO06vqDtnh";
        $baseDeDonnees = "bdd_6_10";

        $connexion = new PDO("mysql:host=$serveur;connexion$connexionname=$baseDeDonnees", $utilisateur, $motDePasse);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        */



    // Préparer la requête SQL d'insertion
    $query = "INSERT INTO Joueur (Nom, Prénom, Email, username, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $connexion->prepare($query);

    $mail = "@arena-monaco.fr";
    $email = $pseudo . $mail;

    // Exécuter la requête avec les valeurs
    $stmt->execute([$nom, $prenom, $email, $pseudo, $mot_de_passe]);


    // Message de succès dans une variable de session
    $_SESSION['message'] = "Ajout du joueur $email réussi.";

    // Rediriger vers la page "AccueilAdminF.php" après l'inscription réussie
    header("Location: AccueilAdminF.php");

    exit(); // Assurez-vous de terminer l'exécution du script après la redirection

  } catch (PDOException $e) {
    // En cas d'erreur, vérifier si c'est une erreur d'intégrité (doublon de clé unique)
    if ($e->errorInfo[1] == 1062) {
      $_SESSION['error_message'] = "Ce pseudo existe déjà.";
      // Rediriger vers la page d'inscription avec un message d'erreur
      header("Location: ErreurAjoutJoueur.php");
      //header("Location: CréationCompteJoueur.php" );
      exit();
    } else {
      // Autre erreur, afficher l'erreur
      echo "Erreur lors de la creation de l'ID : " . $e->getMessage();
    }
  } finally {
    // Fermer la connexion
    $connexion = null;
  }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Site web</title>
  <link rel="stylesheet" href="styles/style-antoine.css">
  <link rel="stylesheet" href="styles/style-antoine-compte.css">
</head>

<body>
  <?php include('MenuAdminF.php'); ?>
  <main>
    <h1>Inscrivez le joueur</h1>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Récupérer les données du formulaire
      $nom = $_POST["nom"];
      $prenom = $_POST["prenom"];
      $pseudo = $_POST["pseudo"];
      $mot_de_passe = $_POST["mot_de_passe"];
    }
    ?>
    <form action="" method="post">
      <div id="contact">
        <p id="content"> Prenom <input type="text" name="prenom" placeholder="Jean" required> </p>
        <p id="content"> Nom <input type="text" name="nom" placeholder="DUPONT" required></p>
        <p id="content"> Pseudo <input type="text" name="pseudo" placeholder="toto" required></p>
        <p id="content"> Nouveau Mot de passe : <input type="password" name="mot_de_passe" required> </p>
        <button type="submit"> Enregistrer les données </button>
        <button type="button" onclick="window.location.href='AccueilAdminF.php'"> Retour </button>
      </div>
    </form>
  </main>
  <button id="return-button" onclick="window.location.href='AccueilAdminF.php'">Retour</button>
  <p>Votre adresse mail est de la forme pseudo@arena-monaco.fr </p>
</body>

</html>