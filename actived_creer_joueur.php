<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];

    //virifier si l'add se termine par @arena-monaco.fr
    if (!endsWith($email, '@arena-monaco.fr')) {
        echo "Laddresse mail doit se terminer par @arena-monaco.fr";
        exit();
    }

    // Configuration pour l'accès à l'Active Directory
    $ldap_server = "ldaps://dc.arena-monaco.fr"; // Remplacez par votre serveur LDAP
    $ldap_user = 'cn=Administrateur, cn=Users, dc=arena-monaco, dc=fr'; // Remplacez par votre nom d'utilisateur LDAP 
    $ldap_password = '1234567890A@'; // Remplacez par votre mot de passe LDAP
    $ldap_base_dn = 'dc=arena-monaco, dc=fr'; // Remplacez par votre base DN
    $ldap_port = 636;

    //Donnees à ajouter
    $usercn = $prenom . " " . $nom;
    $usersn = $nom;
    $usergivenname = $prenom;
    $userpassword = $mot_de_passe;
    $usermail = $email;

    //function encodePassword($userpassword){
    //$userpassword="\"".$userpassword."\"";
    // $encoded= "";
    // for($i=0; $i <strlen($userpassword); $i++){$encoded.="{$userpassword{$i}}\000";}
    // return $encoded;
    //}
    // Connexion à l'Active Directory
    $ldap_conn = ldap_connect("ldaps://dc.arena-monaco.fr", 636) or die("Impossible de se connecter au serveur LDAP.");
    ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

    if ($ldap_conn) {
        // Authentification
        $ldap_bind = ldap_bind($ldap_conn, $ldap_user, $ldap_password);


        if ($ldap_bind) {

            //Verifier si l'addresse exite deja 
            $filter = "(mail=$email)";
            $attributes = array("mail");
            $search = ldap_search($ldap_conn, $ldap_base_dn, $filter, $attributes);
            $entries = ldap_get_entries($ldap_conn, $search);

            if ($entries['count'] > 0) {
                echo " Email deja utilisé";
                exit();
            }
            // Ajout d'un nouvel utilisateur
            $dn = "CN=" . $prenom . " " . $nom . ",OU=utilisateurs,DC=arena-monaco,DC=fr"; // DN de l'utilisateur à ajouter
            echo  $dn;
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
                //"userAccountControl" => "512",
            );


            $result = ldap_add($ldap_conn,  $dn, $info);
            if ($result) {

                // Message de succès dans une variable de session
                echo "Ajout du joueur" . $email . "réussi.";

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
}
function endsWith($string, $suffix)
{
    return substr($string, -strlen($suffix)) === $suffix;
}
