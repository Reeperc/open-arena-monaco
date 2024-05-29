<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un utilisateur</title>
</head>
<body>
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
</body>
</html>
