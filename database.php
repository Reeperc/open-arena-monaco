<?php

//BDD Localhost Personel
<<<<<<< HEAD
// $serveur = "localhost";
// $utilisateur = "root";
// $motDePasse = "root";
// $baseDeDonnees = "bdd_6_10";

//BDD Localhost Serveur Web
$serveur = "localhost";
$utilisateur = "mo";
$motDePasse = "mdp";
$baseDeDonnees = "bdd_6_10";
=======
//$serveur = "localhost";
//$utilisateur = "root";
//$motDePasse = "root";
//$baseDeDonnees = "bdd_6_10";

//BDD Localhost Serveur Web
 $serveur = "localhost";
 $utilisateur = "mo";
 $motDePasse = "mdp";
 $baseDeDonnees = "bdd_6_10";
>>>>>>> 8cb27a9be0a75160a8e4aba177d4c39e0262643e

//BDD moduleweb
// $serveur = "moduleweb.esigelec.fr";
// $utilisateur = "grp_6_10";
// $motDePasse = "oPkO06vqDtnh";
// $baseDeDonnees = "bdd_6_10";


try {
    $connexion = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees", $utilisateur, $motDePasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Échec de la connexion à la base de données : " . $e->getMessage());
}
