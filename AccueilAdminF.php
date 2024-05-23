<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Menu Admin</title>
    <link rel="stylesheet" href="styles/style-antoine-config.css">
    <link rel="stylesheet" href="styles/style-antoine.css">
</head>

<body>
    <?php include('MenuAdminF.php'); ?>
    <form action="enregistrer_config.php" method="post">
        <button type="submit">enregistrer les configurations</button>
    </form>
    
</body>

</html>
