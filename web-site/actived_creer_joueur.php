<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];

    // Vérifier si l'adresse se termine par @arena-monaco.fr
    if (!endsWith($email, '@arena-monaco.fr')) {
        echo "L'adresse mail doit se terminer par @arena-monaco.fr";
        exit();
    }

    // Inclure le fichier de connexion à la base de données
    include 'database.php';

    // Vérifier la connexion à la base de données
    if (!$connexion) {
        echo "Échec de la connexion à la base de données.";
        exit();
    }

    // Vérifier si l'utilisateur existe déjà dans la base de données
    try {
        $stmt_check = $connexion->prepare("SELECT id FROM Joueur WHERE Email = :email");
        $stmt_check->bindParam(':email', $email);
        $stmt_check->execute();
        $row = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            echo "Email déjà utilisé dans la base de données";
            exit();
        }

        // Si l'utilisateur n'existe pas, l'ajouter à la base de données
        $stmt_insert = $connexion->prepare("INSERT INTO Joueur (Nom, Prénom, Email, username, password) VALUES (:nom, :prenom, :email, :username, :mot_de_passe)");
        $stmt_insert->bindParam(':nom', $nom);
        $stmt_insert->bindParam(':prenom', $prenom);
        $stmt_insert->bindParam(':email', $email);
        $stmt_insert->bindParam(':username', $prenom); // Utiliser le prénom comme nom d'utilisateur par exemple
        $hashed_password = password_hash($mot_de_passe, PASSWORD_BCRYPT);
        $stmt_insert->bindParam(':mot_de_passe', $hashed_password);

        if ($stmt_insert->execute()) {
            echo "Utilisateur ajouté à la base de données avec succès.";

            // Configuration pour l'accès à l'Active Directory
            $ldap_server = "ldaps://dc.arena-monaco.fr";
            $ldap_user = 'cn=Administrateur, cn=Users, dc=arena-monaco, dc=fr';
            $ldap_password = '1234567890A@';
            $ldap_base_dn = 'dc=arena-monaco, dc=fr';
            $ldap_port = 636;

            // Connexion à l'Active Directory
            $ldap_conn = ldap_connect($ldap_server, $ldap_port) or die("Impossible de se connecter au serveur LDAP.");
            ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

            if ($ldap_conn) {
                // Authentification
                $ldap_bind = ldap_bind($ldap_conn, $ldap_user, $ldap_password);

                if ($ldap_bind) {
                    // Ajout d'un nouvel utilisateur dans l'Active Directory
                    $dn = "CN=" . $prenom . " " . $nom . ",OU=utilisateurs,DC=arena-monaco,DC=fr";
                    $info = array(
                        "cn" => $prenom . " " . $nom,
                        "sn" => $nom,
                        "givenName" => $prenom,
                        "userPassword" => $mot_de_passe,
                        "mail" => $email,
                        "sAMAccountName" => strtolower($prenom),
                        'userPrincipalName' => $email,
                        "unicodePwd" => mb_convert_encoding("\"$mot_de_passe\"", 'UTF-16LE'),
                        "adminCount" => array(0),
                        "userAccountControl" => "66048",
                        "objectClass" => ["top", "person", "organizationalPerson", "user"],
                    );

                    $result = ldap_add($ldap_conn, $dn, $info);
                    if ($result) {
                        // Message de succès dans l'Active Directory
                        echo "Ajout de l'utilisateur " . $email . " réussi dans l'Active Directory.";

                        // Rediriger vers la page "AccueilAdminF.php" après l'inscription réussie
                        header("Location: AccueilAdminF.php");
                        exit(); // Assurez-vous de terminer l'exécution du script après la redirection
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
        } else {
            echo "Échec de l'ajout de l'utilisateur dans la base de données.";
        }
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
    }
}

function endsWith($string, $suffix) {
    return substr($string, -strlen($suffix)) === $suffix;
}
?>
