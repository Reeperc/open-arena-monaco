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

  <!-- Contenu de MenuVisiteurF.php -->
  <!-- Ajoutez ici le contenu HTML de MenuVisiteurF.php -->

  <div class="wrapper">
    <div class="content">
      <video autoplay loop muted playsinline id="background-video">
        <source src="videos/video2.mp4" type="video/mp4">
      </video>
    </div>

    <!-- Contenu de FooterF.php -->
    <!-- Ajoutez ici le contenu HTML de FooterF.php -->
  </div>

  <!-- Script pour afficher le message de déconnexion -->
  <script>
    window.onload = function() {
      const urlParams = new URLSearchParams(window.location.search);
      const logoutMessage = urlParams.get('logout_message');
      if (logoutMessage) {
        alert(logoutMessage);
      }
    };
  </script>
</body>

</html>