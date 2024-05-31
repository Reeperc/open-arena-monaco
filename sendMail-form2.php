<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoyer un Email</title>
    <link rel="stylesheet" href="styles/stylesa.css">
    <script src="libs/jquery.min.js"></script>
    <script src="libs/gsap.min.js"></script>
</head>

<body>
    <div id="form-container">
        <form id="emailForm" method="POST" action="sendMail-form-sent2.php">
            <input type="email" name="user1" placeholder="Email destinataire 1" required>
            <input type="email" name="user2" placeholder="Email destinataire 2" required>
            <button type="submit">Envoyer</button>
        </form>
        <div id="result"></div>
    </div>

    <script src="styles/scriptsa.js"></script>
</body>

</html>