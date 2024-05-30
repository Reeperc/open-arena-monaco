<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #4b6cb7, #182848);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        h2 {
            font-size: 2em;
            text-align: center;
            margin-bottom: 1em;
            animation: fadeIn 2s ease-in-out;
        }
        ul {
            list-style: none;
            padding: 0;
            animation: slideIn 1s ease-out;
        }
        li {
            background: rgba(255, 255, 255, 0.1);
            padding: 1em;
            margin: 0.5em 0;
            border-radius: 5px;
            transition: background 0.3s, transform 0.3s;
        }
        li:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        @keyframes slideIn {
            0% { transform: translateY(-100px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body>
    <div>
        <?php
        // Configuration pour l'accès à l'Active Directory
        $ldap_server = 'ldap://195.221.30.4'; // Remplacez par votre serveur LDAP
        $ldap_user = 'cn=Administrateur, cn=Users, dc=arena-monaco, dc=fr'; // Remplacez par votre nom d'utilisateur LDAP
        $ldap_password = '1234567890A@'; // Remplacez par votre mot de passe LDAP
        $ldap_base_dn = 'DC=arena-monaco, DC=fr'; // Remplacez par votre base DN

        // Connexion à l'Active Directory
        $ldap_conn = ldap_connect($ldap_server) or die("Impossible de se connecter au serveur LDAP.");
        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

        if ($ldap_conn) {
            // Authentification
            $ldap_bind = ldap_bind($ldap_conn, $ldap_user, $ldap_password);

            if ($ldap_bind) {
                // Requête pour récupérer tous les utilisateurs
                $filter = "(objectClass=user)";
                $attributes = array("cn", "mail", "sn", "givenName");
                $search = ldap_search($ldap_conn, $ldap_base_dn, $filter, $attributes);
                $entries = ldap_get_entries($ldap_conn, $search);

                // Affichage des utilisateurs
                echo "<h2>Liste des utilisateurs :</h2>";
                echo "<ul>";
                for ($i = 0; $i < $entries['count']; $i++) {
                    if (isset($entries[$i]['cn'][0]) && isset($entries[$i]['mail'][0]) && isset($entries[$i]['sn'][0]) && isset($entries[$i]['givenname'][0])) {
                        $cn = $entries[$i]['cn'][0];
                        $email = $entries[$i]['mail'][0];
                        $nom = $entries[$i]['sn'][0];
                        $prenom = $entries[$i]['givenname'][0];
                        echo "<li>Nom complet : $prenom $nom - Email : $email</li>";
                    }
                }
                echo "</ul>";
            } else {
                echo "<h2>Échec de l'authentification LDAP.</h2>";
            }

            // Fermeture de la connexion LDAP
            ldap_close($ldap_conn);
        } else {
            echo "<h2>Échec de la connexion au serveur LDAP.</h2>";
        }
        ?>
    </div>
</body>
</html>
