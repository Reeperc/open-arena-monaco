<?php
// Autres codes PHP si nécessaire
session_start();
// Afficher le message de déconnexion s'il est présent dans l'URL
if (isset($_GET['logout_message'])) {
  echo "<script>window.onload = function() { alert('" . $_GET['logout_message'] . "'); }</script>";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <link rel="stylesheet" href="style.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Site web</title>
</head>

<body>
  <link rel="stylesheet" href="style.css">
  <?php include('MenuVisiteurF.php'); ?>

  <div class="wrapper">
    <div class="content">

      <video autoplay loop muted playsinline id="background-video">
        <source src="videos/video2.mp4" type="video/mp4">
      </video>
    </div>

    <?php include('FooterF.php'); ?>
  </div>
</body>

</html>