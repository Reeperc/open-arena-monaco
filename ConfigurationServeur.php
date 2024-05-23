<?php
session_start();
// Vérifier si l'utilisateur est connecté en tant que admin
if (!isset($_SESSION['organisateur_username'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ConnexionF.php");
    exit();
}

if (isset($_SESSION['welcome_message9'])) {
    echo "<p style='color: green;'>" . $_SESSION['welcome_message9'] . "</p>";
    unset($_SESSION['welcome_message9']); // Supprimer la variable de session après l'affichage
}
?>

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
                <label for="map-select">Sélectionnez une Map :</label>
                <select id="map-select" name="map">
                    <option value="delta">delta</option>
                    <option value="map2">Map 2</option>
                    <option value="map3">Map 3</option>
                    <!-- Ajoutez d'autres options ici -->
                </select>
            </div>
            <div>
                <label for="mode-select">Sélectionnez un Mode de Jeu :</label>
                <select id="mode-select" name="mode">
                    <option value="0">Mode 0</option>
                    <option value="1">Mode 1</option>
                    <option value="2">Mode 2</option>
                    <!-- Ajoutez d'autres options ici -->
                </select>
            </div>
            <div style="margin-left: 20px;">
                <label for="warmup-counter">Warmup (secondes):</label>
                <input type="number" id="warmup-counter" name="warmup" min="0" value="0">
            </div>
        </div>

        <h2>Contrôle du Serveur</h2>
        <div style="display: flex; justify-content: space-between;">
            <button type="button" onclick="startServiceAjax()">Ouvrir la partie</button>
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
                    <div style="margin-left: 20px;"> <!-- Nouvelle division pour le compteur de niveau -->

                        <button class="button" type="button" onclick="addBot()">Ajouter</button>
                        <button class="delete-button" type="button" onclick="removeBot()">Supprimer</button>
                        <div id="bot-message" class="bot-message"></div>
                        <div id="bot-remove-message" class="bot-remove-message"></div>
                </form>
            </div>
            <div style="margin-left: 25%;">
                <img id="bot-image" class="bot-image" src="" alt="Image du Bot">
            </div>
        </section>

        <section>
            <button style="width: 100%;" onclick="launchGame()">Lancer la partie</button>
        </section>
    </main>

    <script>
        function addBot() {
            const botName = document.getElementById('bot-name').value;
            const botLevel = document.getElementById('bot-level').value;

            const formData = new FormData();
            formData.append('bot_name', botName);
            formData.append('bot_level', botLevel);

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
                    document.getElementById('message').innerHTML = data;
                })
                .catch(error => {
                    document.getElementById('message').innerHTML = 'Erreur : ' + error;
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

            fetch('start_service.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('message').innerHTML = data;
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