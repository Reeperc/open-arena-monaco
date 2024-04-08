<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant que membre
if (!isset($_SESSION['membre_username'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ConnexionF.php");
    exit();
}

if (isset($_SESSION['welcome_message'])) {
  echo "<p style='color: green;'>".$_SESSION['welcome_message']."</p>";
  unset($_SESSION['welcome_message']); // Supprimer la variable de session après l'affichage
}

// Le reste de votre code pour la page AccueilMembreF.php
?>


<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Site web</title>
    <style>
      /* Ajoutez ici le contenu de votre fichier AccueilMembre.css */

      main {
        background-color: white; /* Fond blanc */
        width: 30%; /* Largeur de 30% de la largeur de la fenêtre */
        position: absolute; /* Position absolue pour superposer sur les images */
        top: 75%; /* Positionné à 50% de la hauteur de la fenêtre */
        left: 40%; /* Positionné à 50% de la largeur de la fenêtre */
        transform: translate(-50%, -50%); /* Centre horizontalement et verticalement */
        padding: 20px; /* Ajoute un espacement intérieur pour l'apparence */
      }
  
      .image-container {
        display: flex;
      }
  
      .image-container img {
        margin: 35px; /* Ajoutez un espace entre les images si nécessaire */
        width: 550px; /* Définissez la largeur souhaitée (par exemple, 100px) */
        height: auto; /* La hauteur est automatiquement ajustée pour maintenir les proportions */
      }
  
      .wrapper {
        display: flex;
      }
  
      .content {
        flex: 1; /* Occupe tout l'espace restant à gauche */
      }

    </style>
  </head>
  <body>
  <?php include('MenuMembreF.php'); ?>
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


