<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        h1 {
            font-size: 2.5em;
            text-align: center;
            margin-bottom: 1em;
            animation: fadeIn 2s ease-in-out;
        }
        form {
            background: rgba(0, 0, 0, 0.5);
            padding: 2em;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: slideIn 1s ease-out;
        }
        label, select, button {
            display: block;
            width: 100%;
            margin-bottom: 1em;
        }
        select, button {
            padding: 0.75em;
            border: none;
            border-radius: 5px;
            font-size: 1em;
        }
        select {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }
        button {
            background: #ff7e5f;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #feb47b;
        }
        p {
            text-align: center;
            font-size: 1.2em;
            animation: fadeIn 2s ease-in-out;
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
        <h1>Supprimer un utilisateur</h1>
        <form method="POST" action="supp_joueur.php">
            <label for="email_utilisateur">Sélectionnez un utilisateur à supprimer :</label>
            <select name="email_utilisateur" id="email_utilisateur">
                <?php
                // Configuration pour l'accès à l'Active Directory
                $ldap_server = 'ldap://195.221.30.4'; // Remplacez par votre serveur LDAP
                $ldap_user = 'cn=Administrateur,cn=Users,dc=arena-monaco,dc=fr'; // Remplacez par votre nom d'utilisateur LDAP
                $ldap_password = '1234567890A@'; // Remplacez par votre mot de passe LDAP
                $ldap_base_dn = 'DC=arena-monaco,DC=fr'; // Remplacez par votre base DN
                $ldap_group_dn = 'OU=utilisateurs,DC=arena-monaco,DC=fr'; // Remplacez par le DN de votre groupe d'utilisateurs

                // Connexion à l'Active Directory
                $ldap_conn = ldap_connect($ldap_server) or die("Impossible de se connecter au serveur LDAP.");
                ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

                if ($ldap_conn) {
                    // Authentification
                    $ldap_bind = ldap_bind($ldap_conn, $ldap_user, $ldap_password);

                    if ($ldap_bind) {
                        // Recherche des utilisateurs dans le groupe spécifié
                        $filter = "(objectClass=user)";
                        $search = ldap_search($ldap_conn, $ldap_group_dn, $filter);
                        $entries = ldap_get_entries($ldap_conn, $search);

                        if ($entries['count'] > 0) {
                            // Parcourir les utilisateurs et créer les options de la liste déroulante
                            for ($i = 0; $i < $entries['count']; $i++) {
                                $email = isset($entries[$i]['mail'][0]) ? $entries[$i]['mail'][0] : '';
                                $nom_prenom = isset($entries[$i]['givenname'][0]) ? $entries[$i]['givenname'][0] . ' ' . $entries[$i]['sn'][0] : $entries[$i]['sn'][0];
                                echo "<option value='$email'>$nom_prenom ($email)</option>";
                            }
                        } else {
                            echo "<option value=''>Aucun utilisateur trouvé</option>";
                        }
                    } else {
                        echo "<option value=''>Échec de l'authentification LDAP</option>";
                    }

                    // Fermeture de la connexion LDAP
                    ldap_close($ldap_conn);
                } else {
                    echo "<option value=''>Échec de la connexion au serveur LDAP</option>";
                }
                ?>
            </select>
            <br><br>
            <button type="submit">Supprimer</button>
        </form>

        <?php
        // Afficher le message de succès ou d'erreur de la session
        session_start();
        if (isset($_SESSION['message'])) {
            echo "<p>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']); // Supprimer le message après l'affichage
        }
        ?>
    </div>
</body>
</html>
