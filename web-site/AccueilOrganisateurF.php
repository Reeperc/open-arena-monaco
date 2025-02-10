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

  <script>
    function launchGame() {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "launch_game.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          document.getElementById("result").innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    }
  </script>

</head>

<body>
  <link rel="stylesheet" href="style.css">
  <?php include('MenuOrganisateurF.php'); ?>

  <video autoplay loop muted playsinline id="background-video">
    <source src="videos/video6.mp4" type="video/mp4">
  </video>
  <main>

  </main>

  <!-- <?php include('FooterF.php'); ?> -->
  </div>

</body>

</html>