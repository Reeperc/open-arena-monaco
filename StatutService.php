<!doctype html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="styles/style-antoine-statut.css">
    <link rel="stylesheet" href="style.css">
    <title>Statut des serveurs</title>
    <script>
        function getServiceStatusRouen() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "StatutServiceRouen.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("result").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        function getServiceStatusMonaco() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "StatutServiceMonaco.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("result").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        function getServiceStatusParis() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "StatutServiceParis.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("result").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        function getServiceStatusMontcuq() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "StatutServiceMQ.php", true);
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
        <a href="#" class="button-item" onclick="getServiceStatusRouen(); return false;">
                <img src="" alt="">
                <p>Etat du serveur Rouen</p>
            </a>

            <a href="#" class="button-item" onclick="getServiceStatusMonaco(); return false;">
                <img src="" alt="">
                <p>Etat du serveur Monaco</p>
            </a>
            <a href="#" class="button-item" onclick="getServiceStatusParis(); return false;">
                <img src="" alt="">
                <p>Etat du serveur Paris</p>
            </a>

            <a href="#" class="button-item" onclick="getServiceStatusMontcuq(); return false;">
                <img src="" alt="">
                <p>Etat du serveur MQ</p>
            </a>
        </section>
    </main>

    <div id="result"></div>
</body>

</html>
