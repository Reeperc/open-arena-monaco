<!doctype html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="styles/style-antoine-statut.css">
    <link rel="stylesheet" href="style.css">
    <title>Statut des serveurs</title>
    <script>
        function getServiceStatus() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "service_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("result").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>
</head>

<body>
    <?php include('MenuAdminF.php'); ?>

    <main>
        <section class="button-grid">
            <a href="StatutServiceRouen.php" class="button-item">
                <img src="" alt="">
                <p>Etat du serveur Rouen</p>
            </a>

            <a href="#" class="button-item" onclick="getServiceStatus(); return false;">
                <img src="" alt="">
                <p>Etat du serveur Monaco</p>
            </a>
            <a href="StatutServiceParis.php" class="button-item">
                <img src="" alt="">
                <p>Etat du serveur Paris</p>
            </a>

            <a href="StatutServiceMQ.php" class="button-item">
                <img src="" alt="">
                <p>Etat du serveur MQ</p>
            </a>
        </section>
    </main>

    <div id="result"></div>
</body>

</html>
