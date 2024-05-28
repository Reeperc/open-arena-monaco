<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Lancement partie</title>
    <link rel="stylesheet" href="styles/style-antoine-config.css">
    <link rel="stylesheet" href="style.css">
    <?php include('MenuOrganisateurF.php'); ?>
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

    <script>
        // Fonction pour récupérer les utilisateurs depuis le serveur AD et les mettre à jour dans les listes déroulantes
        function fetchUsersFromAD() {
            fetch('ADutilisateurs.php')
                .then(response => response.json())
                .then(data => {
                    const userList1 = document.getElementById('listeNoms1');
                    const userList2 = document.getElementById('listeNoms2');

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

        // Appeler la fonction pour récupérer les utilisateurs au chargement de la page
        document.addEventListener('DOMContentLoaded', fetchUsersFromAD);


        const maps = {
            0: ['czest1dm', 'chaos2', 'mlca1', 'oa_dm1'],
            1: ['am_lavactf', 'am_lavactfxl', 'am_underworks2', 'cbctf1', 'ctf_compromise', 'ctf_gate1', 'ctf_inyard', 'delta'],
            2: ['aggressor', 'am_lavaarena', 'ctf_gate1', 'ctf_inyard', 'mlca1'],
            3: ['am_lavactf', 'am_lavactfxl', 'ctf_inyard', 'delta', 'hydronext2'],
            4: ['am_lavactf', 'am_lavactf2', 'delta', 'hydronext2', 'oa_bases3', 'oa_Thor'],
            5: ['aggressor', 'am_lavaarena', 'mlca1'],
            6: ['aggressor', 'oa_dm1']
        };

        function updateMapOptions() {
            const modeSelect = document.getElementById('mode-select');
            const mapSelect = document.getElementById('map-select');
            const mapContainer = document.getElementById('map-container');

            const selectedMode = modeSelect.value;

            // Clear previous options
            mapSelect.innerHTML = '';

            if (selectedMode !== '') {
                // Add new options
                maps[selectedMode].forEach(map => {
                    const option = document.createElement('option');
                    option.value = map;
                    option.text = map;
                    mapSelect.appendChild(option);
                });
                mapContainer.style.display = 'block';
            } else {
                mapContainer.style.display = 'none';
            }
        }

        function addBot() {
            const botName = document.getElementById('bot-name').value;
            const botLevel = document.getElementById('bot-level').value;
            const botTeam = document.getElementById('bot-team').value; // Récupérer la valeur de l'équipe du bot

            const formData = new FormData();
            formData.append('bot_name', botName);
            formData.append('bot_level', botLevel);
            formData.append('bot_team', botTeam); // Ajouter l'équipe du bot aux données du formulaire

            fetch('add_bot.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('bot-message').innerHTML = data;
                    document.getElementById('bot-remove-message').innerHTML = ''; // Clear remove message
                })
                .catch(error => {
                    document.getElementById('bot-message').innerHTML = 'Erreur : ' + error;
                });
        }

        function removeBot() {
            const botName = document.getElementById('bot-name').value;

            const formData = new FormData();
            formData.append('bot_name', botName);

            fetch('remove_bot.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('bot-remove-message').innerHTML = data;
                    document.getElementById('bot-message').innerHTML = ''; // Clear add message
                })
                .catch(error => {
                    document.getElementById('bot-remove-message').innerHTML = 'Erreur : ' + error;
                });
        }

        function launchGame() {
            fetch('lance_partie.php', {
                    method: 'POST',
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('message-launchGame').innerHTML = data;
                })
                .catch(error => {
                    document.getElementById('message-launchGame').innerHTML = 'Erreur : ' + error;
                });
        }

        function startServiceAjax() {
            const map = document.getElementById('map-select').value;
            const mode = document.getElementById('mode-select').value;
            const warmup = document.getElementById('warmup-counter').value; // Récupérer la valeur du temps de warmup

            const formData = new FormData();
            formData.append('selected-map', map);
            formData.append('selected-mode', mode);
            formData.append('selected-warmup', warmup);

            // Envoyer les données à start_service.php
            fetch('start_service.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('message').innerHTML = data;
                    // Envoyer les données à sendMail.php
                    return fetch('sendMail.php', {
                        method: 'POST',
                        body: formData
                    });
                })
                .then(response => response.text())
                .then(data => {
                    // Afficher le message indiquant que les joueurs ont été notifiés
                    document.getElementById('message').innerHTML += "<br>Les joueurs ont été notifiés du lancement de la partie";
                })
                .catch(error => {
                    document.getElementById('message').innerHTML = 'Erreur : ' + error;
                });
        }

        function stopServiceAjax() {
            fetch('stop_service.php', {
                    method: 'POST'
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('message').innerHTML = data;
                })
                .catch(error => {
                    document.getElementById('message').innerHTML = 'Erreur : ' + error;
                });
        }

        function showBotImage() {
            const botName = document.getElementById('bot-name').value;
            const botImage = document.getElementById('bot-image');

            // Mapping bot names to images
            const botImages = {
                Angelyss: '../images/bots/Angelyss.png',
                Arachna: '../images/bots/Arachna.png',
                Assassin: '../images/bots/Assassin.png',
                Ayumi: '../images/bots/Ayumi.png',
                Beret: '../images/bots/Beret.png',
                Gargoyle: '../images/bots/Gargoyle.png',
                Kyonshi: '../images/bots/Kyonshi.png',
                Liz: '../images/bots/Liz.png',
                Major: '../images/bots/Major.png',
                Merman: '../images/bots/Merman.png',
                Neko: '../images/bots/Neko.png',
                Penguin: '../images/bots/Penguin.png',
                Sarge: '../images/bots/Sarge.png',
                Sergei: '../images/bots/Sergei.png',
                Skelebot: '../images/bots/Skelebot.png',
                S_Marine: '../images/bots/Smarine.png',
                Sorceress: '../images/bots/Sorceress.png',
                Tony: '../images/bots/Tony.png',
                // Ajoutez les autres bots ici
            };

            botImage.src = botImages[botName] || '';
            botImage.alt = botName ? `Image du bot ${botName}` : 'Image du Bot';
        }

        // Initial call to display the image for the selected bot
        document.addEventListener('DOMContentLoaded', showBotImage);
    </script>
</body>

</html>