<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Lancement partie</title>
    <link rel="stylesheet" href="styles/style-antoine-config.css">
    <link rel="stylesheet" href="style.css">
    <?php include('MenuOrganisateurF.php'); ?>
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

        // Fonction pour vérifier l'utilisateur actuel pour chaque appareil toutes les secondes
        function checkUser(device) {
            const currentUserId = `currentUser${device}`;
            const authorizedUserId = `authorizedUser${device}`;
            fetchUserData(`current_user_device${device}.txt`, currentUserId);

            const authorizedUser = document.getElementById(authorizedUserId).innerText;
            const currentUser = document.getElementById(currentUserId).innerText;

            setTimeout(() => checkUser(device), 1000);
        }

        // Fonction pour démarrer le contrôle et définir l'utilisateur autorisé pour chaque appareil
        function startControl(device) {
            const user = document.getElementById(`inputAuthorizedUser${device}`).value;
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
            fetchUsersFromAD();
            checkUser(1);
            fetchUserData('current_user_device1.txt', 'currentUser1');
            fetchUserData('authorized_user_device1.txt', 'authorizedUser1');

            checkUser(2);
            fetchUserData('current_user_device2.txt', 'currentUser2');
            fetchUserData('authorized_user_device2.txt', 'authorizedUser2');
        }

        // Fonction pour récupérer les utilisateurs depuis le serveur AD et les mettre à jour dans les listes déroulantes
        function fetchUsersFromAD() {
            fetch('ADutilisateurs.php')
                .then(response => response.json())
                .then(data => {
                    const userList1 = document.getElementById('inputAuthorizedUser1');
                    const userList2 = document.getElementById('inputAuthorizedUser2');

                    // Vider les listes déroulantes
                    userList1.innerHTML = '';
                    userList2.innerHTML = '';

                    // Remplir les listes déroulantes avec les utilisateurs récupérés
                    data.forEach(user => {
                        const option1 = document.createElement('option');
                        option1.text = user;
                        userList1.appendChild(option1);

                        const option2 = document.createElement('option');
                        option2.text = user;
                        userList2.appendChild(option2);
                    });
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des utilisateurs depuis le serveur AD :', error);
                });
        }

        document.addEventListener('DOMContentLoaded', showBotImage);
    </script>
