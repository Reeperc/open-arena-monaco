<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Menu Admin</title>
    <link rel="stylesheet" href="styles/style-antoine-config.css">
    <link rel="stylesheet" href="styles/style-antoine.css">
</head>

<body>
    <?php include('MenuAdminF.php'); ?>
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
                    <option value="1">0</option>
                    <option value="2">Mode 2</option>
                    <option value="3">Mode 3</option>
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
                <form onsubmit="addBot(); return false;">
                    <label for="bot-name">Nom du Bot:</label>
                    <select id="bot-name" name="bot_name" required>
                        <option value="Angelyss">Angelyss</option>
                        <option value="Andriy">Andriy</option>
                        <option value="Arachna">Arachna</option>
                        <option value="Assassin">Assassin</option>
                        <option value="Ayumi">Ayumi</option>
                        <option value="Beret">Beret</option>
                        <option value="Broadklin">Broadklin</option>
                        <option value="Cyber-Garg">Cyber-Garg</option>
                        <option value="Dark">Dark</option>
                        <option value="Gargoyle">Gargoyle</option>
                        <option value="Ghost">Ghost</option>
                        <option value="Grism">Grism</option>
                        <option value="Grunt">Grunt</option>
                        <option value="Headcrash">Headcrash</option>
                        <option value="Jenna">Jenna</option>
                        <option value="Kyonshi">Kyonshi</option>
                        <option value="Liz">Liz</option>
                        <option value="Major">Major</option>
                        <option value="Merman">Merman</option>
                        <option value="Metalbot">Metalbot</option>
                        <option value="Morgan">Morgan</option>
                        <option value="Murielle">Murielle</option>
                        <option value="Neko">Neko</option>
                        <option value="Nekoyss">Nekoyss</option>
                        <option value="Penguin">Penguin</option>
                        <option value="Rai">Rai</option>
                        <option value="S_Marine">S_Marine</option>
                        <option value="Sarge">Sarge</option>
                        <option value="Sergei">Sergei</option>
                        <option value="Skelebot">Skelebot</option>
                        <option value="Sorceress">Sorceress</option>
                        <option value="Tanisha">Tanisha</option>
                        <option value="Tony">Tony</option>
                    </select>

                    <label for="bot-level">Niveau du Bot:</label>
                    <input type="number" id="bot-level" name="bot_level" min="1" max="10" required>

                    <button class="button" onclick="addBot()">Ajouter</button>
                    <button class="delete-button" onclick="deleteBot()">Supprimer</button>
                </form>
            </div>
        </section>

        <section>
            <button style="width: 100%;" onclick="launchGame()">Lancer la partie</button>
        </section>
    </main>

    <script>
        function addBot() {
            // Code pour ajouter un bot à la liste
        }

        function deleteBot() {
            // Code pour supprimer un bot de la liste
        }

        function launchGame() {
            // Code pour lancer la partie
        }

        function startServiceAjax() {
            // Récupère les valeurs sélectionnées pour la map et le mode
            const map = document.getElementById('map-select').value;
            const mode = document.getElementById('mode-select').value;

            // Crée un objet FormData
            const formData = new FormData();
            formData.append('selected-map', map);
            formData.append('selected-mode', mode);

            // Effectue une requête AJAX
            fetch('start_service.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Affiche le message de retour dans la div message
                document.getElementById('message').innerHTML = data;
            })
            .catch(error => {
                // Affiche l'erreur dans la div message
                document.getElementById('message').innerHTML = 'Erreur : ' + error;
            });
        }

        function stopServiceAjax() {
            // Effectue une requête AJAX pour arrêter le service
            fetch('stop_service.php', {
                method: 'POST'
            })
            .then(response => response.text())
            .then(data => {
                // Affiche le message de retour dans la div message
                document.getElementById('message').innerHTML = data;
            })
            .catch(error => {
                // Affiche l'erreur dans la div message
                document.getElementById('message').innerHTML = 'Erreur : ' + error;
            });
        }
    </script>
</body>

</html>
