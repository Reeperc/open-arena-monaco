<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status du Service</title>
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
    <h1>Vérifier le statut du service OpenArena</h1>
    <button onclick="getServiceStatus()">Status du Service</button>
    <div id="result"></div>
</body>

</html>