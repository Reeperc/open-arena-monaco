<!doctype html>
<html lang="fr">

<head>
  <link rel="stylesheet" href="style.css">

  <title>Menu Admin</title>
  <script>
    function getServiceStatus(server) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "service_status.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          document.getElementById("result").innerHTML = xhr.responseText;
        }
      };
      xhr.send("server=" + server);
    }

    function startStopService(action) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "start_stop_service.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          document.getElementById("result").innerHTML = xhr.responseText;
        }
      };
      xhr.send("action=" + action);
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

    <!-- Section des trois boutons -->
    <section class="button-grid">
      <a href="ConfigurationServeur.php" class="button-item-joueur">
        <img src="" alt="">
        <p>Configuration serveur</p>
      </a>

      <a href="StatutDesServeurs.php" class="button-item-joueur">
        <img src="" alt="">
        <p>Statut des serveurs</p>
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
