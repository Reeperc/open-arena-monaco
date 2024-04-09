<?php
session_start(); // Démarrer la session

// Afficher le message de la variable de session
if (isset($_SESSION['message'])) {
    echo "<p>{$_SESSION['message']}</p>";
    // Supprimer le message de la session pour ne pas l'afficher à nouveau
    unset($_SESSION['message']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $mot_de_passe = password_hash($_POST["mot_de_passe"], PASSWORD_DEFAULT);

    try {
        // Établir la connexion à la base de données
        $serveur = "localhost";
        $utilisateur = "grp_6_10";
        $motDePasse = "oPkO06vqDtnh";
        $baseDeDonnees = "bdd_6_10";

        $connexion = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees", $utilisateur, $motDePasse);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer la requête SQL d'insertion
        $query = "INSERT INTO Joueur (Nom, Prénom, Email, username, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $connexion->prepare($query);

        // Exécuter la requête avec les valeurs
        $stmt->execute([$nom, $prenom, $email, $mot_de_passe]);

        // Message de succès dans une variable de session
        $_SESSION['message'] = "Ajout du joueur $email réussi.";

        // Rediriger vers la page "AccueilAdminF.php" après l'inscription réussie
        header("Location: AccueilAdminF.php");

        exit(); // Assurez-vous de terminer l'exécution du script après la redirection

    } catch (PDOException $e) {
        // En cas d'erreur, afficher l'erreur
        echo "Erreur lors de l'inscription : " . $e->getMessage();
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
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    main {
      margin: 20px;
    }

    h1 {
      text-align: center;
    }

    #contact {
      display: flex;
      flex-direction: column;
      max-width: 400px;
      margin: auto;
    }

    p {
      margin-top: 10px;
    }

    input, button {
      margin-top: 5px;
    }

    button {
      background-color: #008CBA;
      color: #fff;
      padding: 10px;
      cursor: pointer;
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
<?php include('MenuAdminF.php'); ?>
  <main>
    <h1>Inscrivez le joueur</h1>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les données du formulaire
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $mot_de_passe = $_POST["mot_de_passe"];
    }
    ?>
    <form action="" method="post">
      <div id="contact">
        <p id="content"> Nom <input type="text" name="nom" placeholder="DUPONT" required></p>
        <p id="content"> Prenom <input type="text" name="prenom" placeholder="Jean" required> </p>
        <p id="content"> Email <input type="email" name="email" placeholder="Ex : TOTO@gmail.com" required></p>
        <p id="content"> Nouveau Mot de passe : <input type="password" name="mot_de_passe" required> </p>
        <button type="submit"> Enregistrer les données </button>
        <button type="button" onclick="window.location.href='AccueilAdminF.php'"> Retour </button>
      </div>
    </form>
  </main>
  <button id="return-button" onclick="window.location.href='AccueilAdminF.php'">Retour</button>
  <?php include('FooterF.php'); ?>
</body>
</html>
