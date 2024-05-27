<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];

    // Vérifier si l'adresse email se termine par @arena-monaco.fr
    if (!endsWith($email, '@arena-monaco.fr')) {
        echo "L'adresse email doit se terminer par @arena-monaco.fr";
        exit();
    }

    // Configuration pour l'accès à l'Active Directory
    $ldap_server = "ldaps://dc.arena-monaco.fr";
    $ldap_user = 'cn=Administrateur, cn=Users, dc=arena-monaco, dc=fr';
    $ldap_password = '1234567890A@';
    $ldap_base_dn = 'dc=arena-monaco, dc=fr';
    $ldap_port = 636;

    // Données à ajouter
    $usercn = $prenom . " " . $nom;
    $usersn = $nom;
    $usergivenname = $prenom;
    $userpassword = $mot_de_passe;
    $usermail = $email;

    // Connexion à l'Active Directory
    $ldap_conn = ldap_connect($ldap_server, $ldap_port) or die("Impossible de se connecter au serveur LDAP.");
    ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

    if ($ldap_conn) {
        // Authentification
        $ldap_bind = ldap_bind($ldap_conn, $ldap_user, $ldap_password);

        if ($ldap_bind) {
            // Vérifier si l'adresse email existe déjà
            $filter = "(mail=$email)";
            $attributes = array("mail");
            $search = ldap_search($ldap_conn, $ldap_base_dn, $filter, $attributes);
            $entries = ldap_get_entries($ldap_conn, $search);

            if ($entries['count'] > 0) {
                echo "Email déjà utilisé";
                exit();
            }

            // Ajout d'un nouvel utilisateur
            $dn = "CN=$prenom $nom,OU=utilisateurs,DC=arena-monaco,DC=fr";
            $info = array(
                "cn" => $usercn,
                "sn" => $usersn,
                "givenName" => $usergivenname,
                "userPassword" => $userpassword,
                "mail" => $usermail,
                "sAMAccountName" => $usergivenname,
                'userPrincipalName' => $usermail,
                "unicodePwd" => mb_convert_encoding("\"$userpassword\"", 'UTF-16LE'),
                "adminCount" => array(0),
                "userAccountControl" => "66048",
                "objectClass" => ["top", "person", "organizationalPerson", "user"],
            );

            $result = ldap_add($ldap_conn, $dn, $info);
            if ($result) {
                // Inclure le fichier de connexion à la base de données
                require 'database.php';

                try {
                    // Préparation et exécution de la requête SQL pour insérer l'utilisateur
                    $stmt = $connexion->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$nom, $prenom, $email, password_hash($mot_de_passe, PASSWORD_DEFAULT)]);

                    echo "Utilisateur créé avec succès dans l'Active Directory et la base de données.";

                    // Redirection après l'inscription réussie
                    header("Location: AccueilAdminF.php");
                    exit();
                } catch (PDOException $e) {
                    echo "Échec de l'ajout de l'utilisateur dans la base de données : " . $e->getMessage();
                }
            } else {
                echo "Échec de l'ajout de l'utilisateur dans l'Active Directory.";
            }
        } else {
            echo "Échec de l'authentification LDAP.";
        }

        // Fermeture de la connexion LDAP
        ldap_close($ldap_conn);
    } else {
        echo "Échec de la connexion au serveur LDAP.";
    }
}

function endsWith($string, $suffix) {
    return substr($string, -strlen($suffix)) === $suffix;
}
?>
