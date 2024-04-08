<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant que membre
if (!isset($_SESSION['membre_username'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ConnexionF.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historique de la Page</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table, th, td {
      border: 1px solid black;
    }

    th, td {
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    a {
      cursor: pointer;
      color: red;
      text-decoration: none;
    }

    #return-button {
     position: fixed;
     bottom: 20px;
     right: 20px;
     background-color: #007bff;
     color: #fff;
     padding: 10px;
     border: none;
     cursor: pointer;
    }
  </style>
</head>
<body>
<?php include('MenuMembreF.php'); ?>
  <h1>Historique de la Page Web</h1>

  <table>
    <thead>
      <tr>
        <th>Date</th>
        <th>Événement</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>2023-11-10</td>
        <td>Page créée</td>
        <td><a href="#">Supprimer</a></td>
      </tr>
      <tr>
        <td>2023-11-10</td>
        <td>Mise à jour pour ajouter l'historique</td>
        <td><a href="#">Supprimer</a></td>
      </tr>
      <tr>
        <td>2023-11-15</td>
        <td>Ajout d'une fonctionnalité particulière</td>
        <td><a href="#">Supprimer</a></td>
      </tr>
      <!-- Ajoutez d'autres lignes d'historique au besoin -->
    </tbody>
  </table>
  <button id="return-button" onclick="window.location.href='AccueilMembreF.php'">Retour</button>  <?php include('FooterF.php'); ?>
</body>
</html>
