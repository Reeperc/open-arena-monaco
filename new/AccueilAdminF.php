<!doctype html>
<html lang="fr">

<head>
  <link rel="stylesheet" href="style.css">

  <title>Site web</title>
  <script>
    function getServiceStatus() {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "service_status.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          document.getElementById("result").innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    }

    function startService() {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "start_service.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          document.getElementById("result").innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    }

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

    function stopService() {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "stop_service.php", true);
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

  <?php include('MenuAdminF.php'); ?>

  <video autoplay loop muted playsinline id="background-video">
    <source src="videos/video2.mp4" type="video/mp4">
  </video>
  <main>
    <h1></h1>
    <p></p>

    <!-- Section des six boutons géants -->
    <section class="button-grid">
      <a href="#" class="button-item" onclick="startService(); return false;">
        <img src="imaaage.jpg" alt="">
        <p>Démarrer le service</p>
      </a>

      <a href="StatutServiceRouen.php" class="button-item-joueur">
        <img src="" alt="">
        <p>Etat du serveur Rouen</p>
      </a>

      <a href="#" class="button-item" onclick="getServiceStatus(); return false;">
        <img src="" alt="">
        <p>Etat du serveur Monaco</p>
      </a>

      <a href="#" class="button-item" onclick="stopService(); return false;">
        <img src="" alt="">
        <p>Arrêter le service</p>
      </a>

      <a href="StatutServiceParis.php" class="button-item-joueur">
        <img src="image.jpg" alt="">
        <p>Etat du serveur Paris</p>
      </a>

      <a href="StatutServiceMQ.php" class="button-item-joueur">
        <img src="" alt="">
        <p>Etat du serveur MQ</p>
      </a>

      <a href="Competition4.php" class="button-item-joueur">
        <img src="" alt="">
        <p>Arbre de compétition</p>
      </a>

      <a href="#" class="button-item" onclick="launchGame(); return false;">
        <img src="" alt="">
        <p>Lancer le jeu</p>
      </a>

      <a href="CréationCompteJoueur.php" class="button-item">
        <img src="" alt="">
        <p>Créer un compte joueur</p>
      </a>
    </section>
    <div style="font-size: 22px" id="result"></div>
  </main>
  <!-- <?php include('FooterF.php'); ?> -->

</body>


</html>