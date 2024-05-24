<?php
session_start();

if (isset($_SESSION['success_message'])) {
  echo "<p style='color: green;'>" . $_SESSION['success_message'] . "</p>";
  unset($_SESSION['success_message']); // Supprimer la variable de session après l'affichage
}
?>
<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Connexion</title>
</head>

<body>
  <link rel="stylesheet" href="style.css">
  <?php include('MenuVisiteurF.php'); ?>
  <video autoplay loop muted playsinline id="background-video">
    <source src="videos/video5.mp4" type="video/mp4">
  </video>
  <!-- <main class='background-transparent'>
    <form method="post" class="login-form">
      <label for="username" class="form-label">Nom d'utilisateur :</label><br>
      <input type="text" id="username" name="username" required class="form-input"><br><br>

      <label for="password" class="form-label">Mot de passe :</label><br>
      <input type="password" id="password" name="password" required class="form-input"><br><br>

      <button type="submit" class="form-button">Connexion</button>
    </form>
  </main> -->
  <mainclass='background-transparent'>
    <h2>Connexion</h2>
    <?php if (isset($error_message)) { ?>
      <p class="error-message"><?php echo $error_message; ?></p>
    <?php } ?>
    <form method="post" action="connexionphp.php">
      <label class="form-label" for="email">identifiant :</label>
      <input class="form-input" type="text" id="email" name="email" required>
      <label class="form-label for=" password">Mot de passe :</label>
      <input type="password" id="password" name="password" required>
      <button type="submit">Se connecter</button>
    </form>
    </main>
</body>

</html>