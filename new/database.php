<?php

$serveur = "localhost";
$utilisateur = "root";
$motDePasse = "root";
// $serveur = "moduleweb.esigelec.fr";
$baseDeDonnees = "bdd_6_10";
// $utilisateur = "grp_6_10";
// $motDePasse = "oPkO06vqDtnh";



try {
    $connexion = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees", $utilisateur, $motDePasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Échec de la connexion à la base de données : " . $e->getMessage());
}
