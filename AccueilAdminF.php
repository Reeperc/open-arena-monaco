<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/style-antoine-config.css">
    <title>Menu Admin</title>
</head>

<body>
    <?php include('MenuAdminF.php'); ?>
    <main>
        <section>
            <h2>Contrôle du Serveur</h2>
            <button onclick="startService()">Démarrer le service</button>
            <button onclick="stopService()">Arrêter le service</button>
            <button onclick="launchGame()">Lancer la partie</button>
        </section>

        <section>
            <h2>Configuration Sélectionnée</h2>
            <div>
                <h3>Bots Sélectionnés</h3>
                <ul>
                    <!-- Exemple statique, à remplacer par une génération dynamique -->
                    <li>Bot 1 - Niveau 5</li>
                    <li>Bot 2 - Niveau 3</li>
                    <li>Bot 3 - Niveau 7</li>
                </ul>
            </div>
            <div>
                <h3>Temps de Warmup Sélectionné</h3>
                <p>10 minutes</p> <!-- Exemple statique, à remplacer par la valeur dynamique -->
            </div>
        </section>
    </main>
</body>

</html>
