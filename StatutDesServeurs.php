<!doctype html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="styles/style-antoine-statut.css">
    <link rel="stylesheet" href="style.css">
    <title>Statut des serveurs</title>
    <script>
        function getServiceStatus(serverIP, port, website) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "service_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("result").innerHTML = xhr.responseText;
                }
            };
            xhr.send("server_ip=" + encodeURIComponent(serverIP) + "&port=" + encodeURIComponent(port) + "&website=" + encodeURIComponent(website));
        }
    </script>
    <style>
        #result {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php include('MenuAdminF.php'); ?>

    <main>
        <section class="button-grid">
            <a href="#" class="button-item" onclick="getServiceStatus('192.168.1.1', 27960, 'http://192.168.1.1'); return false;">
                <img src="" alt="">
                <p>Etat du serveur Rouen</p>
            </a>
            <a href="#" class="button-item" onclick="getServiceStatus('195.221.30.65', 27961, 'http://195.221.30.16'); return false;">
                <img src="" alt="">
                <p>Etat du serveur Monaco</p>
            </a>
            <a href="#" class="button-item" onclick="getServiceStatus('192.168.1.3', 27962, 'http://192.168.1.3'); return false;">
                <img src="" alt="">
                <p>Etat du serveur Paris</p>
            </a>
            <a href="#" class="button-item" onclick="getServiceStatus('192.168.1.4', 27963, 'http://192.168.1.4'); return false;">
                <img src="" alt="">
                <p>Etat du serveur MQ</p>
            </a>
        </section>
    </main>

    <div id="result"></div>
</body>

</html>
