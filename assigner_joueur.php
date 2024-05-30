<!DOCTYPE html>
<html lang="fr">
    
<head>
    <meta charset="UTF-8">
    <title>Contrôle d'utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            text-align: center;
            padding: 20px;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 0.5em;
            text-shadow: 2px 2px 5px #000;
        }
        h2 {
            font-size: 1.5em;
            margin-bottom: 1em;
            text-shadow: 1px 1px 3px #000;
        }
        select, button {
            padding: 10px 20px;
            margin: 10px;
            font-size: 1em;
            border-radius: 5px;
            border: none;
            box-shadow: 2px 2px 5px #000;
            transition: all 0.3s ease;
        }
        button {
            background: #28a745;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
            transform: scale(1.1);
        }
        select {
            background: #fff;
            color: #000;
        }
        #currentUser1, #currentUser2, #authorizedUser1, #authorizedUser2 {
            transition: all 0.5s ease;
        }
        .fade-in {
            animation: fadeIn 1s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
    <script>
        // Fonction pour ajouter la classe fade-in lors de la mise à jour du texte
        function updateElementText(elementId, text) {
            const element = document.getElementById(elementId);
            element.classList.remove('fade-in');
            setTimeout(() => {
                element.innerText = text || "Aucun";
                element.classList.add('fade-in');
            }, 50);
        }

        // Fonction pour récupérer le contenu d'un fichier et mettre à jour l'élément HTML correspondant
        function fetchUserData(url, elementId) {
            const uniqueUrl = `${url}?t=${new Date().getTime()}`;
            fetch(uniqueUrl)
                .then(response => response.text())
                .then(data => {
                    updateElementText(elementId, data);
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
                    updateElementText(`authorizedUser${device}`, user);
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
    <h2>Utilisateur actuel : <span id="currentUser1" class="fade-in">Chargement...</span></h2>
    <h2>Utilisateur autorisé : <span id="authorizedUser1" class="fade-in">Chargement...</span></h2>
    <select id="selectAuthorizedUser1">
        <option value="">Sélectionner un utilisateur</option>
    </select>
    <button onclick="startControl(1)">Lancer le contrôle pour l'appareil 1</button>

    <h1>Appareil 2</h1>
    <h2>Utilisateur actuel : <span id="currentUser2" class="fade-in">Chargement...</span></h2>
    <h2>Utilisateur autorisé : <span id="authorizedUser2" class="fade-in">Chargement...</span></h2>
    <select id="selectAuthorizedUser2">
        <option value="">Sélectionner un utilisateur</option>
    </select>
    <button onclick="startControl(2)">Lancer le contrôle pour l'appareil 2</button>
</body>
</html>
