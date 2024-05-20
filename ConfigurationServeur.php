<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion des Bots et Configuration du Serveur Monaco</title>
    <link rel="stylesheet" href="styles/style-antoine-config.css">
    <script>
        function toggleBotList() {
            var botList = document.getElementById("botList");
            if (botList.classList.contains("open")) {
                botList.classList.remove("open");
            } else {
                botList.classList.add("open");
            }
        }

        function startService() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "start_service.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("result").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        function stopService() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "stop_service.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("result").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        function addBot() {
            var botName = document.getElementById("bot-name").value;
            var botLevel = document.getElementById("bot-level").value;
            var botList = document.getElementById("added-bots");
            var existingBots = document.querySelectorAll("#added-bots li");

            // Vérifiez si le bot est déjà dans la liste
            for (var i = 0; i < existingBots.length; i++) {
                if (existingBots[i].textContent.includes(botName)) {
                    alert("Ce bot est déjà ajouté.");
                    return;
                }
            }

            // Ajouter le bot à la liste
            var listItem = document.createElement("li");
            listItem.textContent = botName + " - Niveau " + botLevel;
            botList.appendChild(listItem);
        }

        function startWarmup() {
            // Code pour démarrer le warmup
        }

        function startGame() {
            // Code pour démarrer la partie
        }
    </script>
</head>

<body>
    <?php include('MenuAdminF.php'); ?>
    <div class="rectangle-fixe">
        <main>
            <h1>Lancement/Arrêt du service</h1>
            <section class="button-grid">
                <a href="#" class="button-item" onclick="startService(); return false;">
                    Démarrer le service
                </a>
                <a href="#" class="button-item" onclick="stopService(); return false;">
                    Arrêter le service
                </a>
            </section>
            <div style="font-size: 22px" id="result"></div>

            <div class="bot-form">
                <h2>Ajouter un Bot</h2>
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

                    <input type="submit" value="Ajouter">
                </form>
            </div>

            <div class="bot-list">
                <h2>Bots Ajoutés</h2>
                <ul id="added-bots">
                    <!-- Les bots ajoutés apparaîtront ici -->
                </ul>
            </div>

            <div class="warmup-block">
                <h2>Warmup</h2>
                <button onclick="startWarmup()">Warmup</button>
                <input type="number" id="warmup-counter" value="0" min="0">
                <span>secondes</span>
            </div>
            
            <button id="start-game-btn" onclick="startGame()">Lancer la partie</button>
        </main>
    </div>
</body>

</html>
