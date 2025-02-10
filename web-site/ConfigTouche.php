<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant que joueur
if (!isset($_SESSION['joueur_username'])) {
  // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
  header("Location: ConnexionF.php");
  exit();
}

if (isset($_SESSION['welcome_message5'])) {
  echo "<p style='color: green;' class='message-success'>" . $_SESSION['welcome_message5'] . "</p>";
  unset($_SESSION['welcome_message5']); // Supprimer la variable de session après l'affichage
}
?>

<!doctype html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu Joueur</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="styles/style-joueur.css">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      margin: 0;
      padding: 0;
      overflow: hidden;
      color: #fff;
      background: #000;
    }

    #background-video {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -1;
      filter: brightness(50%);
    }

    main {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      text-align: center;
    }

    h2 {
      font-size: 2.5rem;
      margin-bottom: 20px;
    }

    .form-container {
      background: rgba(0, 0, 0, 0.8);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    label {
      font-size: 1.2rem;
      margin: 10px 0;
    }

    input[type="text"] {
      padding: 10px;
      font-size: 1rem;
      margin-bottom: 20px;
      width: 100%;
      max-width: 300px;
      border: none;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
    }

    button[type="submit"] {
      padding: 10px 20px;
      font-size: 1.2rem;
      color: #fff;
      background: #007BFF;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s, transform 0.3s;
    }

    button[type="submit"]:hover {
      background: #0056b3;
      transform: scale(1.1);
    }

    .message-success {
      font-size: 1.2em;
      text-align: center;
      margin: 20px;
      color: green;
      display: none;
    }
  </style>
</head>

<body>
  <?php include('MenuJoueurF.php'); ?>

  <video autoplay loop muted playsinline id="background-video">
    <source src="videos/video6.mp4" type="video/mp4">
  </video>
  <main>
    <h2>Configure tes touches ici</h2>

    <div class="form-container">
      <form id="configForm" action="config.php" method="post">
        <label for="t_droite">Droite :</label>
        <input type="text" id="t_droite" name="t_droite" maxlength="1" required><br>

        <label for="t_avancer">Avancer :</label>
        <input type="text" id="t_avancer" name="t_avancer" maxlength="1" required><br>

        <label for="t_gauche">Gauche :</label>
        <input type="text" id="t_gauche" name="t_gauche" maxlength="1" required><br>

        <label for="t_reculer">Reculer :</label>
        <input type="text" id="t_reculer" name="t_reculer" maxlength="1" required><br>
        <button type="submit">Enregistrer les touches</button>
      </form>
    </div>
  </main>

  <script src="libs/jquery.min.js"></script>
  <script src="libs/gsap.min.js"></script>
  <script>
    $(document).ready(function() {
      // Animation d'apparition pour le message de succès
      if ($('.message-success').length) {
        gsap.fromTo('.message-success', {
          y: -50,
          opacity: 0
        }, {
          y: 0,
          opacity: 1,
          duration: 1
        });
        setTimeout(function() {
          gsap.to('.message-success', {
            y: 50,
            opacity: 0,
            duration: 1,
            onComplete: function() {
              $('.message-success').hide();
            }
          });
        }, 3000);
      }

      // Animation d'apparition pour le formulaire
      gsap.fromTo('.form-container', {
        y: 50,
        opacity: 0
      }, {
        y: 0,
        opacity: 1,
        duration: 1,
        stagger: 0.2
      });
    });
  </script>
</body>

</html>