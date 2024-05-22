<!DOCTYPE html>
<html lang="fr">
/**/
<head>
    <meta charset="UTF-8">
    <title>Menu Admin</title>
    <link rel="stylesheet" href="styles/style-antoine-config.css">
    <link rel="stylesheet" href="styles/style-antoine.css">
    <style>
        /* Ajout du style pour aligner et ajuster la taille des boutons */
        .bot-form button {
            margin-left: 10px; /* Espacement entre les boutons */
            flex: 1; /* Ajustement automatique de la taille */
        }
    </style>
</head>

<body>
    <?php include('MenuAdminF.php'); ?>
    <main>
    <h2>Sélection de la Map et du Mode de Jeu</h2>
            <div style="display: flex; align-items: center;">
                <div style="margin-right: 20px;">
                    <label for="map-select">Sélectionnez une Map :</label>
                    <select id="map-select" name="map">
                        <option value="map1">Map 1</option>
                        <option value="map2">Map 2</option>
                        <option value="map3">Map 3</option>
                        <!-- Ajoutez d'autres options ici -->
                    </select>
                </div>
                <div>
                    <label for="mode-select">Sélectionnez un Mode de Jeu :</label>
                    <select id="mode-select" name="mode">
                        <option value="mode1">Mode 1</option>
                        <option value="mode2">Mode 2</option>
                        <option value="mode3">Mode 3</option>
                        <!-- Ajoutez d'autres options ici -->
                    </select>
                </div>
                <div style="margin-left: 20px;">
                    <label for="warmup-counter">Warmup (secondes):</label>
                    <input type="number" id="warmup-counter" name="warmup" min="0" value="0">
                </div>
            </div>
        </section>

        <section>
            <h2>Contrôle du Serveur</h2>
            <div style="display: flex; justify-content: space-between;">
                <button onclick="startService()">Démarrer le service</button>
                <button onclick="stopService()">Arrêter le service</button>
            </div>
        </section>
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
                </main>
                <main>
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
    </script>
</body>

</html>