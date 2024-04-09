<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant que joueur
if (!isset($_SESSION['joueur_username'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ConnexionF.php");
    exit();
}

if (isset($_SESSION['welcome_message5'])) {
  echo "<p style='color: green;'>".$_SESSION['welcome_message5']."</p>";
  unset($_SESSION['welcome_message5']); // Supprimer la variable de session après l'affichage
}

// Le reste de votre code pour la page AccueilJoueurF.php
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
        background-color: #054C8A; /* Fond bleu foncé */
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
  <?php include('MenuJoueurF.php'); ?>
    <div class="wrapper">
      <div class="content">
      <main>
          <article>
            <h1>Qui sommes nous ?</h1>
            <p>Bienvenue sur le site officiel de la plus grande compétition de toute l'histoire du jeu Open Arena ! ce tournois opposera les meilleures équipes de chacunes de ces villes : Monaco, Rouen, Paris et Montcuq.</p>
  
            <h2>Remerciement</h2>
            <p>Merci bien évidemment à Aurélien, Taher et Auriace pour leur soutien infaillible dans cette mission, ainsi qu'à Antoine et Baptiste pour leur dévouement sur la configuration du serveur !</p>
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


