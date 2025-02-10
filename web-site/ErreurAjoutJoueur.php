<?php
session_start();
/*

// Stocker le message de déconnexion dans une variable temporaire
$erreurMessage = "Ce nom d'utilisateur existe déjà.";

// Rediriger vers la page de creation du joueur avec le message en paramètre
header("Location: CréationCompteJoueur.php?erreurMessage=" . urlencode($erreurMessage));
exit();
*/
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
        <h1> Ce pseudo est deja pris <h1>
        <a href="CréationCompteJoueur.php"> <p style="color:DodgerBlue;">Retour inscription</p></a>
</main>
</body>
</html>