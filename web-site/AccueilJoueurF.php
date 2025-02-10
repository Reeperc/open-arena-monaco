<?php
session_start();
$nom = strtolower($_SESSION['joueur_sAMAccountName']);
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

    h1 {
      font-size: 3rem;
      margin-bottom: 20px;
    }

    p {
      font-size: 1.5rem;
    }

    .button-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-top: 50px;
    }

    .button-item-joueur {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 20px;
      background: rgba(255, 255, 255, 0.1);
      border: 2px solid #fff;
      border-radius: 10px;
      text-decoration: none;
      color: #fff;
      transition: transform 0.3s, background 0.3s;
    }

    .button-item-joueur img {
      width: 100px;
      height: 100px;
      margin-bottom: 10px;
    }

    .button-item-joueur p {
      margin: 0;
      font-size: 1.2rem;
    }

    .button-item-joueur:hover {
      transform: scale(1.1);
      background: rgba(255, 255, 255, 0.2);
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
    <h1>Bienvenue, <?php echo $nom; ?>!</h1>
    <p>Joueur : <?php echo $nom; ?> </p>

    <!-- Section des six boutons géants -->
    <section class="button-grid">
      <a href="ConfigTouche.php" class="button-item-joueur">
        <!-- <img src="image.jpg" alt=""> -->
        <p>Configurer les touches</p>
      </a>
      <a href="ListMapPourJoueur.php" class="button-item-joueur">
        <!-- <img src="image.jpg" alt=""> -->
        <p>Liste des cartes</p>
      </a>
      <a href="ModesJeuxPourJoueur.php" class="button-item-joueur">
        <!-- <img src="image.jpg" alt=""> -->
        <p>Modes de jeux</p>
      </a>
      <!-- Ajoutez d'autres boutons ici -->
    </section>
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

      // Animation d'apparition pour les boutons
      gsap.fromTo('.button-item-joueur', {
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