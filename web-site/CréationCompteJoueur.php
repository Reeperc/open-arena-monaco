<?php
session_start(); // Démarrer la session

// Afficher le message de la variable de session
if (isset($_SESSION['message'])) {
  echo "<p>{$_SESSION['message']}</p>";
  // Supprimer le message de la session pour ne pas l'afficher à nouveau
  unset($_SESSION['message']);
}
/*
// Afficher le message d'erreur de creation de compte s'il est présent danns l'URL
if (isset($_GET['errorMessage'])) {
  echo "<script>window.onload = function() { alert('" . $_GET['errorMessage'] . "'); }</script>";
}
*/

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
  <button type="button" onclick="window.location.href='supprimerJoueur.php'"> Supprimer un joueur </button>
</body>

</html>