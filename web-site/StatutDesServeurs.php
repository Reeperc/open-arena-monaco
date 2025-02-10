<!doctype html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="styles/style-antoine-statut.css">
    <link rel="stylesheet" href="style.css">
    <title>Statut des serveurs</title>
    <script>
        function getServiceStatus(serverIP, website, elementId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "service_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById(elementId).innerHTML = xhr.responseText;
                }
            };
            xhr.send("server_ip=" + encodeURIComponent(serverIP) + "&website=" + encodeURIComponent(website));
        }

        function updateStatuses() {
            getServiceStatus('195.221.50.25', 'http://195.221.50.17', 'status-rouen');
            getServiceStatus('195.221.30.65', 'http://195.221.30.16', 'status-monaco');
            getServiceStatus('195.221.40.129', 'http://195.221.40.131', 'status-paris');
            getServiceStatus('195.221.20.27', 'http://195.221.20.46', 'status-mq');
        }

        setInterval(updateStatuses, 5000); // Mettre à jour toutes les 5 secondes
    </script>
</head>

<body>
    <?php include('MenuAdminF.php'); ?>

    <main>
        <section class="server-grid">
            <div class="server-info" id="server-rouen">
                <img src="images/villes/rouen.jpg" alt="Icone Serveur Rouen" class="server-icon">
                <div class="server-name">Serveur Rouen</div>
                <div class="server-details">IP: 195.221.50.25</div>
                <div class="server-details">URL: <a href="http://195.221.50.17" target="_blank">http://195.221.50.17</a></div>
                <div id="status-rouen" class="server-details">Vérification en cours...</div>
            </div>
            <div class="server-info" id="server-monaco">
                <img src="images/villes/monaco.jpg" alt="Icone Serveur Monaco" class="server-icon">
                <div class="server-name">Serveur Monaco</div>
                <div class="server-details">IP: 195.221.30.65</div>
                <div class="server-details">URL: <a href="http://195.221.30.16" target="_blank">http://195.221.30.16</a></div>
                <div id="status-monaco" class="server-details">Vérification en cours...</div>
            </div>
            <div class="server-info" id="server-paris">
                <img src="images/villes/paris.jpg" alt="Icone Serveur Paris" class="server-icon">
                <div class="server-name">Serveur Paris</div>
                <div class="server-details">IP: 195.168.40.129</div>
                <div class="server-details">URL: <a href="http://195.221.40.131" target="_blank">http://195.221.40.131</a></div>
                <div id="status-paris" class="server-details">Vérification en cours...</div>
            </div>
            <div class="server-info" id="server-mq">
                <img src="images/villes/montcuq.jpg" alt="Icone Serveur MQ" class="server-icon">
                <div class="server-name">Serveur MQ</div>
                <div class="server-details">IP: 195.168.20.27</div>
                <div class="server-details">URL: <a href="http://195.221.20.46" target="_blank">http://195.221.20.46</a></div>
                <div id="status-mq" class="server-details">Vérification en cours...</div>
            </div>
        </section>
    </main>

    <script>
        updateStatuses(); // Initial call to set statuses on page loaddd
    </script>
</body>

</html>