<?php
session_start();

if (isset($_SESSION['error_message'])) {
  echo "<p style='color: green;'>".$_SESSION['error_message']."</p>";
  unset($_SESSION['error_message']); // Supprimer la variable de session après l'affichage
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $tel = $_POST["tel"];
    $date_naissance = $_POST["date_naissance"];
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
        $query = "INSERT INTO Membre (username, password, Nom, Prénom, Tel, DateNaissance) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $connexion->prepare($query);

        // Exécuter la requête avec les valeurs
        $stmt->execute([$email, $mot_de_passe, $nom, $prenom, $tel, $date_naissance]);

        // Stocker le message de succès dans une variable de session
        $_SESSION['success_message'] = "$email, Votre compte a été créé avec succès !";

        // Rediriger vers la page "AccueilMembre.html" après l'inscription réussie
        header("Location: connexionF.php");
        exit(); // Assurez-vous de terminer l'exécution du script après la redirection

    } catch (PDOException $e) {
        // En cas d'erreur, vérifier si c'est une erreur d'intégrité (doublon de clé unique)
        if ($e->errorInfo[1] == 1062) {
            $_SESSION['error_message'] = "Ce nom d'utilisateur existe déjà.";
            // Rediriger vers la page d'inscription avec un message d'erreur
            header("Location: CréationCompteF.php");
            exit();
        } else {
            // Autre erreur, afficher l'erreur
            echo "Erreur lors de l'inscription : " . $e->getMessage();
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
<?php include('MenuVisiteurF.php'); ?>
  <main>
    <h1>Inscrivez-vous</h1>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les données du formulaire
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $tel = $_POST["tel"];
        $date_naissance = $_POST["date_naissance"];
        $email = $_POST["email"];
        $mot_de_passe = $_POST["mot_de_passe"];
        $confirmer_mot_de_passe = $_POST["confirmer_mot_de_passe"];

        // Vous pouvez faire d'autres traitements ici, comme l'insertion dans une base de données
        // Pour cet exemple, nous affichons simplement les données
        echo "Nom: $nom<br>";
        echo "Prenom: $prenom<br>";
        echo "Tel: $tel<br>";
        echo "Date de Naissance: $date_naissance<br>";
        echo "Email: $email<br>";
        // N'oubliez pas de sécuriser les mots de passe dans un environnement de production
        echo "Mot de passe: $mot_de_passe<br>";
    }
    ?>
    <form action="" method="post">
      <div id="contact">
        <p id="content"> Nom <input type="text" name="nom" placeholder="DUPONT" required></p>
        <p id="content"> Prenom <input type="text" name="prenom" placeholder="Jean" required> </p>
        <p id="content"> Tel <input type="tel" name="tel" placeholder="Ex : 0665******" required></p>
        <p id="content"> Date de Naissance <input type="text" name="date_naissance" placeholder="Ex : 07/07/2007" required> </p>
        <p id="content"> Email <input type="email" name="email" placeholder="Ex : TOTO@gmail.com" required></p>
        <p id="content"> Nouveau Mot de passe : <input type="password" name="mot_de_passe" required> </p>
        <button type="submit"> Enregistrer les données </button>
        <button type="button" onclick="window.location.href='index.php'"> Retour </button>
      </div>
    </form>
  </main>
  <button id="return-button" onclick="window.location.href='index.php'">Retour</button>
  <?php include('FooterF.php'); ?>
</body>
</html>
