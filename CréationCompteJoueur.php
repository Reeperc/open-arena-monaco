<?php

session_start(); // Démarrer la session



// Afficher le message de la variable de session

if (isset($_SESSION['message'])) {

  echo "<p>{$_SESSION['message']}</p>";

  // Supprimer le message de la session pour ne pas l'afficher à nouveau

  unset($_SESSION['message']);
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



    input,
    button {

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

    <form action="actived_creer_joueur.php" method="post">

      <div id="contact">

        <p id="content"> Prenom <input type="text" name="prenom" placeholder="Jean" required> </p>

        <p id="content"> Nom <input type="text" name="nom" placeholder="DUPONT" required></p>

        <p id="content"> Email <input type="email" name="email" placeholder="Ex : joueur@arena-monaco.fr" required></p>

        <p id="content"> Nouveau Mot de passe : <input type="password" name="mot_de_passe" required> </p>

        <button type="submit"> Enregistrer les données </button>

        <button type="button" onclick="window.location.href='AccueilAdminF.php'"> Retour </button>

      </div>

    </form>

  </main>

  <button id="return-button" onclick="window.location.href='AccueilAdminF.php'">Retour</button>
  <button type="button" onclick="window.location.href='voir_joueur.php'"> Afficher les joueurs </button>
  <button type="button" onclick="window.location.href='supp_joueur.php'"> Supprimer un joueur </button>

  <?php include('FooterF.php'); ?>

</body>

</html>