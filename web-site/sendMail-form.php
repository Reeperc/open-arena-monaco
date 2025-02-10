<?php
session_start();
// Vérifier si l'utilisateur est connecté en tant que admin
if (!isset($_SESSION['organisateur_username'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ConnexionF.php");
    exit();
}

if (isset($_SESSION['welcome_message9'])) {
    echo "<p style='color: green;' class='message-success'>" . $_SESSION['welcome_message9'] . "</p>";
    unset($_SESSION['welcome_message9']); // Supprimer la variable de session après l'affichage
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'envoi d'email</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styles/style-mail.css">
    <style>
        /* Ajoutez votre CSS ici */
        .message-success,
        .message-error {
            display: none;
            font-size: 1.2em;
            text-align: center;
            margin: 20px;
        }

        .message-success {
            color: green;
        }

        .message-error {
            color: red;
        }
    </style>
</head>

<body>
    <video autoplay loop muted playsinline id="background-video">
        <source src="videos/video10.mp4" type="video/mp4">
    </video>
    <?php include('MenuOrganisateurF.php'); ?>
    <main class="main-mail">
        <div class="form-container-mail">
            <h2>Envoyer un Email</h2>
            <form id="mailForm" action="sendMail-form-sent.php" method="post">
                <label for="to">À :</label>
                <input type="text" id="to" name="to" placeholder="Séparer les mails par des virgules" required>

                <label for="subject">Objet :</label>
                <input type="text" id="subject" name="subject" required>

                <label for="body">Message :</label>
                <textarea id="body" name="body" required></textarea>

                <button type="submit">Envoyer le mail</button>
            </form>
            <div class="message-success">Message envoyé avec succès !</div>
            <div class="message-error">Échec de l'envoi du message. Veuillez réessayer.</div>
        </div>
    </main>
    <script src="libs/jquery.min.js"></script>
    <script src="libs/gsap.min.js"></script>
    <script>
        // Animation avec GSAP
        $(document).ready(function() {
            // Animation pour la soumission du formulaire
            $('#mailForm').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(response) {
                        $('.message-success').show();
                        gsap.fromTo('.message-success', {
                            y: -50,
                            opacity: 0
                        }, {
                            y: 0,
                            opacity: 1,
                            duration: 1
                        });
                        setTimeout(function() {
                            gsap.to('.message-success', {
                                y: 50,
                                opacity: 0,
                                duration: 1,
                                onComplete: function() {
                                    $('.message-success').hide();
                                }
                            });
                        }, 3000);
                    },
                    error: function(xhr, status, error) {
                        $('.message-error').show();
                        gsap.fromTo('.message-error', {
                            y: -50,
                            opacity: 0
                        }, {
                            y: 0,
                            opacity: 1,
                            duration: 1
                        });
                        setTimeout(function() {
                            gsap.to('.message-error', {
                                y: 50,
                                opacity: 0,
                                duration: 1,
                                onComplete: function() {
                                    $('.message-error').hide();
                                }
                            });
                        }, 3000);
                    }
                });
            });
        });
    </script>
</body>

</html>