<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arbre de Compétition</title>
    <link rel="stylesheet" href="style.css">
    <?php include('MenuOrganisateurF.php'); ?>
    <?php require_once('creer_nouvelle_table.php'); ?>
    <?php require_once('recuperer_id_match.php'); ?>
</head>

<body>
    <video autoplay loop muted playsinline id="background-video">
        <source src="videos/video6.mp4" type="video/mp4">
    </video>

    <button type="submit" onclick="location.href= 'Competition4.php';" style="width: 100px;"> Creer arbre</button>
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        creer_nouvelle_table($id = recuperer_id_match() + 1 );
        echo "test";
    }
    ?>
<?php    $id = recuperer_id_match()+1;
echo $id; ?>
    <a href=Competition4.php> test </a>