</head>
<body class="config">
    <main>
        <h2>Sélection de la Map et du Mode de Jeu</h2>
        <div style="display: flex; align-items: center;">
            <div style="margin-right: 20px;">
                <label for="mode-select">Sélectionnez un Mode de Jeu :</label>
                <select id="mode-select" name="mode" onchange="updateMapOptions()">
                    <option value="">-- Mode de jeu --</option>
                    <option value="0">Match à mort (Deathmatch)</option>
                    <option value="1">Capture du drapeau (CTF)</option>
                    <option value="2">Domination</option>
                    <option value="3">One-Flag CTF</option>
                    <option value="4">Harvester</option>
                    <option value="5">Rocket Arena</option>
                    <option value="6">Instagib</option>
                </select>
            </div>
            <div id="map-container" style="display: none;">
                <label for="map-select">Sélectionnez une Map :</label>
                <select id="map-select" name="map">
                    <!-- Options de la carte mises à jour dynamiquement -->
                </select>
            </div>
            <div style="margin-left: 20px;">
                <label for="warmup-counter">Warmup (secondes):</label>
                <input type="number" id="warmup-counter" name="warmup" min="0" max="5000" value="0">
            </div>
        </div>

        <h2>Contrôle du Serveur</h2>
        <div style="display: flex; justify-content: space-between;">
            <button type="button" onclick="startServiceAjax()">Ouvrir la partie</button>
            <select id="listeNoms1"></select>
            <select id="listeNoms2"></select>
            <button type="button" onclick="stopServiceAjax()">Fermer la partie</button>
        </div>

        <form id="serverForm" action="start_service.php" method="post" style="display:none;">
            <input type="hidden" id="selected-map" name="selected-map">
            <input type="hidden" id="selected-mode" name="selected-mode">
        </form>

        <div id="message" style="margin-top: 20px;"></div>
    </main>

    <main>
        <section>
            <h2>Ajouter ou Supprimer un Bot</h2>
            <div class="bot-form" style="display: flex; align-items: center;">
                <form id="addBotForm" onsubmit="addBot(); return false;">
                    <label for="bot-name">Nom du Bot:</label>
                    <select id="bot-name" name="bot_name" onchange="showBotImage()" required>
                        <option value="Angelyss">Angelyss</option>
                        <option value="Arachna">Arachna</option>
                        <option value="Assassin">Assassin</option>
                        <option value="Ayumi">Ayumi</option>
                        <option value="Beret">Beret</option>
                        <option value="Gargoyle">Gargoyle</option>
                        <option value="Kyonshi">Kyonshi</option>
                        <option value="Liz">Liz</option>
                        <option value="Major">Major</option>
                        <option value="Merman">Merman</option>
                        <option value="Neko">Neko</option>
                        <option value="Penguin">Penguin</option>
                        <option value="S_Marine">S_Marine</option>
                        <option value="Sarge">Sarge</option>
                        <option value="Sergei">Sergei</option>
                        <option value="Skelebot">Skelebot</option>
                        <option value="Sorceress">Sorceress</option>
                        <option value="Tony">Tony</option>
                    </select>

                    <label for="bot-level">Niveau du Bot:</label>
                    <input type="number" id="bot-level" name="bot_level" min="1" max="5" value="1" required>

                    <label for="bot-team">Équipe du Bot:</label>
                    <select id="bot-team" name="bot_team" required>
                        <option value="red">Rouge</option>
                        <option value="blue">Bleu</option>
                    </select>

                    <div style="margin-left: 20px;"> <!-- Nouvelle division pour le compteur de niveau -->
                </form>
            </div>
            <div style="margin-left: 25%;">
                <img id="bot-image" class="bot-image" src="" alt="Image du Bot">
                <p></p>
                <p></p>
                <p></p>
                <button class="button" type="button" onclick="addBot()">Ajouter</button>
                <button class="delete-button" type="button" onclick="removeBot()">Supprimer</button>
                <div id="bot-message" class="bot-message"></div>
                <div id="bot-remove-message" class="bot-remove-message"></div>
            </div>
        </section>

        <section>
            <button style="width: 100%;" onclick="launchGame()">Lancer la partie</button>
            <div id="message-launchGame" class="message"></div>
        </section>
    </main>

    <main>
        <section>
            <h2>Gestion des Utilisateurs</h2>
            <div class="user-management" style="display: flex; flex-direction: column;">
                <div style="display: flex; align-items: center;">
                    <label for="inputAuthorizedUser1">Utilisateur autorisé pour l'appareil 1:</label>
                    <select id="inputAuthorizedUser1">
                        <option value="">Sélectionnez un utilisateur</option>
                    </select>
                    <button type="button" onclick="startControl(1)">Définir</button>
                </div>
                <div>
                    <strong>Utilisateur actuel pour l'appareil 1:</strong>
                    <span id="currentUser1">Aucun</span>
                </div>
                <div>
                    <strong>Utilisateur autorisé pour l'appareil 1:</strong>
                    <span id="authorizedUser1">Aucun</span>
                </div>
            </div>

            <div class="user-management" style="display: flex; flex-direction: column; margin-top: 20px;">
                <div style="display: flex; align-items: center;">
                    <label for="inputAuthorizedUser2">Utilisateur autorisé pour l'appareil 2:</label>
                    <select id="inputAuthorizedUser2">
                        <option value="">Sélectionnez un utilisateur</option>
                    </select>
                    <button type="button" onclick="startControl(2)">Définir</button>
                </div>
                <div>
                    <strong>Utilisateur actuel pour l'appareil 2:</strong>
                    <span id="currentUser2">Aucun</span>
                </div>
                <div>
                    <strong>Utilisateur autorisé pour l'appareil 2:</strong>
                    <span id="authorizedUser2">Aucun</span>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
