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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Site web</title>
    <style>

        main {
            background-color: white;
            width: 30%;
            position: absolute;
            top: 87%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
        }

        .image-container {
            display: flex;
        }

        .image-container img {
            margin: 35px;
            width: 680px;
            height: auto;
        }
    </style>
</head>
<body>
<?php include('MenuVisiteurF.php'); ?>
    <div class="wrapper">
      <div class="content">
        <main>
          <article>
            <h1>Qui sommes nous ?</h1>
            <p>Bienvenue sur le site officiel de la plus grande compétition de toute l'histoire du jeu Open Arena ! ce tournois opposera les meilleures équipes de chacunes de ces villes : Monaco, Rouen, Paris et Montcuq.</p>
  
            <h2>Remerciement</h2>
            <p>Merci bien évidemment à Taher et Horiace pour leur soutien infaillible dans cette mission, ainsi qu'à Antoine et Baptiste pour leur dévouement sur la configuration du serveur !</p>
            <p>Nous souhaitons également remercier l'ESIGELEC de nous avoir confié ce projet, digne d'étudiants exceptionnels comme ceux de notre équipe.</p>
          </article>
        </main>

        <h1>Bienvenue sur notre page d'accueil</h1>
        <div class="image-container">
          <img src="resoudre-diagramme-echecs-du-jour-1.jpg" alt="image d'accueil">
          <img src="resoudre-diagramme-echecs-du-jour-1.jpg" alt="image d'accueil">
        </div>
        <div class="image-container">
          <img src="resoudre-diagramme-echecs-du-jour-1.jpg" alt="image d'accueil">
          <img src="resoudre-diagramme-echecs-du-jour-1.jpg" alt="image d'accueil">
        </div>

        <?php include('FooterF.php'); ?>
      </div>

    </body>
    </html>
