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
            <p>Nous sommes une association de jeux qui proposent aux visiteurs de notre site de rejoindre des parties, dans leurs jeux favoris. Ils peuvent également ajouter leurs jeux préférés en favori afin d'y accéder plus rapidement. Ils peuvent également, s'ils le souhaitent, consulter les infos de chaque jeu proposé par le site. Ces informations comprennent une image représentative du jeu, les règles du jeu ainsi que d'autres infos.</p>
  
            <h2>Remerciement</h2>
            <p>Merci bien évidemment aux deux informaticiens de génie que sont Aurélien MARTINEAU et Alexandre MATIAS pour avoir codé l'intégralité de notre site web.</p>
            <p>Nous souhaitons également remercier l'ESIGELEC de nous avoir confié leurs deux plus brillants étudiants.</p>
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
