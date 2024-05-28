<?php
// Afficher toutes les erreurs dans le navigateur pour le débogage
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Vérifier si PHPMailer est installé
if (!file_exists('vendor/autoload.php')) {
    die('PHPMailer non installé. Exécutez `composer install`.');
}

// Charger les classes PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Charger les dépendances Composer

// Récupération des données du formulaire
$token = $_POST["token"];
$password = $_POST["password"];
$password_confirmation = $_POST["password_confirmation"];

// Validation des mots de passe
if ($password !== $password_confirmation) {
    die("Les mots de passe ne correspondent pas");
}

// Génération du hash du mot de passe
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Inclure le fichier de connexion à la base de données
require('database.php');

try
