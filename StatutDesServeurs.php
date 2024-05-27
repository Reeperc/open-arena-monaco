<!doctype html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="styles/style-antoine-statut.css">
    <link rel="stylesheet" href="style.css">
    <title>Statut des serveurs</title>
    <script>
        function getServiceStatus(serverIP, port, website, elementId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "service_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById(elementId).innerHTML = xhr.responseText;
                }
            };
            xhr.send("server_ip=" + encodeURIComponent(serverIP) + "&port=" + encodeURIComponent(port) + "&website=" + encodeURIComponent(website));
        }

        function updateStatuses() {
            getServiceStatus('192.221.50.27', 27960, 'http://192.221.50.17', 'status-rouen');
            getServiceStatus('195.221.30.65', 27961, 'http://195.221.30.16', 'status-monaco');
            getServiceStatus('192.168.40.129', 27960, 'http://192.221.40.131', 'status-paris');
            getServiceStatus('192.168.20.27', 27965, 'http://192.221.20.46', 'status-mq');
        }

        setInterval(updateStatuses, 5000); // Mettre à jour toutes les 5 secondes
    </script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #result {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .server-info {
            text-align: center;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .server-icon {
            width: 50px;
            height: 50px;
            display: block;
            margin: 0 auto;
        }

        .server-name {
            font-size: 1.2em;
            margin-top: 10px;
        }

        .server-details {
            margin-top: 5px;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <?php include('MenuAdminF.php'); ?>

    <main>
        <section class="server-grid">
            <div class="server-info" id="server-rouen">
                <img src="icons/server-rouen.png" alt="Icone Serveur Rouen" class="server-icon">
                <div class="server-name">Serveur Rouen</div>
                <div class="server-details">IP: 192.221.50.27</div>
                <div class="server-details">URL: <a href="http://192.221.50.17" target="_blank">http://192.221.50.17</a></div>
                <div id="status-rouen" class="server-details">Vérification en cours...</div>
            </div>
            <div class="server-info" id="server-monaco">
                <img src="icons/server-monaco.png" alt="Icone Serveur Monaco" class="server-icon">
                <div class="server-name">Serveur Monaco</div>
                <div class="server-details">IP: 195.221.30.65</div>
                <div class="server-details">URL: <a href="http://195.221.30.16" target="_blank">http://195.221.30.16</a></div>
                <div id="status-monaco" class="server-details">Vérification en cours...</div>
            </div>
            <div class="server-info" id="server-paris">
                <img src="icons/server-paris.png" alt="Icone Serveur Paris" class="server-icon">
                <div class="server-name">Serveur Paris</div>
                <div class="server-details">IP: 192.168.40.129</div>
                <div class="server-details">URL: <a href="http://192.221.40.131" target="_blank">http://192.221.40.131</a></div>
                <div id="status-paris" class="server-details">Vérification en cours...</div>
            </div>
            <div class="server-info" id="server-mq">
                <img src="icons/server-mq.png" alt="Icone Serveur MQ" class="server-icon">
                <div class="server-name">Serveur MQ</div>
                <div class="server-details">IP: 192.168.20.27</div>
                <div class="server-details">URL: <a href="http://192.221.20.46" target="_blank">http://192.221.20.46</a></div>
                <div id="status-mq" class="server-details">Vérification en cours...</div>
            </div>
        </section>
    </main>

    <div id="result"></div>

    <script>
        updateStatuses(); // Initial call to set statuses on page load
    </script>
</body>

</html>
