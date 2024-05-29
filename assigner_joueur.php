<!DOCTYPE html>
<html lang="fr">
    
<head>
    <meta charset="UTF-8">
    <title>Contrôle d'utilisateur</title>
    <script>
        // Fonction pour récupérer le contenu d'un fichier et mettre à jour l'élément HTML correspondant
        function fetchUserData(url, elementId) {
            const uniqueUrl = `${url}?t=${new Date().getTime()}`;
            fetch(uniqueUrl)
                .then(response => response.text())
                .then(data => {
                    document.getElementById(elementId).innerText = data || "Aucun";
                });
        }

        // Fonction pour récupérer les utilisateurs du groupe "utilisateurs" et remplir les menus déroulants
        function fetchUsers() {
            fetch('get_users.php')
                .then(response => response.json())
                .then(users => {
                    if (users.error) {
                        alert(users.error);
                    } else {
                        users.forEach(user => {
                            const option1 = document.createElement('option');
                            const option2 = document.createElement('option');
                            option1.value = option1.text = user;
                            option2.value = option2.text = user;
                            document.getElementById('selectAuthorizedUser1').appendChild(option1);
                            document.getElementById('selectAuthorizedUser2').appendChild(option2);
                        });
                    }
                });
        }

        // Fonction pour vérifier l'utilisateur actuel pour chaque appareil toutes les secondes
        function checkUser(device) {
            const currentUserId = `currentUser${device}`;
            const authorizedUserId = `authorizedUser${device}`;
            fetchUserData(`current_user_device${device}.txt`, currentUserId);

            setTimeout(() => checkUser(device), 1000);
        }

        // Fonction pour démarrer le contrôle et définir l'utilisateur autorisé pour chaque appareil
        function startControl(device) {
            const user = document.getElementById(`selectAuthorizedUser${device}`).value;
            if (user) {
                fetch(`authorized_user_device${device}.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'user=' + encodeURIComponent(user)
                }).then(() => {
                    document.getElementById(`authorizedUser${device}`).innerText = user;
                    checkUser(device);
                });
            }
        }

        // Charger les utilisateurs au démarrage de la page
        window.onload = function() {
            fetchUsers();

            checkUser(1);
            fetchUserData('current_user_device1.txt', 'currentUser1');
            fetchUserData('authorized_user_device1.txt', 'authorizedUser1');

            checkUser(2);
            fetchUserData('current_user_device2.txt', 'currentUser2');
            fetchUserData('authorized_user_device2.txt', 'authorizedUser2');
        }
    </script>
</head>
<body>
    <h1>Appareil 1</h1>
    <h2>Utilisateur actuel : <span id="currentUser1">Chargement...</span></h2>
    <h2>Utilisateur autorisé : <span id="authorizedUser1">Chargement...</span></h2>
    <select id="selectAuthorizedUser1">
        <option value="">Sélectionner un utilisateur</option>
    </select>
    <button onclick="startControl(1)">Lancer le contrôle pour l'appareil 1</button>

    <h1>Appareil 2</h1>
    <h2>Utilisateur actuel : <span id="currentUser2">Chargement...</span></h2>
    <h2>Utilisateur autorisé : <span id="authorizedUser2">Chargement...</span></h2>
    <select id="selectAuthorizedUser2">
        <option value="">Sélectionner un utilisateur</option>
    </select>
    <button onclick="startControl(2)">Lancer le contrôle pour l'appareil 2</button>
</body>
</html>
