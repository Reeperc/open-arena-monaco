<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        /* Styles pour la mise en page */
        body {
            font-family: Arial, sans-serif;
        }

        main {
            background-color: #2C6CC2;
            width: 30%;
            /* Largeur de 30% de la largeur de la fenêtre */
            position: absolute;
            /* Position absolue pour superposer sur les images */
            top: 32%;
            /* Positionné à 50% de la hauteur de la fenêtre */
            left: 32%;
            /* Positionné à 50% de la largeur de la fenêtre */
            padding: 20px;
            /* Ajoute un espacement intérieur pour l'apparence */
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            color: white;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: none;
            border-radius: 4px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        p.error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <main>
        <h2>Connexion</h2>
        <?php if (isset($error_message)) { ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php } ?>
        <form method="post" action="connexionphp.php">
            <label for="email">ident :</label>
            <input type="text" id="email" name="email" required>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Se connecter</button>
        </form>
    </main>
</body>

</html>