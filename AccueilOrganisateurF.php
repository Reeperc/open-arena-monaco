<?php
session_start();
// Vérifier si l'utilisateur est connecté en tant que admin
if (!isset($_SESSION['organisateur_username'])) {
  // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
  header("Location: ConnexionF.php");
  exit();
}

if (isset($_SESSION['welcome_message9'])) {
  echo "<p style='color: green;'>" . $_SESSION['welcome_message9'] . "</p>";
  unset($_SESSION['welcome_message9']); // Supprimer la variable de session après l'affichage
}
?>

<!doctype html>
<html lang="fr">

<head>

  <title>Menu Organisateur</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <link rel="stylesheet" href="style.css">
  <?php include('MenuOrganisateurF.php'); ?>

  <video autoplay loop muted playsinline id="background-video">
    <source src="videos/video6.mp4" type="video/mp4">
  </video>
  <main>
    <h1></h1>
    <p></p>

    <!-- Section des six boutons géants -->
    <section class="button-grid">
      <a href="Competition4.php" class="button-item-joueur">
        <img src="" alt="">
        <p>Arbre de compétition</p>
      </a>

      <a href="StatutServiceParis.php" class="button-item-joueur">
        <img src="image.jpg" alt="">
        <p>Etat du serveur Paris</p>
      </a>

      <a href="StatutServiceMQ.php" class="button-item-joueur">
        <img src="" alt="">
        <p>Etat du serveur MQ</p>
      </a>

      <a href="ListmapsAdmin.php" class="button-item-joueur">
        <img src="" alt="">
        <p>Liste des cartes</p>
      </a>

      <a href="StatutServiceMonaco.php" class="button-item-joueur">
        <img src="" alt="">
        <p>Etat du serveur Monaco</p>
      </a>

      <a href="StatutServiceRouen.php" class="button-item-joueur">
        <img src="" alt="">
        <p>Etat du serveur Rouen</p>
      </a>

      <!-- <a href="" class="button-item">
        <img src="" alt="">
        <p>un bouton</p>
      </a>

      <a href="" class="button-item">
        <img src="" alt="">
        <p>un bouton</p> -->
      </a>
    </section>
  </main>

  <!-- <?php include('FooterF.php'); ?> -->
  </div>

</body>

</html>