<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contrôle d'utilisateur</title>
    <script>
        // Fonction pour récupérer le contenu d'un fichier et mettre à jour l'élément HTML correspondant
        function fetchUserData(url, elementId) {
            // Ajoutez un paramètre unique pour éviter le cache
            const uniqueUrl = `${url}?t=${new Date().getTime()}`;
            fetch(uniqueUrl)
                .then(response => response.text())
                .then(data => {
                    document.getElementById(elementId).innerText = data || "Aucun";
                });
        }

        // Fonction pour vérifier l'utilisateur actuel pour chaque appareil toutes les secondes
        function checkUser(device) {
            const currentUserId = `currentUser${device}`;
            const authorizedUserId = `authorizedUser${device}`;
            fetchUserData(`current_user_device${device}.txt`, currentUserId);

            const authorizedUser = document.getElementById(authorizedUserId).innerText;
            const currentUser = document.getElementById(currentUserId).innerText;

            setTimeout(() => checkUser(device), 1000);  // Continue to check every second
        }

        // Fonction pour démarrer le contrôle et définir l'utilisateur autorisé pour chaque appareil
        function startControl(device) {
            const userSelect = document.getElementById(`selectAuthorizedUser${device}`);
            const user = userSelect.value;
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

        // Fonction pour récupérer les utilisateurs depuis AD et remplir les listes déroulantes
        function fetchUsersFromAD() {
            fetch('ADutilisateurs.php')
                .then(response => response.json())
                .then(data => {
                    const userList1 = document.getElementById('selectAuthorizedUser1');
                    const userList2 = document.getElementById('selectAuthorizedUser2');

                    // Récupérer les valeurs actuellement sélectionnées dans les listes déroulantes
                    const selectedUser1 = userList1.value;
                    const selectedUser2 = userList2.value;

                    // Vider les listes déroulantes
                    userList1.innerHTML = '';
                    userList2.innerHTML = '';

                    // Remplir les listes déroulantes avec les utilisateurs récupérés, en excluant les utilisateurs déjà sélectionnés dans l'autre liste
                    data.forEach(user => {
                        const option1 = document.createElement('option');
                        option1.text = user;
                        option1.value = user;
                        if (user !== selectedUser2) {
                            userList1.appendChild(option1);
                        }

                        const option2 = document.createElement('option');
                        option2.text = user;
                        option2.value = user;
                        if (user !== selectedUser1) {
                            userList2.appendChild(option2);
                        }
                    });

                    // Réappliquer les sélections précédentes
                    userList1.value = selectedUser1;
                    userList2.value = selectedUser2;
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des utilisateurs depuis le serveur AD :', error);
                });
        }

        // Appeler la fonction pour récupérer les utilisateurs au chargement de la page
        document.addEventListener('DOMContentLoaded', fetchUsersFromAD);
    </script>
</head>
<body>
    <h1>Appareil 1</h1>
    <h2>Utilisateur actuel : <span id="currentUser1">Chargement...</span></h2>
    <h2>Utilisateur autorisé : <span id="authorizedUser1">Chargement...</span></h2>
    <select id="selectAuthorizedUser1">
        <option value="">Sélectionnez un utilisateur</option>
    </select>
    <button onclick="startControl(1)">Lancer le contrôle pour l'appareil 1</button>

    <h1>Appareil 2</h1>
    <h2>Utilisateur actuel : <span id="currentUser2">Chargement...</span></h2>
    <h2>Utilisateur autorisé : <span id="authorizedUser2">Chargement...</span></h2>
    <select id="selectAuthorizedUser2">
        <option value="">Sélectionnez un utilisateur</option>
    </select>
    <button onclick="startControl(2)">Lancer le contrôle pour l'appareil 2</button>
</body>
</html>
