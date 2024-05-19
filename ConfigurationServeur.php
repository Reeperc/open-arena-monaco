<!doctype html>
<html lang="fr">

<head>
  <link rel="stylesheet" href="style.css">

  <title>Configuration du serveur Monaco</title>
  <style>
    body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            color: #0088ff;
            height: 100%;
            background-image: url('images/hannah-oates-brick-wall-wip.jpg'); /* Assurez-vous que le chemin est correct */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
  </style>
  <script>
    
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

    // function launchGame() {
    //   var xhr = new XMLHttpRequest();
    //   xhr.open("POST", "launch_game.php", true);
    //   xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    //   xhr.onreadystatechange = function() {
    //     if (xhr.readyState == 4 && xhr.status == 200) {
    //       document.getElementById("result").innerHTML = xhr.responseText;
    //     }
    //   };
    //   xhr.send();
    // }

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

  <main>
    <h1></h1>
    <p></p>

    <!-- Section des six boutons géants -->
    <section class="button-grid">
      <a href="#" class="button-item" onclick="startService(); return false;">
        <img src="images/imaaage.jpg" alt="">
        <p>Démarrer le service</p>
      </a>
    
      <a href="#" class="button-item" onclick="stopService(); return false;">
        <img src="" alt="">
        <p>Arrêter le service</p>
      </a>
    </section>
    <div style="font-size: 22px" id="result"></div>
  </main>
</body>

</html>
